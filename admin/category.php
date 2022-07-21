<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objval		  	= new validate();
$objgen		  	=	new general();
$pagehead 		= "Category";
$list_url 		= URLAD."category";
$srdiv    	 	= "none";
$adddiv   	 	= "none";
$objPN		    = new page(1);
$pagesize	    =	20;
$page	 	      = isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";
$order 		    =	$order_arr['order_num'] + 1;
if(isset($_GET['del']))
{
   $id		= $_GET['del'];
   $msg     = $objgen->del_Row("category","id=".$id);
    if($msg=="")
  {
	  header("location:".$list_url."/?msg=3&page=".$page);
  }
}
if($_GET['msg']==1)
{
	$msg2 	  	= "$pagehead Created Successfully.";
	$adddiv   	= "show";
	$srdiv    	= "none";
}
if($_GET['msg']==2)
{
	$msg2 = "$pagehead Updated Successfully.";
}
if($_GET['msg']==3)
{
	$msg2 		= "$pagehead Deleted Successfully.";
}
if($_GET['msg']==4)
{
	$msg2 		= "$pagehead Status Changed Successfully.";
}
if(isset($_GET['st']))
{
  $id 		= $_GET['id'];
  $st 		= $_GET['st'];
  if($st=='active')
  $status 	= "inactive";
  if($st=='inactive')
  $status 	= "active";
     $msg   =   $objgen->upd_Row("category","status='$status'","id=".$id);
     header('location:'.$list_url.'/?msg=4&page='.$page);
}
if(isset($_POST['Create']))
{
	$category   		= $objgen->check_input($_POST['cat_name']);
	$top_menu_order  	= $objgen->check_input($_POST['top_menu_order']);
	$left_menu_order  	= $objgen->check_input($_POST['left_menu_order']);
	$fa_icon 			= $objgen->check_input($_POST['fa_icon']);
	$status 			= $objgen->check_input($_POST['status']);
	$rules				=	array();
	$rules[] 			= "required,cat_name,Enter the Category";
	$errors  			= $objval->validateFields($_POST, $rules);
	$brd_exit 			= $objgen->chk_Ext("category","cat_name='$category'");
	if($brd_exit>0)
	{
		$errors[] 	= "This $pagehead is already exists.";
		$adddiv     = "show";
		$srdiv      = "none";
	}
	
	if(empty($errors))
	{
		$msg 	= $objgen->ins_Row('category','cat_name,top_menu_order,left_menu_order,status,fa_icon',"'".$category."','".$top_menu_order."','".$left_menu_order."','".$status."','".$fa_icon."'");
		if($msg=="")
		{
			header("location:".$list_url."/?msg=1");
		}
	}
}
if(isset($_GET['edit']))
{
	$id 				= $_GET['edit'];
	$result     		= $objgen->get_Onerow("category","and id=".$id);
	$category   		= $objgen->check_tag($result['cat_name']);
	$top_menu_order   	= $objgen->check_tag($result['top_menu_order']);
	$left_menu_order  	= $objgen->check_tag($result['left_menu_order']);
	$fa_icon  			= $objgen->check_tag($result['fa_icon']);
	$status 			= $objgen->check_tag($result['status']);
	$adddiv     		= "show";
	$srdiv      		= "none";
}

