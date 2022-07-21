<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		=	new general();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard | <?php echo TITLE; ?></title>
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
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=URLAD?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
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
        <div class="row">
		
		 <?php

            $menu_cnt = $objgen->get_AllRowscnt("left_menu"," AND show_home='yes' AND status='active'");
            if($menu_cnt>0)
            {
			
              $menu_arr = $objgen->get_AllRows("left_menu",0,$menu_cnt,"id asc"," AND show_home='yes' AND status='active'");
              
              foreach($menu_arr as $key => $row)
              {
			  
			    	$flag = 1;
					
			   if($row['url'] == "admin-users" &&  $_SESSION['MYPR_adm_type']!='admin')
				{
				  $flag = 2;
				}
				
				
			  if($flag ==1)
			  {

              echo $objgen->dashboard_count($row['menu_table'],$row['name'],$row['color'],$row['icon'],$row['url']); 
              //   if($_SESSION['MYPR_adm_type']=='admin')
              //   {
                    
              // echo $objgen->dashboard_count("admin","Admin Users","success","fa fa-user","admin-users"," and username<>'admin'");
              //   }
			  
			  }
              }
            }
                     
                    
            ?>
			
         
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        
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
