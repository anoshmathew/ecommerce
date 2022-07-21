<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objgen   = new general();
$objval =   new validate();

$pagehead = "Admin User";
$list_url = URLAD."list-adminusers";
$srdiv    = "none";
$adddiv   = "none";
  

$objPN    =   new page(1);
/** Page Settings  **/
$pagesize = 25;
$page   = isset($_REQUEST['page'])  ? $_REQUEST['page'] : "1";

if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("admin","admin_id=".$id);
   if($msg=="")
   {
	   header("location:".$list_url."/?msg=3&page=".$page);
   }
}

if(isset($_GET['st']))
{
   $id = $_GET['id'];
   $st = $_GET['st'];
   if($st=='active')
    $status = "inactive";
   if($st=='inactive')
    $status = "active";
   
   $msg = $objgen->upd_Row("admin","status='$status'","admin_id=".$id);
   header('location:'.$list_url.'/?msg=4&page='.$page);
}

if($_GET['msg']==1)
{
  $msg2     = "User Created Successfully.";
  $adddiv    = "show";
  $srdiv    = "none";
}

if($_GET['msg']==2)
{
  $msg2 = "User Updated Successfully.";
}

if($_GET['msg']==3)
{
  $msg2 = "User Deleted Successfully.";
}

if($_GET['msg']==4)
{
  $msg2 = "Status Changed Successfully.";
}

