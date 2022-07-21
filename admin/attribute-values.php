<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		=	new general();
$objval	    =   new validate();
$list_url = URLAD."attribute-values";
$red_url = URLAD."attribute";
//$add_url  = URLAD."add-user";
$srdiv    = "none";
$adddiv   = "none";
$status   = 'active';
$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";
if(isset($_GET['id']))
{
	$aid 		= $_GET['id'];
	$result     = $objgen->get_Onerow("attributes","AND id=".$aid);
	$name       = $objgen->check_tag($result['name']);
}
$pagehead = "Attribute of ".$name;
if(isset($_GET['del']))
{
   	$id= $_GET['del'];
   	$msg     = $objgen->del_Row("attributes_values","id=".$id);
    if($msg=="")
   	{
		header("location:".$list_url."/?id=".$aid."&msg=3&page=".$page);
   	}
}
if(isset($_GET['st']))
{
	 $id 		= $_GET['id'];
	 $st 		= $_GET['st'];
	 $st_arr 	= $objgen->get_Onerow("attributes_values"," AND id=".$st);
	 if($st_arr['status']=='active')
	  $status 	= "inactive";
	 if($st_arr['status']=='inactive')
	  $status 	= "active";
	 $msg	=	$objgen->upd_Row("attributes_values","status='$status'","id=".$st);
	 header('location:'.$list_url.'/?id='.$id.'&msg=4&page='.$page);
}
if($_GET['msg']==1)
{
  	$msg2 		= "Attribute Value Created Successfully.";
   	$adddiv   	= "show";
   	$srdiv    	= "none";
}
if($_GET['msg']==3)
{
  	$msg2 = "Attribute Value Deleted Successfully.";
}
if($_GET['msg']==4)
{
  	$msg2 = "Status Changed Successfully.";
}
if(isset($_POST['Create']))
{
   	$attr_val  		 = $objgen->check_input($_POST['attr_val']);
   	$rules		     = array();
   	$rules[] 	     = "required,attr_val,Enter the Attribute Value";
   	$errors  	     = $objval->validateFields($_POST,$rules);
   	$brd_exit   = $objgen->chk_Ext("attributes_values","attr_val='$attr_val' and attr_id='$aid'");
	if($brd_exit>0)
	{
		$errors[] = "This Attribute Value is already exists.";
		$adddiv   = "show";
  		$srdiv    = "none";
	} 
   	if(empty($errors))
	{
		$msg = $objgen->ins_Row('attributes_values','attr_val,attr_id',"'".$attr_val."','".$aid."'");
      	if($msg=="")
      	{
      		header("location:".$list_url."/?msg=1&id=$aid&page".$page);
      	}
	}
}
if(isset($_POST['Search']))
{
	$page=1;
}
$where = " and attr_id=".$aid;
if(isset($_REQUEST['ta']) &&  trim($_REQUEST['ta'])!="")
{
  	$ta 	= trim($_REQUEST['ta']);
  	$where .= " and attr_val like '%".$ta."%'";
  	$srdiv  = "block";
  	$adddiv = "none";
}
$row_count = $objgen->get_AllRowscnt("attributes_values",$where);
if($row_count>0)
{
  	$objPN->setCount($row_count);
  	$objPN->pageSize($pagesize);
  	$objPN->setCurrPage($page);
  	$objPN->setDispType('PG_BOOSTRAP_AD');
  	$pages 		= $objPN->get(array("ta" => $ta), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  	$res_arr 	= $objgen->get_AllRows("attributes_values",$pagesize*($page-1),$pagesize,"id desc",$where);
}
if(isset($_POST['Reset']))
{
	unset($_REQUEST);
	header("location:".$list_url."/?id=$aid");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$pagehead?> | <?php echo TITLE; ?></title>
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
            <h1 class="m-0 text-dark"><?=$pagehead?>s</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
             <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=URLAD?>">Home</a></li>
              <li class="breadcrumb-item active"><?=$pagehead?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row" style="clear:both;margin-bottom:10px;">
			<div class="col-md-12" align="right" style="clear:both">
				<button type="button"  class="btn btn-inline btn-danger" onClick="click_button(1)"><i class="fa fa-edit"></i> New</button>
				<button type="button"  class="btn btn-inline btn-primary" onClick="click_button(2)" ><i class="fa fa-search"></i> Search</button>
				<a type="button" href="<?=$list_url?>/?id=<?=$aid?>"  class="btn btn-inline btn-warning"><i class="fa fa-refresh"></i> Reset</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<?php
			if($msg!="")
			{
			?>
			<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
			<i class="ace-icon fa fa-times"></i>
			</button>
			<strong>
			<i class="ace-icon fa fa-times"></i>
			Oh snap!
			</strong>
			<?php echo $msg; ?>
			<br>
			</div>
			<?php
			}
			?>
			<?php
			if (!empty($errors)) 
			{
			?>
			<div class="alert alert-danger alert-dismissable">
			<i class="fa fa-ban"></i>
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
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
			<i class="ace-icon fa fa-times"></i>
			</button>
			<strong>
			<i class="ace-icon fa fa-check"></i>
			Sucsess!
			</strong>
			<?php echo $msg2; ?>
			<br>
			</div>
			<?php
			}
			?>
			</div>
		</div>
	  <div class="row hide_div" style="padding-top:10px;display:<?=$adddiv?>" id="adddiv">
		<div class="col-md-12">
            <div class="card card-<?=TH_COLOR?>">
              <div class="card-header">
                <h3 class="card-title">Enter <?=$pagehead?> Informations</h3>	
              </div>
			 <form role="form" method="post" enctype="multipart/form-data" >
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
									<label for="username">Attribute Name : </label>
                 							<?=$name?>
										</div>
									</div>
									<div class="col-md-12">
									<div class="form-group">
									<label for="username">Attribute Value <span class="error" style="color:red;">*</span></label>
                 					<input type="text" class="form-control" value="<?=$attr_val?>" name="attr_val" id="attr_val" required />														</div>
									</div>									
								</div>							
							</div>
						</div>
						<div class="card-footer center">
						<?php
						if(isset($_GET['edit']))
						{
						?>
						<button class="btn btn-primary" type="submit" name="Update"><i class="ace-icon fa fa-check bigger-110"></i>&nbsp;Update
						</button>
						<?php
						}
						else
						{
						?>
						<button type="submit" class="btn btn-primary" name="Create" ><span class="fa fa-save  ace-icon"></span>&nbsp;Save</button>
						<?php
						}
						?>
						<a class="btn btn-warning" type="reset"  href="<?=$list_url?>/?id=<?=$aid?>"><i class="fa fa-undo"></i>&nbsp;Cancel </a>						
						</div>
					</form>				
            </div>
          </div>        
          </div>		  
	<div class="row hide_div" style="padding-top:10px;display:<?=$srdiv?>"  id="srdiv">	
		<div class="col-md-12">
            <div class="card card-<?=TH_COLOR?>">
              <div class="card-header">
                	<h3 class="card-title">Search <?=$pagehead?></h3>     
              </div>		  
			 <form role="form" method="post" enctype="multipart/form-data" >
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="brandname">Attribute Value</label>
                 				<input type="text" class="form-control" value="<?=$ta?>" name="ta" id="ta"  />
									</div>
								</div>	
							</div>
						</div>
						<div class="card-footer center"> 
							<button type="submit" class="btn btn-primary" name="Search"><span class="fa fa-search  ace-icon"></span>&nbsp;Search</button>
							<a class="btn btn-warning" type="reset"  href="<?=$list_url?>/?id=<?=$aid?>"><i class="fa fa-refresh"></i>Reset </a>
						</div>
					</form>
            </div>
          </div> 
          </div>  
		  <div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header">
						<h3 class="card-title">List <?=$pagehead?>s</h3>
					</div>
					<div class="card-body table-responsive p-0">
						<table class="table table-bordered table-hover table-sm">
						<tr>
						<th>Attribute Value</th>
						<th>Status</th>
						<th>Action</th>
						</tr>
							<?php
							if($row_count>0)
							{
								foreach($res_arr as $key=>$val)
								{
							?>
						<tr>
					     <td><?php echo $objgen->check_tag($val['attr_val']); ?></td>
                                <td>
	                                                <?php
													if($val['status']=='active')
													{
													?>
	                                                <a href="<?=$list_url?>/?id=<?=$aid?>&page=<?=$page?>&st=<?=$val['id']?>" role="button" >
													<span class="badge bg-success">Active</span>
	                                                </a>
													<?php
													}
													else
													{
													?>
	                                                <a href="<?=$list_url?>/?id=<?=$aid?>&page=<?=$page?>&st=<?=$val['id']?>" role="button" >
													<span class="badge bg-warning">Inactive</span>
	                                                </a>
													<?php
													}
													?>
                                                    </td>                   
						
												<td> 
                                                <?php
												if($val['status']=='active')
												{
												?>
												<a href="<?=$list_url?>/?id=<?=$aid?>&page=<?=$page?>&st=<?=$val['id']?>" role="button" class="btn btn-success btn-sm" ><i class="fas fa-unlock "></i></a>
												<?php
												}
												else
												{
												?>
												<a href="<?=$list_url?>/?id=<?=$aid?>&page=<?=$page?>&st=<?=$val['id']?>" role="button" class="btn btn-danger btn-sm" ><i class="fas fa-lock "></i></a>
												<?php
												}
												?>					  	
							<a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>&id=<?=$aid?>" role="button" onClick="return confirm('Do you want to delete this <?=$pagehead?>?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a>
						</td>
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
			<div class="card-footer clearfix">
			<?php echo $pages; ?>
			</div>
			<?php
			}
			?>
			</div>		
			</div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once "footer.php"; ?>
</div>
<!-- ./wrapper -->
 <?php require_once "footer-script.php"; ?>
 <script type="text/javascript">
      jQuery(function($) {
          /***************/
        $('.show-details-btn').on('click', function(e) {
          e.preventDefault();
          $(this).closest('tr').next().toggleClass('open');
          $(this).find('.ace-icon').toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
        });
        /***************/
      });
  </script>
</body>
</html>
