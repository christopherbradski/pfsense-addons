<?php
require_once("guiconfig.inc");

if ($_POST) {
    if (isset($_POST['apikey'])) {
        // Process API key
        $config['pfblockerng-addon-whitelist_rulegen']['apikey'] = $_POST['apikey'];
        write_config("Saved API Key for pfblockerng-addon-whitelist_rulegen");
    }

    if (isset($_POST['username'])) {
        // Process username
        $config['pfblockerng-addon-whitelist_rulegen']['username'] = $_POST['username'];
        write_config("Saved Username for pfblockerng-addon-whitelist_rulegen");
    }

    if ($_POST['action'] == "add_domain") {
        // Add domain
        $config['pfblockerng-addon-whitelist_rulegen']['domains'][] = $_POST['domain'];
        write_config("Added new domain to pfblockerng-addon-whitelist_rulegen");
    } elseif ($_POST['action'] == "delete_domain") {
        // Delete domain
        $index = $_POST['index'];
        unset($config['pfblockerng-addon-whitelist_rulegen']['domains'][$index]);
        write_config("Deleted a domain from pfblockerng-addon-whitelist_rulegen");
    }
}

$apikey = $config['pfblockerng-addon-whitelist_rulegen']['apikey'];
$username = $config['pfblockerng-addon-whitelist_rulegen']['username'];
$domains = $config['pfblockerng-addon-whitelist_rulegen']['domains'];
?>

<!DOCTYPE html>
<html>
<body>
    <form action="whitelist_rulegen_configure.php" method="post">
        API Key: <input type="text" name="apikey" value="<?= htmlspecialchars($apikey) ?>">
        <input type="submit" value="Save API Key">
    </form>

    <form action="whitelist_rulegen_configure.php" method="post">
        Username: <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
        <input type="submit" value="Save Username">
    </form>

    <form action="whitelist_rulegen_configure.php" method="post">
        Add Domain: <input type="text" name="domain">
        <input type="hidden" name="action" value="add_domain">
        <input type="submit" value="Add Domain">
    </form>

    <?php if (!empty($domains)): ?>
        <ul>
            <?php foreach ($domains as $index => $domain): ?>
                <li>
                    <?= htmlspecialchars($domain) ?>
                    <form action="whitelist_rulegen_configure.php" method="post">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <input type="hidden" name="action" value="delete_domain">
                        <input type="submit" value="Delete">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
