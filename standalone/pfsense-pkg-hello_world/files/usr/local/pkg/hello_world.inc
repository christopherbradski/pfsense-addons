#!/usr/local/bin/php -f
<?php
require_once("globals.inc");
require_once("config.inc");
require_once("functions.inc");
require_once("pkg-utils.inc");
require_once("service-utils.inc");

// Define constants and package-specific functions here
define('HELLO_WORLD_CONF', '/usr/local/etc/hello_world.conf');

function install_hello_world() {
    // Create configuration file or make other necessary file system changes
    file_put_contents(HELLO_WORLD_CONF, "hello_world_enabled=yes\n");

    // Add necessary menu items to the pfSense interface
    add_menu_items();

    // Start the hello_world service
    start_service('hello_world');

    // Write changes to the pfSense configuration
    write_config("[Hello World] Package installed.");
}

function add_menu_items() {
    global $config;

    // Define your package's menu item
    $menu_item = array(
        'name' => 'Hello World',
        'section' => 'Services',
        'url' => '/pkg_edit.php?xml=hello_world.xml',
        'desc' => 'Hello World configuration'
    );

    // Check if the menu item already exists
    if (!is_array($config['installedpackages']['menu'])) {
        $config['installedpackages']['menu'] = array();
    }

    // Add the menu item
    $config['installedpackages']['menu'][] = $menu_item;
}

// Main execution block
if ($argv[1] == 'POST-INSTALL') {
    install_hello_world();
}
?>
