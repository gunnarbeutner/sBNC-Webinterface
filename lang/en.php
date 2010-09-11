<?php
	$LANG = array(
			'menu_logout'                   => 'Logout',
			'menu_index'                    => 'Index',
			'menu_settings'                 => 'Settings',
			'menu_admin'                    => 'Admin',
			'menu_log'                      => 'Awaylog',
			
			'index_welcome'                 => 'Welcome, %s!',
			'index_uptime'                  => 'You are connected to IRC for <strong>%s</strong>.',
			'index_nick'                    => 'Your current nick is <strong>%s</strong>, awaynick is <strong>%s</strong>.',
			'index_server'                  => 'You are connected to server <strong>%s</strong>.',
			'index_traffic'                 => 'Traffic: Incoming %s, Outgoing %s',
			'index_channels'                => 'Channels',
			'index_status'                  => 'Online-Status',
			'index_statusimage'             => 'You are able to show your Status using the following image: <img src="'.pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME).'status.php?user=%s" alt="Online-Status of %s" />',
			
			'settings_realname'             => 'Real Name',
			'settings_realname_placeholder' => 'Name of Bouncer owner',
			'settings_realname_changed'     => 'Real Name was changed to <strong>%s</strong>.',
			
			'settings_vhost'                => 'vHost',
			'settings_vhost_placeholder'    => 'vHost of bouncer, leave empty for default',
			'settings_vhost_changed'        => 'vHost was changed to <strong>%s</strong>.',
			'settings_vhost_default'	=> 'Default vHost',
			
			'settings_server'               => 'IRC Server',
			'settings_server_placeholder'   => 'The IRC Server to connect to',
			'settings_server_changed'       => 'IRC Server was changed to <strong>%s</strong>.',
			
			'settings_serverpass'           => 'IRC Server Password',
			'settings_serverpass_placeholder' => 'Password of IRC Server, if needed',
			'settings_serverpass_changed'   => 'IRC Server Password was changed to <strong>%s</strong>.',
			
			'settings_awaynick'             => 'Awaynick',
			'settings_awaynick_placeholder' => 'Awaynick will be set upon disconnection',
			'settings_awaynick_changed'     => 'Awaynick was changed to <strong>%s</strong>.',
			
			'settings_away'                 => 'Away Message',
			'settings_away_placeholder'     => 'Away will be set upon disconnection',
			'settings_away_changed'         => 'Away was changed to <strong>%s</strong>.',
			
			'settings_nickserv'             => 'NickServ',
			'settings_nick'                 => 'Nickname',
			'settings_nick_changed'         => 'Nickname was changed to <strong>%s</strong>.',
			
			'settings_password'             => 'Password',
			'settings_password_changed'     => 'Password was changed to <strong>%s</strong>.',
			
			'log_erased'                    => 'Log was erased.',
			'log_prompt'                    => 'Erase log',
			
			'lang_changed'                  => 'Language changed',
			'lang_changed_text'             => 'Language was changed to <strong>english</strong>.',
			
			'form_submit'                   => 'Submit'
		);
?>
