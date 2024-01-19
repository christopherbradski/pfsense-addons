<?php
require_once("config.inc");

// Set the main config to the package
$pkg_config = &$config['pfblockerng-addon-whitelist_rulegen']; // Use reference to modify the original $config array

$username = $pkg_config['username'];
$apikey = $pkg_config['apikey'];

// Check if 'global_ttl' is set and not null, otherwise set to default (86400 seconds)
if (!isset($pkg_config['global_ttl']) || $pkg_config['global_ttl'] === null) {
    $pkg_config['global_ttl'] = 86400; // Default value for 'global_ttl'

    // Write the changes back to config.xml
    write_config("Setting default value for global_ttl in pfBlockerNG-Addon-Whitelist Rulegen");
}

$global_ttl = $pkg_config['global_ttl'];

echo json_encode(array("apikey" => $apikey, "username" => $username, "global_ttl" => $global_ttl));
?>
