<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objval		  = new validate();
$objgen		  =	new general();

$pagehead     = "Page";
$list_url     = URLAD."list-page";
$add_url      = URLAD."add-page";
$page	 	  = isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2       = "Pages Created Successfully.";

}
if($_GET['msg']==3)
{
  $msg2       = "Image Deleted Successfully.";

}
if(isset($_GET['delimg']))
{
	$id       = $_GET['delimg'];
	$edit     = $_GET['edit'];
	
	$result   = $objgen->get_Onerow("pages","AND id=".$id);
	$photo    = $objgen->check_tag($result['image']);
	
	if(file_exists("../photos/orginal/".stripslashes($photo)))
	unlink("../photos/orginal/".stripslashes($photo));
	
	if(file_exists("../photos/medium/".stripslashes($photo)))
	unlink("../photos/medium/".stripslashes($photo));
	
	if(file_exists("../photos/small/".stripslashes($photo)))
	unlink("../photos/small/".stripslashes($photo));
	
	if(file_exists("../photos/large/".stripslashes($photo)))
	unlink("../photos/large/".stripslashes($photo));
	
	$msg = $objgen->upd_Row('pages',"image=''","id=".$id);
	
	if($msg=="")
	{
		header("location:".$add_url."/?msg=3&edit=".$edit."&page=".$page);
	}
}

if(isset($_GET['delimg2']))
{
     $id      = $_GET['delimg2'];
	 $edit    = $_GET['edit'];
	 $result     		= $objgen->get_Onerow("page_img","AND id=".$id);
	 $photo     		= $objgen->check_tag($result['image']);
   
   	 if(file_exists("../photos/orginal/".stripslashes($photo)))
			unlink("../photos/orginal/".stripslashes($photo));

   	 if(file_exists("../photos/medium/".stripslashes($photo)))
			unlink("../photos/medium/".stripslashes($photo));
			
	 if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	
	 if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));

    $msg     = $objgen->del_Row("page_img","id=".$id);
   if($msg=="")
   {
	 header("location:".$add_url."/?msg=3&edit=".$edit."&page=".$page);
   }
}

if(isset($_POST['Create']))
{
   $title  		     = $objgen->check_input($_POST['title']);
   $description      = $_POST['description'];
   $pages            = $objgen->check_input($_POST['pages']); 
   $date			 = date('y-m-d');
 
   $rules		     = array();
   $rules[] 	     = "required,title,Enter the Title";
   $rules[]          = "required,description,Enter the Description";
   $rules[]          = "required,pages,Enter the Page";

   $errors  	     = $objval->validateFields($_POST, $rules);
  
    $brd_exit = $objgen->chk_Ext("pages","page='$pages'");
	if($brd_exit>0)
	{
		$errors[] = "This Page is already exists.";
	
	}
  
	if(empty($errors))
	{
	
		if($_FILES["main_img"]["name"]!="")
		{
			$upload = $objgen->upload_resize("main_img","page","image",array('l','m','s'),"null","",array(800,800,'auto',100),array(200,200,'auto',100),array(100,100,'auto',100));
			
			if($upload[1]!="")
				$errors[] = $upload[1];
			else
				$main_img = $upload[0];
		}

		

		$msg = $objgen->ins_Row('pages','title,description,image,page,created_date',"'".$title."','".$objgen->baseencode($description)."','".$main_img."','".$pages."','". $date."'");
		
		$insrt = $objgen->get_insetId();
		
		if(count($_FILES['subfile']['tmp_name'])>0)
		{
			for($i=0; $i < count($_FILES['subfile']['tmp_name']); $i++)
			{
			
				if($_FILES['subfile']['name'][$i]!="")
				{
					$sub_img = date("YmdHis").$_FILES['subfile']['name'][$i];
					
					if(copy($_FILES['subfile']['tmp_name'][$i],'../photos/orginal/'.$sub_img))
					{
						$image    = new resize("../photos/orginal/".$sub_img);
						$image->resizeImage(800,800,'auto');
						$image->saveImage("../photos/large/".$sub_img);
						
						$image    = new resize("../photos/orginal/".$sub_img);
						$image->resizeImage(200,200,'crop');
						$image->saveImage("../photos/medium/".$sub_img);
						
						$image    = new resize("../photos/orginal/".$sub_img);
						$image->resizeImage(100,100,'crop');
						$image->saveImage("../photos/small/".$sub_img);
					
						$msg = $objgen->ins_Row('page_img','page_id,image',"'".$insrt."','".$sub_img."'");
					}             
				}           
			}
	
		}
	
	if($msg=="")
	{
		header("location:".$add_url."/?msg=1");
	}
	}
}
		 
