<?php

// Settings Options


  // Set a unique slug-like ID
  $prifixx = '_bppfsettings_';

  // Create options
  CSF::createOptions( $prifixx , array(
    'framework_title' => 'Portfolio Settings',
    'menu_title' => 'Settings',
    'menu_parent'=> 'edit.php?post_type=bportfolio',
    'menu_slug'   => 'portfolio-settings',
    'menu_type'  => 'submenu',
    'theme'      => 'light',
    'footer_credit' => __('If you like <strong> bPortfolio </strong> please leave us a <a href="https://wordpress.org/plugins/bportfolio/reviews/?filter=5#new-post" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'bportfolio'),
  
  ));


  // Create a section for Styling
  CSF::createSection( $prifixx , array(
    'title'  => 'Styling',
    'icon'   => 'dashicons dashicons-admin-customizer',
    'fields' => array(

      // Option page Title
      array(
        'type'    => 'submessage',
        'content' => '<h3>Options for Portfolio Single Page</h3>',
        'style'   => 'info',
      ),
      array(
        'id'      => 'overlay_bg_color',
        'type'    => 'color',
        'title'   => __('Overlay color', 'bportfolio'),
        'desc'    => __('Project Overlay color for Items', 'bportfolio'),
        'default' => '#5d3dfd'
      ),
      array(
        'id'      => 'pagi_prev_txt',
        'type'    => 'text',
        'title'   => __('Previous Pagination Text', 'bportfolio'),
        'desc'    => __('Input Previous Pagination Text', 'bportfolio'),
        'default' => 'Previous Project'
      ),
      array(
        'id'      => 'pagi_next_txt',
        'type'    => 'text',
        'title'   => __('Next Pagination Text', 'bportfolio'),
        'desc'    => __('Input Here Next Pagination Text', 'bportfolio'),
        'default' => 'Next Project'
      ),
      array(
        'id'      => 'pagination_txt_color',
        'type'    => 'color',
        'title'   => __('Pagination Text Color', 'bportfolio'),
        'desc'    => __('Choose Pagination Text Color', 'bportfolio'),
        'default' => '#777'
      ),
      array(
        'id'      => 'pagination_txt_hover',
        'type'    => 'color',
        'title'   => __('Pagination Text Hover Color', 'bportfolio'),
        'desc'    => __('Choose Pagination Text Hover Color', 'bportfolio'),
        'default' => '#5d3dfd'
      ),


  // SOCIAL MEDIA LINK
  // A Subheading
  array(
    'type'    => 'subheading',
    'content' => 'Social Media Options',
  ),

  array(
    'id'      => 'facebook_link',
    'type'    => 'text',
    'title'   => __('Facebook', 'bportfolio'),
    'desc'    => __('Enter Your Facebook Profile Link Here', 'bportfolio'),
  ),
  array(
    'id'      => 'twitter_link',
    'type'    => 'text',
    'title'   => __('Twitter', 'bportfolio'),
    'desc'    => __('Enter Your Twitter Profile Link Here', 'bportfolio'),
  ),
  array(
    'id'      => 'linkedin_link',
    'type'    => 'text',
    'title'   => __('Linkedin', 'bportfolio'),
    'desc'    => __('Enter Your Linkedin Profile Link Here', 'bportfolio'),
  ),
  array(
    'id'      => 'dribble_link',
    'type'    => 'text',
    'title'   => __('Dribble', 'bportfolio'),
    'desc'    => __('Enter Your Dribble Profile Link Here', 'bportfolio'),
  ),
  array(
    'id'      => 'behance_link',
    'type'    => 'text',
    'title'   => __('Behance', 'bportfolio'),
    'desc'    => __('Enter Your Behance Profile Link Here', 'bportfolio'),
  ),
  array(
    'id'      => 'pinterest_link',
    'type'    => 'text',
    'title'   => __('Pinterest', 'bportfolio'),
    'desc'    => __('Enter Your Pinterest Profile Link Here', 'bportfolio'),
  ),



    )

    
  ));