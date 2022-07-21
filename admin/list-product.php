<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		= new general();
$pagehead	= "Product";
$list_url 	= URLAD."list-product";
$add_url	= URLAD."add-product";
$detail		= URLAD."more-details";
$srdiv    	= "none";
$adddiv   	= "none";
$objPN		= new page(1);
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==2)
{
  	$msg2 = "Product Updated Successfully.";
}
if($_GET['msg']==3)
{
  	$msg2 = "Product Deleted Successfully.";
}
if($_GET['msg']==4)
{
  	$msg2 = "Product Status Changed Successfully.";
}
if($_GET['msg']==5)
{
  	$msg2 = "Feature Status Changed Successfully.";
}
if(isset($_GET['del']))
{
	$id		= $_GET['del']; 
	$where   = "AND prod_id=".$id;
	$prodimg_count= $objgen->get_AllRowscnt("product_image",$where);
	if($prodimg_count>0)
	{
	  $prodimg_arr = $objgen->get_AllRows("product_image",0,$prodimg_count,"id asc",$where);
	  foreach($prodimg_arr as $key=>$result)
	  {
	 $photo   = $objgen->check_tag($result['image']); 
   	 if(file_exists("../photos/orginal/".stripslashes($photo)))
			unlink("../photos/orginal/".stripslashes($photo));
   	 if(file_exists("../photos/medium/".stripslashes($photo)))
			unlink("../photos/medium/".stripslashes($photo));	
	 if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	 if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));
		}
	}
    $msg    = $objgen->del_Row("product_image","prod_id=".$id);
	$msg	= $objgen->del_Row("product","id=".$id);
	$msg	= $objgen->del_Row("product_attr","prod_id=".$id);
	$msg	= $objgen->del_Row("deal_products","prod_id=".$id);
	$ms 	= $objgen->del_Row("featured_products","prod_id=".$id);
	if($msg=="")
	{
		header("location:".$list_url."/?msg=3&page=".$page);
	}
}
if(isset($_GET['st']))
{
	 $st 		= $_GET['st'];
	 $stat_arr 	= $objgen->get_Onerow("product"," AND id=".$st);
	 if($stat_arr['p_status']=='active')
	  $status 	= "inactive";
	 if($stat_arr['p_status']=='inactive')
	  $status 	= "active";
	 
	 $msg		=	$objgen->upd_Row("product","p_status='$status'","id=".$st);
	 header('location:'.$list_url.'/?msg=4&page='.$page);
}
if(isset($_GET['feat']))
{
	 $feat 		= $_GET['feat'];
	 $feat_arr 	= $objgen->get_Onerow("product"," AND id=".$feat);
	 if($feat_arr['featured']=='yes')
	  $status 	= "no";
	 if($feat_arr['featured']=='no')
	  $status 	= "yes";
	 
	 $msg		=	$objgen->upd_Row("product","featured='$status'","id=".$feat);
	
	 header('location:'.$list_url.'/?msg=5&page='.$page);
}
if(isset($_GET['b_sell']))
{
	 $b_sell 		= $_GET['b_sell'];
	 $b_sell_arr 	= $objgen->get_Onerow("product"," AND id=".$b_sell);
	 if($b_sell_arr['best_seller']=='yes')
	  $status 	= "no";
	 if($b_sell_arr['best_seller']=='no')
	  $status 	= "yes";
	 
	 $msg		=	$objgen->upd_Row("product","best_seller='$status'","id=".$b_sell);
	
	 header('location:'.$list_url.'/?msg=5&page='.$page);
}
if(isset($_POST['Search']))
{
	$page		=	1;
	$srdiv  	= 	"block";
}

if(isset($_REQUEST['us']) &&  trim($_REQUEST['us'])!="")
{
	$us     = trim($_REQUEST['us']);
	$where .= " and model_no = '".$us."'";
	$srdiv  = "block";
}

