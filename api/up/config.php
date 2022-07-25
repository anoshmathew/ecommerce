<?php 



#	Project		:	Project Name

#	Description	:	Configuration File for database and other settings.	

	

	define("DB_TYPE","mysqli");

	define("DB_HOST","localhost");

	define("DB_USER","appdevel_freshdaykart");

	define("DB_PASSWORD","+H.EnaRI5XxY");

	define("DB_NAME","appdevel_freshdaykart");

	define("SMTPHOST", "");

	define("FOLDER_PATH", "/api");

	define("URL", FOLDER_PATH."/");

	define("URLAD", FOLDER_PATH."/admin/");

	define("ROOT_PATH",$_SERVER["HTTP_HOST"].FOLDER_PATH);

	define("ROOT_SITE",$_SERVER["DOCUMENT_ROOT"].FOLDER_PATH);

	define("WEBLINK","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH);

	define("WEBLINKAD","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH."/admin");

	define("FROMMAIL", "info@freshdaykart.com");

	define("FROMNAME", "Freshdaykart"); 

	define("ADMINMAIL", "sumeshtg@gmail.com");

	define("ADMINNAME", "Freshdaykart"); 

	define("TITLE", "Freshdaykart");

	define("SITE_NAME", "Freshdaykart");

	define("SHORT_NAME", "Freshdaykart");

	define("WEBSITE", "www.freshdaykart.com");

	define("DESCRIP", "");

	define("SETTINGS", "smartweb");

	define("WATERMARK", "");

	define("CACHE", "Disabled");//Enabled, Disabled

	//ini_set('display_errors', 'On');

	error_reporting (E_ALL ^ E_NOTICE);

	ini_set( 'date.timezone', 'Asia/Calcutta' );

	@setcookie( "sweb", SETTINGS, (time() + (10 * 365 * 24 * 60 * 60)));

	define("SECRET_KEY","BhArAt383STGOPPArmAr");	/*IMPORTANT*/

	define("SECRET_USER","swebapuser");	/*IMPORTANT*/

	define("SECRET_PWD","2074@seb#209Y");	/*IMPORTANT*/

	define("SMS_ACCT", "4a1b102c5d4d0925b2900a0788ed494b");
    define("SMS_HEAD", "FRDKRT");

	define("API_ROOT_PATH","http://freshdaykart.com/api/");

	define("FILE_ROOT_PATH","http://freshdaykart.com/public/");

	define("IMAGE_PATH", 'http://freshdaykart.com/public/');

	define('SUPPORT_MAIL', 'freshdaykart@gmail.com');

	define('SUPPORT_NUMBER', '+91 9074077007');

	define('ADMIN_NUMBER', '9446717047');

	define('EMAILPATH', 'http://freshdaykart.com/public/');

?>



