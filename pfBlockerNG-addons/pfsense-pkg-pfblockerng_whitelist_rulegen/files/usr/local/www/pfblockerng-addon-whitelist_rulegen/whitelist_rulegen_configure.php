<?php
require_once("guiconfig.inc");
require_once("head.inc");

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

$pgtitle = array("Whitelist Rulegen Configuration");
include("head.inc");
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">pfSense API Credentials</h2>
    </div>
    <div class="panel-body">
        <form action="whitelist_rulegen_configure.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="username" value="<?= htmlspecialchars($username) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="apikey" class="col-sm-2 control-label">API Key</label>
                <div class="col-sm-10">
                    <input type="password" name="apikey" class="form-control" id="apikey" value="<?= htmlspecialchars($apikey) ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("foot.inc"); ?>
