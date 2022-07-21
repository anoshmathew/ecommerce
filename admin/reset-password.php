<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objval	=   new validate();
$objgen		=	new general();

$pagehead = "Reset Password";
$list_url = URLAD."reset-password";
$srdiv    = "none";
$adddiv   = "none";


$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "User Created Successfully.";
}

if(isset($_POST['Change']))
{
	$old 		= trim($_POST['old_pwd']);
	$pass 		= trim($_POST['new_pwd']);
	$conf_pass 	= trim($_POST['conf_password']);
	
	$rules		=	array();
	$rules[] 	= "required,old_pwd,Enter the Old Password";
	$rules[] 	= "required,new_pwd,Enter the New Password";
	$rules[] 	= "required,conf_password,Enter the Conf. Password";
	
	$errors  	= $objval->validateFields($_POST, $rules);
	
	if(empty($errors))
	{
		$msg = $objgen->match_Pass($pass,$conf_pass);
		if($msg=="")
		{
			$msg = $objgen->chng_password('admin','password',$_POST,'admin_id',$_SESSION['MYPR_adm_id']);
			if($msg=="")
			{
				$msg2 		= "Password Changed Successfully.";
				$old 		= "";
				$pass 		= "";
				$conf_pass 	= "";
			}
		}
	}
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
            <h1 class="m-0 text-dark"><?=$pagehead?></h1>
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
			if (!empty($errors)) {
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
        <div class="row">
		
		<div class="col-md-6">

            <div class="card card-<?=TH_COLOR?>">
              <div class="card-header">
                <h3 class="card-title">Enter Password Informations</h3>
              </div>
			  
			 <form role="form" action="" method="post" enctype="multipart/form-data" >
              <div class="card-body">   
			           
			     <label for="old_pwd">Old Password</label>
				 <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
               	  <input type="password" class="form-control" value="<?=$old?>" name="old_pwd" id="old_pwd" placeholder="Old password" maxlength="20" required />
                </div>
				
				<label for="new_pwd">New Password</label>
				 <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
               	  <input type="password" class="form-control" value="<?=$pass?>" name="new_pwd" id="new_pwd" placeholder="New password" maxlength="20" required />
                </div>
				
				<label for="conf_password">Confirm Password</label>
				 <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
               	  <input type="password" class="form-control" value="<?=$conf_pass?>" name="conf_password" id="conf_password" placeholder="Confirm password" maxlength="20" required />
                </div>

              </div>
			  
			    <div class="card-footer">
				
				<button type="submit" class="btn btn-primary" name="Change"><span class="fa fa-save"></span>&nbsp;Save</button>
        
                </div>
				</form>
				
            </div>
          </div>
         
          </div>
        </div>
    </section>

  </div>
  <!-- /.content-wrapper -->
  <?php require_once "footer.php"; ?>

</div>
<!-- ./wrapper -->

 <?php require_once "footer-script.php"; ?>
</body>
</html>
