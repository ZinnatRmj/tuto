<?php
// date_default_timezone_set( "Indian/Mauritius" ) ;

define('__ROOT__', dirname(dirname(__FILE__)) . '/' );

define( '__BASEURL__', '/' ) ;


$displayerrors = 1 ;

if ( $displayerrors ) {

	// ----------------------------------------------------------------------------------------------------
	// - Display Errors
	// ----------------------------------------------------------------------------------------------------

	ini_set('display_errors', 'On');
	ini_set('html_errors', 0);

	// ----------------------------------------------------------------------------------------------------
	// - Error Reporting
	// ----------------------------------------------------------------------------------------------------
	// error_reporting(-1);

	error_reporting( E_ALL & ~E_NOTICE  & ~E_STRICT & ~E_WARNING );
}
ini_set('memory_limit', '128M');

date_default_timezone_set( 'Europe/Paris' ) ;

class conf {
	public static $server = 'localhost' ;
	public static $database = 'wines' ;
	public static $username = 'root' ;
	public static $password = '' ;

	public static $captchaPrivate = '6LeNZ_sSAAAAAItJn6Xko6GoXa2xN7lUE6dNuk7G' ;
	public static $captchaPublic = "6LeNZ_sSAAAAAJ3u3oh_DRpGUhO-sbKr31wmtJAF" ;

	public static $override = 0 ;
	public static $debugMail = false ;

	public static $from = "no-reply@covea.qualification-insynium.com" ;
	public static $fromName = "Outil prevention covea" ;
	public static $site_url = "http://covea.qualification-insynium.com/" ;

	public static $def = array (
		'com' => 'display' ,
		'task' => null ,
		'view' => 'display'
	);
}
