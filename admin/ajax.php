<?php
require_once "includes/includepath.php";
$objgen		  =	new general();

if($_GET['pid']==1)
{
	$category	= $_GET['st'];
	$where		= " and category_id=".$category;
	$st_count	= $objgen->get_AllRowscnt("sub_category",$where);
	if($st_count>0)
	{
		$st_arr		= $objgen->get_AllRows("sub_category",0,$st_count,"category_name",$where);
	}
?>
	<select name="sub_category" id="sub_category" class="form-control selectpicker" data-live-search="true" required>
	<option value="" selected="selected" >-Select-</option>
	<?php
	if($st_count>0)
	{
	foreach($st_arr as $key=>$val)
	{
	?>
	
	<option value="<?=$val['id']?>" <?php if($val['id']==$cat) { ?> selected="selected" <?php } ?> >
	<?=$objgen->check_tag($val['category_name'])?> 
	</option>
	<?php
	}
	}
	?>
	</select>
	
	<script>
$('#sub_category').selectpicker('refresh');
</script>    
<?php
}


if($_GET['pid']==2)
{
	$category	= $_GET['st2'];
	$where		= " and category_id=".$category;
	$st_count	= $objgen->get_AllRowscnt("sub_category",$where);
	if($st_count>0)
	{
		$st_arr		= $objgen->get_AllRows("sub_category",0,$st_count,"category_name",$where);
	}
?>
	<select name="ut" id="ut" class="form-control selectpicker" data-live-search="true" >
	<option value="" selected="selected" >-Select-</option>
	<?php
	if($st_count>0)
	{
	foreach($st_arr as $key=>$val)
	{
	?>
	
	<option value="<?=$val['id']?>" <?php if($val['id']==$sub_category2) { ?> selected="selected" <?php } ?> >
	<?=$objgen->check_tag($val['category_name'])?> 
	</option>
	<?php
	}
	}
	?>
	
	</select>
	
		<script>
$('#ut').selectpicker('refresh');
</script>     
<?php
}
if($_GET['pid']==3)
{
	$category	= $_GET['st3'];
	$where		= " and cat_id=".$category;
	$st_count	= $objgen->get_AllRowscnt("sub_category",$where);
	if($st_count>0)
	{
		$st_arr		= $objgen->get_AllRows("sub_category",0,$st_count,"sub_cat_name",$where);
	}
?>
	<select name="sub_category" id="sub_category" required class="form-control selectpicker" data-live-search="true" >
	<option value="" selected="selected" >-Select-</option>
	<?php
	if($st_count>0)
	{
	foreach($st_arr as $key=>$val)
	{
	?>
	<option value="<?=$val['id']?>" <?php if($val['id']==$sub_category) { ?> selected="selected" <?php } ?> >
	<?=$objgen->check_tag($val['sub_cat_name'])?> 
	</option>
	<?php
	}
	}
	?>
	</select> 
<script>
$('#sub_category').selectpicker('refresh');
</script> 
  
<?php
}

if($_GET['pid']==4)
{
	$category	= $_GET['st4'];
	$where		= " and sub_category_id=".$category;
	$st_count	= $objgen->get_AllRowscnt("sub_sub_category",$where);
	if($st_count>0)
	{
		$st_arr		= $objgen->get_AllRows("sub_sub_category",0,$st_count,"category_name",$where);
	}
?>
	<select name="sub_sub_category" id="sub_sub_category"  class="form-control selectpicker" data-live-search="true"  >
	<option value="" selected="selected" >-Select-</option>
	<?php
	if($st_count>0)
	{
	foreach($st_arr as $key=>$val)
	{
	?>
	
	<option value="<?=$val['id']?>" <?php if($val['id']==$sub_sub_category) { ?> selected="selected" <?php } ?> >
	<?=$objgen->check_tag($val['category_name'])?> 
	</option>
	<?php
	}
	}
	?>
	</select>
	<script>
$('#sub_sub_category').selectpicker('refresh');
</script>    
<?php
}					

if($_GET['pid']==5)
{
	$category	= $_GET['st5'];
	$where		= " and cat_id=".$category;
	$st_count	= $objgen->get_AllRowscnt("sub_category",$where);
	if($st_count>0)
	{
		$st_arr		= $objgen->get_AllRows("sub_category",0,$st_count,"sub_cat_name",$where);
	}
?>
<select name="uu" id="uu" class="form-control selectpicker" data-live-search="true">
	<option value="" selected="selected" >-Select-</option>
	<?php
	if($st_count>0)
	{
	foreach($st_arr as $key=>$val)
	{
	?>
	<option value="<?=$val['id']?>" <?php if($val['id']==$sub_category) { ?> selected="selected" <?php } ?> >
	<?=$objgen->check_tag($val['sub_cat_name'])?> 
	</option>
	<?php
	}
	}
	?>
	</select> 
	<script>
$('#uu').selectpicker('refresh');
</script>    
<?php
}