if(isset($_REQUEST['ut']) &&  trim($_REQUEST['ut'])!="")
{
	$ut     = trim($_REQUEST['ut']);
	$where .= " and category  =".$ut;
	$srdiv  = "block";
}
if(isset($_REQUEST['uu']) &&  trim($_REQUEST['uu'])!="")
{
	$uu     = trim($_REQUEST['uu']);
	$where .= " and sub_category ='".$uu."'";
	$srdiv  = "block";
}
if(isset($_REQUEST['uw']) &&  trim($_REQUEST['uw'])!="")
{
	$uw 	= trim($_REQUEST['uw']);
	$where .= " and product_name like '%".$uw."%'";
	$srdiv  = "block";
}
$row_count = $objgen->get_AllRowscnt("product",$where);
if($row_count>0)
{
	  $objPN->setCount($row_count);
	  $objPN->pageSize($pagesize);
	  $objPN->setCurrPage($page);
	  $objPN->setDispType('PG_BOOSTRAP_AD');
	  $pages = $objPN->get(array("us" => $us,"ut" => $ut,"uu" => $uu,"uw" => $uw), 
	  1, WEBLINKAD."/".$params[0]."/", "", "active");
	  $res_arr = $objgen->get_AllRows("product",$pagesize*($page-1),$pagesize,"id desc",$where);
}
$where   = "";
$cat_count= $objgen->get_AllRowscnt("category",$where);
if($cat_count>0)
{
	$cat_arr = $objgen->get_AllRows("category",0,$cat_count,"cat_name asc",$where);
}

