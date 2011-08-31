<?php
// $Id: theme-settings.php,v 1.8 2011/01/01 13:20:14 njyoung Exp $

function phptemplate_settings($saved_settings) {
	
	$defaults = array(
    	'select_brand_bar' 				=> 0,
    	'show_belltower' 				=> 1,
		'site_title_url' 				=> base_path().path_to_theme() . '/images/base/site_title_image.png',
		'show_breadcrumbs'      		=> 1,
		'breadcrumb_separator'		 	=> ' > ',
		'show_quicklinks'				=> 1,
		'copyright_information' 		=> '© 2011',
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
  $form['show_belltower'] = array(
    '#type' => 'select',
     '#title' => 'Show Belltower in header',
    '#default_value' => $settings['show_belltower'],
  	'#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );
  
  $form['site_title_url'] = array(
    '#title' => 'Site Title Image URL',
    '#description' => t('Full URL (including http://) of the image to use for the site title in the main banner'), 
    '#type' => 'textfield',
    '#default_value' => $settings['site_title_url'],
    '#size' => 60, 
    '#maxlength' => 128, 
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