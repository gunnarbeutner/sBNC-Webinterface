<?php
	require_once 'core/global.php';
	
	if (!$loggedin) {
		header('Location: '.$path, true, 307);
		exit(0);
	}
	
	$traffic = $sbnc->call("gettraffic");
	$nick = $sbnc->call("getvalue", array("nick"));
	$awaynick = $sbnc->call("getvalue", array("awaynick"));
	$server = $sbnc->call("getvalue", array("server"));
	$port = $sbnc->call("getvalue", array("port"));
	
	$breadcrumb = array($_SESSION['user'], $LANG['menu_settings']);
	
	/**
	 * https://sourceforge.net/apps/mantisbt/sbnc/view.php?id=1
	 *
	 * lock.tcl lacks iface2-support
	 * I'll define all locked settings as false unless lock.tcl is working
	 *
	 * Change value to true, if you locked these settings. They will not appear in list
	 * and users will not be able to change them with this interface
	 */
	
	$realname_locked    = false;
	$vhost_locked       = false;
	$server_locked      = false;
	$serverpass_locked  = false;
	$awaynick_locked    = false;
	$away_locked        = false;
	$awaymessage_locked = true; // This is globally locked in default lock.tcl and also part of a tcl script, so i'll lock it by default unless it is possible to find out if it is really locked.
	
	$vhost = $sbnc->call('getvalue', array('vhost'));
	
	if (empty($vhost)) {
		$vhost = $sbnc->call('getglobaltag', array('gvhost'));
	}
	
	$realname = $sbnc->call('getvalue', array('realname'));
	$server = $sbnc->call('getvalue', array('server'));
	$port = intval($sbnc->call('getvalue', array('port')));
	$serverpass = $sbnc->call("getvalue", array("serverpass"));
	$awaynick = $sbnc->call("getvalue", array("awaynick"));
	$away = $sbnc->call("getvalue", array("away"));
	
	require_once 'templates/header.html';
	
	if (isset($_POST['realname']) && $_POST['realname'] != $realname) {
		$sbnc->call("setvalue", array("realname", $_POST['realname']));
?>
			<h3><?php echo $LANG['settings_realname']; ?></h3>
			<p><?php printf($LANG['settings_realname_changed'], htmlspecialchars($_POST['realname'])); ?></p>
<?php
		$realname = $_POST['realname'];
	}
	
	if (isset($_POST['vhost']) && $_POST['vhost'] != $vhost) {
		$sbnc->call("setvalue", array("vhost", $_POST['vhost']));
?>
			<h3><?php echo $LANG['settings_vhost']; ?></h3>
			<p><?php printf($LANG['settings_vhost_changed'], htmlspecialchars($_POST['vhost'])); ?></p>
<?php
		$vhost = $_POST['vhost'];
	}
	
	if (isset($_POST['server'])) {
		$srv = explode(':', $_POST['server'], 2);
		
		if ($server != $srv[0]) {
			$sbnc->call("setvalue", array("server", $srv[0]));
				
			$server = $srv[0];
		}
		
		if ($port != $srv[1]) {
			$sbnc->call("setvalue", array("port", $srv[1]));
				
			$port = $srv[1];
		}
		
		if ($server != $srv[0] || $port != $srv[1]) {
?>
			<h3><?php echo $LANG['settings_server']; ?></h3>
			<p><?php printf($LANG['settings_server_changed'], htmlspecialchars($_POST['server'])); ?></p>
<?php
		}
	}
	
	if (isset($_POST['serverpass']) && $_POST['serverpass'] != $serverpass) {
		$sbnc->call("setvalue", array("serverpass", $_POST['serverpass']));
?>
			<h3><?php echo $LANG['settings_serverpass']; ?></h3>
			<p><?php printf($LANG['settings_serverpass_changed'], htmlspecialchars($_POST['serverpass'])); ?></p>
<?php
		$serverpass = $_POST['serverpass'];
	}
	
	if (isset($_POST['awaynick']) && $_POST['awaynick'] != $awaynick) {
		$sbnc->call("setvalue", array("awaynick", $_POST['awaynick']));
?>
			<h3><?php echo $LANG['settings_awaynick']; ?></h3>
			<p><?php printf($LANG['settings_awaynick_changed'], htmlspecialchars($_POST['awaynick'])); ?></p>
<?php
		$awaynick = $_POST['awaynick'];
	}
	
	if (isset($_POST['away']) && $_POST['away'] != $away) {
		$sbnc->call("setvalue", array("away", $_POST['away']));
?>
			<h3><?php echo $LANG['settings_away']; ?></h3>
			<p><?php printf($LANG['settings_away_changed'], htmlspecialchars($_POST['away'])); ?></p>
<?php
		$away = $_POST['away'];
	}
?>
	
	<form action="user_settings.php" method="post">
		<fieldset>
			<legend><?php echo $LANG['settings_general']; ?></legend>
							
			<label for="realname" class="left"><?php echo $LANG['settings_realname']; ?></label>
			<input type="text" name="realname" id="realname" value="<?php echo htmlspecialchars($realname); ?>" placeholder="<?php echo $LANG['settings_realname_placeholder']; ?>" title="<?php echo $LANG['settings_realname_placeholder']; ?>" /><br />
			
			<label for="vhost" class="left"><?php echo $LANG['settings_vhost']; ?></label>
			<input type="text" name="vhost" id="vhost" value="<?php echo $vhost; ?>" placeholder="<?php echo $LANG['settings_vhost_placeholder']; ?>" title="<?php echo $LANG['settings_vhost_placeholder']; ?>" /><br />
		</fieldset>

		<fieldset>
			<legend><?php echo $LANG['settings_server']; ?></legend>
			
			<label for="server" class="left"><?php echo $LANG['settings_server']; ?></label>
			<input type="text" name="server" id="server" value="<?php echo htmlspecialchars($server).':'.$port; ?>" placeholder="<?php echo $LANG['settings_server_placeholder']; ?>" title="<?php echo $LANG['settings_server_placeholder']; ?>" /><br />
			
			<label for="serverpass" class="left"><?php echo $LANG['settings_serverpass']; ?></label>
			<input type="text" name="serverpass" id="serverpass" value="<?php echo htmlspecialchars($serverpass); ?>" placeholder="<?php echo $LANG['settings_serverpass_placeholder']; ?>" title="<?php echo $LANG['settings_serverpass_placeholder']; ?>" /><br />
		</fieldset>

		<fieldset>
			<legend><?php echo $LANG['settings_away']; ?></legend>
							
			<label for="awaynick" class="left"><?php echo $LANG['settings_awaynick']; ?></label>
			<input type="text" name="awaynick" id="awaynick" value="<?php echo htmlspecialchars($awaynick); ?>" placeholder="<?php echo $LANG['settings_awaynick_placeholder']; ?>" title="<?php echo $LANG['settings_awaynick_placeholder']; ?>" /><br />
							
			<label for="away" class="left"><?php echo $LANG['settings_away']; ?></label>
			<input type="text" name="away" id="away" value="<?php echo htmlspecialchars($away); ?>" placeholder="<?php echo $LANG['settings_away_placeholder']; ?>" title="<?php echo $LANG['settings_away_placeholder']; ?>" /><br />
						
			<input type="submit" value="<?php echo $LANG['form_submit']; ?>" class="submit" />
		</fieldset>
	</form>
<?php
	require_once 'templates/footer.html';
?>
