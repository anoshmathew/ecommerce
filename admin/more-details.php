<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen     =   new general();
$objval     =   new validate();

$pagehead   = "Prodcut Detail";
$add_url    = URLAD."more-details";
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";
$id         = $_GET['id'];
$detail     = $_GET['detail'];

if($_GET['msg']==4)
{
  	$msg2 = "Status Changed Successfully.";
}

if(isset($_GET['st']))
{
	 $id = $_GET['id'];
	 $st = $_GET['st'];
	 $page=$_GET['page'];
	 if($st=='active')
	 $status = "inactive";
	 if($st=='inactive')
	 $status = "active";
	 
	 $msg	=	$objgen->upd_Row("product","p_status='$status'","id=".$id);
	 header('location:'.$add_url.'/?detail='.$id.'&page='.$page.'&msg=4');
}
if(isset($_GET['st1']))
{
	 $id = $_GET['id'];
	 $st = $_GET['st1'];
	 $page=$_GET['page'];
	 
	 if($st=='yes')
	  $status = "no";
	  
	 if($st=='no')
	  $status = "yes";
	 
	 $msg	=	$objgen->upd_Row("product","best_seller='$status'","id=".$id);
	 header('location:'.$add_url.'/?detail='.$id.'&page='.$page.'&msg=4');
}
if(isset($_GET['st2']))
{
	 $id = $_GET['id'];
	 $st = $_GET['st2'];
	 $page=$_GET['page'];
	 
	 if($st=='yes')
	  $status = "no";
	  
	 if($st=='no')
	  $status = "yes";
	 
	 $msg	=	$objgen->upd_Row("product","featured='$status'","id=".$id);
	 header('location:'.$add_url.'/?detail='.$id.'&page='.$page.'&msg=4');
}

	$result  		  = $objgen->get_Onerow("product","AND id =".$detail);
	
	$create_date      = date('d-M-Y',strtotime($objgen->check_tag($result['create_date'])));
	
	$model_no		  = $objgen->check_tag($result['model_no']);
	$brand			  = $objgen->check_tag($result['brand']);
	$category 		  = $objgen->check_tag($result['cat_name']);
	$sub_category 	  = $objgen->check_tag($result['sub_name']);
	$product_name  	  = $objgen->check_tag($result['product_name']);
	$our_price  	  = $objgen->check_tag($result['our_price']);
	$youtube_link	  = $objgen->check_tag($result['youtube_link']);
	$status  		  = $objgen->check_tag($result['status']);
	$used  		      = $objgen->check_tag($result['used']);
	$quantity  		  = $objgen->check_tag($result['quantity']);
	$remark  		  = $objgen->check_tag($result['remark']);
	$tax  		  	  = $objgen->check_tag($result['taxt_id']);
	$resultt  		  = $objgen->get_Onerow("tax","AND id =".$tax);
	$price_percentage = $objgen->check_tag($result['price_percentage']);
	$attr  		  	  = $objgen->check_tag($result['attr_id']);
	$str 			  = explode(" ",$attr);
	$p_status 		  = $objgen->check_tag($result['p_status']);
	$best_seller 	  = $objgen->check_tag($result['best_seller']);
	$featured 	      = $objgen->check_tag($result['featured']);
	$shipp_id	      = $objgen->check_tag($result['shipp_id']);
	$shipp_type	      = $objgen->check_tag($result['shipp_type']);
	$shipp_name	      = $objgen->check_tag($result['shipp_name']);
	$shipp_amount	  = $objgen->check_tag($result['shipp_amount']);
    $actual_price     = $objgen->check_input($result['actual_price']);

	$where = "";

	$attr_count = $objgen->get_AllRowscnt("attributes",$where);
	
	if($attr_count>0)
	{
		 $attr_arr = $objgen->get_AllRows("attributes",0,$attr_count,"id asc",$where);
	} 	
	
	$where = " and prod_id=".$detail;
	$img_count = $objgen->get_AllRowscnt("product_image",$where);
	
    if($img_count>0)
	{
		$img_arr 	= $objgen->get_AllRows("product_image",0,$img_count,"id desc",$where);
	}
	$result2   	  = $objgen->get_Onerow("product_image"," and cover='yes' and prod_id=".$detail);
	$main_img 	  = $objgen->check_tag($result2['image']);
	$main_img_id  = $objgen->check_tag($result2['id']);
	$resultss     = $objgen->get_Onerow("shipping_charge"," and id=".$shipp_id);
	
	
	
 if(isset($_POST['Update']))
 { 
  	$objgen->del_Row("product_attr","prod_id=".$detail);
   	foreach($_POST['attribute'] as $key=>$val)
	{
    	$avl_att_val_arr = array();
		
    	foreach($val as $key2=>$val2)
		{
     		$attr_id 			= $key;
	 		$avl_att_val_arr[] 	= $val2;
		}
		
	 	$avl_att_val = implode(",",$avl_att_val_arr);
		$objgen->ins_Row('product_attr','attr_id,avl_att_val,prod_id',"'".$attr_id."','".$avl_att_val."','".$detail."'");
   	}
   
	header("location:more-details/?detail=".$detail."&page=".$page);  
   
 }  

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>
<?=$pagehead?> | <?php echo TITLE; ?></title>
<?php require_once "header-script.php"; ?>
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
            <h1 class="m-0 text-dark">
              <?=$pagehead?>
              s</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=URLAD?>">Home</a></li>
              <li class="breadcrumb-item active">
                <?=$pagehead?>
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
      <!-- Small boxes (Stat box) -->
      <div class="row" style="clear:both;margin-bottom:10px;">
        <div class="col-md-12" align="right" style="clear:both"> <a type="button"  class="btn btn-inline btn-info" href="<?=URLAD?>list-product"><i class="fa fa-arrow-left"></i> Back</a> </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <?php
			if($msg2!="")
			{
			?>
          <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"> <i class="ace-icon fa fa-times"></i> </button>
            <strong> <i class="ace-icon fa fa-check"></i> Success! </strong> <?php echo $msg2; ?> <br>
          </div>
          <?php
			}
			?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">
              <h3 class="card-title">Product Informations</h3>
            </div>
            <?php
						
						
						?>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Product Name">Change Status</label>
                    <div>
                      <?php
												if($p_status=='active')
												{
												?>
                      <a href="<?=$add_url?>/?id=<?php echo $detail;?>&page=<?=$page?>&st=<?php echo $p_status; ?>" role="button" class="btn btn-success btn-sm" ><i class="fa fa-unlock bigger-120"></i></a>
                      <?php
												}
												else
												{
												?>
                      <a href="<?=$add_url?>/?id=<?php echo $detail;?>&page=<?=$page?>&st=<?php echo $p_status; ?>" role="button" class="btn btn-danger btn-sm" ><i class="fa fa-lock bigger-120"></i></a>
                      <?php
												}
												?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Product Name">Best Seller</label>
                    <div>
                      <?php
												if($best_seller=='yes')
												{
												?>
                      <a href="<?=$add_url?>/?id=<?php echo $detail;?>&page=<?=$page?>&st1=<?php echo $best_seller; ?>" role="button" class="btn btn-success btn-sm" >
                      <?=$best_seller?>
                      </a>
                      <?php
												}
												else
												{
												?>
                      <a href="<?=$add_url?>/?id=<?php echo $detail;?>&page=<?=$page?>&st1=<?php echo $best_seller; ?>" role="button" class="btn btn-danger btn-sm" >
                      <?=$best_seller?>
                      </a>
                      <?php
												}
												?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Product Name">Product Name</label>
                    <div>
                      <?=$product_name?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Create Date">Create Date</label>
                    <div>
                      <?=$create_date?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Model No">Model No</label>
                    <div> <?php echo $model_no ?> </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Brand">Brand</label>
                    <div> <?php echo $brand ?> </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Category">Category </label>
                    <div>
                      <?=$category;?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sub Category">Sub Category </label>
                    <div> <?php echo $sub_category ?> </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="status">Status</label>
                    <div>
                      <?=$status?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="status">Used</label>
                    <div>
                      <?=$used?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Our Price">Our Price</label>
                    <div> &#8377;
                      <?=$our_price?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_link">Our Price (%) </label>
                    <div>
                      <?=$price_percentage?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_link">Tax</label>
                    <div>
                      <?=$resultt['india']?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_link">Quantity</label>
                    <div>
                      <?=$quantity?>
                      Nos. </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="youtube_link">Youtube Link</label>
                    <div> <a href="<?=$youtube_link?>" target="_blank">
                      <?=$youtube_link?>
                      </a> </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="merchant_link">Shipping Type</label>
                    <div>
                      <?=$shipp_type?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="merchant_link">Shipping Name</label>
                    <?php if($shipp_type=='template')
														{
															?>
                    <div>
                      <?=$resultss['name']?>
                    </div>
                    <?php
														}
														?>
                    <?php if($shipp_type=='manual')
														{
															?>
                    <div>
                      <?=$shipp_name?>
                    </div>
                    <?php
														}
														?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="product_link">Attribute</label>
                    <div>
                      	<?php 
						foreach($str as $key)
						{
							$result  = $objgen->get_Onerow("attributes","AND id =".$key);																	
						?>
                      	<?php echo $result['name'];?>
                      	<?php
						}								
						?>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="Remark">Remark</label>
                    <div> <?php echo $remark; ?> </div>
                  </div>
                </div>
                <?php 
				if($main_img!="")
				{
				?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="merchant_link">Main Image</label>
                    <div> <img src="<?=URL?>photos/small/<?php echo $main_img; ?>"/> </div>
                  </div>
                </div>
                <?php
				}
				?>
                <?php 
				if($img_count!="")
				{
				?>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Sub Images</label>
                    <div>
                    <?php
					if($img_count>0)
					{
					?>
                     <?php
						foreach($img_arr as $key=>$val)
						{
							if($val['image']>0)
    						{
					?>
                      <img src="<?=URL?>photos/small/<?php echo $val['image']; ?>" />
                      <?php
															  			}
															  		}
																}
															  ?>
                    </div>
                  </div>
                </div>
                <?php
														}
														?>
              </div>
            </div>
          </div>
          <br clear="all"   />
          <div class="clearfix form-actions" align="center" style="background-color:#E5E5E5;padding:20px"> <a type="button"  class="btn btn-inline btn-info" href="<?=URLAD?>list-product"><i class="fa fa-arrow-left"></i> Back</a> </div>
        </div>
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
</body>
</html>
