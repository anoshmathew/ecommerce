<?php 

#	Project		:	Project Name
#	Description	:	Configuration File for database and other settings.	
	
	define("DB_TYPE","mysqli");
	define("DB_HOST","localhost");
	define("DB_USER","root");
	define("DB_PASSWORD","");
	define("DB_NAME","ecommerce");
	define("SMTPHOST", "");
	define("FOLDER_PATH", "/ecommerce/api");
	define("URL", FOLDER_PATH."/");
	define("URLAD", FOLDER_PATH."/admin/");
	define("ROOT_PATH",$_SERVER["HTTP_HOST"].FOLDER_PATH);
	define("ROOT_SITE",$_SERVER["DOCUMENT_ROOT"].FOLDER_PATH);
	define("WEBLINK","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH);
	define("WEBLINKAD","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH."/admin");
	define("FROMMAIL", "info@phpwebsite.in");
	define("FROMNAME", "Freshdaykart"); 
	define("ADMINMAIL", "sumeshtg@gmail.com");
	define("ADMINNAME", "Admin"); 
	define("TITLE", "Ecommerce");
	define("SITE_NAME", "Ecommerce");
	define("SHORT_NAME", "Ecommerce");
	define("WEBSITE", "www.freshdaykart.com");
	define("DESCRIP", "");
	define("SETTINGS", "smartweb");
	define("WATERMARK", "");
	define("CACHE", "Disabled");//Enabled, Disabled
	//ini_set('display_errors', 'On');
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
	ini_set( 'date.timezone', 'Asia/Calcutta' );
	@setcookie( "sweb", SETTINGS, (time() + (10 * 365 * 24 * 60 * 60)));
	define("SECRET_KEY","BhArAt383STGOPPArmAr");	/*IMPORTANT*/
	define("SECRET_USER","swebapuser");	/*IMPORTANT*/
	define("SECRET_PWD","2074@seb#209Y");	/*IMPORTANT*/
	define("SMS_ACCT", "dbb4ab46acd80cdea07537f53c03b084");
    define("SMS_HEAD", "FEDKRT");
	define("API_ROOT_PATH","http://localhost/ecommerce/api/");
	define("FILE_ROOT_PATH","http://localhost/ecommerce/public/");
	define("IMAGE_PATH", 'http://localhost/ecommerce/public/');
	define('SUPPORT_MAIL', 'support@grocery.com');
	define('SUPPORT_NUMBER', '+91 1234567890');
	define('ADMIN_NUMBER', '9446717047');
	define('EMAILPATH', 'http://localhost/ecommerce/public/');
?>

