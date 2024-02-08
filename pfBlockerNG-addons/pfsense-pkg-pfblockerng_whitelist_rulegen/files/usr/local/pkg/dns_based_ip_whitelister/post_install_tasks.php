<?php
require_once("config.inc");
require_once("functions.inc");
require_once("util.inc");
require_once("pkg-utils.inc");

// Define the menu entry
$menu_item = array(
    'name' => 'Whitelist Rulegen',
    'section' => 'Services',
    'url' => '/dns_based_ip_whitelister/whitelist_rulegen_configure.php',
    'desc' => 'pfBlockerNG-addon create firewall rules from wildcard DNS whitelist'
);

// Check if the menu entry already exists
$found_menu = false;
if (is_array($config['installedpackages']['menu'])) {
    foreach ($config['installedpackages']['menu'] as $item) {
        if ($item['name'] == $menu_item['name']) {
            $found_menu = true;
            break;
        }
    }
}

// Add the menu entry if it doesn't exist
if (!$found_menu) {
    $config['installedpackages']['menu'][] = $menu_item;
    print("Added Whitelist Rulegen menu item.\n");
}

// Define the service entry
$service_entry = array(
    'name' => 'whitelist_rulegen', // Name of the service entry
    'description' => 'Whitelist Rulegen Service', // Description of service
    'rcfile' => '/usr/local/etc/rc.d/svc_whitelist.sh', // Service script located in /usr/local/etc/rc.d/
    'executable' => 'svc_whitelist', // short name of executable < 19 chars..
    'custom_php_service_status_command' =>
        "'mwexec(\"/usr/local/etc/rc.d/svc_whitelist.sh status\") == 0;'"
);

// Check if the service entry already exists
$found_service = false;
if (is_array($config['installedpackages']['service'])) {
    foreach ($config['installedpackages']['service'] as $service) {
        if ($service['name'] == $service_entry['name']) {
            $found_service = true;
            break;
        }
    }
}

// Add the service entry if it doesn't exist
if (!$found_service) {
    $config['installedpackages']['service'][] = $service_entry;
    write_config("Installed whitelist service");
    print("Added Whitelist Rulegen service.\n");
}

// Write changes if new items were added
if (!$found_menu) {
    write_config("Added Whitelist Rulegen menu item(s)");
    print("Added Whitelist Rulegen menu item.\n");
}

print("Whitelist Rulegen configuration completed\n");
?>
