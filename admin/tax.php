<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		= new general();
$objval		= new validate();
$pagehead	= "Tax";
$list_url 	= URLAD."tax";
$srdiv    	= "none";
$adddiv   	= "none";
$objPN		= new page(1);
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";
if(isset($_GET['del']))
{
	$id		= $_GET['del'];
	$msg	= $objgen->del_Row("tax","id=".$id);
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
   $india  			= $objgen->check_input($_POST['india']);
   $international   = $objgen->check_input($_POST['international']);
   $kerala   		= $objgen->check_input($_POST['kerala']);
   $indiantax   	= $objgen->check_input($_POST['indian_name']);
   $internationaltax= $objgen->check_input($_POST['international_name']);
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
  $rules	=	array();
  $rules[] 	=	"required,name,Enter the Tax";
  $errors  	=	$objval->validateFields($_POST, $rules);
  $brd_exit = $objgen->chk_Ext("tax","name='$name'");
	if($brd_exit>0)
	{
		$errors[] 	= "This tax is already exists.";
		$adddiv  	= "show";
		$srdiv   	= "none";
	}
   if(empty($errors))
	{
		$msg = $objgen->ins_Row('tax','name,india,international,kerala,indian_name,international_name',"'".$name."','".$india."','".$international."','".$kerala."','".$indiantax."','".$internationaltax."'");
		if($msg=="")
		{
		   header("location:".$list_url."/?msg=1");
		}
	}
}

if(isset($_GET['edit']))
{
  	$id 					= $_GET['edit'];
	$result				    = $objgen->get_Onerow("tax","and id=".$id);
	$name   				= $objgen->check_tag($result['name']);
	$india   		      	= $objgen->check_tag($result['india']);
	$international    		= $objgen->check_tag($result['international']);
	$kerala   			  	= $objgen->check_tag($result['kerala']);
	$indiantax   	 	  	= $objgen->check_tag($result['indian_name']);
  	$internationaltax 		= $objgen->check_tag($result['international_name']);
	$adddiv           		= "show";
}

if(isset($_POST['Update']))
{    
	$name  			    = $objgen->check_input($_POST['name']);
  	$india  		    = $objgen->check_input($_POST['india']);
  	$international    	= $objgen->check_input($_POST['international']);
  	$kerala   		    = $objgen->check_input($_POST['kerala']);
  	$indiantax   	    = $objgen->check_input($_POST['indian_name']);
  	$internationaltax	= $objgen->check_input($_POST['international_name']);
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
	$errors   	= array();
	$rules		=	array();
	$rules[] 	= 	"required,name,Enter the Tax";
	$errors  	= 	$objval->validateFields($_POST, $rules);
	$brd_exit 	= $objgen->chk_Ext("tax","name= '$name' and id<>".$id);
	if($brd_exit>0)
	{
		$errors[]	= "This $pagehead is already exists.";
		$adddiv   	= "show";
		$srdiv    	= "none";
	}
	if(empty($errors))
	{	 
		$msg = $objgen->upd_Row('tax',"name='".$name."',india='".$india."',international='".$international."',kerala='".$kerala."',indian_name='".$indiantax."',international_name='".$internationaltax."'","id=".$id);
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
	$un     = trim($_REQUEST['un']);
	$where .= " and name like '%".$un."%'";
	$srdiv  = "block";
}
$row_count = $objgen->get_AllRowscnt("tax",$where);
if($row_count>0)
{
	  $objPN->setCount($row_count);
	  $objPN->pageSize($pagesize);
	  $objPN->setCurrPage($page);
	  $objPN->setDispType('PG_BOOSTRAP_AD');
	  $pages 	= $objPN->get(array("un" => $un), 1, WEBLINKAD."/".$params[0]."/", "", "active");
	  $res_arr 	= $objgen->get_AllRows("tax",$pagesize*($page-1),$pagesize,"id desc",$where);
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
              <?=$pagehead?></h1>
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
          <div class="col-md-12" align="right" style="clear:both">
            <button type="button"  class="btn btn-inline btn-danger" onClick="click_button(1)"><i class="fa fa-edit"></i> New</button>
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
        <div class="row hide_div" style="padding-top:10px;display:<?=$adddiv?>" id="adddiv">
          <div class="col-md-12">
            <div class="card card-<?=TH_COLOR?>">
              <div class="card-header">
                <h3 class="card-title">Enter
                  <?=$pagehead?>
                  Informations</h3>
              </div>
              <form role="form" method="post" enctype="multipart/form-data" >
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Name <span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$name?>" name="name" id="name" placeholder = "Name" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="state">Kerala (Percentage)</label>
                        <input type="text" class="form-control" value="<?=$kerala?>" name="kerala" id="kerala" placeholder ="Kerala (Percentage)"/>
                      </div>
                    </div>
                    <div  class="col-md-6">
                      <div class="form-group">
                        <label for="india">Indian Tax Name</label>
                        <input type="text" class="form-control" value="<?=$indiantax?>" name="indian_name" id="indian_name" placeholder ="Indian Tax Name"/>
                      </div>
                    </div>
                    <div  class="col-md-6">
                      <div class="form-group">
                        <label for="">India (Percentage)</label>
                        <input type="text" class="form-control" value="<?=$india?>" name="india" id="india" placeholder ="India (Percentage)" />
                      </div>
                    </div>
                    <div  class="col-md-6">
                      <div class="form-group">
                        <label for="">International Tax Name</label>
                        <input type="text" class="form-control" value="<?=$internationaltax?>" name="international_name" id="international_name" placeholder ="International Tax Name"/>
                      </div>
                    </div>
                    <div  class="col-md-6">
                      <div class="form-group">
                        <label for="">International (Percentage)</label>
                        <input type="text" class="form-control" value="<?=$international?>" name="international" id="international" placeholder = "International (Percentage)"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer center">
                  <?php
						if(isset($_GET['edit']))
						{
						?>
                  <button class="btn btn-primary" type="submit" name="Update"><i class="ace-icon fa fa-check bigger-110"></i>&nbsp;Update </button>
                  <?php
						}
						else
						{
						?>
                  <button type="submit" class="btn btn-primary" name="Create" ><span class="fa fa-save  ace-icon"></span>&nbsp;Save</button>
                  <?php
						}
						?>
                  <a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="fa fa-undo"></i>&nbsp;Cancel </a> </div>
              </form>
            </div>
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
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="Username">Name</label>
                        <input type="text" class="form-control" value="<?=$un?>" name="un" id="un" placeholder ="Name">
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
                  <?=$pagehead?></h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover table-sm">
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Kerala (Percentage)</th>
                    <th>Indian Name</th>
                    <th>Indian (Percentage)</th>
                    <th>International Name</th>
                    <th>International(Percentage)</th>
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
                    <td><?php echo $objgen->check_tag($val['kerala']); ?></td>
                    <td><?php echo $objgen->check_tag($val['indian_name']); ?></td>
                    <td><?php echo $objgen->check_tag($val['india']); ?></td>
                    <td><?php echo $objgen->check_tag($val['international_name']); ?></td>
                    <td><?php echo $objgen->check_tag($val['international']); ?></td>
                    <td><a href="<?=$list_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a> <a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Tax?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a> </td>
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
</body>
</html>
