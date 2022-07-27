<?php
require_once "includes/includepath.php";
require_once "phpmailer/class.phpmailer.php";

$objgen = new general();
$objval	= new validate();
$api    = new api();
$rest   = new rest();
	

$api->valide_method('POST'); // Check Post
$keyparam =  isset($rest->_request['key']) ? $rest->_request['key'] : ""; 
$authkey  = $api->valide_key($keyparam); // Auth key Validation

if($authkey==true)
{
	$id    = isset($rest->_request['id']) ? $rest->_request['id'] : "";
	$status =  isset($rest->_request['status']) ? $rest->_request['status'] : ""; 
	
	$where 	  ="";
	if($id!="")
	{
		$where 	   .=  " AND id=".$id;
	}
	if($status!="")
	{
		$where 		   .= " AND status='$status'";
	}
	$cat_details   	= $objgen->get_AllRowscnt("attributes",$where);
	
	if($cat_details>0)
	{
		$cat_arr 	= $objgen->get_AllRows("attributes",0,$cat_details,"id asc",$where);
		$data		= array();
 	
		foreach($cat_arr as $key=>$val)
		{
		    $key = $key+1;

			$data[$key]['id'] 				= $val['id'];
			$data[$key]['name']    		= $val['name'];
			$data[$key]['template_name']   	= $val['template_name'];
			$data[$key]['status']  			= $val['status'];  
	  }

		$response_arr["data"] 		        = array_values($data);	
		$response_arr["response_code"]      = 200;
		$response_arr["status"]  		    = "Success";
		$response_arr['message']            = "";

		$rest->response($api->json($response_arr), 200);
	}
	else
	{
		$data['response_code']      = 200;
		$data['status']             = "Error";					
		$data['message']            = "No Result Found";

		$rest->response($api->json($data),220);
	}
}
else
{
	$data['response_code']      = 401;
	$data['status']             = 'Error';
	$data['message']            = "Unauthorized";

	$rest->response($api->json($data),401); //'Unauthorized'
}

$api->processApi(); //Process API
?>