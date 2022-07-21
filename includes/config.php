<?php 

#	Project		:	Project Name
#	Description	:	Configuration File for database and other settings.	
	
	define("DB_TYPE","mysqli");
	define("DB_HOST","localhost");
	define("DB_USER","root");
	define("DB_PASSWORD","");
	define("DB_NAME","ecommerce");
	define("SMTPHOST", "");
	define("FOLDER_PATH", "/ecommerce");
	define("URL", FOLDER_PATH."/");
	define("URLAD", FOLDER_PATH."/admin/");
	define("ROOT_PATH",$_SERVER["HTTP_HOST"].FOLDER_PATH);
	define("ROOT_SITE",$_SERVER["DOCUMENT_ROOT"].FOLDER_PATH);
	define("WEBLINK","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH);
	define("WEBLINKAD","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH."/admin");
	define("FROMMAIL", "info@phpwebsite.in");
	define("FROMNAME", "Admin"); 
	define("ADMINMAIL", "sumeshtg@gmail.com");
	define("ADMINNAME", "Admin"); 
	define("TITLE", "SmartWebIn");
	define("SITE_NAME", "SmartWebIn");
	define("SHORT_NAME", "SwebIn");
	define("WEBSITE", "www.example.com");
	define("DESCRIP", "");
	define("SETTINGS", "smartweb");
	define("WATERMARK", "");
	define("TH_COLOR", "primary");
	//ini_set('display_errors', 'On');
	ini_set( 'date.timezone', 'Asia/Calcutta' );
	@setcookie( "sweb", SETTINGS, (time() + (10 * 365 * 24 * 60 * 60)));
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
	
	
?>

