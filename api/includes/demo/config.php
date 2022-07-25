<?php 



#	Project		:	Project Name

#	Description	:	Configuration File for database and other settings.	

	

	define("DB_TYPE","mysqli");

	define("DB_HOST","localhost");

	define("DB_USER","phpwebyg_springbazaar");

	define("DB_PASSWORD","JaWY2FHKJ4");

	define("DB_NAME","phpwebyg_springbazaar");

	define("SMTPHOST", "");

	define("FOLDER_PATH", "/sumesh/springbazaarapi");

	define("URL", FOLDER_PATH."/");

	define("URLAD", FOLDER_PATH."/admin/");

	define("ROOT_PATH",$_SERVER["HTTP_HOST"].FOLDER_PATH);

	define("ROOT_SITE",$_SERVER["DOCUMENT_ROOT"].FOLDER_PATH);

	define("WEBLINK","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH);

	define("WEBLINKAD","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH."/admin");

	define("FROMMAIL", "info@phpwebsite.in");

	define("FROMNAME", "TheSpringbazaar"); 

	define("ADMINMAIL", "sumeshtg@gmail.com");

	define("ADMINNAME", "Admin"); 

	define("TITLE", "TheSpringbazaar");

	define("SITE_NAME", "TheSpringbazaar");

	define("SHORT_NAME", "TheSpringbazaar");

	define("WEBSITE", "www.example.com");

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

	define("SMS_ACCT", "dbb4ab46acd80cdea07537f53c03b084");

    define("SMS_HEAD", "FEDKRT");

	define("API_ROOT_PATH","http://project.phpwebsites.in/springbazaarapi/");
	define("FILE_ROOT_PATH","http://project.phpwebsites.in/springbazaar/public/");
	define("IMAGE_PATH", 'http://project.phpwebsites.in/springbazaar/public/');
	define('SUPPORT_MAIL', 'support@grocery.com');
	define('SUPPORT_NUMBER', '+91 1234567890');
	define('EMAILPATH', 'http://project.phpwebsites.in/springbazaar/public/');

?>



