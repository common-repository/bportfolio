<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//
// Metabox of the PAGE
// Set a unique slug-like ID
//
$prefix = '_bportfolio_';

//
// Create a metabox
//
CSF::createMetabox( $prefix, array(
  'title'        => 'Portfolio Options',
  'post_type'    => 'bportfolio',
  'show_restore' => true,
) );

//
// Create a section
//
CSF::createSection( $prefix, array(
  'title'  => 'Project Settings',
  'icon'   => 'fas fa-rocket',
  'fields' => array(

    // Fields
    array(
      'id'      => 'project_screenshot',
      'type'    => 'gallery',
      'title'   => __('Project Picture/Screenshot', 'bportfolio'),
      'subtitle'=> __('Use Same size Image. Recommended (\'945 x 670\')px', 'bportfolio'),
      'desc'    => __('Upload Project\'s Pictures / Screenshots.', 'bportfolio'),
      'add_title' => 'Add Project Pictures',
      'fields'    => array(
        array(
          'id'    => 'project_pic',
          'type'  => 'upload',
          'title' => 'Project Picture',
        ),
      )
    ),
    array(
      'id'      => 'project_dsc_heading',
      'type'    => 'text',
      'title'   => __('Project Description Heading', 'bportfolio'),
      'desc'    => __('Enter Here Portfolio Description Heading.', 'bportfolio'),
      'default' => 'ABOUT THE PROJECT',
    ),
    array(
      'id'      => 'project_dsc',
      'type'    => 'textarea',
      'title'   => __('Portfolio Description', 'bportfolio'),
      'desc'    => __('Enter Here Portfolio Description.', 'bportfolio'),
      'default' => 'Great code deserves an equally stunning visual representation, and this is what we deliver. Our Product Design team combines beautiful interfaces with captivating user experience. Top-notch blockchain developers, designers, and product owners - ready to build your product.',
    ),
    array(
      'id'      => 'client_name',
      'type'    => 'text',
      'title'   => __('Project Client\'s Name', 'bportfolio'),
      'desc'    => __('Enter Here Client\'s Name.', 'bportfolio'),
      'default' => 'bPlugins',
    ),
    array(
      'id'      => 'project_date',
      'type'    => 'date',
      'title'   => __('Project\'s Date', 'bportfolio'),
      'desc'    => __('Select Project\'s Date.', 'bportfolio'),
      'settings' => array(
        'dateFormat'      => 'd M, yy',
        'changeMonth'     => true,
        'changeYear'      => true,
        'showWeek'        => true,
        'showButtonPanel' => true,
        'weekHeader'      => 'Week',
        'monthNamesShort' => array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ),
        'dayNamesMin'     => array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
      ),
      'default' => 'd M, yy',
    ),
    array(
      'id'      => 'project_link',
      'type'    => 'text',
      'title'   => __('Project Demo Link', 'bportfolio'),
      'desc'    => __('Enter Project Demo Link Here', 'bportfolio'),
      'default' => 'https://example.com',
    ),




  )

) );

