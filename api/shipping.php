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
	
	$where 	  ="";
	if($id!="")
	{
		$where 	   .=  " AND id=".$id;
	}
	
	$ship_details   	= $objgen->get_AllRowscnt("shipping_charge",$where);
	
	if($ship_details>0)
	{
		$ship_arr 	= $objgen->get_AllRows("shipping_charge",0,$ship_details,"id asc",$where);
		$data		= array();
 	
		foreach($ship_arr as $key=>$val)
		{
		    $key = $key+1;

			$data[$key]['id'] 				        = $val['id'];
			$data[$key]['name']    		            = $val['name'];
			$data[$key]['shipping_kerala']          = $val['shipping_kerala'];
            $data[$key]['shipping_indian']          = $val['shipping_indian'];
            $data[$key]['shipping_international']   = $val['shipping_international'];

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