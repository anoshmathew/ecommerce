<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen		= new general();
$objval		= new validate();

$srdiv      = "none";
$adddiv     = "none";
$pagehead	= "Home Slider";
$list_url 	= URLAD."sliders";
$show_home	= "no";

$objPN		= new page(1);
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if(isset($_GET['del']))
{
	$id		= $_GET['del'];
	$msg	= $objgen->del_Row("slider","id=".$id);
	
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
  	$msg2 		= "$pagehead Updated Successfully.";
}

if($_GET['msg']==3)
{

  	$msg2 		= "$pagehead Deleted Successfully.";
}

if(isset($_GET['delimg']))
{
    $id      		= $_GET['delimg'];
	$edit    		= $_GET['edit'];
	$result       	= $objgen->get_Onerow("slider","AND id=".$id);
	$photo     		= $objgen->check_tag($result['image']);
   
   	if(file_exists("../photos/orginal/".stripslashes($photo)))
			unlink("../photos/orginal/".stripslashes($photo));

   	if(file_exists("../photos/medium/".stripslashes($photo)))
			unlink("../photos/medium/".stripslashes($photo));
			
	if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	
	if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));

    $msg     = $objgen->upd_Row("slider","image=''","id=".$id);
	
    if($msg=="")
   	{
		header("location:".$list_url."/?msg=3&edit=".$edit."&page=".$page);
   	}
}

if(isset($_POST['Create']))
{ 
   	$title1  = $objgen->check_input($_POST['title1']);
   	$title2  = $objgen->check_input($_POST['title2']);
   	$title3  = $objgen->check_input($_POST['title3']);
   	$link    = $objgen->check_input($_POST['link']);

	$adddiv  = "show";
	$srdiv   = "none";
	
   	$rules	  =	array();
   	$rules[] = "required,title1,Enter the Title 1";
   	$rules[] = "required,title2,Enter the Title 2";
   	$rules[] = "required,title3,Enter the Title 3";
   	$rules[] = "required,link,Enter the Link";
   	
   $errors		  =	$objval->validateFields($_POST, $rules);

   if(empty($errors))
	{
	  if($_FILES["image"]["name"]!="")
	  {						
	  	$upload = $objgen->upload_resize("image","slider","image",array('l','m','s'),"null","",array(1339,280,'crop',100),array(323,326,'crop',100),array(100,85,'crop',100));
	  	
		if($upload[1]!="")
	  	   $errors[] = $upload[1];
	  	else
	  	  $image = $upload[0];
	  	
           
	  }   
	  $msg = $objgen->ins_Row('slider','title1,title2,title3,image,link',"'".$title1."','".$title2."','".$title3."','".$image."','".$link."'");
	  if($msg=="")
	  {
	  		header("location:".$list_url."/?msg=1");
	  }
	}

}

if(isset($_GET['edit']))
{
	$id 		= $_GET['edit'];
	$result 	= $objgen->get_Onerow("slider","and id=".$id);
	$title1     = $objgen->check_tag($result['title1']);
	$title2	    = $objgen->check_tag($result['title2']);
	$title3     = $objgen->check_tag($result['title3']);
	$link 	    = $objgen->check_tag($result['link']);
  	$image 	    = $objgen->check_tag($result['image']);

	$adddiv     = "show";
  	$srdiv      = "none";
}

if(isset($_POST['Update']))
{    
   $title1  = $objgen->check_input($_POST['title1']);
   $title2  = $objgen->check_input($_POST['title2']);
   $title3  = $objgen->check_input($_POST['title3']);
   $link    = $objgen->check_input($_POST['link']);

	if($_FILES["image"]["name"]!="")
	{
		$upload = $objgen->upload_resize("image","slider","image",array('l','m','s'),$image,"",array(1339,280,'crop',100),array(495,303,'crop',100),array(100,85,'crop',100));
			
			if($upload[1]!="")
			  $errors[] = $upload[1];
			else
			 $image = $upload[0];		
	}
		$msg =     $objgen->upd_Row('slider',"image='".$image."',title1='".$title1."',title2='".$title2."',title3='".$title3."',link='".$link."'","id=".$id);

	if($msg=="")
	{
		header("location:".$list_url."/?msg=2&page=".$page);
	}
}

