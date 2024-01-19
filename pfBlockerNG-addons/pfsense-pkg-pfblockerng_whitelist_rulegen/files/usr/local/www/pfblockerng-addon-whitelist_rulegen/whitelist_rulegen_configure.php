<?php
require_once("guiconfig.inc");
require_once("head.inc");

// Fetch the available interfaces
$interfaces = get_configured_interface_with_descr();
if (!$interfaces) {
    $interfaces = array('lan' => 'LAN');
}

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

    if (isset($_POST['global_ttl'])) {
        // Save configured global_ttl
        $config['pfblockerng-addon-whitelist_rulegen']['global_ttl'] = $_POST['global_ttl'];
        write_config("Saved IP TTL for pfblockerng-addon-whitelist_rulegen");
    }

    if (isset($_POST['interface'])) {
        // Save selected interface
        $config['pfblockerng-addon-whitelist_rulegen']['interface'] = $_POST['interface'];
        write_config("Saved Interface for pfblockerng-addon-whitelist_rulegen");
    }
}

$username = $config['pfblockerng-addon-whitelist_rulegen']['username'];
$apikey = $config['pfblockerng-addon-whitelist_rulegen']['apikey'];
$global_ttl = $config['pfblockerng-addon-whitelist_rulegen']['global_ttl'] ?? '86400'; // Default to 1 Day in seconds
$selected_interface = $config['pfblockerng-addon-whitelist_rulegen']['interface'] ?? 'lan'; // Default to 'LAN'

$pgtitle = array("Whitelist Rulegen Configuration");
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

<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Whitelist Configuration</h2>
    </div>
    <div class="panel-body">
        <form action="whitelist_rulegen_configure.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="global_ttl" class="col-sm-2 control-label">IP Address TTL (seconds)</label>
                <div class="col-sm-10">
                    <input type="text" name="ip_ttl" class="form-control" id="global_ttl" value="<?= htmlspecialchars($global_ttl) ?>">
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

<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">Interface Selection</h2>
    </div>
    <div class="panel-body">
        <form action="whitelist_rulegen_configure.php" method="post" class="form-horizontal">
            <div class="form-group">
                <label for="interface" class="col-sm-2 control-label">Interface</label>
                <div class="col-sm-10">
                    <select name="interface" id="interface" class="form-control">
                        <?php foreach ($interfaces as $iface_name => $iface_descr): ?>
                            <option value="<?= htmlspecialchars($iface_name) ?>" <?= $iface_name == $selected_interface ? 'selected' : '' ?>>
                                <?= htmlspecialchars($iface_descr) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
