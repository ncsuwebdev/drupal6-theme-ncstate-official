<?php
// $Id: theme-settings.php,v 1.8 2011/01/01 13:20:14 njyoung Exp $

function ncstate_official_settings($saved_settings) {
	
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
  	
	// Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  // Create the form widgets using Forms API
  $form['select_brand_bar'] = array(
    '#type' => 'select',
    '#title' => 'Select Brand Bar (Utility Bar) to use at the top of the theme', 
    '#default_value' => $settings['select_brand_bar'],
	'#options' => array(
			0 => 'None - Use Default Top Menu',
  			1 => 'Red text on White',
	  		2 => 'Red text on White (centered)',
	      	3 => 'White text on Red',  
	      	4 => 'White text on Red (centered)',    
	      	5 => 'White text on Black',
	      	6 => 'White text on Black - Centered',
	      	7 => 'Black text on White',
	      	8 => 'Black text on White - Centered',
	),
  );
  
  $form['anniversary_header'] = array(
    '#type' => 'select',
     '#title' => 'Show Anniversary Logo',
    '#default_value' => $settings['anniversary_header'],
  	'#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );
  
  $form['show_belltower'] = array(
    '#type' => 'select',
     '#title' => 'Show Belltower in header',
    '#default_value' => $settings['show_belltower'],
  	'#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );
  
  $form['title_image_url'] = array(
    '#title' => 'Site Title Image Full URL',
    '#description' => t('Transparent PNG / GIF that will function as the title of your site. OIT Design (http://oitdesign.ncsu.edu) can create this correctly for you.'), 
    '#type' => 'textfield',
    '#default_value' => $settings['title_image_url'],
    '#size' => 60, 
    '#maxlength' => 255, 
    '#required' => TRUE,
  );
  
  $form['site_title_vertical_offset'] = array(
    '#title' => 'Site Title Vertical Offset (px)',
    '#description' => t('Move the site title vertically (helpful if you change the size or font options). NOTE: include "px" on the end of your offset.'), 
    '#type' => 'textfield',
    '#default_value' => $settings['site_title_vertical_offset'],
    '#size' => 6, 
    '#maxlength' => 5, 
    '#required' => TRUE,
  );
  
  $form['site_title_horizontal_offset'] = array(
    '#title' => 'Site Title Horizontal Offset (px)',
    '#description' => t('Move the site title horizontally (helpful if you change the size or font options). NOTE: include "px" on the end of your offset.'), 
    '#type' => 'textfield',
    '#default_value' => $settings['site_title_horizontal_offset'],
    '#size' => 6, 
    '#maxlength' => 5, 
    '#required' => TRUE,
  );
	
  $form['show_breadcrumbs'] = array(
    '#title' => 'Show Breadcrumbs when available', 
    '#type' => 'select',
    '#default_value' => $settings['show_breadcrumbs'],
    '#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );
  
  $form['breadcrumb_separator'] = array(
    '#title' => 'Breadcrumb Separator',
    '#description' => t('The character that will go in between breadcrumb items. Include spaces if necessary'), 
    '#type' => 'textfield',
    '#default_value' => $settings['breadcrumb_separator'],
    '#size' => 15, 
    '#maxlength' => 10, 
    '#required' => FALSE,
  );
  
  $form['show_quicklinks'] = array(
    '#title' => 'Show Quicklinks menu in header', 
    '#type' => 'select',
    '#default_value' => $settings['show_quicklinks'],
    '#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );
  $form['copyright_information'] = array(
    '#title' => 'Copyright information',
    '#description' => t('Information about copyright holder of the website - will show up at the bottom of the page'), 
    '#type' => 'textfield',
    '#default_value' => $settings['copyright_information'],
    '#size' => 60, 
    '#maxlength' => 128, 
    '#required' => FALSE,
  );
  
  $form['footer_contact_information'] = array(
    '#title' => 'Footer Contact Information',
    '#description' => t('For example: North Carolina State University Raleigh, NC 27695 Phone: (919) 515-2011'), 
    '#type' => 'textfield',
    '#default_value' => $settings['footer_contact_information'],
    '#size' => 60, 
    '#maxlength' => 128, 
    '#required' => TRUE,
  );

  // Return the additional form widgets
  return $form;

}