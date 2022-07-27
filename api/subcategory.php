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
	$cat_id 	=	isset($rest->_request['cat_id']) ? $rest->_request['cat_id'] : ""; 

	if($id!="")
	{
		$where .=  " AND id=".$id;
	}
	if($cat_id!="")
	{
		$where .=  " AND cat_id=".$cat_id;
	}
	if($status!="")
	{
		$where .= " AND status='$status'";
	}
	$cat_details   	= $objgen->get_AllRowscnt("sub_category",$where);
	if($cat_details>0)
	{
		$cat_arr 	= $objgen->get_AllRows("sub_category",0,$cat_details,"cat_id asc, id asc",$where);
		$data		= array();
	    //$result     = $objgen->get_Onerow("contact","AND id='1'");
		
		foreach($cat_arr as $key=>$val)
		{
			$key = $key+1;
			$result     					= $objgen->get_Onerow("category"," and id=".$val['cat_id']);
			
			$data[$key]['id'] 				= $val['id'];
			$data[$key]['cat_id'] 			= $val['cat_id'];
			$data[$key]['cat_name'] 		= $result['cat_name'];
			$data[$key]['sub_cat_name']    	= $objgen->check_tag($val['sub_cat_name']);
			$data[$key]['status']    	= $objgen->check_tag($val['status']);
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