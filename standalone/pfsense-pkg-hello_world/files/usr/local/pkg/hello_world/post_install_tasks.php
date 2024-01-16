<?php
require_once("config.inc");
require_once("functions.inc");
require_once("util.inc");
require_once("pkg-utils.inc");

// Define the menu entry
$hello_world_menu_item = array(
    'name' => 'Hello World', // Name of the menu item
    'section' => 'Services',       // Section where the menu item should appear
    'url' => '/hello_world.php', // URL of the page to load when the menu item is clicked
    'desc' => 'Hello World' // Description of the menu item
);

// Add the menu entry
if (!is_array($config['installedpackages']['menu'])) {
    $config['installedpackages']['menu'] = array();
}
$config['installedpackages']['menu'][] = $hello_world_menu_item;

// Define the service entry
$hello_world_service = array(
    'name' => 'hello_world', // Name of the service entry
    'description' => 'Hello World Service', // Description of service
    'rcfile' => 'hello_world_service.sh', // Service script located in /usr/local/etc/rc.d/
    'executable' => 'hello_world', // short name of executable < 19 chars..
);

if (!is_array($config['installedpackages']['service'])) {
    $config['installedpackages']['service'] = array();
    }
$config['installedpackages']['service'][] = $hello_world_service;

// Write changes
write_config("Added hello_world menu item and service.");

print("Hello World configuration completed")
?>
