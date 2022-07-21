<?php
require_once "includes/includepath.php";
$objgen		=	new general();

//echo $objgen->encrypt_pass('jkshop@321');

if($_COOKIE["swebin_user_ad"]!="")
 $username = $_COOKIE["swebin_user_ad"];

if($_COOKIE["swebin_sec_ad"]!="")
 $password = $objgen->decrypt_pass($_COOKIE["swebin_sec_ad"]);

if(isset($_POST['Login']))
{
  
  $username     = trim($_POST['username']);
  $password     = trim($_POST['password']);
  $remember_me    = $_POST['remember_me'];
  
  if($username!="" && $password!="")
  {
    $msg = $objgen->chk_Login('admin',$username,$password,'','admin_id','username','password','active',1,'*',$remember_me);
    if($msg=="")
    {
    header("location:".URLAD."home");
    }
  }
  else
  {
     $msg = "Enter Username and Password.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | <?php echo TITLE; ?></title>
  <?php require_once "header-script.php"; ?>
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=URLAD?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <b>Admin</b><?=SITE_NAME?>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
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
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username"  name="username" required maxlength="20" value="<?=$username?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password"name="password"  required maxlength="20" value="<?=$password?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" name="remember_me" id="remember" value="yes" <?php if($_COOKIE["swebin_user_ad"]!="") { ?> checked="checked" <?php } ?> />
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
		     <button type="submit" class="btn btn-primary btn-block" name="Login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php require_once "footer-script.php"; ?>


</body>
</html>
