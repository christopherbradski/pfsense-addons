<?php
require_once("config.inc");

// Assuming 'my_package' is the name of your package
$pkg_config = $config['installedpackages']['pfblockerng-addon-whitelist_rulegen']['config'][0];
$username = $pkg_config['username'];
$api = $pkg_config['apikey'];

echo json_encode(array("api" => $api, "username" => $username));
?>