if(isset($_POST['Search']))
{
	$page=1;
}

$where 		= "";
$row_count 	= $objgen->get_AllRowscnt("slider",$where);

if($row_count>0)
{
	$objPN->setCount($row_count);
	$objPN->pageSize($pagesize);
	$objPN->setCurrPage($page);
	$objPN->setDispType('PG_BOOSTRAP_AD');
	$pages 		= $objPN->get(array("un" => $un), 1, WEBLINKAD."/".$params[0]."/", "", "active");
	$res_arr 	= $objgen->get_AllRows("slider",$pagesize*($page-1),$pagesize,"id desc",$where);
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
            <h1 class="m-0 text-dark"><?=$pagehead?>s</h1>
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
            <!--			<button type="button"  class="btn btn-inline btn-primary" onClick="click_button(2)" ><i class="fa fa-search"></i> Search</button>-->
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
              <strong> <i class="ace-icon fa fa-check"></i> Success! </strong> <?php echo $msg2; ?> <br>
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
                        <label for="image">Slider Image (992 px x 439 px)
                          <?php
                          if(!isset($_GET['edit']))
										      {
										      ?>
                            <span class="error" style="color:red;">*</span>
                              </label>
                            <?php
										      }
										      ?>    
                        <br>
                        <input type="file"  name="image" id="image"/>
                        <br>
                        <div id="imagePreview1"></div>
                        <?php
										    if($image!="")
										    {
										    ?>
                            <p class="help-block"><img src="<?=URL?>photos/small/<?php echo $image; ?>" width="93" height="93"  />&nbsp;&nbsp;<a href="<?=$list_url?>/?delimg=<?=$id?>&edit=<?=$id?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Image?')"><i class="fas fa-trash-alt"></i></a></p>
                            <?php
										    }
										    ?>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title1">Title 1<span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$title1?>" name="title1" id="title1" placeholder = "Title 1" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title2">Title 2<span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$title2?>" name="title2" id="title2" placeholder = "Title 2" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title3">Title 3<span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$title3?>" name="title3" id="title3" placeholder = "Title 3" required />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="link">Link<span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="<?=$link?>" name="link" id="link" placeholder = "Link" required />
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
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h3 class="card-title">List <?=$pagehead?>s</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover table-sm">
                  <tr>
                    <th>Title 1</th>
                    <th>Title 2</th>
                    <th>Title 3</th>
                    <th>Slider</th>
                    <th>Action</th>
                  </tr>
                  <?php
							if($row_count>0)
							{
							foreach($res_arr as $key=>$val)
							{
							?>
                  <tr>
                    <td><?php echo $objgen->check_tag($val['title1']); ?></td>
                    <td><?php echo $objgen->check_tag($val['title2']); ?></td>
                    <td><?php echo $objgen->check_tag($val['title3']); ?></td>
                    <td><img src="<?=URL?>photos/small/<?=$objgen->check_tag($val['image']); ?>"></td>
                    <td>
                      <a href="<?=$list_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" class="btn btn-primary btn-sm" ><i class="fas fa-edit"></i></a> <a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Slider?')" class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i></a> </td>
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
<script>
		$(function() {
		  $("#image").on("change", function()
		  {
			var files = !!this.files ? this.files : [];
			if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		
			if (/^image/.test( files[0].type)){ // only image file
			  var reader = new FileReader(); // instance of the FileReader
			  reader.readAsDataURL(files[0]); // read the local file
		
			  reader.onloadend = function(){ // set image data as background of div
				$("#imagePreview1").css("width", "120px");
				$("#imagePreview1").css("height", "100px");
				$("#imagePreview1").css(" background-position", "center center");
				$("#imagePreview1").css("background-size",  "cover");
				$("#imagePreview1").css("display",  "inline-block");
				$("#imagePreview1").css("background-image", "url("+this.result+")");
			  }
			}
		  });
		});
	</script>
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
