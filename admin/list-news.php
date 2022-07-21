<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen	    = new general();

$pagehead 	= "New";
$list_url 	= URLAD."list-news";
$add_url  	= URLAD."add-news";

$srdiv    = "none";
$adddiv    = "none";

$objPN	    = 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";


if($_GET['msg']==2)
{
  $msg2 	= "News Updated Successfully.";
}

if($_GET['msg']==3)
{
  $msg2 	= "News  Deleted Successfully."; 
}

if(isset($_GET['del']))
{
   	$id		  = $_GET['del'];
	$result   = $objgen->get_Onerow("news","AND id=".$id);
   	
	
    $photo    = $objgen->check_tag($result['image']);
   
   	 if(file_exists("../photos/orginal/".stripslashes($photo)))
			unlink("../photos/orginal/".stripslashes($photo));

   	 if(file_exists("../photos/medium/".stripslashes($photo)))
			unlink("../photos/medium/".stripslashes($photo));
			
	 if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	
	 if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));
		
     $msg 	  = $objgen->del_Row("news_img","news_id=".$id);
		
	$msg 	  = $objgen->del_Row("news","id=".$id);
	
    if($msg=="")
  	 {
			header("location:".$list_url."/?msg=3&page=".$page);
   	}
}

if(isset($_POST['Search']))
{
	$page=1;
}

$where = "";
if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
   $un 	   = trim($_REQUEST['un']);
   $where .= " and title like '%".$un."%'";
   $srdiv    = "block";
   $adddiv    = "none";
}


$row_count = $objgen->get_AllRowscnt("news",$where);
if($row_count>0)
{
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP_AD');
  $pages   = $objPN->get(array("un" => $un), 1, WEBLINKAD."/".$params[0]."/", "", "page-item");
  $res_arr = $objgen->get_AllRows("news",$pagesize*($page-1),$pagesize,"id desc",$where);
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
			<a type="button"  class="btn btn-inline btn-danger" href="<?=$add_url?>" ><i class="fa fa-edit"></i> New</a>
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
		
		
	<div class="row hide_div" style="padding-top:10px;display:<?=$srdiv?>"  id="srdiv">
      <div class="col-md-12">
        <div class="card <?=TH_COLOR?>">
          <div class="card-header">
            <h3 class="card-title">Search <?=$pagehead?></h3>           
          </div>
          <form role="form" method="post" enctype="multipart/form-data" >
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="Title">Title</label>
                    <input type="text" class="form-control" value="<?=$un?>" name="un" id="un"  />
                  </div>
                </div>
              </div>
            </div>
            
            <div class="card-footer center"> 
              <button type="submit" class="btn btn-primary" name="Search"><span class="fa fa-search  ace-icon"></span>&nbsp;Search</button>
              <a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="ace-icon fa fa-refresh"></i>Reset </a>
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
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Created Date</th>
            <th style="width:20%">Action</th>
            </tr>
              <?php
              if($row_count>0)
              {
              foreach($res_arr as $key=>$val)
              {
              ?>
            <tr>
            <td><?php echo $objgen->check_tag($val['title']); ?></td>
            <td><?php echo substr(strip_tags($objgen->basedecode($val['description'])),0,100)."..."; ?></td>
            <td><?php if($val['image']!=""){?><img src="<?=URL?>photos/small/<?php echo $objgen->check_tag($val['image']);?>"><?php } ?></td>
            <td><?php echo $objgen->check_tag($val['created_date']); ?></td>
           
            <td> 
                        
              <a href="<?=$add_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a>
              <a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Page?')" class="btn btn-sm btn-danger" ><i class="fas fa-trash-alt"></i></a>
              
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
