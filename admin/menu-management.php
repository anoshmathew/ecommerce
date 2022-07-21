<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objval   =   new validate();
$objgen   = new general();

$pagehead = "Menu Management";
$list_url = URLAD."menu-management";

$srdiv    = "none";
$adddiv   = "none";

$objPN    =   new page(1);

$pagesize = 25;
$page     = isset($_REQUEST['page'])  ? $_REQUEST['page'] : "1";

$max_order_arr = $objgen->get_MAxVal("left_menu","menu_order","menu_order","menu_type='menu'");
$menu_order     = $max_order_arr['menu_order'] + 1;
$alt_order = $menu_order;


if(isset($_GET['del']))
{
   $id    = $_GET['del'];
   $msg   = $objgen->del_Row("left_menu","id=".$id);
   if($msg=="")
   {
     header("location:".$list_url."/?msg=3&page=".$page);
   }
}

if($_GET['msg']==1)
{
  $msg2     = "Menu Created Successfully.";
  $adddiv   = "show";
  $srdiv    = "none";
}

if($_GET['msg']==2)
{
  $msg2 = "Menu Updated Successfully.";
}

if($_GET['msg']==3)
{
  $msg2 = "Menu Deleted Successfully.";
}

if($_GET['msg']==4)
{
  $msg2 = "Status Changed Successfully.";
}

if(isset($_GET['st']))
{
  $id = $_GET['id'];
  $st = $_GET['st'];
  if($st=='active')
  $status = "inactive";
  if($st=='inactive')
  $status = "active";
     $msg   =   $objgen->upd_Row("left_menu","status='$status'","id=".$id);
     header('location:'.$list_url.'/?msg=4&page='.$page);
}

if(isset($_POST['Create']))
{
  $menu_id       = 0;
  $menu_order    = 0;
  $show_home     = 'No';
  $name          = $objgen->check_input($_POST['name']);
  $menu_id       = $objgen->check_input($_POST['menu_id']);
  if($menu_id=='')
  {
    $menu_id   = 0;
    $menu_type = "menu";
  }
  else
  {
    $menu_type = "sub-menu";
  }

  $menu_order    = $objgen->check_input($_POST['menu_order']);
  $url           = $objgen->check_input($_POST['url']);
  $icon          = $objgen->check_input($_POST['icon']);
  $menu_table    = $objgen->check_input($_POST['menu_table']);
  $active_file   = $objgen->check_input($_POST['active_file']);
  $color         = $objgen->check_input($_POST['color']);
  $show_home     = $objgen->check_input($_POST['show_home']);  

  $rules     = array();
  $rules[]   = "required,name,Enter the Menu Name";
  $rules[]   = "required,icon,Enter the Menu Icon";
  $errors    = $objval->validateFields($_POST, $rules);
  
  $brd_exit = $objgen->chk_Ext("left_menu","name='$name'");
  if($brd_exit>0)
  {
    $errors[] = "This Menu Name is already exists.";
    $adddiv     = "show";
    $srdiv      = "none";
  } 
 

    if(empty($errors))
    {
      if($menu_id==0)
      {
      $brd_exit1 = $objgen->chk_Ext("left_menu","menu_order='".$menu_order."' and menu_type='menu'");
      if($brd_exit1>0)
      {
        if($menu_order=='')
        {
          $menu_order = $alt_order;
        }
        $msg     = $objgen->upd_Row("left_menu","menu_order=".$alt_order,"menu_order=".$menu_order." and menu_id=0 and menu_type='menu'");   
      }
      }

      if($menu_id!=0)
      {

        $sub_ord_arr   = $objgen->get_MAxVal("left_menu","menu_order","menu_order","menu_type='sub-menu' and menu_id=".$menu_id);
        $submenu_order = $sub_ord_arr['menu_order'] + 1;
        $sub_alt_order = $submenu_order;

      $brd_exit2 = $objgen->chk_Ext("left_menu","menu_order='".$menu_order."' and menu_type='sub-menu' and menu_id=".$menu_id);
      if($brd_exit2>0)
      {
        if($menu_order=='')
        {
          $menu_order = $sub_alt_order;
        }
        $msg = $objgen->upd_Row("left_menu","menu_order=".$submenu_order,"menu_order=".$menu_order." and menu_type='sub-menu' and menu_id=".$menu_id);
        
      }
      }

      $msg = $objgen->ins_Row('left_menu','name,url,icon,menu_order,menu_table,active_file,menu_type,menu_id,color,show_home',"'".$name."','".$url."','".$icon."','".$menu_order."','".$menu_table."','".$active_file."','".$menu_type."','".$menu_id."','".$color."','".$show_home."'");


      if($msg=="")
      {
          header("location:".$list_url."/?msg=1");
      }
    }
}

