<?php
	$LANG = array(
			'menu_logout'                   => 'Abmelden',
			'menu_index'                    => 'Übersicht',
			'menu_settings'                 => 'Einstellungen',
			'menu_admin'                    => 'Admin',
			'menu_log'                      => 'Awaylog',
			'menu_admin_userlist'           => 'Benutzerliste',
			'menu_admin_trust'              => 'Trusted IPs',
			'menu_admin_tags'               => 'Einstellungen',
			'menu_admin_mainlog'            => 'Mainlog',
			
			'index_welcome'                 => 'Willkommen, %s!',
			'index_uptime'                  => 'Du bist seit <strong>%s</strong> im IRC unterwegs.',
			'index_nick'                    => 'Dein derzeitiger Nickname ist <strong>%s</strong>, dein Awaynick ist <strong>%s</strong>.',
			'index_server'                  => 'Du bist zum Server <strong>%s</strong> verbunden.',
			'index_traffic'                 => 'Du hast bisher %s eingehenden Traffic und %s ausgehenden Traffic verursacht.',
			'index_channels'                => 'Kanäle',
			'index_status'                  => 'Online-Status',
			'index_statusimage'             => 'Um in Foren, Blogs etc. deinen Onlinestatus im IRC anzuzeigen, kannst du folgende Grafik verwenden: <img src="'.pathinfo($_SERVER['REQUEST_URI'], PATHINFO_DIRNAME).'status.php?user=%s" alt="Online-Status von %s" />',
			
			'settings_realname'             => 'Echter Name',
			'settings_realname_placeholder' => 'Der Name des Besitzers des Bouncers.',
			'settings_realname_changed'     => 'Der echte Name wurde auf <strong>%s</strong> geändert.',
			
			'settings_vhost'                => 'vHost',
			'settings_vhost_placeholder'    => 'vHost des Bouncers, leerlassen für Standard.',
			'settings_vhost_changed'        => 'Die vHost wurde auf <strong>%s</strong> geändert.',
			'settings_vhost_default'	=> 'Standard-vHost',
			
			'settings_server'               => 'IRC-Server',
			'settings_server_placeholder'   => 'Die Adresse des IRC-Servers, zu den shroudBNC verbinden soll.',
			'settings_server_changed'       => 'Die Adresse des IRC-Servers wurde auf <strong>%s</strong> geändert.',
			
			'settings_serverpass'           => 'IRC-Server-Passwort',
			'settings_serverpass_placeholder' => 'Das Passwort des IRC-Servers, zu dem verbunden wird.',
			'settings_serverpass_changed'   => 'Das Passwort des IRC-Servers wurde auf <strong>%s</strong> geändert.',
			
			'settings_awaynick'             => 'Awaynick',
			'settings_awaynick_placeholder' => 'Der Awaynick wird gesetzt, sobald du vom Bouncer disconnectest.',
			'settings_awaynick_changed'     => 'Der Awaynick wurde auf <strong>%s</strong> geändert.',
			
			'settings_away'                 => 'Abwesenheitsnachricht',
			'settings_away_placeholder'     => 'Die Abwesenheitsnachricht wird gesetzt, sobald du vom Bouncer disconnectest.',
			'settings_away_changed'         => 'Die Abwesenheitsnachricht wurde auf <strong>%s</strong> geändert.',
			
			'settings_nickserv'             => 'NickServ',
			'settings_nick'                 => 'Nickname',
			'settings_nick_changed'         => 'Der Nickname wurde auf <strong>%s</strong> geändert.',
			
			'settings_password'             => 'Passwort',
			'settings_password_changed'     => 'Das Passwort wurde auf <strong>%s</strong> geändert.',
			
			'log_erased'                    => 'Das Log wurde gelöscht.',
			'log_prompt'                    => 'Log leeren',
			
			'lang_changed'                  => 'Sprache geändert',
			'lang_changed_text'             => 'Die Sprache wurde auf <strong>Deutsch</strong> geändert.',
			
			'form_submit'                   => 'Absenden',
			
			'admin_userlist'                => 'Benutzerliste'
		);
?>
