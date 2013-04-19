<?php
// $Id: template.php,v 1.16.2.3 2010/05/11 09:41:22 goba Exp $

// pass variables to javascript so they can use the base path and theme path
	$js = "var base_path = '". base_path() . "';";
	drupal_add_js($js, 'inline');

	$themePath = "var theme_path = '". path_to_theme() . "';";
	drupal_add_js($themePath, 'inline');

  drupal_add_js(array('ncstate_official' => array(
      'slider_transition_time' => theme_get_setting('slider_transition_time'),
    )), 'setting');

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
        'title_image_url'      		=> 'http://drupal.ncsu.edu/resources/theme-resources/ncstate_official/site_title/site_title_image.png',
        'site_title_vertical_offset'    => '0px',
        'site_title_horizontal_offset'  => '0px',
        'show_breadcrumbs'      	=> 1,
        'breadcrumb_separator'		=> ' > ',
        'show_post_info_on_search'      => 0,
        'slider_transition_time'        => 5000,
        'copyright_information' 	=> '© ' . date('Y', time()),
        'footer_contact_information'	=> 'North Carolina State University Raleigh, NC 27695 Phone: (919) 515-2011',
        'social_facebook_url'           => 'http://facebook.com/ncstate',
        'social_youtube_url'            => 'http://youtube.com/ncstate',
        'social_twitter_url'            => 'http://twitter.com/ncstate',
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

  /*
  echo '<pre><hr /><hr /><hr /><hr /><hr /><hr />';
  print_r($vars);
  die();
  */

  	// check to see if this is an admin or another known protected page. If it is, then do not show the left or right regions (to maximize space for those awesome drupal tables that overlap the divs so nicely ;-)
  	$forceHideLeftRightRegions = false;

  	// these are the paths on which to hide the left/right regions
  	$matchPaths = array(
  		'page-admin',
  		'page-node-webform',
  		'page-node-webform-results',
  		'page-node-edit'
  	);

  	foreach($vars['template_files'] as $key => $value) {
  		if(in_array($value, $matchPaths)) {
  			$forceHideLeftRightRegions = true;
  		}
  	}

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
	if(!$forceHideLeftRightRegions) {
		if($vars['left_above_menu'] || $vars['left_primary_menu'] || $vars['left_secondary_menu'] || $vars['left_below_menu']) {
			// there is something in the left region, so set the necessary widths here
			$vars['page']['region-widths']['show-left-region'] = true;
			$vars['page']['region-widths']['left-region-width'] = 20;
		}
	}
	if(!$forceHideLeftRightRegions) {
		if($vars['right_top_sidebar'] || $vars['right_main_sidebar'] || $vars['right_main_blank_sidebar'] || $vars['right_bottom_sidebar']) {
			// there is something in the right region, so set the necessary widths here
			$vars['page']['region-widths']['show-right-region'] = true;
			$vars['page']['region-widths']['right-region-width'] = 25;
		}
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

	// detect if the search bar displayed, and set the header region widths accordingly
	if ($vars['header_search']) {
		$vars['page']['region-widths']['show-right-header-region'] = true;
		$vars['page']['region-widths']['region-header-left-width'] = 62 - $bellTowerWidth;

	} else {
		$vars['page']['region-widths']['show-right-header-region'] = false;
		$vars['page']['region-widths']['region-header-left-width'] = 90 - $bellTowerWidth;
	}



	//set the title image appropriately based on how much room there is to use: number of grids * 10 (pixels), minus 30 (pixels) for space
	$vars['page']['region-widths']['region-header-title-width'] = ($vars['page']['region-widths']['region-header-left-width'] * 10) - 30;

	// check for footer horizontal menu. If configured by user, display it. If not configured by user, display default menu.
	if(!$vars['footer_menu']) {
		$vars['footer_menu'] = '
			<ul aria-label="Services Navigation" role="navigation">
                            <li><a href="http://www.ncsu.edu/emergency-information/">Emergency Info</a></li>
                            <li><a href="http://www.ncsu.edu/privacy/" title="North Carolina State University Privacy Policy">Privacy</a></li>
                            <li><a href="http://www.ncsu.edu/copyright/" title="North Carolina State University copyright policy">Copyright</a></li>
                            <li><a class="track" href="http://oit.ncsu.edu/itaccess/legislation-and-policies" title="North Carolina State University website accessibility information">Accessibility</a></li>
                            <li><a class="track" href="http://oied.ncsu.edu/oied/">Diversity</a></li>
                            <li><a class="track" href="http://policies.ncsu.edu/" title="North Carolina State University Policies">University Policies</a></li>
                            <li><a href="http://www.ncsu.edu/about-site/" title="About the North Carolina State University website">About the Site</a></li>
                            <li><a class="track" href="https://jobs.ncsu.edu/" title="Jobs at North Carolina State University">Jobs</a></li>
                            <li><a href="http://www.ncsu.edu/contact-us/" title="Contact North Carolina State University">Contact NC State</a></li>
                        </ul>';
	} else {
		$vars['footer_menu'] = $vars['footer_menu'];
	}

  // dont show breadcrumbs on home page
  if ($vars['is_front']) {
    $vars['breadcrumb'] = NULL;
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
  return t('!datetime',
    array(
      '!username' => theme('username', $node),
      '!datetime' => 'Created: ' . format_date($node->created) . ', Last Updated: ' . format_date($node->changed),
    ));
}
