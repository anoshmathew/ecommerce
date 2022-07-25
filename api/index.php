<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
 require_once "includes/includepath.php";
  #remove the directory path we don't want
   if(URL!="/")
  {
  $request  = str_replace(URL, "", $_SERVER['REQUEST_URI']);
  }
  else
  {
    $request = ltrim($_SERVER['REQUEST_URI'],'/');
  }
 //$request = $_SERVER['REQUEST_URI'];
 
  #split the path by '/'
  $params     = explode("/", $request);
  
 //print_r($params);

  #keeps users from requesting any file they want
  $safe_pages = array( "nourl", "thread");
  
  if($params[0]=="")
  {
    include("api.php");
  }
  else
  {
   
  if(!in_array($params[0], $safe_pages)) {
    if(file_exists($params[0].".php"))
	 include($params[0].".php");
	else
	  include("404.php");
  } else {
    include("404.php");
  }
  
  }
?>