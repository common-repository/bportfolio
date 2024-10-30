<?php

// Settings Options


  // Set a unique slug-like ID
  $prifix_opt = '_bppfshortcode_';

  // Create options
  CSF::createMetabox( $prifix_opt, array(
    'title'     => 'Shortcode Generator',
    'class'     => 'spt-main-class',
    'post_type' => 'shortcode-generator',
    'show_restore' => true,
    'theme'     => 'light',
  ) );

    // Create a section
  CSF::createSection( $prifix_opt, array(
    'title'  => 'Layout',
    'icon' => 'dashicons dashicons-layout',
    'fields' => array(

      //
      // A text field
      array(
        'id'      => 'project_layout',
        'type'    => 'button_set',
        'title'   => __('Layout', 'bportfolio'),
        'subtitle'=> __('Number of Columns in a Row', 'bportfolio'),
        'desc'    => __('Choose Your Desired Column', 'bportfolio'),
        'options'    => array(
          '6'  => 'Two Column',
          '4'  => 'Three Column',
          '3'  => 'Four Column',
        ),
        'default' => '4',
      ),
      array(
        'id'      => 'project_width',
        'type'    => 'button_set',
        'title'   => __('Layout Width', 'bportfolio'),
        'subtitle'=> __('Set Project\'s Container Width', 'bportfolio'),
        'desc'    => __('Choose Your Container Width', 'bportfolio'),
        'options'    => array(
          ''      => 'boxed',
          'auto-' => 'Auto',
          'large-'=> 'Full Width',
        ),
        'default' => '',
      ),
  
    )


  ) );


  // Create a section for Filtering
  CSF::createSection( $prifix_opt, array(
    'title'  => 'Filtering',
    'icon'   => 'dashicons dashicons-filter',
    'fields' => array(

      //
      // A text field
      array(
        'id'      => 'project_include',
        'type'    => 'select',
        'title'   => __('Include', 'bportfolio'),
        'desc'    => __('List of Post/IDs to show (Leave it blank for Default / All Posts)', 'bportfolio'),
        'options' => 'posts',
        'query_args' => array(
            'post_type' => 'bportfolio',
        ),
        'placeholder' => 'Select Post',
        'multiple' => true,
        'chosen' => true,
      ),
      array(
        'id'      => 'project_exclude',
        'type'    => 'select',
        'title'   => __('Exclude', 'bportfolio'),
        'desc'    => __('List of Post/IDs not to show (Leave it blank for Default / All Posts.).', 'bportfolio'),
        'options' => 'posts',
        'query_args' => array(
            'post_type' => 'bportfolio',
        ),
        'placeholder' => 'Select Post',
        'multiple' => true,
        'chosen' => true,
      ),
      array(
        'id'      => 'project_limit',
        'type'    => 'number',
        'title'   => __('Limit', 'bportfolio'),
        'desc'    => __('The number of posts to show. Set empty to show all found posts.', 'bportfolio'),
        'default' => -1,
      ),
      array(
        'id'      => 'project_cat',
        'type'    => 'select',
        'title'   => __('Categories', 'bportfolio'),
        'desc'    => __('Select the Category Only you want Show, Leave it blank for Default / All categories.', 'bportfolio'),
        'options' => 'categories',
        'query_args' => array(
            'taxonomy' => 'bportfolio_cat',
        ),
        'placeholder' => 'Select Category',
        'multiple' => true,
        'chosen' => true,
      ),
      array(
        'id'      => 'project_order',
        'type'    => 'radio',
        'title'   => __('Order', 'bportfolio'),
        'options' => array(
          'ASC'   => 'Ascending',
          'DESC'  => 'Descending ',
        ),
        'default' => 'DESC',
      ),
    )

    
  ) );

  // Create a section for Styling
  CSF::createSection( $prifix_opt, array(
    'title'  => 'Styling',
    'icon'   => 'dashicons dashicons-admin-customizer',
    'fields' => array(

 
      array(
        'id'      => 'overlay_bg_color',
        'type'    => 'color',
        'title'   => __('Overlay color', 'bportfolio'),
        'desc'    => __('Overlay color for Portfolio Items', 'bportfolio'),
        'default' => '#5d3dfd'
      ),
      array(
        'id'      => 'btn_bg_color',
        'type'    => 'color',
        'title'   => __('Button background color', 'bportfolio'),
        'desc'    => __('Button background color for Portfolio Menu', 'bportfolio'),
        'default' => '#333'
      ),
  
      array(
        'id'      => 'btn_hover_bg_color',
        'type'    => 'color',
        'title'   => __('Button hover background color', 'bportfolio'),
        'desc'    => __('Button hover background color for Portfolio Menu', 'bportfolio'),
        'default' => '#5d3dfd'
      ),
      array(
        'id'      => 'btn_active_bg_color',
        'type'    => 'color',
        'title'   => __('Button active background color', 'bportfolio'),
        'desc'    => __('Button hover background color for Portfolio Menu', 'bportfolio'),
        'default' => '#5d3dfd'
      ),
      array(
        'id'      => 'btn_text_color',
        'type'    => 'color',
        'title'   => __('Button Text color', 'bportfolio'),
        'desc'    => __('Button Text color for Portfolio Menu', 'bportfolio'),
        'default' => '#333'
      ),
      array(
        'id'      => 'btn_hvr_text_color',
        'type'    => 'color',
        'title'   => __('Button Hover Text color', 'bportfolio'),
        'desc'    => __('Button Hover Text color for Portfolio Menu', 'bportfolio'),
        'default' => '#fff'
      ),
      array(
        'id'      => 'btn_bdr_radius',
        'type'    => 'number',
        'title'   => __('Button Border Radius', 'bportfolio'),
        'desc'    => __('Input your border radius value in number, No Need to use px', 'bportfolio'),
        'default' => 4,
      ),

    )

    
  ) );