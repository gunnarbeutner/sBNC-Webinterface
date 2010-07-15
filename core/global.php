<?php
	function __autoload($class) {
		if (file_exists('core/class.'.$class.'.php') && is_readable('core/class.'.$class.'.php')) {
			require_once 'core/class.'.$class.'.php';
		}
	}
	
	session_start();
	
	$sbnc = new sBNCInterface;
	
	if (!empty($_SESSION['user']) && !empty($_SESSION['pass']) && $sbnc->login($_SESSION['user'], $_SESSION['pass'])) {
		$loggedin = true;
	} else {
		$loggedin = false;
	}
?>