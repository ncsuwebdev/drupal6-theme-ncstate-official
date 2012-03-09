<?php
// $Id: template.php,v 1.16.2.3 2010/05/11 09:41:22 goba Exp $

// pass variables to javascript so they can use the base path and theme path
	$js = "var base_path = '". base_path() . "';";
	drupal_add_js($js, 'inline');
	
	$themePath = "var theme_path = '". path_to_theme() . "';";
	drupal_add_js($themePath, 'inline');

/*
* Initialize theme settings
*/
if (is_null(theme_get_setting('ncstate_official_select_brand_bar'))) {  
  global $theme_key;

  /*
   * The default values for the theme variables. Make sure $defaults exactly
   * matches the $defaults in the theme-settings.php file.
   */
    
  $defaults = array(
    	'select_brand_bar' 				=> 0,
    	'anniversary_header'			=> 0,
    	'show_belltower' 				=> 1,
		'title_image_url'      			=> 'http://drupal.ncsu.edu/resources/theme-resources/ncstate_official/site_title/site_title_image.png',
  		'site_title_vertical_offset'    => '0px',
		'site_title_horizontal_offset'  => '0px',
		'show_breadcrumbs'      		=> 1,
		'breadcrumb_separator'		 	=> ' > ',
		'show_quicklinks'				=> 1,
		'copyright_information' 		=> '© ' . date('Y', time()),
		'footer_contact_information'	=> 'North Carolina State University Raleigh, NC 27695 Phone: (919) 515-2011',
  	);

  // Get default theme settings.
  $settings = theme_get_settings($theme_key);
  // Don't save the toggle_node_info_ variables.
  if (module_exists('node')) {
    foreach (node_get_types() as $type => $name) {
      unset($settings['toggle_node_info_' . $type]);
    }
  }
  // Save default theme settings.
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, $settings)
  );
  // Force refresh of Drupal internals.
  theme_get_setting('', TRUE);
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */

