<?php
// $Id: theme-settings.php,v 1.8 2011/01/01 13:20:14 njyoung Exp $

function ncstate_official_settings($saved_settings) {

	$defaults = array(
            'title_image_url'      		=> 'http://drupal.ncsu.edu/resources/theme-resources/ncstate_official/site_title/site_title_image.png',
            'site_title_vertical_offset'        => '0px',
            'site_title_horizontal_offset'      => '0px',
            'show_breadcrumbs'                  => 1,
            'breadcrumb_separator'		=> ' > ',
            'show_post_info_on_search'          => 0,
            'slider_transition_time'            => 5000,
            'copyright_information'             => '© ' . date('Y', time()),
            'footer_contact_information'	=> 'North Carolina State University Raleigh, NC 27695 Phone: (919) 515-2011',
            'social_facebook_url'               => 'http://facebook.com/ncstate',
            'social_youtube_url'                => 'http://youtube.com/ncstate',
            'social_twitter_url'                => 'http://twitter.com/ncstate',
  	);

	// Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  $form['title_image_url'] = array(
    '#title' => 'Site Title Image Full URL',
    '#description' => t('Transparent PNG / GIF title of your site. OIT Design (http://oitdesign.ncsu.edu) can create this correctly for you. Must include http:// or https://'),
    '#type' => 'textfield',
    '#default_value' => $settings['title_image_url'],
    '#size' => 120,
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

  $form['show_post_info_on_search'] = array(
    '#title' => 'Show Post Information on Search Results',
    '#type' => 'select',
    '#default_value' => $settings['show_post_info_on_search'],
    '#options' => array(
      0 => 'False',
      1 => 'True',
    ),
  );

  $sliderTransitionTimeArray = array(
      1000 => '1 Second',
      3000 => '3 Seconds',
      5000 => '5 Seconds',
      10000 => '10 Seconds',
      15000 => '15 Seconds',
      20000 => '20 Seconds',
      30000 => '30 Seconds',
      60000 => '60 Seconds',
    );

  $form['slider_transition_time'] = array(
        '#type'          => 'select',
        '#title'         => t('Set the slider transition time'),
        '#default_value' => $settings['slider_transition_time'],
        '#description'   => t("<p>This is the amount of seconds each slide will display before transitioning to the next panel. If you are not using a slider anywhere on your site, ignore this setting.</p>"),
        '#required'      => TRUE,
        '#options'       => $sliderTransitionTimeArray,
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
  
  $form['social_facebook_url'] = array(
    '#title' => 'Facebook page URL',
    '#description' => t('Change this to your own facebook URL, or leave as the default (http://facebook.com/ncstate)'),
    '#type' => 'textfield',
    '#default_value' => $settings['social_facebook_url'],
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );
  
  
  $form['social_youtube_url'] = array(
    '#title' => 'Youtube Account URL',
    '#description' => t('Change this to your own youtube channel URL, or leave as the default (http://youtube.com/ncstate)'),
    '#type' => 'textfield',
    '#default_value' => $settings['social_youtube_url'],
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );
  
  
  $form['social_twitter_url'] = array(
    '#title' => 'Twitter Account URL',
    '#description' => t('Change this to your own twitter account URL, or leave as the default (http://twitter.com/ncstate)'),
    '#type' => 'textfield',
    '#default_value' => $settings['social_twitter_url'],
    '#size' => 60,
    '#maxlength' => 128,
    '#required' => TRUE,
  );
  
  
  // Return the additional form widgets
  return $form;

}