if(isset($_POST['Update']))
{    
	$category   		= $objgen->check_input($_POST['cat_name']);
	$top_menu_order  	= $objgen->check_input($_POST['top_menu_order']);
  	$left_menu_order  	= $objgen->check_input($_POST['left_menu_order']);
	$status  			= $objgen->check_input($_POST['status']);	
	$fa_icon  			= $objgen->check_input($_POST['fa_icon']);	
	$errors 			= array();
	$rules				= array();
	$rules[] 			= "required,cat_name,Enter the category";
	$errors  			= $objval->validateFields($_POST, $rules);
	$brd_exit	= $objgen->chk_Ext("category","cat_name='$category' and id<>".$id);
	if($brd_exit>0)
	{
		$errors[]	= "This $pagehead is already exists.";
		$adddiv     = "show";
		$srdiv      = "none";
	}
	
	if(empty($errors))
	{
		$msg	= $objgen->upd_Row('category',"cat_name='".$category."'top_menu_order='".$top_menu_order."',left_menu_order='".$left_menu_order."',fa_icon='".$fa_icon."',status='".$status."'","id=".$id);		
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
	$un 		= trim($_REQUEST['un']);
	$where 	   .= " and cat_name like '%".$un."%'";
	$adddiv   	= "none";
	$srdiv    	= "show";
}
$row_count = $objgen->get_AllRowscnt("category",$where);
if($row_count>0)
{
	$objPN->setCount($row_count);
	$objPN->pageSize($pagesize);
	$objPN->setCurrPage($page);
	$objPN->setDispType('PG_BOOSTRAP_AD');
	$pages 		= $objPN->get(array("un" => $un), 1, WEBLINKAD."/".$params[0]."/", "", "active");
	$res_arr 	= $objgen->get_AllRows("category",$pagesize*($page-1),$pagesize,"id desc",$where);
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
              <li class="breadcrumb-item"><a href="<?=URLAD?>home">Home</a></li>
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
                        <label for="cat_name">Category <span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$category?>" name="cat_name" id="cat_name" placeholder = "Category" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="top_menu_order">Top Menu Order <span class="error" style="color:red;">*</span></label>
                        <input type="num" class="form-control" value="<?=$top_menu_order?>" name="top_menu_order" id="top_menu_order" placeholder = "Top menu order" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="category_name">Left Menu Order <span class="error" style="color:red;">*</span></label>
                        <input type="num" class="form-control" value="<?=$left_menu_order?>" name="left_menu_order" id="left_menu_order" placeholder = "Left menu order" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="fa_icon">Fa Icon Class<span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$fa_icon?>" name="fa_icon" id="fa_icon" placeholder = "Fa Icon" required />
                      </div>
                    </div>
                    <div  class="col-md-6">
                        <div class="form-group">
                          <label for="mainimage">Status</label>
                          <br />
                          <div class="icheck-primary d-inline">
                            <input  type="radio" value="active" <?php if($status=='active') { ?> checked="checked"  <?php } ?>  checked="checked" name="status" id="radioPrimary1" >
                            <label for="radioPrimary1">Active</label>
                          </div>
                          &nbsp&nbsp
                          <div class="icheck-primary d-inline">
                            <input   type="radio" value="inactive" <?php if($status=='inactive') { ?> checked="checked"  <?php } ?> name="status"  id="radioPrimary2" >
                            <label for="radioPrimary2">Inactive </label>
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
                        <label for="Username">Category</label>
                        <input type="text" class="form-control" value="<?=$un?>" name="un" id="un"  placeholder = "Category"required/>
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
                <h3 class="card-title">List <?=$pagehead?></h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover table-sm">
                  <tr>
                    <th>Id</th>
                    <th>Category Name</th>                    
                    <th>Top Menu Order</th>
					          <th>Left Menu Order</th>
					          <th>Fa Icon Class</th>
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
                    <td><?php echo $objgen->check_tag($val['id']); ?></td>
                    <td><?php echo $objgen->check_tag($val['cat_name']); ?></td>
                    <td><?php echo $objgen->check_tag($val['top_menu_order']); ?></td>
					<td><?php echo $objgen->check_tag($val['left_menu_order']); ?></td>
					<td><?php echo $objgen->check_tag($val['fa_icon']); ?></td>
					<td>
             			<?php
             				if($val['status']=='active')
             				{
             					?>
             					<a href="<?=$list_url?>/?id=<?=$val['id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" >
             					<span class="badge bg-success">Active</span>
             					</a>
             					<?php
             				}
             				else
             				{
             				?>
             					<a href="<?=$list_url?>/?id=<?=$val['id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" >
             					<span class="badge bg-warning">Inactive</span>
             					</a>
             				<?php
             				}
             			?>
            		</td>
                    <td><a href="<?=$list_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a> <a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Category?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a> </td>
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
