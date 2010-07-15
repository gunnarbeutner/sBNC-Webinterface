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
?>