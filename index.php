<?php
	require_once 'core/global.php';
	
	// This is the main login page, so if User is logged in, we will log him out.
	if ($loggedin) {
		session_destroy();
		
		$_SESSION = array();
	}
	
	// nothing more to do here, just show us the login form
	// Only one file, we won't show any user data this time
	require_once 'templates/login.html';
?>