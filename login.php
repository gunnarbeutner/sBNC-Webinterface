<?php
	require_once 'core/global.php';
	
	if (isset($_POST['user'], $_POST['pass']) && $sbnc->login($_POST['user'], $_POST['pass'])) {
		$_SESSION['user'] = $_POST['user'];
		$_SESSION['pass'] = $_POST['pass'];
		
		$lang = $sbnc->Call('gettag', array('lang'));
		if (file_exists('lang/'.$lang.'.php')) {
			$_SESSION['language'] = $lang;
		} else {
			$_SESSION['language'] = 'en';
		}
		
		unset($sbnc);
		
		header('Location: '.$path.'user_index.php', true, 307);
	} else {
		header('Location: '.$path, true, 307);
	}
?>