<?php
	require_once 'core/global.php';
	
	session_destroy();
	
	$_SESSION = array();
	
	header('Location: '.$path, true, 307);
?>