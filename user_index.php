<?php
	require_once 'core/global.php';
	
	if ($loggedin) {
		$traffic = $sbnc->call("gettraffic");
		$nick = $sbnc->call("getvalue", array("nick"));
		$awaynick = $sbnc->call("getvalue", array("awaynick"));
		$server = $sbnc->call("getvalue", array("server"));
		$port = $sbnc->call("getvalue", array("port"));
				
				if (empty($awaynick)) {
					$awaynick = $nick;
				}
				
				if (empty($server)) {
					$server = '-';
				} elseif ($port != 6667) {
					$server .= ':'.$port;
				}
				
				$breadcrumb = array($_SESSION['user'], 'Index');
				
				if (isset($_POST['lang']) && file_exists('lang/'.$_POST['lang'].'.php')) {
					$sbnc->call("setlang", array($_POST['lang']));
					
					$_SESSION['language'] = $_POST['lang'];
					
					require 'lang/'.$_SESSION['language'].'.php';
					require_once 'templates/header.html';
?>
					<h3><?php echo $LANG['lang_changed']; ?></h3>
					<p><?php echo $LANG['lang_changed_text']; ?></p>
<?php
				} else {
					require_once 'templates/header.html';
				}
?>
					<h3><?php printf($LANG['index_welcome'], $nick); ?></h3>
					
					<p><?php printf($LANG['index_uptime'], Func::duration($sbnc->call("getvalue", array("uptime")))); ?> <?php printf($LANG['index_nick'], $nick, $awaynick); ?> <?php printf($LANG['index_server'], $server); ?></p>
					<p><?php printf($LANG['index_traffic'], Func::byte_format($traffic[2]+$traffic[0]), Func::byte_format($$traffic[3]+$traffic[1]) ); ?></p>
<?php
				$channels = $sbnc->call("getchannels");
				if (is_array($channels)) {
?>
					
					<h3><?php echo $LANG['index_channels']; ?></h3>
					<ul>
<?php
					foreach($sbnc->call("getchannels") as $channel) {
?>
						<li><?php echo $channel; ?></li>
<?php
					}
?>
					</ul>
<?php
				}
?>
					
					<form action="user_index.php" method="post">
						<fieldset>
							<legend>Set Language</legend>
							
							<label for="lang">Select Language</label>
							<select name="lang" id="lang">
								<option value="de"<?php if ($sbnc->call('getlang') == 'de') { echo ' selected="selected"'; } ?>>Deutsch</option>
								<option value="en"<?php if ($sbnc->call('getlang') == 'en') { echo ' selected="selected"'; } ?>>English</option>
							</select>
							
							<input type="submit" value="Submit" class="submit" />
						</fieldset>
					</form>
<?php
		require_once 'templates/footer.html';
	} else {
		header('Location: http://'.$_SERVER['HTTP_HOST'].pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME).'/', true, 307);
	}
?>