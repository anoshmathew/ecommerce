<?php
require_once "includes/includepath.php";
require_once "phpmailer/class.phpmailer.php";

$objgen = new general();
$objval	= new validate();
$api    = new api();
$rest   = new rest();

$where ="";
$api->valide_method('POST'); // Check Post
$keyparam = $rest->_request['key']; 
$authkey  = $api->valide_key($keyparam); // Auth key Validation

if($authkey==true)
{
	$id    = isset($rest->_request['id']) ? $rest->_request['id'] : "";
	$status =  isset($rest->_request['status']) ? $rest->_request['status'] : ""; 
	$attr_id 	=	isset($rest->_request['attr_id']) ? $rest->_request['attr_id'] : ""; 

	if($id!="")
	{
		$where .=  " AND id=".$id;
	}
	if($attr_id!="")
	{
		$where .=  " AND attr_id=".$cat_id;
	}
	if($status!="")
	{
		$where .= " AND status='$status'";
	}
	$attr_details   	= $objgen->get_AllRowscnt("attributes_values",$where);
	if($attr_details>0)
	{
		$attr_arr 	= $objgen->get_AllRows("attributes_values",0,$attr_details,"attr_id asc, id asc",$where);
		$data		= array();
	    //$result     = $objgen->get_Onerow("contact","AND id='1'");
		
		foreach($attr_arr as $key=>$val)
		{
			$key = $key+1;
			$result     					= $objgen->get_Onerow("attributes"," and id=".$val['attr_id']);
			
			$data[$key]['id'] 				= $val['id'];
			$data[$key]['attr_id'] 			= $val['attr_id'];
            $data[$key]['attribute'] 		= $result['name'];
			$data[$key]['attr_val'] 		= $val['attr_val'];
			$data[$key]['status']    	    = $objgen->check_tag($val['status']);
		}

		$response_arr["data"] 	  = array_values($data);
	
		$response_arr["response_code"]    	= 200;
		$response_arr["status"]  		  	= "Success";
		$data['message']            		= "";

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