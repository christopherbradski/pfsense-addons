<?php
require_once("guiconfig.inc");

include("head.inc");

if ($_POST) {
    if (isset($_POST['username'])) {
        // Save username
        $config['pfblockerng-addon-whitelist_rulegen']['username'] = $_POST['username'];
        write_config("Saved Username for pfblockerng-addon-whitelist_rulegen");
    }

    if (isset($_POST['apikey'])) {
        // Save API key
        $config['pfblockerng-addon-whitelist_rulegen']['apikey'] = $_POST['apikey'];
        write_config("Saved API Key for pfblockerng-addon-whitelist_rulegen");
    }

}

$username = $config['pfblockerng-addon-whitelist_rulegen']['username'];
$apikey = $config['pfblockerng-addon-whitelist_rulegen']['apikey'];
?>

<!DOCTYPE html>
<html>
<body>
    <form action="whitelist_rulegen_configure.php" method="post">
        Username: <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
        <input type="submit" value="Save Username">
    </form>

    <form action="whitelist_rulegen_configure.php" method="post">
        API Key: <input type="password" name="apikey" value="<?= htmlspecialchars($apikey) ?>">
        <input type="submit" value="Save API Key">
    </form>


</body>
</html>

<?php include("foot.inc"); ?>