if(isset($_GET['edit']))
{
	$id 				= $_GET['edit'];
	$result     		= $objgen->get_Onerow("pages","AND id=".$id);
	$title      		= $objgen->check_tag($result['title']);
	$description       	= $objgen->basedecode($result['description']);
	$pages         		= $objgen->check_tag($result['page']);
	$main_img		    = $objgen->check_tag($result['image']);

	
	$where 		= " and page_id=".$id;
	$img_count 	= $objgen->get_AllRowscnt("page_img",$where);
	if($img_count>0)
	{
		$img_arr = $objgen->get_AllRows("page_img",0,$img_count,"id asc",$where);
	}

}
if(isset($_POST['Update']))
{    
	$title	        = $objgen->check_input($_POST['title']);
	$description   	= $_POST['description'];
	$pages         	= $objgen->check_input($_POST['pages']);  
	
	$errors        	= array();
	$rules		    = array();
	$rules[] 	    = "required,title,Enter the Title";
	$rules[]       	= "required,description,Enter the Description";
	$rules[]       	= "required,pages,Enter the Page";
	
	$errors  	    = $objval->validateFields($_POST, $rules);
	
	$brd_exit 		= $objgen->chk_Ext("pages","page='$pages' and id <>".$id);
	if($brd_exit>0)
	{
		$errors[] 	= "This Page is already exists.";

	}
	
	if(empty($errors))
	{
	   if($_FILES["main_img"]["name"]!="")
			{
				$upload = $objgen->upload_resize("main_img","page","image",array('l','m','s'),$main_img,"",array(308,441,'auto',100),array(150,150,'auto',100),array(100,100,'auto',100));
				
				if($upload[1]!="")
				$errors[] = $upload[1];
				else
				$main_img = $upload[0];

			}
	
		$msg = $objgen->upd_Row('pages',"title='".$title."',description='".$objgen->baseencode($description)."',image='".$main_img."',page='".$pages."'","id=".$id);
		
		if($msg=="")
		{ 
			
			if(count($_FILES['subfile']['tmp_name'])>0)
			{
				for($i=0; $i < count($_FILES['subfile']['tmp_name']); $i++)
				{
					if($_FILES['subfile']['name'][$i]!="")
					{
						$sub_img = date("YmdHis").$_FILES['subfile']['name'][$i];
	
						if(copy($_FILES['subfile']['tmp_name'][$i],'../photos/orginal/'.$sub_img))
						{
							$image = new resize("../photos/orginal/".$sub_img);
							$image->resizeImage(800,800,'auto');
							$image->saveImage("../photos/large/".$sub_img);
							
							$image = new resize("../photos/orginal/".$sub_img);
							$image->resizeImage(200,200,'crop');
							$image->saveImage("../photos/medium/".$sub_img);
							
							$image = new resize("../photos/orginal/".$sub_img);
							$image->resizeImage(100,100,'crop');
							$image->saveImage("../photos/small/".$sub_img);
							
							$msg	= $objgen->ins_Row('page_img','image,page_id',"'".$sub_img."','".$id."'");
						}
					}             
				}           
			}
		}
		header("location:".$list_url."/?msg=2&page=".$page);
	}
	
}

