<?php // $Id: page.tpl.php,v 1.18.2.1 2011/02/07 00:13:31 njyoung Exp $ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
	<head>
		<?php print $head; ?>
		<title><?php print $head_title; ?></title>
		<?php print $styles; ?>
		<?php print $scripts; ?>
        <style type="text/css" media="all"><?php print $dynamic_styles; ?></style>
	</head>
	<body>
	<!-- start accessibility links -->
        <div class="skipNav">
            <a href="#main-content-anchor" title="Skip to main content area">Skip to the main content area</a>
        </div>
	<!-- end accessibility links -->
	<!-- show either the default red menu at the top of the header region, or the brand bar  -->
	<?php if(theme_get_setting('select_brand_bar') != 0): ?>
        <div id="region-brandbar-container">
            <a class="access" name="brand-bar">NC State Brand Bar</a>
            <div id="region-brandbar" role="navigation" aria-label="NC State Brand Bar"><?php print $page['brand-bar-code'];?></div>
        </div>
        <!-- End brandbar region -->
    <?php endif; ?>
		<div id="page-container" class="container_<?php echo $page['region-widths']['maxPageWidth']; ?>">
			<!-- start header container region with site title, search box etc -->
			<div id="region-header-container" class="container_<?php echo $page['region-widths']['maxPageWidth']; ?>">
				<div id="head">
                                    <div id="region-noBrandBarDefaultTopMenu-container">
                                        <a class="access" name="university-navigation-links">University Navigation Links</a>
                                        <div id="region-noBrandBarDefaultTopMenu" role="navigation" aria-label="University Navigation Links">
                                            <h2 class="brickHeaderLogo" title="North Carolina State University">
                                                <a href="http://www.ncsu.edu" title="North Carolina State University">
                                                    <img class="ncsu-text" alt="North Carolina State University" src="<?php echo base_path() . path_to_theme(); ?>/images/base/125-anniversary-stripbrick-redonwhite.gif"></a>
                                            </h2>
                                            <ul id="noBrandBarDefaultTopMenuNav">
                                                    <li>
                                                        <a href="http://www.ncsu.edu/directory/" title="Find People at North Carolina State University">Find People</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.lib.ncsu.edu/" title="North Carolina State University Libraries">Libraries</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://news.ncsu.edu/" title="Latest North Carolina State University News">News</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://calendar.activedatax.com/ncstate/" title="North Carolina State University Events Calendar">Calendar</a>
                                                    </li>
                                                    <li>
                                                            <a href="http://mypack.ncsu.edu" title="North Carolina State University Portal">MyPack Portal</a>
                                                    </li>
                                                    <li>
                                                            <a href="http://giving.ncsu.edu" title="Giving to North Carolina State University">Giving</a>
                                                    </li>
                                                    <li class="last">
                                                            <a href="http://www.ncsu.edu/campus_map/" title="North Carolina State University Campus Map">Campus Map</a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
    				<?php if(theme_get_setting('show_belltower')): ?>
						<div id="region-header-left-belltower" class="grid_7">
					        <a href="<?php echo base_path(); ?>" title="Return to the homepage of this website">
					        	<span class="bellTowerLogo" title="Image of North Carolina State University Bell Tower"></span>
					        </a>
					    </div>
					<?php endif; ?>
					<div id="region-header-left" class="grid_<?php echo $page['region-widths']['region-header-left-width']; ?>">
				        <a href="<?php echo base_path(); ?>" title="Return to the homepage of this website">
				        	<img alt="Site Title: <?php echo $site_name; ?>" title="Site Title: <?php echo $site_name; ?>" id="siteTitleImage" src="<?php echo theme_get_setting('title_image_url'); ?>" />
				        </a>
				    </div>
				    <?php if ($page['region-widths']['show-right-header-region']): ?>
                                        <div id="region-header-right" class="grid_28">
                                                    <?php if($header_search): ?>
                                                            <a class="access" name="site-search">Search this site</a>    	
                                                            <div role="search" aria-label="Search this website" id="header-site-search">
                                                                    <?php print $header_search; ?>
                                                            </div>
                                                    <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
				</div>
			</div>
			<!--  End header container region -->
			<!--  START Horizontal Menu Region -->
			<?php if($horizontal_main_menu): ?>
				<div id="horizontal-menu-container" class="container_<?php echo $page['region-widths']['maxPageWidth']; ?>">
                                    <div id="horizontal-menu-grid" class="grid_<?php echo $page['region-widths']['maxPageWidth']; ?>">
					<?php if($horizontal_main_menu): ?>
						<div id="horizontal-main-menu">
							<a class="access" name="horizontal-main-menu">Horizontal Main Menu</a>
							<?php print $horizontal_main_menu; ?>
						</div>
					<?php endif; ?>
                                        </div>
				</div>
			<?php endif; ?>
			<!--  End horizontal menu -->
			<!-- Start 3 column layout area -->
			<div id="content-area-container" class="container_<?php echo $page['region-widths']['maxPageWidth']; ?>">
				<div id="content-area" class="grid_<?php echo $page['region-widths']['maxPageWidth']; ?> <?php if($page['region-widths']['show-left-region']): echo 'content-area-background-with-left-column'; else: echo 'content-area-background-without-left-column'; endif;?>">
					<!-- begin grid for left side of the layout -->
					<?php if($page['region-widths']['show-left-region']): ?>
						<a class="access" name="left-sidebar" role="navigation" aria-label="Left Side Bar (Primary Navigation Area)">Left Side Bar (Primary Navigation Area)</a>    	
						<div class="grid_<?php echo $page['region-widths']['left-region-width']; ?>">
							<div id="region-left-menu-area-container" class="container_<?php echo $page['region-widths']['left-region-width']; ?>">
								<div id="region-left-menu" class="grid_<?php echo $page['region-widths']['left-region-width']; ?>">
									<?php if($left_above_menu): ?>
										<div id="left-above-menu" class="grid_<?php echo $page['region-widths']['left-region-width']; ?>">
								      		<div id="left-above-menu-content" role="navigation" aria-label="Left Region Above Menus">
												<?php print $left_above_menu; ?>
											</div>
										</div>
									<?php endif; ?>
									<?php if($left_primary_menu): ?>
										<div id="left-main-menu" class="grid_<?php echo $page['region-widths']['left-region-width']; ?>">
											<div id="left-main-menu-content" role="navigation" aria-label="Primary Menu Region">		
												<?php print $left_primary_menu; ?>
											</div>
										</div>
									<?php endif; ?>
									<?php if($left_secondary_menu): ?>
										<div id="left-sub-menu" class="grid_<?php echo $page['region-widths']['left-region-width']; ?>">
											<div id="left-sub-menu-content" role="navigation" aria-label="Secondary Menu Region">
												<?php print $left_secondary_menu; ?>
											</div>
										</div>
									<?php endif; ?>
									<?php if($left_below_menu): ?>
										<div id="left-below-menu" class="grid_<?php echo $page['region-widths']['left-region-width']; ?>">
								      		<div id="left-below-menu-content" role="navigation" aria-label="Region Below Primary and Secondary Menus">	
												<?php print $left_below_menu; ?>
											</div>
										</div>
									<?php endif; ?>
									<?php if($page['region-widths']['show-left-region']): ?>
										<div id="left-end-separator" class="grid_<?php echo $page['region-widths']['left-region-width']; ?>"></div>
									<?php endif; ?>
								</div>			
							</div>
						</div>
					<?php endif; ?>
					<!-- end grid for left side of the layout -->
					<!-- begin grid for center and right side of the layout -->
					<!-- check to see if there's a left bar and then set the width accordingly -->
					<div class="grid_<?php echo $page['region-widths']['center-right-region-width']; ?>">
						<div id="region-center-right-container" class="container_<?php echo $page['region-widths']['center-right-region-width']; ?>">
							<?php if ($breadcrumb && theme_get_setting('show_breadcrumbs')): ?>
								<div id="region-breadcrumbs" class="grid_<?php echo $page['region-widths']['center-right-region-width']; ?>">
									<a class="access" name="breadcrumb">Breadcrumbs</a>    	
									<div id="breadcrumb" class="alpha omega" role="navigation" aria-label="Breadcrumb Links List">
										<?php print $breadcrumb; ?>
									</div>
								</div>
							<?php endif; ?>
                            <a class="access" name="main-content-anchor"></a>
							<?php if($main_image): ?>
								<div id="region-main-image" class="grid_<?php echo $page['region-widths']['center-right-region-width']; ?>">
									<div class="alpha omega">
										<?php print $main_image; ?>
									</div>
								</div>
							<?php endif; ?>
							<div id="region-center-content-container" class="container_<?php echo $page['region-widths']['center-region-width']; ?>">
                                <div id="main-content-wrapper" class="grid_<?php echo $page['region-widths']['center-region-width']; ?>">	
									<?php if($main_above_content): ?>
                                        <div id="above-main-content">  
	                                    	<?php print($main_above_content); ?>
                                        </div>
                                	<?php endif; ?>
                                    <div id="main-content" role="main" aria-label="Main Content Area">
									    <?php if ($mission): print '<div id="mission">'. $mission .'</div>'; endif; ?>
									    <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
									    <?php if ($title): print '<div id="page-title"><h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1></div>'; endif; ?>
									    <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
									    <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
									    <?php if ($show_messages && $messages): print $messages; endif; ?>
									    <?php print $help; ?>
							          	<div class="clear-block">
							          		<?php print $content ?>
										</div>
										<?php print $feed_icons ?>
									</div>
                                    <?php if($main_below_content): ?>
	                                    <div id="below-main-content">  
	                                        <?php print($main_below_content); ?>
		                                </div>
                                    <?php endif; ?>
                            </div>
                    </div>
                    <?php if($page['region-widths']['show-right-region']): ?>
                            <a class="access" name="right-sidebar">Right Side Bar</a>    
                            <div id="region-right-sidebar-container" class="container_<?php echo $page['region-widths']['right-region-width']; ?>">
                                    <div id="region-right-sidebar" class="grid_<?php echo $page['region-widths']['right-region-width']; ?>">
                                            <?php if($right_main_sidebar): ?>
                                                    <div id="right-main-sidebar" class="grid_<?php echo $page['region-widths']['right-region-width']; ?>">
                                                        <div id="right-main-sidebar-content">
                                                                <?php print $right_main_sidebar; ?>
                                                        </div>
                                                    </div>
                                            <?php endif; ?>	
						 			</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<!-- end grid for center and right side of the layout -->
				</div>
			</div>
			<!-- End 3 column layout area -->
			<!-- Start footer area (everything underneath the main content area) -->
			<div id="region-footer-container" class="container_<?php echo $page['region-widths']['maxPageWidth']; ?>">
				<div id="footer-separator" class="grid_<?php echo $page['region-widths']['maxPageWidth']; ?>"></div>
				<a class="access" name="footer">Footer</a>    
				<div id="footer-horizontal-menu" class="grid_<?php echo $page['region-widths']['maxPageWidth']; ?>" role="contentinfo" aria-label="Footer">
					<?php print $footer_menu; ?>
				</div>
                                <div id="footer-address-contact-info" class="grid_68">
					<?php echo theme_get_setting('footer_contact_information'); ?>
				</div>
                                <div id="social" class="grid_22">
                                    <ul class="social">
                                        <li><a href="<?php echo theme_get_setting('social_facebook_url'); ?>" class="facebook track" title="Like us on Facebook">Facebook</a></li>
                                        <li><a href="<?php echo theme_get_setting('social_youtube_url'); ?>" class="youtube track" title="See us on YouTube">YouTube</a></li>
                                        <li><a href="<?php echo theme_get_setting('social_twitter_url'); ?>" class="twitter track" title="Follow us on Twitter">Twitter</a></li>
                                        <li><a href="http://oncampus.ncsu.edu" class="oncampus track" title="NC State on onCampus">OnCampus</a></li>
                                    </ul>
                                </div>
			</div>
		</div>
	<?php print $closure ?>
	</body>
</html>