if($ut!="")
{

		$where		= " and cat_id=".$ut;
		$sub_cat_count= $objgen->get_AllRowscnt("sub_category",$where);
		if($sub_cat_count>0)
		{
			$sub_cat_arr = $objgen->get_AllRows("sub_category",0,$sub_cat_count,"sub_cat_name asc",$where);
		}		
}
if(isset($_POST['Reset']))
{
	unset($_REQUEST);
	header("location:".$list_url);
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
<link href="<?=URLAD?>plugins/bootstrap-select-1.13.9/dist/css/bootstrap-select.css" rel="stylesheet" />
<link rel="stylesheet" href="<?=URLAD?>plugins/datepicker/datepicker3.css">
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
            <h1 class="m-0 text-dark"><?=$pagehead?>s</h1>
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
          <div class="col-md-12" align="right" style="clear:both"> <a type="button"  class="btn btn-inline btn-danger" href="<?=$add_url?>" ><i class="fa fa-edit"></i> New</a>
            <button type="button"  class="btn btn-inline btn-primary" onClick="click_button(2)" ><i class="fa fa-search"></i> Search</button>
            <a type="button" href="<?=$list_url?>"  class="btn btn-inline btn-warning"><i class="fa fa-refresh"></i> Reset</a> </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php
			if($msg!="")
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
			foreach ($errors as $error1)
			echo "<div> - ".$error1." </div>";
			?>
            </div>
            <?php
			} 
			?>
            <?php
			if($msg2!="")
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
        <div class="row hide_div" style="padding-top:10px;display:<?=$srdiv?>"  id="srdiv">
          <div class="col-md-12">
            <div class="card card-<?=TH_COLOR?>">
              <div class="card-header">
                <h3 class="card-title">Search
                  <?=$pagehead?>
                </h3>
              </div>
              <form role="form" method="post" enctype="multipart/form-data" >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="Username">Model No</label>
                        <input type="text" class="form-control" value="<?=$us?>" name="us" id="us"  />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="Username">Category</label>
                        <select name="ut" id="ut" class="form-control form-group selectpicker" data-live-search="true" onChange="product_cat(this.value)">
                          	<option value=""   selected="selected" >-Select-</option>
                          	<?php
             				if($cat_count>0)
             				{
                				foreach($cat_arr as $key=>$val)
                				{
                        			 ?>
                          <option value="<?=$val['id']?>" <?php if($val['id']==$ut) { ?> selected="selected" <?php } ?> >
                          <?=$objgen->check_tag($val['cat_name'])?>
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
                        <label for="uu">Sub Category</label>
                        <span id="sub_cat">
                        <select name="uu" id="uu" class="form-control selectpicker" data-live-search="true"  >
                          <option value=""   selected="selected" >-Select-</option>
                          <?php
             			if($sub_cat_count>0)
             			{
                			foreach($sub_cat_arr as $key=>$val)
                			{
                        		 ?>
                          <option value="<?=$val['id']?>" <?php if($val['id']==$uu) { ?> selected="selected" <?php } ?> >
                          <?=$objgen->check_tag($val['sub_cat_name'])?>
                          </option>
                          <?php
                        	 }
                        }
                        	?>
                        </select>
                        </span> </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="Username">Product Name</label>
                        <input type="text" class="form-control form-group" value="<?=$uw?>" name="uw" id="uw"  />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer center">
                  <button type="submit" class="btn btn-primary" name="Search"><span class="fa fa-search  ace-icon"></span>&nbsp;Search</button>
                  <a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="fa fa-refresh"></i>Reset </a> </div>
              </form>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">List
                  <?=$pagehead?>
                </h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover table-sm">
                  <tr>
                    <th>ID</th>
                    <th>Model No</th>
					<th>Product</th>
                    <th>Date</th>   
					<th>Best Seller</th>                
                    <th>Featured</th>
                    <th>Status</th>
                    <th>View</th>
                    <th style="width:10%">Actions</th>
                  </tr>
                  <?php
							if($row_count>0)
							{
								foreach($res_arr as $key=>$val)
								{
									//$res_cat     	= $objgen->get_Onerow("category","AND id =".$val['category']);
	
							?>
                  <tr>
                    <td><?php echo $objgen->check_tag($val['id']); ?></td>
					<td><?php echo $objgen->check_tag($val['model_no']); ?></td>
					<td><?php echo $objgen->check_tag($val['product_name']); ?></td>
                    
                    <td><?php echo $objgen->check_tag($val['create_date']); ?></td>
                    
                    <?php
							//$re			= $objgen->check_tag($val['admin_id']);
							//$res_admin	= $objgen->get_Onerow("admin","AND admin_id =".$re);
							?>
                    
					<td><?php
								if($val['best_seller']=='yes')
								{
								?>
                      <a href="<?=$list_url?>/?b_sell=<?=$val['id']?>&page=<?=$page?>" role="button"> <span class="badge bg-success">Yes</span></a>
                      <?php
								}
								else
								{
								?>
                      <a href="<?=$list_url?>/?b_sell=<?=$val['id']?>&page=<?=$page?>" role="button"> <span class="badge bg-warning">No</span></a>
                      <?php
								}
								?>
                    </td>

					<td><?php
								if($val['featured']=='yes')
								{
								?>
                      <a href="<?=$list_url?>/?feat=<?=$val['id']?>&page=<?=$page?>" role="button"> <span class="badge bg-success">Yes</span></a>
                      <?php
								}
								else
								{
								?>
                      <a href="<?=$list_url?>/?feat=<?=$val['id']?>&page=<?=$page?>" role="button"> <span class="badge bg-warning">No</span></a>
                      <?php
								}
								?>
                    </td>
                    <td><?php
								if($val['p_status']=='active')
								{
								?>
                      <a href="<?=$list_url?>/?st=<?=$val['id']?>&page=<?=$page?>" role="button"> <span class="badge bg-success">Active</span></a>
                      <?php
								}
								else
								{
								?>
                      <a href="<?=$list_url?>/?st=<?=$val['id']?>&page=<?=$page?>" role="button"> <span class="badge bg-warning">Inactive</span></a>
                      <?php
								}
								?>
                    </td>
                    <td><a href="<?=$detail?>/?detail=<?=$val['id']?>&page=<?=$page?>" role="button" 
										class="btn btn-xs btn-success" target="_blank" ><i class="fa fa-search bigger-120"></i></a></td>
                    <td><a href="<?=$add_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a> <a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Product?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a> </td>
                  </tr>
                  <?php
							}
						}
						?>
                </table>
              </div>
            </div>
            <?php
			if($row_count > $pagesize) 
			{
			?>
            <div class="card-footer clearfix"> <?php echo $pages; ?> </div>
            <?php
			}
			?>
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
<script src="<?=URLAD?>plugins/bootstrap-select-1.13.9/dist/js/bootstrap-select.js"></script>
<script src="<?=URLAD?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript">
    $('.date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy'
    })
</script>
<script>
function product_cat(id)
   {
    $.ajax({type: "GET",
		    url: "<?=URLAD?>ajax.php",
		    data: {pid : 5, st5 : id},
		    success: function (result)
		    {
				$("#sub_cat").html(result);
		    }
		  });
	}
	</script>
</body>
</html>
