<?php
	function __autoload($class) {
		if (file_exists('core/class.'.$class.'.php') && is_readable('core/class.'.$class.'.php')) {
			require_once 'core/class.'.$class.'.php';
		}
	}
	
	session_start();
	
	$sbnc = new sBNCInterface;
	
	if (!empty($_SESSION['user']) && !empty($_SESSION['pass']) && $sbnc->login($_SESSION['user'], $_SESSION['pass'])) {
		if (file_exists('lang/'.$_SESSION['language'].'.php')) {
			require_once 'lang/'.$_SESSION['language'].'.php';
			
		} elseif (file_exists('lang/en.php')) {
			require_once 'lang/en.php';
			
		} else {
			Error::failure('Language not found', array('There is no supported language file available.'));
		}
		
		$loggedin = true;
	} else {
		$loggedin = false;
	}
	
	$path = 'http://'.$_SERVER['HTTP_HOST'].pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME);
	
	if (substr($path, -1) != '/'){
		$path .= '/';
	}
	
	if ($sbnc->call('getvalue', array('admin')) == 1) {
		if (!empty($_SERVER['SERVER_ADDR'])) {
			if ($sbnc->call('istrustedip', array($_SERVER['SERVER_ADDR'])) != 1) {
				$sbnc->call('addtrustedip', array($_SERVER['SERVER_ADDR']));
			}
		} else {
			if (count($sbnc->call('gettrustedips')) == 0) {
				Error::warn('Trusted IP missing', array('You didn\'t add a trusted IP to shroudBNC and i wasnt able add your servers IP to shroudBNC', 'Please type the following into your client on IRC when connected to shroudBNC', '<code>/sbnc tcl iface-trust:addtrustedip &lt;your webservers IP&gt;</code>'));
			}
		}
	}
?>