if(isset($_POST['Cancel']))
{
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
    <link rel="stylesheet" href="<?=URLAD?>plugins/summernote/summernote-bs4.css">
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
		
		
	<div class="row hide_div" >
		<div class="col-md-12">
		<div class="card <?=TH_COLOR?>">
			<div class="card-header">
			<h3 class="card-title">Enter <?=$pagehead?> Informations</h3>           
			</div>
		<form role="form" method="post" enctype="multipart/form-data" >
			<div class="card-body">
			<div class="row">
				<div class="col-md-12">
				<div class="form-group">
				<label for="title">Title</label>
				<span class="error" style="color:red;">*</span>
				<input type="text" class="form-control" name="title" id="title" value="<?=$title?>" placeholder="Title" required>
				</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">   
						<label for="description">Description <span class="error" style="color:red;">*</span></label>
						
						<textarea class="form-control editor1 " id="editor1" name="description" required   style="height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" ><?=$description?></textarea>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="pages">Page <span class="error" style="color:red;">*</span></label>
						<input type="text" class="form-control" name="pages" id="pages" value="<?=$pages?>" placeholder="Page url" required>
					</div>
				<div class="col-md-4">
					<div class="form-group">
					<label>Images (800 px * 800 px)</label>
					
					<input type="file"  name="main_img" id="main_img"  >
					<div id="imagePreview"></div>
					<?php
					if($main_img!="")
					{
					?>
					<p class="help-block"><img src="<?=URL?>photos/small/<?php echo $main_img; ?>"   />&nbsp;&nbsp;<a href="<?=$add_url?>/?delimg=<?=$id?>&edit=<?=$id?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Image?')"><i class="fa fa-trash" aria-hidden="true"></i></a></p>
					<?php
					}
					?>
					
					<br>
					<label>Sub Images (800 px * 800 px)</label><br>
					<?php
					if($img_count>0)
					{
						foreach($img_arr as $val)
						{
					?>
					
					<div style="border:1px solid #009900; padding:10px;margin-bottom:5px;">
					<div class="form-group">
						<p class="help-block"><img src="<?=URL?>photos/small/<?php echo $objgen->check_tag($val['image']); ?>" />&nbsp;&nbsp;<a href="<?=$add_url?>/?delimg2=<?=$val['id']?>&edit=<?=$id?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Image?')"><i class="fa fa-trash" aria-hidden="true"></i></a></p>
					</div>
					</div>
					<?php
						} 
					 } 
					 ?>
					<div id="imageadd">
						<div class="form-group">
							<div style=" padding:10px;margin-bottom:5px;" class="alert-primary">
							
								<input type="file"  name="subfile[]" id="main_imgs"   />
								<div id="imagePreviews"></div>
							</div>
						</div>
					</div>
					<div class="form-group" >
					<button class="btn btn-primary" type="button" name="add" onClick="addmore()"><span class="fa fa-plus"></span>&nbsp;Add More</button>
					</div>
					
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
			<a class="btn btn-warning" type="reset"  href="<?=$list_url?>"><i class="ace-icon fa fa-undo"></i>&nbsp;Cancel </a>
			
			</div>
		</form>
        </div>
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

	<script src="<?=URLAD?>plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.editor1').summernote()
  })
</script>
	<script>
		$(function() {
		  $("#main_img").on("change", function()
		  {
			var files = !!this.files ? this.files : [];
			if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		
			if (/^image/.test( files[0].type)){ // only image file
			  var reader = new FileReader(); // instance of the FileReader
			  reader.readAsDataURL(files[0]); // read the local file
		
			  reader.onloadend = function(){ // set image data as background of div
				$("#imagePreview").css("width", "120px");
				$("#imagePreview").css("height", "100px");
				$("#imagePreview").css(" background-position", "center center");
				$("#imagePreview").css("background-size",  "cover");
				$("#imagePreview").css("display",  "inline-block");
				$("#imagePreview").css("background-image", "url("+this.result+")");
			  }
			}
		  });
		});
	</script>
	<script>
		function addmore()
		{
		$('#imageadd').append(' <div style=" padding:10px;margin-bottom:5px;" class="alert-primary"><div class="form-group"><input type="file" name="subfile[]" id="main_imgs" /><br><div id="imagePreviews"></div><br><a href="javascript:void(0)" class="btn btn-danger remove_field "><span class="fa fa-minus"></span>&nbsp;Remove </a></div></div>');
		}
	
		$('#imageadd').on("click",".remove_field", function(e){ //user click on remove text
	
		e.preventDefault(); $(this).parent('div').parent('div').remove(); 
		});
	</script>

</body>
</html>
