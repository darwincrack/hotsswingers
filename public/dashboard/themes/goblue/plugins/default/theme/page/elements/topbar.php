<?php
	if(ossn_isLoggedin()){		
		$hide_loggedin = "hidden-xs hidden-sm";
	}
?>
<!-- ossn topbar -->
<div class="topbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2 left-side left">
				<?php if(ossn_isLoggedin()){ ?>
				<div class="topbar-menu-left">
					<li id="sidebar-toggle" data-toggle='0'>
						<a role="button" data-target="#"> <i class="fa fa-th-list"></i></a>
					</li>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-7 site-name text-center <?php echo $hide_loggedin;?>">



<div class="logo" style="width: 100%">
	<?php // $data=print_r(ossn_getimagenes(4,'medium'));?>
                                  <a href="<?php echo ossn_site_url();?>" style="padding: 0;">
                                    
                                    <img src="<?php echo ossn_getbaseurl('uploads/'.ossn_sitelogo()); ?>" alt="<?php echo ossn_sitenamev();?>" style="width: 145px;"></a>
                                    
                                  </a>
                            </div>


			<!--	<span><a href="<?php echo ossn_site_url();?>"><?php echo ossn_sitelogo(); ?><?php echo ossn_site_settings('site_name');?></a></span> -->
			</div>
			<div class="col-md-3 text-right right-side">
				<div class="topbar-menu-right <?php echo ossn_getrole()?>">

<?php //"<pre>". print_r($_SESSION['OSSN_USER'])."</pre>"?>
					<ul>
					<li class="ossn-topbar-dropdown-menu">
						<div class="dropdown">
						<?php
							if(ossn_isLoggedin()){						
								echo ossn_plugin_view('output/url', array(
									'role' => 'button',
									'data-toggle' => 'dropdown',
									'data-target' => '#',
									'text' => '<i class="fa fa-sort-desc"></i>',
								));									
								echo ossn_view_menu('topbar_dropdown'); 
							}
							?>
						</div>
					</li>                
					<?php
						if(ossn_isLoggedin()){
							echo ossn_plugin_view('notifications/page/topbar');
						}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ./ ossn topbar -->