if(isset($_POST['Create']))
{
     $username        = $objgen->check_input($_POST['username']);
   	 $user_type       = $objgen->check_input3($_POST['user_type']);
   	 $password        = trim($_POST['password']);

   	$rules     = array();
   	$rules[]   = "required,username,Enter the Username";
   	$rules[]   = "required,password,Enter the Password";
   	$errors    = $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("admin","username='$username' and user_type='$user_type'");
  	if($brd_exit>0)
  	{
    	$errors[] 	= "This username is already exists.";
     	$adddiv    	= "show";
     	$srdiv    	= "none";
  	}
  
  	if($username=='superadmin' || $username=='admin')
  	{
    	$errors[]  = "This username is already exists.";
    	$adddiv    = "show";
    	$srdiv     = "none";
  	}

   	if(empty($errors))
  	{
     	$msg = $objgen->ins_Row('admin','username,password,user_type',"'".$username."','".$objgen->encrypt_pass($password)."',
		'".$user_type."'");
     	if($msg=="")
     	{
         	header("location:".$list_url."/?msg=1");
     	}
  	}
}

if(isset($_GET['edit']))
{
	$id = $_GET['edit'];
	$result        = $objgen->get_Onerow("admin","AND admin_id=".$id);
	$username     = $objgen->check_tag($result['username']);
	$user_type     = $objgen->check_tag($result['user_type']);
	$password     = $objgen->decrypt_pass($result['password']);
	
	$adddiv    = "show";
  	$srdiv     = "none";
  
}

if(isset($_POST['Update']))
{    
	$username  = $objgen->check_input($_POST['username']);
	$user_type = $objgen->check_input3($_POST['user_type']);
	$password  = trim($_POST['password']);
	
	$errors    = array();
	$rules     = array();
	$rules[]   = "required,username,Enter the Username";
	$rules[]   = "required,password,Enter the Password";
	$errors    = $objval->validateFields($_POST, $rules);
   
  $brd_exit = $objgen->chk_Ext("admin","username='$username'  and user_type='$user_type' and admin_id<>".$id);
	if($brd_exit>0)
	{
		$errors[] = "This username is already exists.";
		$adddiv   = "show";
		$srdiv    = "none";
	}  
	if($username=='superadmin' || $username=='admin')
	{
		$errors[] = "This username is already exists.";
		$adddiv   = "show";
		$srdiv    = "none";
	}

	if(empty($errors))
	{
		$msg = $objgen->upd_Row('admin',"username='".$username."',password='".$objgen->encrypt_pass($password)."',
		user_type='".$user_type."'","admin_id=".$id);
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
	$where .= " and username like '%".$un."%'";
	$srdiv    = "block";
	$adddiv   = "none";
}

if(isset($_REQUEST['ut']) &&  trim($_REQUEST['ut'])!="")
{
	$ut = trim($_REQUEST['ut']);
	$where .= " and user_type = '".$ut."'";
	$srdiv    = "block";
	$adddiv   = "none";
}

$where .= " and username<>'admin'";
$row_count = $objgen->get_AllRowscnt("admin",$where);
if($row_count>0)
{
	$objPN->setCount($row_count);
	$objPN->pageSize($pagesize);
	$objPN->setCurrPage($page);
	$objPN->setDispType('PG_BOOSTRAP_AD');
	$pages = $objPN->get(array("un" => $un, "ut" => $ut), 1, WEBLINKAD."/".$params[0]."/", "", "page-item");
	$res_arr = $objgen->get_AllRows("admin",$pagesize*($page-1),$pagesize,"admin_id desc",$where);
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
              <li class="breadcrumb-item"><a href="<?=URLAD?>home">Home</a></li>
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
			Success!
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
									<label for="Username">Username <span class="error" style="color:red;">*</span></label>
       
									<input type="text" class="form-control" name="username" id="username" value="<?=$username?>" placeholder="Username" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">   
									<label for="Password">Password  <span class="error" style="color:red;">*</span></label>

									<input type="password" class="form-control" id="password" name="password" value="<?=$password?>" placeholder="Password" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									<label for="user_type">User Type <span class="error" style="color:red;">*</span></label>
         
									<select class="form-control" name="user_type" id="user_type" required>
									<option value="">Select</option>
									<option value="staff" <?php if($user_type=='staff') { ?> selected="selected" <?php } ?> >Staff</option>
									<option value="admin" <?php if($user_type=='admin') { ?> selected="selected" <?php } ?> >Admin</option>
									</select>
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
										<label for="Username">Username</label>
										<input type="text" class="form-control" value="<?=$un?>" name="un" id="un"  />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="user_type">User Type</label>
										<select class="form-control" name="ut" id="ut">
										<option value="">Select</option>
										<option value="staff" <?php if($ut=='staff') { ?> selected="selected" <?php } ?> >Staff</option>
										<option value="admin" <?php if($ut=='admin') { ?> selected="selected" <?php } ?> >Admin</option>
										</select>
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
						
						<th>Username</th>
						<th>UserType</th>
						<th>Status</th>
						<th>Password</th>
						<th>Action</th>
						
						</tr>
							<?php
							if($row_count>0)
							{
							foreach($res_arr as $key=>$val)
							{
							?>
						<tr>
						<td><?php echo $objgen->check_tag($val['username']); ?></td>
						<td><?php echo ucfirst($objgen->check_tag($val['user_type'])); ?></td>
						
						<td>
							<?php
							if($val['status']=='active')
							{
							?>
							<a href="<?=$list_url?>/?id=<?=$val['admin_id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" >
							<span class="badge bg-success">Active</span>
							</a>
							<?php
							}
							else
							{
							?>
							<a href="<?=$list_url?>/?id=<?=$val['admin_id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" >
							<span class="badge bg-warning">Inactive</span>
							</a>
							<?php
							}
							?>
						</td>
						<td class="center">
							<div class="action-buttons">
								<a href="#" class="green bigger-140 show-details-btn" title="Show Details">
								<i class="ace-icon fa fa-angle-double-down"></i>
								<span class="sr-only">Details</span>
								</a>
							</div>
						</td>
						<td> 
							<?php
							if($val['status']=='active')
							{
							?>
							<a href="<?=$list_url?>/?id=<?=$val['admin_id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" class="btn btn-success btn-sm" ><i class="fas fa-unlock "></i></a>
							<?php
							}
							else
							{
							?>
							<a href="<?=$list_url?>/?id=<?=$val['admin_id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" class="btn btn-danger btn-sm" ><i class="fas fa-lock"></i></a>
							<?php
							}
							?>
																			  
							<a href="<?=$list_url?>/?edit=<?=$val['admin_id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a>
							<a href="<?=$list_url?>/?del=<?=$val['admin_id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this User?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a>
							
						</td>
						</tr>
						<tr class="detail-row">
						<td colspan="5">
							<div class="row" >
								<div class="col-xs-12 col-sm-12">
									Password : <span><?=$objgen->decrypt_pass($val['password'])?></span>
								</div>
							</div>
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
