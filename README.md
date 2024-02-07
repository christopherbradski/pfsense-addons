# pfsense-pfBlockerNG-addons

## pfBlockerNG_addon_whitelister-rulegen
### Introduction
The Whitelist_Rulegen-addon compliments a pfBockerNG install by generating traditional firewall rules based off the wildcard whitelist entries. Without this capability, pfBlockerNG is only capable of performing DNS based blackholing. Any request not on the whitelist is forwarded to a non-existent ip address while valid DNS requests are resolved.

Here, we monitor the DNS based requests and create a dynamic alias list and associated "allow" rule. The alias results are checked on each resolution and if an ip address "expires", it will be removed from the associated alias.

Please note: This package requires pfBlockerNG and the pfSense-API package. These dependencies may be removed in a later version.

### Requirements
Supported Versions:
* pfSense 2.7.X

Required Packages:
* pfSense-API
* pfBlockerNG

### Installation
To install the pfSense-API, simply run the following command from the pfSense shell:
```
    pkg -C /dev/null add https://github.com/jaredhendrickson13/pfsense-api/releases/latest/download/pfSense-2.7-pkg-API.pkg && /etc/rc.restart_webgui
```
Note: omit "&& /etc/restart_webgui" if not installing via SSH.

To install the Whitelist-Rulegen-addon, simply run the following command from the pfSense-shell:
```
    setenv IGNORE_OSVERSION yes && pkg -C /dev/null add https://github.com/christopherbradski/pfsense-addons/releases/download/v0.0.1-alpha/pfsense-pkg-pfblockerng_whitelist_rulegen-0.1.pkg
```

pfBlockerNG is a standard package within the pfSense repository. To install:
```
    pkg install pfSense-pkg-pfBlockerNG
```

### Configuration & Authentication
The Whitelist-Rulegen-addon leverages the pfSense-API to updates the whitelist alias, by default this use the same credentials as the webConfigurator. Users may create an additional API user in 'System/User Manager/Users'. To provide the username and password visit 'Services/Whitelist Rulegen'. Enter the Username and password (aka API key).

The IP Address TTL is default to 1 day, decrease or increase this based on your requirements. Everytime a DNS record is resolved the TTL for all records is checked and removed from the alias if there TTL has expired.

The interface to create the allow rules defaults to 'LAN'. Select the interface that the Whitelist-Rulegen addon should create the policy rules for. Click save and restart the service under 'Status/Services'.
