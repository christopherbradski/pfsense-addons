import logging
import os
import re
import subprocess
import time

from pathlib import Path
from whitelist_monitor.filtersets.common import commonFilters
from whitelist_monitor.pfsense import api as pfsense_api

filters = commonFilters()

# Configure logging
logging.basicConfig(filename='/var/log/whitelist.log',
                    format='%(asctime)s %(levelname)s: %(message)s',
                    level=logging.INFO)


# This class monitors the dns_reply log and for whitelisted domains and adds
# the matching host record to an alias and allow rule.
class LogWatcher:

    # Set log file and create empty dictionary
    def __init__(self, log_file, filter_module):
        self.log_file = log_file
        self.filter_module = filter_module
        self.ip_table = {}

        self.ttl = pfsense_api.get_configured_ttl()

    # Open log file and seek to end to process new lines
    def watch_log(self):
        with open(self.log_file, "r") as f:
            f.seek(0, 2)  # Go to the end of the file
            while True:
                line = f.readline()
                if not line:
                    time.sleep(0.1)
                    continue
                if self.filter_module.filter_line(line):
                    to_filter = line.split(",")
                    if to_filter[0] == "DNS-reply":
                        ip_address = self.filter_module.validate_ip_destination(
                            to_filter[8]
                        )
                        domain = to_filter[6]
                        if ip_address:
                            self.update_table(domain, ip_address)

    def update_table(self, domain, ip_address):
        current_time = time.time()
        if domain not in self.ip_table:
            self.ip_table[domain] = [{'address': ip_address, 'timestamp': current_time, 'ttl': self.ttl}]
            self.async_update_firewall(ip_address)
        else:
            # Remove expired ip addresses
            self.ip_table[domain] = [ip for ip in self.ip_table[domain] if current_time - ip['timestamp'] < ip['ttl']]

            for ip in self.ip_table[domain]:
                if ip['address'] == ip_address and current_time - ip['timestamp'] < ip['ttl']:
                    return # IP address already exists and is not expired

            # Add new address
            self.ip_table[domain].append({'address': ip_address, 'timestamp': current_time, 'ttl': self.ttl})
            self.async_update_firewall(ip_address)

    # TODO (chris): Convert to task/queue based to process in background
    # Create an alias and or rule if they do not exist
    # If alias exist, update the ip address
    def async_update_firewall(self, ip_address):
        alias_name = "allow_dns_whitelist"
        rule_description = "Allow hosts from DNS whitelist."
        if not pfsense_api.alias_exists(alias_name):
            pfsense_api.create_alias(alias_name, ip_address["address"])
        interface = pfsense_api.get_configured_interface()
        if not pfsense_api.rule_exists(rule_description):
            pfsense_api.create_firewall_rule(alias_name, rule_description, interface)
        alias_data = pfsense_api.add_ip_to_alias_if_not_exists(
            alias_name, ip_address["address"]
        )

# This class creates a "filter" function for advanced filtering of DNS requests
class FilterModule:

    def __init__(self, patterns):
        self.patterns = patterns

    def filter_line(self, line):
        return any(re.search(pattern, line) for pattern in self.patterns)

    @staticmethod
    def validate_ip_destination(address):
        ipv4_match = re.match(filters.ipv4_pattern, address)
        if ipv4_match:
            return {"address_type": "ipv4", "address": ipv4_match.group()}

        ipv6_match = re.match(filters.ipv6_pattern, address)
        if ipv6_match:
            return {"address_type": "ipv6", "address": ipv6_match.group()}

        return None


def run():
    # TODO (chris): Create a function/class to mange pid file
    # Create a pid file
    try:
        # Allow any char. In a future release the UI can offer the ability to specify patterns.
        patterns = [
            ".*",
        ]

        LOG_PATH = os.getenv('DNS_LOG', r'/var/log/pfblockerng/dns_reply.log')

        file_path = Path(LOG_PATH)

        while not file_path.exists():
            time.sleep(.1)

        filter_module = FilterModule(patterns)
        log_watcher = LogWatcher(LOG_PATH, filter_module)
        log_watcher.watch_log()
    except Exception as e:
        logging.error(f"Error occurred: {e}")



if __name__ == "__main__":
    run()
