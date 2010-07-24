<?php
	require_once 'core/global.php';
	
	session_destroy();
	
	$_SESSION = array();
	
	header('Location: http://'.$_SERVER['HTTP_HOST'].pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME));?>