if($_GET['pid']==6)
{
	$category	= $_GET['st6'];
	$where		= " and sub_category_id=".$category;
	$st_count	= $objgen->get_AllRowscnt("sub_sub_category",$where);
	if($st_count>0)
	{
		$st_arr		= $objgen->get_AllRows("sub_sub_category",0,$st_count,"category_name",$where);
	}
?>
<select name="uv" id="uv"  class="form-control selectpicker" data-live-search="true">
	<option value="" selected="selected" >-Select-</option>
	<?php
	if($st_count>0)
	{
	foreach($st_arr as $key=>$val)
	{
	?>
	
	<option value="<?=$val['id']?>" <?php if($val['id']==$sub_sub_category) { ?> selected="selected" <?php } ?> >
	<?=$objgen->check_tag($val['category_name'])?> 
	</option>
	<?php
	}
	}
	?>
	</select> 
<script>
$('#uv').selectpicker('refresh');
</script>   
<?php
}

if($_GET['pid']==7)
{
	$id    = $_GET['id'];

	$p_arr = $objgen->get_OneRow("product"," AND id=".$id);
?>

    <input type="text" class="form-control" name="price" id="price" value="<?=$price?>" placeholder="Current Price is <?=$p_arr['our_price']?>"/>
	
<?php
}	

if($_GET['pid']==8)
{	

unset($_SESSION['category']);
unset($_SESSION['sub_category']);
unset($_SESSION['sub_sub_category']);
unset($_SESSION['merchant']);
unset($_SESSION['weight']);
unset($_SESSION['price_percentage']);
unset($_SESSION['model_no']);
unset($_SESSION['brand']);
unset($_SESSION['product_name']);
unset($_SESSION['merchant_price']) ;
unset($_SESSION['our_price']);
unset($_SESSION['merchant']);
unset($_SESSION['status']);
unset($_SESSION['quantity']);
unset($_SESSION['merchant_link']);
unset($_SESSION['remark']);
unset($_SESSION['prod_desc']);
unset($_SESSION['attr_id']);
unset($_SESSION['p_status']);
unset($_SESSION['featured']);
unset($_SESSION['best_seller']);
unset($_SESSION['shipp_type']);
unset($_SESSION['shipp_name']);
unset($_SESSION['shipp_amount']);
unset($_SESSION['shipp_id']);
unset($_SESSION['per_price']);
unset($_SESSION['actual_price']);
unset($_SESSION['tax']);
unset($_SESSION['feature1_title']);
unset($_SESSION['feature2_title']);
unset($_SESSION['feature3_title']);
unset($_SESSION['feature4_title']);
unset($_SESSION['feature5_title']);
unset($_SESSION['feature1_desc']);
unset($_SESSION['feature2_desc']);
unset($_SESSION['feature3_desc']);
unset($_SESSION['feature4_desc']);
unset($_SESSION['feature5_desc']); 
}

if($_GET['pid']==9)
{
	$id  	= $_GET['id'];
	$status = $_GET['status'];
	$msg    = $objgen->upd_Row('orders',"status='".$status."'","id=".$id);

	$msgs 	= $objgen->upd_Row('order_pro',"status='".$status."'","order_id=".$id);

	$ord_arr = $objgen->get_OneRow("orders"," AND id=".$id);
	$usr_arr = $objgen->get_OneRow("users"," AND id=".$ord_arr['user_id']);
	
	//echo $usr_arr['mobile'];
//exit;

	if($status=='Cancelled')
	{
		$smscontent =  urlencode("Dear ".$usr_arr['firstname'].", Your Order  ".$id." is cancelled due to some problems.  We are sorry for the inconvenience! Team Buynowit.");
    
	
		 $smsurl	=	'http://sms.xeoinfotech.com/httpapi/httpapi?token='.SM_TOKEN.'&sender='.SM_SEN_ID.'&number='.$usr_arr['mobile'].'&route=2&type=1&sms='.$smscontent;
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$smsurl);
        curl_exec($ch);
	}
	if($status=='Shipped')
	{
		$smscontent =  urlencode("Dear ".$usr_arr['firstname'].", Your Order ".$id." has been shipped. Thank you! Team Buynowit.");
    
  			 $smsurl	=	'http://sms.xeoinfotech.com/httpapi/httpapi?token='.SM_TOKEN.'&sender='.SM_SEN_ID.'&number='.$usr_arr['mobile'].'&route=2&type=1&sms='.$smscontent;
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$smsurl);
        curl_exec($ch);
	}
	if($status=='Delivered')
	{
		$smscontent =  urlencode("Dear ".$usr_arr['firstname'].", Your Order ".$id." is delivered. Thank you! Team Buynowit.");
    
  				 $smsurl	=	'http://sms.xeoinfotech.com/httpapi/httpapi?token='.SM_TOKEN.'&sender='.SM_SEN_ID.'&number='.$usr_arr['mobile'].'&route=2&type=1&sms='.$smscontent;
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$smsurl);
        curl_exec($ch);
	}
}
			
?>
