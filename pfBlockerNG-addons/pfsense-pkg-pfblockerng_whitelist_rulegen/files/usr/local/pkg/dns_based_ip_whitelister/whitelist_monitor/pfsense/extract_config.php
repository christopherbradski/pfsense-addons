<?php
require_once("config.inc");

// Set the main config to the package
$pkg_config = &$config['dns_based_ip_whitelister']; // Use reference to modify the original $config array

$username = $pkg_config['username'];
$apikey = $pkg_config['apikey'];

// Check if 'global_ttl' is set and not null, otherwise set to default (86400 seconds)
if (!isset($pkg_config['global_ttl']) || $pkg_config['global_ttl'] === null) {
    $pkg_config['global_ttl'] = 86400; // Default value for 'global_ttl'

    // Write the changes back to config.xml
    write_config("Setting default value for global_ttl in pfBlockerNG-Addon-Whitelist Rulegen");
}

// Configure default interface for rules gen
if (!isset($pkg_config['interface']) || $pkg_config['interface'] === null) {
    $pkg_config['interface'] = 'lan'; // Default value for 'lan'

    // Write the changes back to config.xml
    write_config("Setting the default interface to LAN");
}

$global_ttl = $pkg_config['global_ttl'];
$interface = $pkg_config['interface'];

echo json_encode(array("apikey" => $apikey,
    "username" => $username,
    "global_ttl" => $global_ttl,
    "interface" => $interface));
?>
