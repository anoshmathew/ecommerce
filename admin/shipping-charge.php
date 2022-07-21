<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		= new general();
$objval		= new validate();
$pagehead	= "Shipping Charge";
$list_url 	= URLAD."shipping-charge";
$srdiv    	= "none";
$adddiv   	= "none";
$objPN		= 	new page(1);
$pagesize	=	20;
$page	 	= 	isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if(isset($_GET['del']))
{
	$id		= $_GET['del'];
	$msg	= $objgen->del_Row("shipping_charge","id=".$id);	
	if($msg=="")
	{
		header("location:".$list_url."/?msg=3&page=".$page);
	}
}
if($_GET['msg']==1)
{
  	$msg2 		= "$pagehead Created Successfully.";
  	$adddiv   	= "show";
  	$srdiv    	= "none";
}
if($_GET['msg']==2)
{
  	$msg2 = "$pagehead Updated Successfully.";
}

if($_GET['msg']==3)
{
  	$msg2 = "$pagehead  Deleted Successfully.";
}
if(isset($_POST['Create']))
{ 
   	$name  			= $objgen->check_input($_POST['name']);
	$india  		= $objgen->check_input($_POST['india']);
   	$international  = $objgen->check_input($_POST['international']);
   	$kerala   		= $objgen->check_input($_POST['kerala']);
	if($india=="")
	{
		$india=0;
	}
	if($international=="")
	{
		$international=0;
	}
	if($kerala=="")
	{
		$kerala=0;
	}
   	$rules		=	array();
   	$rules[] 	=	"required,name,Enter the Shipping Name";
   	$errors  	=	$objval->validateFields($_POST, $rules);  
    $brd_exit 	= $objgen->chk_Ext("shipping_charge","name='$name'");
	if($brd_exit>0)
	{
		$errors[]= "This Shipping Name is already exists.";
		$adddiv  = "show";
		$srdiv   = "none";
	}
   	if(empty($errors))
	{
		 $msg = $objgen->ins_Row('shipping_charge','name,shipping_indian,shipping_international,shipping_kerala',"'".$name."','".$india."','".$international."','".$kerala."'");
		 if($msg=="")
		 {
			   header("location:".$list_url."/?msg=1");
		 }
	}
}
if(isset($_GET['edit']))
{
	$id 				= $_GET['edit'];
	$result				= $objgen->get_Onerow("shipping_charge","and id=".$id);
	$name   			= $objgen->check_tag($result['name']);
	$india   			= $objgen->check_tag($result['shipping_indian']);
	$international   	= $objgen->check_tag($result['shipping_international']);
	$kerala   			= $objgen->check_tag($result['shipping_kerala']);
	$adddiv  			= "show";
}
if(isset($_POST['Update']))
{    
	$name  			 = $objgen->check_input($_POST['name']);
    $india  		 = $objgen->check_input($_POST['india']);
    $international   = $objgen->check_input($_POST['international']);
    $kerala   		 = $objgen->check_input($_POST['kerala']); 
    if($india=="")
	{
		$india=0;
	}
	if($international=="")
	{
		$international=0;
	}
	if($kerala=="")
	{
		$kerala=0;
	}
	$errors = array();
	$rules		=	array();
	$rules[] 	= 	"required,name,Enter the Shipping Name";
	$errors  	= 	$objval->validateFields($_POST, $rules);
	
	$brd_exit = $objgen->chk_Ext("tax","name= '$name' and id<>".$id);
	if($brd_exit>0)
	{
		$errors[]	= "This $pagehead is already exists.";
		$adddiv   	= "show";
		$srdiv    	= "none";
	}
	if(empty($errors))
	{	 
		$msg = $objgen->upd_Row('shipping_charge',"name='".$name."',shipping_indian='".$india."',shipping_international='".$international."',shipping_kerala='".$kerala."'","id=".$id);
	if($msg=="")
	{
		header("location:".$list_url."/?msg=2&page=".$page);
	}
	}
}

if(isset($_POST['Search']))
{
	$page=1;
}
$where = "";
if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
	$un = trim($_REQUEST['un']);
	$where 		.= " and name like '%".$un."%'";
	$srdiv    	 = "block";
}
$row_count = $objgen->get_AllRowscnt("shipping_charge",$where);
if($row_count>0)
{
	$objPN->setCount($row_count);
	$objPN->pageSize($pagesize);
	$objPN->setCurrPage($page);
	$objPN->setDispType('PG_BOOSTRAP_AD');
	$pages = $objPN->get(array("un" => $un), 1, WEBLINKAD."/".$params[0]."/", "", "active");
	$res_arr = $objgen->get_AllRows("shipping_charge",$pagesize*($page-1),$pagesize,"id desc",$where);
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
				<a type="button" href="<?=$list_url?>"  class="btn btn-inline btn-warning"><i class="fa fa-refresh"></i> Reset</a>
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
								<div class="col-md-6">
									<div class="form-group">
									<label for="name">Shipping Name <span class="error" style="color:red;">*</span></label>
       								<input type="text" class="form-control" value="<?=$name?>" name="name" id="name" placeholder="Shipping Name" required />
									</div>
								</div>			
								<div class="col-md-6">
								<div class="form-group">
								<label for="state">Shipping Kerala (Amount)</label>
								<input type="text" class="form-control" value="<?=$kerala?>" name="kerala" id="kerala" placeholder="Shipping Kerala (Amount)"/>
								</div>
								</div>
								<div  class="col-md-6">
								<div class="form-group">
                                <label for="india">Shipping India (Amount)</label>
								<input type="text" class="form-control" value="<?=$india?>" name="india" id="india" placeholder="Shipping India (Amount" />
                                       </div>
										</div>			
								<div  class="col-md-6">
								<div class="form-group">
                                <label for=""> Shipping International (Amount)</label>
								<input type="text" class="form-control" value="<?=$international?>" name="international" id="international" placeholder=" Shipping International (Amount)"/>             
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
						<a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="fa fa-undo"></i>&nbsp;Cancel </a>
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
										<label for="Username">Name</label>
										  <input type="text" class="form-control" value="<?=$un?>" name="un" id="un" placeholder="Name">
									</div>
								</div>			
							</div>
						</div>
						<div class="card-footer center"> 
							<button type="submit" class="btn btn-primary" name="Search"><span class="fa fa-search  ace-icon"></span>&nbsp;Search</button>
							<a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="fa fa-refresh"></i>Reset </a>
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
						    <th>Id</th>
						    <th>Name</th>
						    <th>Shipping Kerala</th>
						    <th>Shipping Indian</th>
						    <th>Shipping International</th>
						    <th>Action</th>
						</tr>
							<?php
							if($row_count>0)
							{
								foreach($res_arr as $key=>$val)
								{
							?>
						<tr>
					        <td><?php echo $objgen->check_tag($val['id']); ?></td>
                            <td><?php echo $objgen->check_tag($val['name']); ?></td>
                            <td><?php echo $objgen->check_tag($val['shipping_kerala']); ?></td>
                            <td><?php echo $objgen->check_tag($val['shipping_indian']); ?></td>
						    <td><?php echo $objgen->check_tag($val['shipping_international']); ?></td>
						    <td> 
						    	<a href="<?=$list_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a>
						    	<a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Shipping Charge?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a>
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
</body>
</html>
