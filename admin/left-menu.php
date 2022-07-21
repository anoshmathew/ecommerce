<?php
$menu1 	 	=  "active";
$active 	=  "";
$head_url 	= $params[0];

if($head_url=='home' || $head_url=='')
{
  $menu1  	= "active";
}

if($head_url=='menu-management')
{
  $menu3 	= "active";
  $open3 	= " menu-open ";
}
if($head_url=='reset-password')
{
  $menu5 	= "active";
  $open3 	= " menu-open ";
}
?>
<aside class="main-sidebar sidebar-light-<?=TH_COLOR?> elevation-4 ">
    <!-- Brand Logo -->
  <a href="<?=URLAD?>home" class="brand-link navbar-<?=TH_COLOR?>">
	<img src="<?=URLAD?>dist/img/AdminLTELogo.png" alt="<?=SITE_NAME?>" class="brand-image img-circle elevation-3" style="opacity: .8">
	<span class="brand-text font-weight-light" style="color:#FFFFFF;font-weight:bold"><?=SITE_NAME?></span>
	</a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=URLAD?>dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info" >
          <a href="#" class="d-block"><?=ucfirst($_SESSION['MYPR_adm_username'])?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
       	<?php
	
	$where 		= " AND menu_type='menu' AND status='active'";
	$left_count 	= $objgen->get_AllRowscnt("left_menu",$where);
	
	if($left_count>0)
	{
		$menu_open = "";
		$left_arr 	= $objgen->get_AllRows("left_menu",0,$left_count,"menu_order asc",$where);
		foreach($left_arr as $key=>$val)
		{
			
			$flag = 1;
			$where 		= " AND menu_id=".$val['id']." AND status='active'";
			$sub_count 	= $objgen->get_AllRowscnt("left_menu",$where);
			if($objgen->check_tag($val['active_file'])!='')
			{
				$act_file = explode(",", $objgen->check_tag($val['active_file']));
				if(in_array($head_url, $act_file))
				{
					$act 		= "active";
					$menu_open 	= "menu-open";

				}
				else
				{
					$act 		= "";
					$menu_open 	= "";
				}
			}
			
				if($val['url'] == "admin-users" &&  $_SESSION['MYPR_adm_type']!='admin')
				{
				  $flag = 2;
				}
			  if($flag ==1)
			  {
			?>
			
			<li <?php if($sub_count>0) { ?> class="nav-item has-treeview <?=$menu_open?>" <?php } else { ?> class="nav-item has-treeview" <?php } ?> id="li_id">
			<a href="<?=URLAD?><?php echo $objgen->check_tag($val['url']); ?>" class="nav-link <?=$act?>">
			<i class="nav-icon fa fa-<?php echo $objgen->check_tag($val['icon']); ?>"></i>
			<p><?php echo $objgen->check_tag($val['name']); ?>
			<?php
			if($sub_count>0)
			{
			?>
			<i class="fa fa-angle-left right"></i>
			<?php
			}
			?>
			</p>
			
			</a>
			
			<?php
			if($sub_count>0)
			{
				$sub_arr 	= $objgen->get_AllRows("left_menu",0,$sub_count,"menu_order asc",$where);
				
				foreach($sub_arr as $sub_key=>$sub_val)
				{
					if($objgen->check_tag($sub_val['active_file'])!='')
					{
						$acti_file = explode(",", $objgen->check_tag($sub_val['active_file']));
						if(in_array($head_url, $acti_file))
						{
							$acti 		= "active";
							$me_open 	= "menu-open";
						}
						else
						{
							$acti 		= "";
							$me_open 	= "";
						}
					}
					
					
				
					
				?>
				
				<ul class="nav nav-treeview">
				<li class="nav-item">
				<a href="<?=URLAD?><?php echo $objgen->check_tag($sub_val['url']); ?>" class="nav-link <?=$acti?>">
				<i class="fa fa-angle-right nav-icon"></i>
			      <?php echo $objgen->check_tag($sub_val['name']); ?>
				</a>
				</li>
				</ul>
				<?php
				}
			}
			?>
			</li>
		<?php
		  }
		 }
	}
	?>
   <li class="nav-item has-treeview <?=$open3?>">
	<a href="#" class="nav-link <?=$menu3?> <?=$menu5?>">
	<i class="nav-icon fa fa-cog"></i>
	<p>
	Settings
	<i class="fa fa-angle-left right"></i>
	</p>
	</a>
	<ul class="nav nav-treeview">
	  <li class="nav-item ">
		<a href="<?=URLAD?>menu-management" class="nav-link <?=$menu3?>">
		 <i class="fa fa-angle-right nav-icon"></i>
		  <p>Manage Menu</p>
		</a>
	  </li>
	  <li class="nav-item ">
		<a href="<?=URLAD?>reset-password" class="nav-link <?=$menu5?>">
		  <i class="fa fa-angle-right nav-icon"></i>
		  <p>Reset Password</p>
		</a>
	  </li>
	  <li class="nav-item">
		<a href="<?=URLAD?>logout" class="nav-link">
		 <i class="fa fa-angle-right nav-icon"></i>
		  <p>Logout </p>
		</a>
	  </li>
	</ul>
	</li>   
	</ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>