function ncstate_official_breadcrumb($breadcrumb) {
  // Wrap separator with span element.
  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<span class="access">' . t('You are here') . '</span>';
    $output .= '<div class="breadcrumb">' . implode('<span class="separator"> ' . theme_get_setting('breadcrumb_separator') . '</span>', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function ncstate_official_preprocess_page(&$vars, $hook) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  
  	/* Add dynamic stylesheet */
  	ob_start();
  	//include('dynamic.css.php');
  	include(drupal_get_path('theme', 'ncstate_official') . '/css/base/dynamic.css.php');
  	$vars['dynamic_styles'] = ob_get_contents();
  	ob_end_clean();  
	
	// Drupal wants us to set the indexes/custom variables ahead of time, or it will throw an error for the world to see (it will work, just with errors)
	$vars['page']['region-widths']['show-left-region'] = '';
	$vars['page']['region-widths']['show-right-region'] = '';

	// detect, set and store the widths for the different regions, based on what's being displayed (left, right, center and all combinations)
	$vars['page']['region-widths']['maxPageWidth'] = 90;// maximum number of columns in the grid system
	
	// check to see if there are left or right regions to make it easier to set widths of regions below
	if($vars['left_above_menu'] || $vars['left_primary_menu'] || $vars['left_secondary_menu'] || $vars['left_below_menu']) { 
		// there is something in the left region, so set the necessary widths here
		$vars['page']['region-widths']['show-left-region'] = true;
		$vars['page']['region-widths']['left-region-width'] = 20;
	}
		
	if($vars['right_above_sidebar'] || $vars['right_center_sidebar'] || $vars['right_below_sidebar'] || $vars['right_below_sidebar_brown'] || $vars['right_below_sidebar_green'] || $vars['right_below_sidebar_red']) {
		// there is something in the right region, so set the necessary widths here
		$vars['page']['region-widths']['show-right-region'] = true;
		$vars['page']['region-widths']['right-region-width'] = 25;
	}
	// now check to see for combinations of the left and right showing or not, and set the swidth accordingly
	// set the center/right region width (everything to the right of the left region)
	if($vars['page']['region-widths']['show-left-region']) {
		$vars['page']['region-widths']['center-right-region-width'] = 70;
	} else {
		$vars['page']['region-widths']['center-right-region-width'] = $vars['page']['region-widths']['maxPageWidth'];
	}
	
	// set the center region width (not including the right region)
	if($vars['page']['region-widths']['show-left-region'] && $vars['page']['region-widths']['show-right-region']) {
		$vars['page']['region-widths']['center-region-width'] = 45; //if both left and right regions are showing
	} elseif($vars['page']['region-widths']['show-left-region'] && !$vars['page']['region-widths']['show-right-region']) {
		$vars['page']['region-widths']['center-region-width'] = 70; // if only the left region is showing
	} elseif(!$vars['page']['region-widths']['show-left-region'] && $vars['page']['region-widths']['show-right-region']) {
		$vars['page']['region-widths']['center-region-width'] = 65; // if only the right region is showing
	} else {
		$vars['page']['region-widths']['center-region-width'] = $vars['page']['region-widths']['maxPageWidth']; // if neither left or right regions are showing
	}
	
	//detect if the belltower is set to be display (configured on the theme options page)
	// if set, give it 7 (the grids value) to be subtracted from the left region's width in the header
	$bellTowerWidth = 0;
	if (theme_get_setting('show_belltower')) {
		$bellTowerWidth = 7;
	}
	
	// detect if the quicklinks and search bar are displayed, and set the header region widths accordingly
	if (theme_get_setting('show_quicklinks') || $vars['header_search']) {
		$vars['page']['region-widths']['show-right-header-region'] = true;
		$vars['page']['region-widths']['region-header-left-width'] = 62 - $bellTowerWidth;
		
		// set the quicklinks code here
		$vars['page']['region-widths']['quicklinks_html'] = "
			<form method=\"post\" id=\"quicklinks_form\" name=\"quicklinks_form\" action=\"javascript:MM_jumpMenuGo('quicklinks','parent',0)\">
								<table cellpadding=\"0\" cellspacing=\"0\" summary=\"This table is used for the visual layout of the QuickLinks navigation feature. The QuickLinks navigation feature allows you to use a combo-box to select a page and a submit button to jump to that page. This feature requires a browser that supports JavaScript.\">
									<tr>
										<td>				
				                            <a class=\"access\" name=\"quicklinks\" aria-label=\"NC State University Quick Links Navgiation\">NC State Quick Links</a>
				                            <select id=\"quicklinks\" name=\"quicklinks\" title=\"Select a page to jump to (requires a browser that supports JavaScript)\">
				                                <option selected=\"selected\">University Quicklinks...</option>
				                                <option style=\"font-weight: bold\" value=\"#\">Customize Quicklinks</option>
				                                <option value=\"http://www.ncsu.edu/registrar/calendars/\">Academic Calendar</option>
				                                <option value=\"http://www.fis.ncsu.edu/ncsubookstores/\">Bookstore</option>
				                                <option value=\"http://www.ncsu.edu//about-nc-state/university-administration/index.html\">Campus Administration</option>
				                                <option value=\"http://www.fis.ncsu.edu/cashier/\">Cashier&#39;s Office</option>
				                                <option value=\"http://www.ncsu.edu//about-nc-state/centennial-campus/index.html\">Centennial Campus</option>
				                                <option value=\"http://www.ncsu.edu//academics/index.html\">Colleges &#38; Academic Departments</option>
				                                <option value=\"http://distance.ncsu.edu\">Distance Education</option>
				                                <option value=\"http://www7.acs.ncsu.edu/financial_aid/\">Financial Aid &#38; Scholarships</option>
				                                <option value=\"http://www2.acs.ncsu.edu/grad/\">Graduate School</option>
				                                <option value=\"http://www.ncsu.edu//campus-life/housing/index.html\">Housing</option>
				                                <option value=\"http://www.ncsu.edu/registrar/\">Registration &#38; Records</option>
				                                <option value=\"http://www.fis.ncsu.edu/uga/\">Undergraduate Admissions</option>
				                                <option value=\"http://vista.ncsu.edu\">Vista Courses</option>
				                                <option value=\"https://webmail.ncsu.edu/src/login.php\">Webmail</option>
				                                <option value=\"http://courses.ncsu.edu\">Wolfware Courses</option>
				                            </select>
										</td>
										<td><input type=\"image\" src=\"" . base_path().path_to_theme() . "/images/base/head_btn_qlinks.gif\" class=\"btn_qlinks quicklinks-button\" alt=\"Jump to the page selected from the Quicklinks combo-box\" title=\"Jump to the page selected from the Quicklinks combo-box\" /></td>
									</tr>
								</table>
							</form>";
		
	} else {
		$vars['page']['region-widths']['show-right-header-region'] = false;
		$vars['page']['region-widths']['region-header-left-width'] = 90 - $bellTowerWidth;
	}
	
	
	
	//set the title image appropriately based on how much room there is to use: number of grids * 10 (pixels), minus 30 (pixels) for space
	$vars['page']['region-widths']['region-header-title-width'] = ($vars['page']['region-widths']['region-header-left-width'] * 10) - 30;
	
	// detect which brand bar is selected, and store in page variable for display
	switch(theme_get_setting('select_brand_bar')) {
		case 1:
			// red text on white
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=red_on_white&amp;inurl=&amp;center=no" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>'; 
			break;
		case 2:
			// red text on white centered
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=red_on_white&amp;inurl=&amp;center=yes" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>'; 
			break;
		case 3:
			// white text on red
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=red&amp;inurl=&amp;center=yes" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>';
			break;
		case 4:
			// white text on red centered
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=red&amp;inurl=&amp;center=yes" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>';
			break;
		case 5:
			// white text on black
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=black&amp;inurl=&amp;center=no" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>'; 
			break;
		case 6:
			// white text on black centered
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=black&amp;inurl=&amp;center=yes" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>';			
			break;
		case 7:
			// black text on white
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=black_on_white&amp;inurl=&amp;center=no" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>'; 
			break;
		case 8:
			// black text on white centered
			$vars['page']['brand-bar-code'] = '<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" /><iframe title="I-Frame showing NC State Branding Bar" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=black_on_white&amp;inurl=&amp;center=yes" scrolling="no">Your browser does not support inline frames or is currently configured  not to display inline frames.<br />Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.</iframe>';			
			break;
	}
	
	// menu that sits on top of the red header region, if there is no brand bar displayed
	
	if(theme_get_setting('select_brand_bar') == 0) {
		
		$image = 'ncsu_text_beside_belltower.png';
		if(theme_get_setting('anniversary_header')) {
			$imageText = '125-anniversary-stripbrick-redonwhite.gif';
			$image125 = '125-anniversary-stripbrick125-redonwhite.gif';
		}
		
		$vars['page']['noBrandBarDefaultTopMenu'] = '
			<h2 title="North Carolina State University">
				<a href="http://www.ncsu.edu" title="North Carolina State University"><img class="ncsu-text" alt="North Carolina State University" src="' . base_path().path_to_theme() . '/images/base/' . $imageText .'"></a>
				<a href="http://125.ncsu.edu" title="125th Anniversary Website for North Carolina State University"><img class="ncsu-text" alt="125.ncsu.edu" src="' . base_path().path_to_theme() . '/images/base/' . $image125 .'"></a>
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
					<a href="giving/index.php" title="Giving to North Carolina State University">Giving</a>
				</li>
				<li class="last">
					<a href="http://www.ncsu.edu/campus_map/" title="North Carolina State University Campus Map">Campus Map</a>
				</li>
			</ul>'; 
	}
	
	// check for footer horizontal menu. If configured by user, display it. If not configured by user, display default menu.
	if(!$vars['footer_menu']) {
		$vars['footer_menu'] = '
			<ul>
	            <li><a href="http://www.ncsu.edu/emergency-information/index.php">Emergency Information</a></li>
	            <li><a href="http://www.ncsu.edu/privacy/index.php" title="North Carolina State University Privacy Policy">Privacy</a></li>
	            <li><a href="http://www.ncsu.edu/copyright/index.php" title="North Carolina State University copyright policy">Copyright</a></li>
	            <li><a href="http://ncsu.edu/it/access/legal/webreg.php" title="North Carolina State University website accessibility information">Accessibility</a></li>
	            <li><a href="http://www.ncsu.edu/diversity/" title="Diversity at NC State">Diversity</a></li>
	            <li><a href="http://policies.ncsu.edu" title="North Carolina State University Policies">University Policies</a></li>
	            <li><a href="http://www.ncsu.edu/about-site/index.php" title="About the North Carolina State University website">About the Site</a></li>
	            <li><a href="http://www7.acs.ncsu.edu/hr/job_applicants/" title="Jobs at North Carolina State University">Jobs</a></li>
	            <li class="last"><a href="http://www.ncsu.edu/contact-us/index.php" title="Contact North Carolina State University">Contact Us</a></li>
	        </ul>';
	} else {
		$vars['footer_menu'] = $vars['footer_menu'];
	}
	
	
	
}

/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function ncstate_official_preprocess_comment_wrapper(&$vars) {
  if ($vars['content'] && $vars['node']->type != 'forum') {
    $vars['content'] = '<h2 class="comments">'. t('Comments') .'</h2>'.  $vars['content'];
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function ncstate_official_menu_local_tasks() {
  return menu_primary_local_tasks();
}

/**
 * Returns the themed submitted-by string for the comment.
 */
function ncstate_official_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

/**
 * Returns the themed submitted-by string for the node.
 */
function ncstate_official_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}