if(isset($_GET['edit']))
{
  $ed = 1;
  $id = $_GET['edit'];
  $result       = $objgen->get_Onerow("left_menu","AND id=".$id);
  $name         = $objgen->check_tag($result['name']);
  $url          = $objgen->check_tag($result['url']);
  $icon         = $objgen->check_tag($result['icon']);
  $menu_order   = $objgen->check_tag($result['menu_order']);
  $old_order    = $objgen->check_tag($result['menu_order']);
  $menu_table   = $objgen->check_tag($result['menu_table']);
  $active_file  = $objgen->check_tag($result['active_file']);
  $menu_type    = $objgen->check_tag($result['menu_type']);
  $menu_id      = $objgen->check_tag($result['menu_id']);
  $color        = $objgen->check_tag($result['color']);
  $show_home    = $objgen->check_tag($result['show_home']);
  
  $adddiv    = "show";
  $srdiv     = "none";
  
}

if(isset($_POST['Update']))
{    
  $name          = $objgen->check_input($_POST['name']);
  $menu_id       = $objgen->check_input($_POST['menu_id']);
  if($menu_id=='')
  {
    $menu_id = 0;
  }
  $url           = $objgen->check_input($_POST['url']);
  $icon          = $objgen->check_input($_POST['icon']);
  $menu_order    = $objgen->check_input($_POST['menu_order']);
  $menu_table    = $objgen->check_input($_POST['menu_table']);
  $active_file   = $objgen->check_input($_POST['active_file']);
  $color         = $objgen->check_input($_POST['color']);
  $show_home     = $objgen->check_input($_POST['show_home']);

  $rules     = array();
  $rules[]   = "required,name,Enter the Menu Name";
  $rules[]   = "required,icon,Enter the Menu Icon";
  $errors    = $objval->validateFields($_POST, $rules);

  $brd_exit = $objgen->chk_Ext("left_menu","name='$name' and id<>".$id);
  if($brd_exit>0)
  {
    $errors[] = "This Menu Name is already exists.";
    $adddiv     = "show";
    $srdiv      = "none";
  }
   
  if(empty($errors))
  {
    if($menu_id==0)
    {
      if($menu_type=="menu")
      {
        $alt_order = $old_order;
      }
		$menu_type = "menu";
		$brd_exit1 = $objgen->chk_Ext("left_menu","menu_order='".$menu_order."' and menu_type='menu' and menu_id=0");
		if($brd_exit1>0)
		{
		   $msg     = $objgen->upd_Row("left_menu","menu_order='".$alt_order."',menu_type='menu'","menu_order=".$menu_order." and menu_id=0 and menu_type='menu'");   
		}
     //$menu_order = $old_order;
    }

    if($menu_id!=0)
      {
        $menu_type = "sub-menu";
        $sub_ord_arr   = $objgen->get_MAxVal("left_menu","menu_order","menu_order","menu_type='sub-menu' and menu_id=".$menu_id);
        $submenu_order = $sub_ord_arr['menu_order'] + 1;
        $sub_alt_order = $submenu_order;

		  $brd_exit2 = $objgen->chk_Ext("left_menu","menu_order='".$menu_order."' and menu_type='sub-menu' and menu_id=".$menu_id);
		  if($brd_exit2>0)
		  {
			if($menu_order=='')
			{
			  $menu_order = $sub_alt_order;
			}
			$msg = $objgen->upd_Row("left_menu","menu_order=".$old_order,"menu_order=".$menu_order." and menu_type='sub-menu' and menu_id=".$menu_id);
			
		  }
      }

    $msg = $objgen->upd_Row('left_menu',"name='".$name."',menu_id='".$menu_id."',url='".$url."',icon='".$icon."',menu_order='".$menu_order."',menu_table='".$menu_table."',active_file='".$active_file."',menu_type='".$menu_type."',menu_id='".$menu_id."',color='".$color."',show_home='".$show_home."'","id=".$id);
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
 
$where = " and menu_type='menu'";
if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
  $un = trim($_REQUEST['un']);
  $where .= " and name like '%".$un."%'";
  $srdiv    = "block";
}
if(isset($_REQUEST['ut']) &&  trim($_REQUEST['ut'])!="")
{
  $ut = trim($_REQUEST['ut']);
  $where .= " and menu_table like '%".$ut."%'";
  $srdiv    = "block";
}

$row_count = $objgen->get_AllRowscnt("left_menu",$where);
if($row_count>0)
{
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP_AD');
  $pages = $objPN->get(array("un" => $un,"ut"=>$ut), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  $res_arr = $objgen->get_AllRows("left_menu",$pagesize*($page-1),$pagesize,"id desc",$where);
}

if(isset($_POST['Reset']))
{
  unset($_REQUEST);
  header("location:".$list_url);
}

if($row_count>0)
{
  $row_arr = $objgen->get_AllRows("left_menu",0,$row_count,"name asc",$where);
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
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="name">Menu Name <span class="error" style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="<?=$name?>" placeholder="" required>
                  </div>
                </div>
                <input type="hidden" name="" id="alt_order" value="<?=$alt_order?>">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="menu_id">Parent Menu</label>
                    <select class="form-control" name="menu_id" id="menu_id" onChange="chng_order(this.value)">
                    <option selected="selected" value="">Select</option>
						<?php
						if($row_count>0)
						{
						foreach($row_arr as $key=>$val)
						{
						?>
						<option value="<?=$val['id']?>" <?php if($val['id']==$menu_id) { ?> selected="selected" <?php } ?> >
						<?=$objgen->check_tag($val['name'])?>
						</option>
						<?php
						}
						}
						?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="url">Url</label>
                  <input type="text" class="form-control" name="url" id="url" value="<?=$url?>" placeholder="list-user" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="icon">Fa-Icon<span class="error" style="color:red;">*</span></label>
                  <input type="text" class="form-control" name="icon" id="icon" value="<?=$icon?>" placeholder="file-o" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="menu_order">Menu Order</label>
                  <input type="text" class="form-control" name="menu_order" id="menu_order" value="<?=$menu_order?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="menu_table">Table Name</label>
                  <input type="text" class="form-control" name="menu_table" id="menu_table" value="<?=$menu_table?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="active_file">Active files</label>
                  <input type="text" class="form-control" name="active_file" id="active_file" value="<?=$active_file?>" placeholder="file name1,file name2 etc..">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">   
                  <label for="color">Color</label>
                  <input type="text" class="form-control" id="color" name="color" value="<?=$color?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">   
                  <label for="status">Set Home</label><br />
                  <label class="radio-inline">
                  <input type="radio" value="yes" name="show_home" <?php if($show_home=='yes') {?> checked="checked" <?php } ?> >Yes</label>
                  <label class="radio-inline">
                  <input type="radio" value="no" name="show_home" <?php if($ed==1) { if($show_home=='no') { echo 'checked="checked"'; } } else {  echo 'checked="checked"';  } ?> > No</label>
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
            <a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="ace-icon fa fa-undo"></i>&nbsp;Cancel </a>
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
                    <label for="Username">Menu Name</label>
                    <input type="text" class="form-control" value="<?=$un?>" name="un" id="un"  />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="Username">Menu Table</label>
                    <input type="text" class="form-control" value="<?=$ut?>" name="ut" id="ut"  />
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
						<table class="table table-bordered table-hover table-striped">
            <tr>
            <th>Menu Name</th>
            <th>Fa-Icon</th>
            <th>Menu Table</th>
            <th>Menu Order</th>
            <th>Status</th>
            <th class="detail-col">More</th>
            <th>Action</th>
            
            </tr>
              <?php
              if($row_count>0)
              {
              foreach($res_arr as $key=>$val)
              {
              ?>
            <tr>
            <td><?php echo $objgen->check_tag($val['name']); ?></td>
            <td><?php echo $objgen->check_tag($val['icon']); ?></td>
            <td><?php echo $objgen->check_tag($val['menu_table']); ?></td>
            <td><?php echo $objgen->check_tag($val['menu_order']); ?></td>
            
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
            <td class="center">
              <div class="action-buttons">
                <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                <i class="ace-icon fa fa-angle-double-down"></i>
                <span class="sr-only">Details</span>
                </a>
              </div>
            </td>
            <td> 
                                    
              <a href="<?=$list_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="ace-icon fas fa-edit"></i></a>
              <a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this User?')" class="btn btn-sm btn-danger" ><i class="ace-icon fas fa-trash "></i></a>
              
            </td>
            </tr>
            <tr class="detail-row">
            <td colspan="7">
              <div class="row" >
                <div class="col-md-4">
                  Url : <span><?=$objgen->check_tag($val['url']); ?></span>
                </div>
                <div class="col-md-4">
                  Active Files : <span><?=$objgen->check_tag($val['active_file']); ?></span>
                </div>
              </div>
            </td>
            </tr>

            <?php
			
			$where = "AND menu_type='sub-menu' AND menu_id =".$val['id'];
            $cat_count= $objgen->get_AllRowscnt("left_menu",$where);
            
            if($cat_count>0)
            {
              
              $cat_arr = $objgen->get_AllRows("left_menu",0,$cat_count,"id asc",$where); 
            foreach($cat_arr as $sub_key=>$sub_val)
            {
            ?>

            <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;|-<?php echo $objgen->check_tag($sub_val['name']); ?></td>
            <td><?php echo $objgen->check_tag($sub_val['icon']); ?></td>
            <td><?php echo $objgen->check_tag($sub_val['menu_table']); ?></td>
            <td>=><?php echo $objgen->check_tag($sub_val['menu_order']); ?></td>
            
            <td>
              <?php
              if($sub_val['status']=='active')
              {
              ?>
              <a href="<?=$list_url?>/?id=<?=$sub_val['id']?>&page=<?=$page?>&st=<?php echo $sub_val['status']; ?>" role="button" >
              <span class="badge bg-success">Active</span>
              </a>
              <?php
              }
              else
              {
              ?>
              <a href="<?=$list_url?>/?id=<?=$sub_val['id']?>&page=<?=$page?>&st=<?php echo $sub_val['status']; ?>" role="button" >
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
                                    
              <a href="<?=$list_url?>/?edit=<?=$sub_val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="ace-icon fas fa-edit"></i></a>
              <a href="<?=$list_url?>/?del=<?=$sub_val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this User?')" class="btn btn-sm btn-danger" ><i class="ace-icon fa fa-trash"></i></a>
              
            </td>
            </tr>
            <tr class="detail-row">
            <td colspan="7">
              <div class="row" >
                <div class="col-md-4">
                  Url : <span><?=$objgen->check_tag($sub_val['url']); ?></span>
                </div>
                <div class="col-md-4">
                  Active Files : <span><?=$objgen->check_tag($sub_val['active_file']); ?></span>
                </div>
              </div>
            </td>
            </tr>
            <?php
            }
            }
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
