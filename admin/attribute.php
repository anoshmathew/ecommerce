<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		=	new general();
$objval	    =   new validate();
$pagehead 	= "Attribute";
$list_url 	= URLAD."attribute";
//$add_url  = URLAD."add-user";
$srdiv    	= "none";
$adddiv   	= "none";
$status   	= 'active';
$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";
if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("attributes_values","attr_id=".$id);
   $msg     = $objgen->del_Row("attributes","id=".$id);
    if($msg=="")
   	{
		header("location:".$list_url."/?msg=3&page=".$page);
   	}
}
if(isset($_GET['st']))
{
	 $id 		= $_GET['id'];
	 $st 		= $_GET['st'];
	 if($st	== 'active')
	  $status 	= "inactive";
	 if($st=='inactive')
	  $status 	= "active"; 
	 $msg		=	$objgen->upd_Row("attributes","status='$status'","id=".$id);
	 header('location:'.$list_url.'/?msg=4&page='.$page);
}
if($_GET['msg']==1)
{
  	$msg2 		= "Attribute Created Successfully.";
   	$adddiv   	= "show";
   	$srdiv    	= "none";
}
if($_GET['msg']==2)
{
  	$msg2 = "Attribute Updated Successfully.";
}
if($_GET['msg']==4)
{
  	$msg2 = "Status Changed Successfully.";
}
if($_GET['msg']==3)
{
  	$msg2 = "Attribute Deleted Successfully.";
}
if(isset($_POST['Create']))
{
   	$templt_name 	= $objgen->check_input($_POST['templt_name']);
   	$name  		 	= $objgen->check_input($_POST['name']);
   	$status  	 	= $objgen->check_input($_POST['status']);
   	$rules		    = array();
  	$rules[] 	    = "required,templt_name,Enter the Template Name";
   	$rules[] 	    = "required,name,Enter the Attribute";
   	$errors  	    = $objval->validateFields($_POST,$rules); 
   	$brd_exit   	= $objgen->chk_Ext("attributes","template_name='$templt_name'");
	if($brd_exit>0)
	{
		  $errors[] = "This Template is already exists.";
		  $adddiv   = "show";
  		  $srdiv    = "none";
	} 
	if(empty($errors))
	{
        $msg = $objgen->ins_Row('attributes','name,template_name,status',"'".$name."','".$templt_name."','".$status."'");
      	if($msg=="")
      	{
      		header("location:".$list_url."/?msg=1");
      	}
	}
}
if(isset($_GET['edit']))
{
    $id           	= $_GET['edit'];
	$result       	= $objgen->get_Onerow("attributes","AND id=".$id);
	$templt_name  	= $objgen->check_tag($result['template_name']);
	$name         	= $objgen->check_tag($result['name']);
	$status       	= $objgen->check_tag($result['status']);
	$adddiv    		= "show";
    $srdiv     		= "none";
}
if(isset($_POST['Update']))
{
	$templt_name 	= $objgen->check_input($_POST['templt_name']);
	$name  		 	= $objgen->check_input($_POST['name']);
   	$status  	 	= $objgen->check_input($_POST['status']);
   	$rules		    = array();
   	$rules[] 	    = "required,templt_name,Enter the Template Name";
   	$rules[] 	    = "required,name,Enter the Attribute";
   	$errors  	    = $objval->validateFields($_POST,$rules); 
    $brd_exit   	= $objgen->chk_Ext("attributes","template_name='$templt_name and id<>$id'");
	if($brd_exit>0)
	{
		  $errors[] = "This Template is already exists.";
		  $adddiv   = "show";
   		  $srdiv    = "none";
	} 
	if(empty($errors))
	{
		$msg = $objgen->upd_Row('attributes',"name='".$name."',template_name='".$templt_name."',status='".$status."'","id=".$id);
      		 if($msg=="")
      		 {
      			   header("location:".$list_url."/?msg=1&page=".$page);
      		 }
	}
}
if(isset($_POST['Search']))
{
	$page=1;
}
if(isset($_REQUEST['ta']) &&  trim($_REQUEST['ta'])!="")
{
	$ta 	= trim($_REQUEST['ta']);
  	$where .= " and name like '%".$ta."%'";
  	$srdiv  = "block";
  	$adddiv	= "none";
}
$row_count = $objgen->get_AllRowscnt("attributes",$where);
if($row_count>0)
{
  	$objPN->setCount($row_count);
  	$objPN->pageSize($pagesize);
  	$objPN->setCurrPage($page);
  	$objPN->setDispType('PG_BOOSTRAP_AD');
  	$pages 	= $objPN->get(array("ta" => $ta), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  	$res_arr= $objgen->get_AllRows("attributes",$pagesize*($page-1),$pagesize,"id desc",$where);
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
								<div class="col-md-4">
									<div class="form-group">
									<label for="name">Template Name <span class="error" style="color:red;">*</span></label>
       								<input type="text" class="form-control" value="<?=$templt_name?>" name="templt_name" id="templt_name" placeholder="Template Name" required />
									</div>
								</div>	
								<div class="col-md-4">
									<div class="form-group">
									<label for="name">Attribute Name <span class="error" style="color:red;">*</span></label>
       								<input type="text" class="form-control" value="<?=$name?>" name="name" id="name" placeholder="Attribute Name" required />
									</div>
								</div>					
					<div  class="col-md-4">
								<div class="form-group">
                                    <label for="mainimage">Status</label><br />
									
									<div class="icheck-primary d-inline">
									<input  type="radio" value="active" <?php if($status=='active') { ?> checked="checked"  <?php } ?> name="status" id="radioPrimary1" >
											<label for="radioPrimary1">Active
											</label>
										  </div>&nbsp&nbsp
           							<div class="icheck-primary d-inline">
											<input   type="radio" value="inactive" <?php if($status=='inactive') { ?> checked="checked"  <?php } ?> name="status"  id="radioPrimary2" >
											<label for="radioPrimary2">Inactive
											</label>
									</div>
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
										<label for="Username">Attribute Name</label>
										 <input type="text" class="form-control" value="<?=$ta?>" name="ta" id="ta"  placeholder="Attribute Name"/>
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
						<th>Template Name</th>
						<th>Attribute</th>
						<th>Attribute Value</th>
						<th>Action</th>
						</tr>
							<?php
							if($row_count>0)
							{
								foreach($res_arr as $key=>$val)
								{
							?>
						<tr>
						   <td><?php echo $objgen->check_tag($val['template_name']); ?></td>
					       <td><?php echo $objgen->check_tag($val['name']); ?></td>
                           <td>	
						   <a href="<?=URLAD?>attribute-values/?id=<?=$val['id']?>" role="button" class="btn btn-danger btn-sm" ><i class="fas  fa-plus bigger-120"></i>Add</a>
						   </td>
						  <td> 
						  		 				<?php
												if($val['status']=='active')
												{
												?>
												<a href="<?=$list_url?>/?id=<?=$val['id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" class="btn btn-success btn-sm" ><i class="fas fa-unlock"></i></a>
												
												<?php
												}
												else
												{
												?>
												<a href="<?=$list_url?>/?id=<?=$val['id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" class="btn btn-danger btn-sm" ><i class="fas fa-lock"></i></a>
												<?php
												}
												?>
							<a href="<?=$list_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a>
							<a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Attribute?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a>
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
