<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen			=	new general();
$objval			=	new validate();
$pagehead		= "Product";
$list_url 		= URLAD."list-product";
$add_url    	= URLAD."add-product";
$create_date  	= date('d-m-Y');
$srd="none";	
$sr="none";	
$page	 		= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";
if($_GET['msg']==1)
{
  	$msg2 	  	= "product Created Successfully.";
  	$adddiv   	= "show";
  	$srdiv    	= "none";
}
if($_GET['msg']==3)
{
  	$msg2 		= "$product Deleted Successfully.";
}
if(isset($_GET['delimg']))
{
     $id      	= $_GET['delimg'];
	 $edit    	= $_GET['edit'];
	 $result  	= $objgen->get_Onerow("product_image","AND id=".$id);
	 $photo   	= $objgen->check_tag($result['image']);
   	 if(file_exists("../photos/orginal/".stripslashes($photo)))
			unlink("../photos/orginal/".stripslashes($photo));

   	 if(file_exists("../photos/medium/".stripslashes($photo)))
			unlink("../photos/medium/".stripslashes($photo));
			
	 if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	
	 if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));

    $msg     	= $objgen->del_Row("product_image","id=".$id);
   if($msg=="")
   {
		header("location:".$add_url."/?msg=3&edit=".$edit."&page=".$page);
   }
}
if(isset($_POST['Create']))
{ 
   	$model_no		 = $objgen->check_input($_POST['model_no']);
   	$brand	 		 = $objgen->check_input($_POST['brand']);
   	$category 		 = $objgen->check_input($_POST['category']);
   	$sub_category 	 = $objgen->check_input($_POST['sub_category']);
	$product_name  	 = $objgen->check_input($_POST['product_name']);
	$actual_price  		 = $objgen->check_input($_POST['actual_price']);
   	$status  		 = $objgen->check_input($_POST['status']);
   	$used  		     = $objgen->check_input($_POST['used']);
   	$quantity  		 = $objgen->check_input($_POST['quantity']);
   	$country	         = $objgen->check_input($_POST['country']);
  	$remark  		 = $objgen->check_input($_POST['remark']);
   	$description      = $_POST['product_details'];
   	$attribute   	 = implode(",",$_POST['attribute']);
   	$tax		 		 = $objgen->check_input($_POST['tax']);
   	$price_percentage = $objgen->check_input($_POST['price_percentage']);
   	$p_status  		 = $objgen->check_input($_POST['p_status']);
   	$shipp_type  	 = $objgen->check_input($_POST['shipp_type']);
   	$shipp_name 		 = $objgen->check_input($_POST['shipp_name']);
   	$shipp_amount  	 = $objgen->check_input($_POST['shipp_amount']);
   	$shipp_id  	     = $objgen->check_input($_POST['shipp_id']);
   	$best_seller  	 = $objgen->check_input($_POST['best_seller']);
   	$featured  		 = $objgen->check_input($_POST['featured']);
   	$our_price     = $objgen->check_input($_POST['our_price']);
   	$youtube_link  	= $objgen->check_input($_POST['youtube_link']);
   	$category_arr 	 = $objgen->get_Onerow("category"," AND id=".$category);
   	$sub_arr 		 = $objgen->get_Onerow("sub_category"," AND id=".$sub_category);
   	$cat_name         = $objgen->check_input($category_arr['cat_name']);
   	$sub_name         = $objgen->check_input($sub_arr['sub_cat_name']);
   	$shipp_name 		 = $objgen->check_input($_POST['shipp_name']);

   if($attribute=="")
   {
   		$attribute=0;
   }
   if($shipp_amount=="")
   {
   	 	$shipp_amount=0;
   }
   if($shipp_id=="")
   {
   	 	$shipp_id=0;
   }
   if($our_price=="")
   {
   		$our_price=0;
   }
   if($tax=="")
   {
	  	$tax=0;
   }
	
   $feature_title1 	=	$objgen->check_input($_POST['feature_title1']);
   $feature_desc1	=	$objgen->check_input($_POST['feature_desc1']);
   $feature_title2	=	$objgen->check_input($_POST['feature_title2']);
   $feature_desc2	=	$objgen->check_input($_POST['feature_desc2']);
   $feature_title3 	=	$objgen->check_input($_POST['feature_title3']);
   $feature_desc3	=	$objgen->check_input($_POST['feature_desc3']);
   $feature_title4 	=	$objgen->check_input($_POST['feature_title4']);
   $feature_desc4	=	$objgen->check_input($_POST['feature_desc4']);
   $feature_title5 	=	$objgen->check_input($_POST['feature_title5']);
   $feature_desc5	=	$objgen->check_input($_POST['feature_desc5']);
   
  // echo $_SESSION['category']; exit();

   $rules		  =	array();
   $rules[]       = "required,create_date,Enter the Date";
   $rules[]		  =	"required,model_no,Enter the model no";
   $rules[]		  =	"required,category,Enter the category";
   $rules[]		  =	"required,sub_category,Enter the sub category";
   $rules[]		  =	"required,product_name,Enter the product name";
   $rules[]		  =	"required,actual_price,Enter the deal price";
   $rules[]		  =	"required,country,Enter the Country";
   $rules[]		  =	"required,status,Select the status";
   $rules[]		  =	"required,quantity,Enter the quantity";
   
   $errors		  =	$objval->validateFields($_POST, $rules);
   $brd_exit	  = $objgen->chk_Ext("product","model_no='$model_no'");
	if($brd_exit>0)
	{
		$errors[] = "This Model No is already exists.";
		$adddiv   = "show";
		$srdiv    = "none";
	}
   	if(empty($errors))
	{
		$msg = $objgen->ins_Row('product','create_date,model_no,brand,category,sub_category,cat_name,sub_name,product_name,youtube_link,
		actual_price,status,used,quantity,country,remark,prod_desc,taxt_id,attr_id,p_status,best_seller,
		featured,shipp_type,shipp_name,shipp_amount,shipp_id,our_price,price_percentage,feature1_title,feature2_title,feature3_title,feature4_title,
		feature5_title,feature1_desc,feature2_desc,feature3_desc,feature4_desc,feature5_desc'
		,"'". date('Y-m-d',strtotime($_POST['create_date']))."',
		'".$model_no."','".$brand."','".$category."','".$sub_category."','".$cat_name."','".$sub_name."','".$product_name."','".$youtube_link."',
		'".$actual_price."','".$status."','".$used."','".$quantity."','".$country."','"
		.$remark."','".$objgen->baseencode($description)."','".$tax."','".$attribute."','".$p_status."','".$best_seller."','".$featured.
		"','".$shipp_type."','".$shipp_name."','".$shipp_amount."','".$shipp_id."','".$our_price."','".$price_percentage."','".$feature_title1."'
		,'".$feature_title2."','".$feature_title3."','".$feature_title4."','".$feature_title5."','".$feature_desc1."','".$feature_desc2."','".$feature_desc3."','".$feature_desc4."','".$feature_desc5."'");
		
		 if($msg=="")
		 {

		
		if($_FILES["main_img"]["name"]!="")
		{
			$insrt = $objgen->get_insetId();
			$upload = $objgen->upload_resize("main_img","product_image","image",array('l','m','s'),"null","",array(1024,920,'auto',100),array(495,303,'auto',100),array(100,85,'auto',100));
					if($upload[1]!="")
					   $errors[] = $upload[1];
					else
					  $image = $upload[0];
					  
					  $msg = $objgen->ins_Row('product_image','image,cover,prod_id',"'".$image."','yes','".$insrt."'");
					  
				} 
				if(count($_FILES['subimage']['tmp_name'])>0)
				{
				for($i=0; $i < count($_FILES['subimage']['tmp_name']); $i++)
				{
						

					if($_FILES['subimage']['name'][$i]!="")
					{
						$file_name = date("YmdHis").$_FILES['subimage']['name'][$i];

						if(copy($_FILES['subimage']['tmp_name'][$i],'../photos/orginal/'.$file_name))
						{
							
		 					$image 		= new resize("../photos/orginal/".$file_name);
		 					$image->resizeImage(1024,920,'auto');
		 					$image->saveImage("../photos/large/".$file_name);

		 					$image 		= new resize("../photos/orginal/".$file_name);
		 					$image->resizeImage(495,303,'auto');
		 					$image->saveImage("../photos/medium/".$file_name);

		 					$image 		= new resize("../photos/orginal/".$file_name);
		 					$image->resizeImage(100,85,'auto');
		 					$image->saveImage("../photos/small/".$file_name);

                         $msg = $objgen->ins_Row('product_image','image,cover,prod_id',"'".$file_name."','no','".$insrt."'");
		 					
		 				}						  
		 			}						
		 		}
		}
		
	 header("location:".$add_url."/?msg=1");
		}
			   
	}
	
}

if(isset($_GET['edit']))
{
	$id 			  = $_GET['edit'];
	$result			  = $objgen->get_Onerow("product","and id=".$id);
	$create_date      = date('d-m-Y',strtotime($result['create_date']));
	$model_no		  = $objgen->check_tag($result['model_no']);
	$brand			  = $objgen->check_tag($result['brand']);
	$category 		  = $objgen->check_tag($result['category']);
	$sub_category 	  = $objgen->check_tag($result['sub_category']);
	$product_name  	  = $objgen->check_tag($result['product_name']);
	$actual_price  	  = $objgen->check_tag($result['actual_price']);
	$status  		  = $objgen->check_tag($result['status']);
	$used  		      = $objgen->check_tag($result['used']);
	$quantity  		  = $objgen->check_tag($result['quantity']);
	$country	 	  = $objgen->check_tag($result['country']);
	$remark  		  = $objgen->check_tag($result['remark']);
	$product_details  = $objgen->basedecode($result['prod_desc']);
	$attribute  	  = $objgen->check_tag($result['attr_id']);
	$p_status  	  	  = $objgen->check_tag($result['p_status']);
	$best_seller 	  = $objgen->check_tag($result['best_seller']);
	$featured 	      = $objgen->check_tag($result['featured']);
	$shipp_type	      = $objgen->check_tag($result['shipp_type']);
	$youtube_link	  = $objgen->check_tag($result['youtube_link']);
   	$our_price     	  = $objgen->check_tag($result['our_price']);

	if($shipp_type=='template')
	{
		$sr="none";
		$srd="block";
	}
	if($shipp_type=='manual')
	{
		$sr="block";
		$srd="none";
	}
	$shipp_amount	      = $objgen->check_tag($result['shipp_amount']);
	$shipp_name	          = $objgen->check_tag($result['shipp_name']);
	$shipp_id	          = $objgen->check_tag($result['shipp_id']);
	//echo $attribute; exit();
	$tax  	  		  = $objgen->check_tag($result['taxt_id']);
	$price_percentage = $objgen->check_tag($result['price_percentage']);
	$where = " and cover='no' and prod_id=".$id;
	$img_count = $objgen->get_AllRowscnt("product_image",$where);
	
    if($img_count>0)
	{
		  $img_arr = $objgen->get_AllRows("product_image",0,$img_count,"id asc",$where);
	}
	$result2   	  = $objgen->get_Onerow("product_image"," and cover='yes' and prod_id=".$id);
	$main_img 	  = $objgen->check_tag($result2['image']);
	$main_img_id  = $objgen->check_tag($result2['id']);

   $feature_title1 	=	$objgen->check_tag($result['feature1_title']);
   $feature_desc1	=	$objgen->check_tag($result['feature1_desc']);
   $feature_title2	=	$objgen->check_tag($result['feature2_title']);
   $feature_desc2	=	$objgen->check_tag($result['feature2_desc']);
   $feature_title3 	=	$objgen->check_tag($result['feature3_title']);
   $feature_desc3	=	$objgen->check_tag($result['feature3_desc']);
   $feature_title4 	=	$objgen->check_tag($result['feature4_title']);
   $feature_desc4	=	$objgen->check_tag($result['feature4_desc']);
   $feature_title5 	=	$objgen->check_tag($result['feature5_title']);
   $feature_desc5	=	$objgen->check_tag($result['feature5_desc']);
}

if(isset($_POST['Update']))
{    
	$model_no		  = $objgen->check_input($_POST['model_no']);
	$brand		 	  = $objgen->check_input($_POST['brand']);
	$category 		  = $objgen->check_input($_POST['category']);
	$sub_category 	  = $objgen->check_input($_POST['sub_category']);
	$product_name  	  = $objgen->check_input($_POST['product_name']);
	$actual_price  	  = $objgen->check_input($_POST['actual_price']);
	$status  		  = $objgen->check_input($_POST['status']);
    $used  		      = $objgen->check_input($_POST['used']);
	$quantity  		  = $objgen->check_input($_POST['quantity']);
    $country	      = $objgen->check_input($_POST['country']);
	$remark  		  = $objgen->check_input($_POST['remark']);
	$description      = $_POST['product_details'];
    $attribute   	  = @implode(",",$_POST['attribute']);
  	$tax		 	  = $objgen->check_input($_POST['tax']);
  	$price_percentage = $objgen->check_input($_POST['price_percentage']);
  	$p_status  		  = $objgen->check_input($_POST['p_status']);
  	$shipp_type  	  = $objgen->check_input($_POST['shipp_type']);
    $shipp_name       = $objgen->check_input($_POST['shipp_name']);
    $shipp_amount  	  = $objgen->check_input($_POST['shipp_amount']);
    $shipp_id  	      = $objgen->check_input($_POST['shipp_id']);
    $best_seller  	  = $objgen->check_input($_POST['best_seller']);
    $featured  		  = $objgen->check_input($_POST['featured']);
    $our_price     	  = $objgen->check_input($_POST['our_price']);
	$youtube_link  	  = $objgen->check_input($_POST['youtube_link']);
   	$category_arr 	  = $objgen->get_Onerow("category"," AND id=".$category);
   	$sub_arr 		  = $objgen->get_Onerow("sub_category"," AND id=".$sub_category);
    $cat_name         = $objgen->check_input($category_arr['cat_name']);
    $sub_name         = $objgen->check_input($sub_arr['sub_cat_name']);
	if($attribute=="")
	{
			$attribute=0;
	}
	if($shipp_amount=="")
	{
			 $shipp_amount=0;
	}
	if($shipp_id=="")
	{
			 $shipp_id=0;
	}
	if($our_price=="")
	{
			$our_price=0;
	}
	if($tax=="")
	{
		   $tax=0;
	}
	 
	$feature_title1 	=	$objgen->check_input($_POST['feature_title1']);
	$feature_desc1	=	$objgen->check_input($_POST['feature_desc1']);
	$feature_title2	=	$objgen->check_input($_POST['feature_title2']);
	$feature_desc2	=	$objgen->check_input($_POST['feature_desc2']);
	$feature_title3 	=	$objgen->check_input($_POST['feature_title3']);
	$feature_desc3	=	$objgen->check_input($_POST['feature_desc3']);
	$feature_title4 	=	$objgen->check_input($_POST['feature_title4']);
	$feature_desc4	=	$objgen->check_input($_POST['feature_desc4']);
	$feature_title5 	=	$objgen->check_input($_POST['feature_title5']);
	$feature_desc5	=	$objgen->check_input($_POST['feature_desc5']);
	
   // echo $_SESSION['category']; exit();
 
	$rules		  =	array();
	$rules[]       = "required,create_date,Enter the Date";
	$rules[]		  =	"required,model_no,Enter the model no";
	$rules[]		  =	"required,category,Enter the category";
	$rules[]		  =	"required,sub_category,Enter the sub category";
	$rules[]		  =	"required,product_name,Enter the product name";
	$rules[]		  =	"required,actual_price,Enter the deal price";
	$rules[]		  =	"required,country,Enter the Country";
	$rules[]		  =	"required,status,Select the status";
	$rules[]		  =	"required,quantity,Enter the quantity";
	
	$errors		  =	$objval->validateFields($_POST, $rules);

	$brd_exit 		  = $objgen->chk_Ext("product","model_no='$model_no' and id<>".$id);
	if($brd_exit>0)
	{
		$errors[]	= "This Model No is already exists.";
		$adddiv   	= "show";
		$srdiv    	= "none";
	}
	if(empty($errors))
	{	 
		$msg = $objgen->upd_Row('product',"create_date='". date('Y-m-d',strtotime($_POST['create_date']))."',model_no='".$model_no."',brand='".$brand."',
		category='".$category."',sub_category='".$sub_category."',cat_name='".$cat_name."',sub_name='".$sub_name."',product_name='".$product_name."',
		youtube_link='".$youtube_link."',actual_price='".$actual_price."',status='".$status."',used='".$used."',quantity='".$quantity."',country='".$country."',remark='".$remark."',
		prod_desc='".$objgen->baseencode($description)."',price_percentage='".$price_percentage."',taxt_id='".$tax."',attr_id='".$attribute."'
		,p_status='".$p_status."',best_seller='".$best_seller."',featured='".$featured."',shipp_type='".$shipp_type."',shipp_name='".$shipp_name."',shipp_amount='".$shipp_amount."',shipp_id='".$shipp_id."',our_price='".$our_price."'
		,our_price='".$our_price."',feature1_title='".$feature_title1."',feature2_title='".$feature_title2."',feature3_title='".$feature_title3."',feature4_title='".$feature_title4."',feature5_title='".$feature_title5."',feature1_desc='".$feature_desc1."',
		feature2_desc='".$feature_desc2."',feature3_desc='".$feature_desc3."',feature4_desc='".$feature_desc4."',feature5_desc='".$feature_desc5."'","id=".$id);

		
		
		
	if($msg=="")
	{
		if($_FILES["main_img"]["name"]!="")
		{
			$upload = $objgen->upload_resize("main_img","product_image","image",array('l','m','s'),$main_img,"",array(1024,920,'auto',100),array(495,303,'auto',100),array(100,85,'auto',100));
			if($upload[1]!="")
			  $errors[] = $upload[1];
			else
			 $image = $upload[0];
		    $msg     = $objgen->del_Row("product_image","cover='yes' and prod_id=".$id);		
			$msg = $objgen->ins_Row('product_image','image,prod_id,cover',"'".$image."','".$id."','yes'");			
		}
 			if(count($_FILES['subimage']['tmp_name'])>0)
			{
				for($i=0; $i < count($_FILES['subimage']['tmp_name']); $i++)
				{
					if($_FILES['subimage']['name'][$i]!="")
					{
						$file_name = date("YmdHis").$_FILES['subimage']['name'][$i];

						if(copy($_FILES['subimage']['tmp_name'][$i],'../photos/orginal/'.$file_name))
						{						
		 					$image 		= new resize("../photos/orginal/".$file_name);
		 					$image->resizeImage(1024,920,'auto');
		 					$image->saveImage("../photos/large/".$file_name);
		 					$image 		= new resize("../photos/orginal/".$file_name);
		 					$image->resizeImage(495,303,'auto');
		 					$image->saveImage("../photos/medium/".$file_name);
		 					$image 		= new resize("../photos/orginal/".$file_name);
		 					$image->resizeImage(100,85,'auto');
		 					$image->saveImage("../photos/small/".$file_name);
                         	$msg = $objgen->ins_Row('product_image','image,cover,prod_id',"'".$file_name."','no','".$id."'");
		 				}						  
		 			}						
		 		}
			}
		header("location:".$list_url."/?msg=2&page=".$page);
	}
}	
}
if(isset($_POST['Cancel']))
{
	 header("location:".$list_url);
}
$where  		= "";
$cat_count= $objgen->get_AllRowscnt("category",$where);
if($cat_count>0)
{
	$cat_arr 	= $objgen->get_AllRows("category",0,$cat_count,"cat_name asc",$where);
}
if($category!="")
{
	$where		= " and cat_id=".$category;
	$sub_cat_count= $objgen->get_AllRowscnt("sub_category",$where);
	if($sub_cat_count>0)
	{
		$sub_cat_arr = $objgen->get_AllRows("sub_category",0,$sub_cat_count,"sub_cat_name asc",$where);
	}
}

$where = "";
$attribute_count 	= $objgen->get_AllRowscnt("attributes",$where);
if($attribute_count>0)
{
  	$attribute_arr 	= $objgen->get_AllRows("attributes",0,$attribute_count,"template_name asc",$where);
}
$where 				= "";
$tax_count 			= $objgen->get_AllRowscnt("tax",$where);
if($tax_count>0)
{
  	$tax_arr 		= $objgen->get_AllRows("tax",0,$tax_count,"name asc",$where);
}
$where 				= "";
$shipp_count 		= $objgen->get_AllRowscnt("shipping_charge",$where);
if($shipp_count>0)
{
  	$shipp_arr 		= $objgen->get_AllRows("shipping_charge",0,$tax_count,"name asc",$where);
}
$where    			= "";
$ctry_cnt 			= $objgen->get_AllRowscnt("countries",$where);
if($ctry_cnt>0)
{ 
	$country_arr 	= $objgen->get_AllRows("countries",0,$ctry_cnt,"id asc",$where);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>
<?=$pagehead
?> | <?php echo TITLE; ?></title>
<?php require_once "header-script.php"; ?>
<link href="<?=URLAD
?>plugins/bootstrap-select-1.13.9/dist/css/bootstrap-select.css" rel="stylesheet" />
<link rel="stylesheet" href="<?=URLAD
?>plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" href="<?=URLAD
?>plugins/datepicker/datepicker3.css">
<link href="<?=URLAD
?>plugins/multiselect/multiselect.css" media="screen" rel="stylesheet" type="text/css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php require_once "header.php"; ?>
  <?php require_once "left-menu.php"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$pagehead
?>s</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=URLAD
?>">Home</a></li>
              <li class="breadcrumb-item active">
                <?=$pagehead
?>
              </li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php
if ($msg != "")
{
?>
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> <i class="ace-icon fa fa-times"></i> </button>
            <strong> <i class="ace-icon fa fa-times"></i> Oh snap! </strong> <?php echo $msg; ?> <br>
          </div>
          <?php
}
?>
          <?php
if (!empty($errors))
{
?>
          <div class="alert alert-danger alert-dismissable"> <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b>Please fix the following errors:</b> <br>
            <?php
    foreach ($errors as $error1) echo "<div> - " . $error1 . " </div>";
?>
          </div>
          <?php
}
?>
          <?php
if ($msg2 != "")
{
?>
          <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> <i class="ace-icon fa fa-times"></i> </button>
            <strong> <i class="ace-icon fa fa-check"></i> Sucsess! </strong> <?php echo $msg2; ?> <br>
          </div>
          <?php
}
?>
        </div>
      </div>
      <div class="row hide_div" style="padding-top:10px;display:<?=$adddiv
?>" id="adddiv">
        <div class="col-md-12">
          <div class="card card-<?=TH_COLOR
?>">
          <div class="card-header">
            <h3 class="card-title">Enter
              <?=$pagehead
?>
              Informations</h3>
          </div>

          <form role="form" method="post" enctype="multipart/form-data" >
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="product_name">Product Name <span class="error" style="color:red;">*</span></label>
                    <input type="text" class="form-control" value="<?=$product_name
?>" name="product_name" id="product_name"  required />
                  </div>
                </div>

				<div class="col-md-4">
                  <div class="form-group">
                    <label for="category_name">Create Date <span class="error" style="color:red;">*</span></label>
                    <input type="text" class="form-control date" value="<?=$create_date
?>" name="create_date" id="create_date" required />
                  </div>
                </div>

				<div class="col-md-4">
                  <div class="form-group">
                    <label for="category_name">Model No <span class="error" style="color:red;">*</span></label>
                    <input type="text" class="form-control" value="<?=$model_no
?>" name="model_no" id="model_no" required />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="brand">Brand Name <span class="error" style="color:red;">*</span></label>
                    <input type="text" class="form-control" value="<?=$brand
?>" name="brand" id="brand"  required />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="category_name">Category <span class="error" style="color:red;">*</span></label>
                    <select name="category" id="category" required class="form-control selectpicker" data-live-search="true" onChange="product_cat(this.value)">
                      <option value=""   selected="selected" >-Select-</option>
                      <?php
if ($cat_count > 0)
{
    foreach ($cat_arr as $key => $val)
    {
?>
                      			<option value="<?=$val['id'] ?>" <?php if ($val['id'] == $category)
        { ?> selected="selected" <?php
        } ?> >
                      			<?=$objgen->check_tag($val['cat_name']) ?>
                      			</option>
                      			<?php
    }
}
?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="category_name">Sub Category <span class="error" style="color:red;">*</span></label>
                    <span id="sub_cat">
                    <select name="sub_category" id="sub_category" class="form-control selectpicker" data-live-search="true" required >
                      	<option value="" selected="selected" >-Select-</option>
                      	<?php
if ($sub_cat_count > 0)
{
    foreach ($sub_cat_arr as $key => $val)
    {
?>
                      <option value="<?=$val['id'] ?>" <?php if ($val['id'] == $sub_category)
        { ?> selected="selected" <?php
        } ?> >
                      <?=$objgen->check_tag($val['sub_cat_name']) ?>
                      </option>
                      <?php
    }
}
?>
                    </select>
                    </span>
					        </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="category_name">Status <span class="error" style="color:red;">*</span></label>
                    <select class="form-control selectpicker" name="status" id="status" required>
                      <option value="Not sold" <?php if ($status == 'Not sold')
{ ?> selected="selected" <?php
} ?> >Not sold</option>
                      <option value="Sold" <?php if ($status == 'Sold')
{ ?> selected="selected" <?php
} ?> >Sold</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="category_name">Discount Percent </label>
                    <select class="form-control selectpicker" name="price_percentage" id="price_percentage" onChange="chng_price()" data-live-search="true" >
                      <?php
$i = 0;
for ($i = 1;$i <= 100;$i++)
{
?>
                      <option value="<?php echo $i; ?>" <?php if ($i == $price_percentage)
    { ?> selected="selected" <?php
    } ?>><?php echo $i; ?>%</option>
                      <?php
}
?>
                    </select>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="actual_price">MRP <span class="error" style="color:red;">*</span></label>
                    <input type="text" class="form-control" value="<?=$actual_price
?>" name="actual_price" id="actual_price"  required />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="our_price">Selling Price</label>
                    <input type="text" class="form-control" value="<?=$our_price
?>" name="our_price" id="our_price"   />
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="category_name">Quantity <span class="error" style="color:red;">*</span></label>
                    <input type="text" class="form-control" value="<?=$quantity
?>" name="quantity" id="quantity" required />
                  </div>
                </div>

                <div  class="col-md-3">
                  <div class="form-group">
                    <label for="mainimage">Product Status</label>
                    <br />
                    <div class="icheck-primary d-inline">
                      <input  type="radio" value="active" <?php if ($p_status == 'active')
{ ?> checked="checked"  <?php
} ?> name="p_status" id="radioPrimary1" >
                      <label for="radioPrimary1">Active </label>
                    </div>
                    &nbsp&nbsp
                    <div class="icheck-primary d-inline">
                      <input   type="radio" value="inactive" <?php if ($p_status == 'inactive')
{ ?> checked="checked"  <?php
} ?> name="p_status" id="radioPrimary2" >
                      <label for="radioPrimary2">Inactive </label>
                    </div>
                  </div>
                </div>

                <div  class="col-md-3">
                  <div class="form-group">
                    <label for="mainimage">Best Seller</label>
                    <br />
                    <div class="icheck-primary d-inline">
                      <input  type="radio" value="yes" <?php if ($best_seller == 'yes')
{ ?> checked="checked"  <?php
} ?> name="best_seller" id="radioPrimary3" >
                      <label for="radioPrimary3">Yes </label>
                    </div>
                    &nbsp&nbsp
                    <div class="icheck-primary d-inline">
                      <input type="radio" value="no" <?php if ($best_seller == 'no')
{ ?> checked="checked"  <?php
} ?> name="best_seller" id="radioPrimary4" >
                      <label for="radioPrimary4">No </label>
                    </div>
                  </div>
                </div>

                <div  class="col-md-3">
                  <div class="form-group">
                    <label for="mainimage">Featured</label>
                    <br />
                    <div class="icheck-primary d-inline">
                      <input type="radio" value="yes" <?php if ($featured == 'yes')
{ ?> checked="checked"  <?php
} ?> name="featured" id="radioPrimary5" >
                      <label for="radioPrimary5">Yes </label>
                    </div>
                    &nbsp&nbsp
                    <div class="icheck-primary d-inline">
                      <input type="radio" value="no" <?php if ($featured == 'no')
{ ?> checked="checked"  <?php
} ?> name="featured" id="radioPrimary6" >
                      <label for="radioPrimary6">No </label>
                    </div>
                  </div>
                </div>

				        <div  class="col-md-3">
                  <div class="form-group">
                    <label for="mainimage">Used</label>
                    <br />
                    <div class="icheck-primary d-inline">
                      <input type="radio" value="used" <?php if ($used == 'used')
{ ?> checked="checked"  <?php
} ?> name="used" id="radioPrimary7" >
                      <label for="radioPrimary7">Yes </label>
                    </div>
                    &nbsp&nbsp&nbsp&nbsp
                    <div class="icheck-primary d-inline">
                      <input type="radio" value="notused" <?php if ($used == 'notused')
{ ?> checked="checked"  <?php
} ?> name="used" id="radioPrimary8" >
                      <label for="radioPrimary8">No </label>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="category_name">Made In <span class="error" style="color:red;">*</span></label>
                    <select name="country" id="country" class="form-control selectpicker" data-live-search="true" required>
                      <option value=""   selected="selected" >-Select Country-</option>
                      <?php
if ($ctry_cnt > 0)
{
    foreach ($country_arr as $key => $val)
    {
?>
                      <option value="<?=$val['id'] ?>" <?php if ($val['id'] == $country)
        { ?> selected="selected" <?php
        } ?> >
                      <?=$objgen->check_tag($val['name']) ?>
                      </option>
                      <?php
    }
}
?>
                    </select>
                  </div>
                </div>

				        <div class="col-md-6">
                  <div class="form-group">
                    <label for="category_name">Tax</label>
                    <select name="tax" id="tax" class="form-control selectpicker" data-live-search="true" >
                      <option value=""   selected="selected" >-Select-</option>
                      <?php
if ($tax_count > 0)
{
    foreach ($tax_arr as $key => $val)
    {
?>
                      <option value="<?=$val['id'] ?>" <?php if ($val['id'] == $tax)
        { ?> selected="selected" <?php
        } ?> >
                      <?=$objgen->check_tag($val['name']) ?>
                      </option>
                      <?php
    }
}
?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="youtube_link">Youtube Link</label>
                    <textarea name="youtube_link" class="form-control" ><?php echo $youtube_link; ?></textarea>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="remark">Remark</label>
                    <textarea name="remark" class="form-control" ><?php echo $remark; ?></textarea>
                  </div>
                </div>

                <div  class="col-md-6">
                  <div class="form-group">
                    <label for="mainimage">Shipp Type</label>
                    <br />
                    <div class="icheck-primary d-inline">
                      <input type="radio" name="shipp_type"  id='purpose' 
                                			<?php if (isset($shipp_type) && $shipp_type == "template") echo "checked"; ?> value="template">
                      <label for="radioPrimary9">Template </label>
                    </div>
                    <div class="icheck-primary d-inline">
                      <input type="radio" name="shipp_type" id='purpose1' 
                                			<?php if (isset($shipp_type) && $shipp_type == "manual") echo "checked"; ?> value="manual" >
                      <label for="radioPrimary10">Manual </label>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Attribute</label>
                  <select class="form-control" name="attribute[]" id="attribute" multiple="multiple" size="5">
                    <?php
if ($attribute_count > 0)
{
    foreach ($attribute_arr as $key => $val)
    {
?>
                    <option value="<?=$val['id'] ?>" <?php if ($attribute == $val['id'])
        { ?>  <?php
        } ?> >
                    <?=$objgen->check_tag($val['template_name']) ?>
                    </option>
                    <?php
    }
}
?>
                  </select>
                </div>
              </div>

                <div class="col-md-6">
                  <div class="form-group"  id='weight3' style="display:<?=$srd ?>">
                    <label for="category_name">Shipping</label>
                    <select name="shipp_id" id="shipp_id"  class="form-control selectpicker" data-live-search="true" >
                      <option value=""   selected="selected" >-Select-</option>
                      <?php
if ($shipp_count > 0)
{
    foreach ($shipp_arr as $key => $val)
    {
?>
                      <option value="<?=$val['id'] ?>" <?php if ($val['id'] == $shipp_id)
        { ?> selected="selected" <?php
        } ?> >
                      <?=$objgen->check_tag($val['name']) ?>
                      </option>
                      <?php
    }
}
?>
                    </select>
                  </div>

				        <div class="col-md-12">
                  <div class="form-group" id='weight1' style="display:<?=$sr
?>;">
                    <label for="category_name">Shipping Name</label>
                    <input type="text" class="form-control" value="<?=$shipp_name
?>" name="shipp_name" id="shipp_name"  />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group" id='weight2' style="display:<?=$sr
?>">
                    <label for="category_name">Shipping Amount</label>
                    <input type="text" class="form-control " value="<?=$shipp_amount
?>" name="shipp_amount" id="shipp_amount" />
                  </div>
                </div>
              </div>
				
				

				<div class="col-md-12">
                <div class="form-group">
                  <label for="category_name">Product Details</label>
                  <textarea style="height:100px;" name="product_details" id="editor1" class="form-control editor1" ><?=$product_details
?>
</textarea>
                </div>
              </div>

              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Title 1</label>
                  <input type="text" name="feature_title1" id="feature_title1" class="form-control" value="<?=$feature_title1
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Descripton 1</label>
                  <input type="text" name="feature_desc1" id="feature_desc1" class="form-control" value="<?=$feature_desc1
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Title 2</label>
                  <input type="text" name="feature_title2" id="feature_title2" class="form-control" value="<?=$feature_title2
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Descripton 2</label>
                  <input type="text" name="feature_desc2" id="feature_desc2" class="form-control" value="<?=$feature_desc2
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Title 3</label>
                  <input type="text" name="feature_title3" id="feature_title3" class="form-control" value="<?=$feature_title3
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="feature_desc3">Feature Descripton 3</label>
                  <input type="text" name="feature_desc3" id="feature_desc3" class="form-control" value="<?=$feature_desc3
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Title 4</label>
                  <input type="text" name="feature_title4" id="feature_title4" class="form-control" value="<?=$feature_title4
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Descripton 4</label>
                  <input type="text" name="feature_desc4" id="feature_desc4" class="form-control" value="<?=$feature_desc4
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Title 5</label>
                  <input type="text" name="feature_title5" id="feature_title5" class="form-control" value="<?=$feature_title5
?>">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="category_name">Feature Descripton 5</label>
                  <input type="text" name="feature_desc5" id="feature_desc5" class="form-control" value="<?=$feature_desc5
?>">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="username">Main Image(850 px x 450 px)</label>
                  <br>
                  <input type="file" name="main_img" id="main_img1" >
				  <br>
                  <div id="imagePreview"></div>
                  <?php
if ($main_img != "")
{
?>
                  <p class="help-block"><img src="<?=URL
?>photos/small/<?php echo $main_img; ?>" width="74" height="93"  />&nbsp;&nbsp;<a href="<?=$add_url ?>/?delimg=<?=$main_img_id ?>&edit=<?=$id ?>&page=<?=$page ?>" role="button" onClick="return confirm('Do you want to delete this Image?')"><span class="fas fa-trash-alt"></span></a></p>
                  <?php
}
?>
                </div>
              </div>
              <div class="col-md-12" style=" padding:10px;">
                <div class="form-group">
                  <label>Sub Images (850 px x 450 px) <span>- Ctrl to select multiple images</span></label>
                  <br>
                  <input type="file"  name="subimage[]" multiple   />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php
if ($img_count > 0)
{
?>
                  <b>Sub Images</b>
                  <?php
    foreach ($img_arr as $key => $val)
    {
?>
                  <div style="border:1px solid #009900; padding:10px;">
                    <div class="form-group">
                      <p class="help-block"><img src="<?=URL
?>photos/small/<?php echo $val['image']; ?>" width="74" height="93" />&nbsp;&nbsp;<a href="<?=$add_url ?>/?delimg=<?=$val['id'] ?>&edit=<?=$id ?>&page=<?=$page ?>" role="button" onClick="return confirm('Do you want to delete this Image?')"><span class="fas fa-trash-alt"></span></a></p>
                    </div>
					
                  </div>
                  <?php
    }
}

?>
                </div>
              </div>
              <div id="imageadd" > </div>
              <br clear="all"   />
            </div>
            </div>


              </div>
             
              
            <div class="card-footer center">
              <?php
if (isset($_GET['edit']))
{
?>
              <button class="btn btn-primary" type="submit" name="Update"><i class="ace-icon fa fa-check bigger-110"></i>&nbsp;Update </button>
              <a  class="btn btn-warning" type="reset"  href="<?=$list_url
?>" ><i class="fa fa-undo"></i>&nbsp;Cancel</a>
              <?php
}
else
{
?>
              <button type="submit" class="btn btn-primary" name="Create" ><span class="fa fa-save  ace-icon"></span>&nbsp;Save</button>
              <a  class="btn btn-warning" type="button"   href="<?=$add_url
?>" onClick="res()" name="Reset"><i class="fa fa-undo"></i>&nbsp;Reset </a>
              <?php
}
?>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /.row (main row) -->
  </div>
  <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once "footer.php"; ?>
</div>
<!-- ./wrapper -->
<?php require_once "footer-script.php"; ?>
<script src="<?=URLAD
?>plugins/bootstrap-select-1.13.9/dist/js/bootstrap-select.js"></script>
<script src="<?=URLAD
?>plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.editor1').summernote()
  })
</script>
<script src="<?=URLAD
?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
			$('.date').datepicker({
				autoclose: true,
				todayHighlight: true,
				format: 'dd-mm-yyyy'
			})
		</script>
<script src="<?=URLAD
?>plugins/multiselect/jquery.multi-select.js" type="text/javascript"></script>
<script type="text/javascript">
	   
		$('#attribute').multiSelect();
    	var data="<?=$attribute
?>";
		var dataarray=data.split(",");
		$("#attribute").val(dataarray);

		$("#attribute").multiSelect("refresh");
		
</script>
<script>
					function res()
					   {
						$.ajax({type: "GET",
								url: "<?=URLAD
?>ajax.php",
								data: {pid : 8},
								success: function (result)
								{
									$("#ret").html(result);
								}
							  });
						}
				</script>
<script>
					function product_cat(id)
					   {
						$.ajax({type: "GET",
								url: "<?=URLAD
?>ajax.php",
								data: {pid : 3, st3 : id},
								success: function (result)
								{
									$("#sub_cat").html(result);
								}
							  });
						}
				</script>
<script>
	  
		 
		 
		 </script>
<script>
		$(function() {
		  $("#main_img1").on("change", function()
		  {
			var files = !!this.files ? this.files : [];
			if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		
			if (/^image/.test( files[0].type)){ // only image file
			  var reader = new FileReader(); // instance of the FileReader
			  reader.readAsDataURL(files[0]); // read the local file
		
			  reader.onloadend = function(){ // set image data as background of div
				$("#imagePreview").css("width", "120px");
				$("#imagePreview").css("height", "100px");
				$("#imagePreview").css(" background-position", "center center");
				$("#imagePreview").css("background-size",  "cover");
				$("#imagePreview").css("display",  "inline-block");
				$("#imagePreview").css("background-image", "url("+this.result+")");
			  }
			}
		  });
		});
	</script>
<script>
$(document).ready(function(){
    $('#purpose').on('change', function() {
     // alert('hi');
      if ( this.value == 'template')
      {
         $("#weight3").show();

         $("#weight1").hide();
         $("#weight2").hide();
      }
      else
      {
        $("#weight3").hide();
      
      }
    });
       

       $('#purpose1').on('change', function() {
       if ( this.value == 'manual')
      {
      	 $("#weight1").show();
         $("#weight2").show();
       
		 $("#weight3").hide();
      }
      else
      {
         $("#weight1").hide();
         $("#weight2").hide();
      }
    });

});
</script>
</body>
</html>
