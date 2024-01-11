import os
import requests

from requests.auth import HTTPBasicAuth

# ToDo: Move this to a config file for pfSense UI

pfsense_url = os.getenv("PFSENSE_URL", "https://https://127.0.0.1/api/v1/")
pfsense_username = os.getenv("PFSENSE_USERNAME", "admin")
pfsense_password = os.getenv("PFSENSE_PASSWORD", "pfsense")

auth = HTTPBasicAuth(pfsense_username, pfsense_password)

# Check if an alias exists
def alias_exists(alias_name):
    response = requests.get(pfsense_url + "firewall/alias", auth=auth, verify=False)
    if response.status_code == 200:
        for alias in response.json()["data"]:
            if alias["name"] == alias_name:
                return True
    return False

# Check if a rule exists
def rule_exists(rule_description):
    response = requests.get(pfsense_url + "firewall/rule", auth=auth, verify=False)
    if response.status_code == 200:
        for rule in response.json()["data"]:
            print(rule)
            if rule["descr"] == rule_description:
                return True
    return False

# Create an firewall rule based using an alias as source
def create_firewall_rule(alias_name, rule_description):
    new_rule_payload = {
        "type": "pass",
        "interface": "lan",
        "protocol": "any",
        "flaoting": True,
        "src": "any",
        "dst": alias_name,
        "descr": rule_description,
        "ipprotocol": "inet",
    }

    response = requests.post(
        pfsense_url + "firewall/rule", auth=auth, json=new_rule_payload, verify=False
    )
    if response.status_code == 200:
        print("Firewall rule created successfully.")
    else:
        print(f"Error creating firewall rule: {response.status_code} - {response.text}")

# Get details of an alias
def get_alias_data(alias_name):
    response = requests.get(pfsense_url + f"firewall/alias", auth=auth, verify=False)
    if response.status_code == 200:
        raw_alias_data = response.json()["data"]
        for alias in raw_alias_data:
            if alias["name"] == alias_name:
                return alias
    else:
        print(f"Error fetching alias data: {response.status_code} - {response.text}")
        return None

# Create a new alias
def create_alias(alias_name, addresses):
    new_alias_payload = {
        "name": alias_name,
        "type": "host",
        "address": addresses,
    }

    response = requests.post(
        pfsense_url + "firewall/alias", auth=auth, json=new_alias_payload, verify=False
    )
    if response.status_code == 200:
        print("Alias created successfully.")
    else:
        print(f"Error creating alias: {response.status_code} - {response.text}")

# Update alias with ip address
def update_alias(alias_name, address):
    update_payload = {
        "name": alias_name,
        "address": [address],
        "detail": "Managed by DNS whitelist",
    }
    print(update_payload)
    response = requests.post(
        pfsense_url + f"firewall/alias/entry",
        auth=auth,
        json=update_payload,
        verify=False,
    )
    if response.status_code == 200:
        print("Alias updated successfully.")
    else:
        print(f"Error updating alias: {response.status_code} - {response.text}")

# Add an ip address to an alias if not exist
def add_ip_to_alias_if_not_exists(alias_name, ip_address):
    alias_data = get_alias_data(alias_name)
    if alias_data is None:
        print("Alias does not exist or could not be retrieved.")
        return None
    if ip_address in alias_data["address"]:
        print(f"IP {ip_address} already exists in the alias {alias_name}.")
        return
    else:
        update_alias(alias_name, ip_address)
        return alias_data
