<?php
@ob_start();
@session_start();
require_once "includes/config.php";

if(file_exists("includes/settings.php"))
{
ini_set("include_path", ROOT_SITE.'/classes' . PATH_SEPARATOR . ROOT_SITE.'/includes' . PATH_SEPARATOR . PATH_SEPARATOR . ROOT_SITE.'/admin/includes' .ini_get("include_path"));

function my_autoloader($class_name) { 
	require_once $class_name . '.class.php';
}

spl_autoload_register('my_autoloader');
}

$request  = str_replace(URL, "", $_SERVER['REQUEST_URI']);
$params     = explode("/", $request);

//$check = new settings(SETTINGS);
//if($check->info->status == 'false')
	//exit($check->info->message);
?>