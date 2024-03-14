<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<li class="menu-title">
				<span>Main</span>
			</li>
			<ul>


				<li>
					<a href="<?= home_path() ?>/"><i class="la la-dashboard"></i> <span> Dashboard</span> </a>

				</li>

				<!-- <li class="submenu">
					<a href="#" class=""><i class="la la-rocket"></i> <span> Projects</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						<li><a href="projects.php">Projects</a></li>
					</ul>
				</li> -->
				<?php

				$get_modules = get_all_module_list($DB);
				$access_session_arr = explode(',', $_SESSION['module_access']);

				// print_r($access_session_arr);
				foreach ($get_modules as $module) {

					if (in_array($module['mm_id'], $access_session_arr)) {
				?>

						<li class="">
							<a href="<?= home_path() . "/" . $module['mm_homepage_link'] ?>"><?= $module['mm_icon'] ?> <span> <?= $module['mm_module_name'] ?></span> </a>
						</li>
				<?php }
				}



				?>






			</ul>
		</div>
	</div>
</div>