<?php
/*
 * Plugin Name: bPortfolio
 * Plugin URI:  https://bplugins.com/
 * Description: Easily display interactive showcase item.
 * Version: 1.0.1
 * Author: bPlugins
 * Author URI: http://bplugins.com
 * License: GPLv3
 * Text Domain:  bportfolio
 * Domain Path:  /languages
*/

if (!defined('ABSPATH')) {
    exit;
}

// SOME INITIAL SETUP
define('BPPF_PLUGIN_DIR', plugin_dir_url( __FILE__ ));
define('BPPF_VER', '1.0.1');

// LOAD PLUGIN TEXT-DOMAIN
function bportfolio_load_textdomain()
{
    load_plugin_textdomain('bportfolio', false, dirname(__FILE__) . "/languages");
}
add_action("plugins_loaded", 'bportfolio_load_textdomain');


// PORTFOLIO ASSETS
function bportfolio_assets()
{
    // stylesheet
    wp_register_style('fontawesome-css', BPPF_PLUGIN_DIR .'public/css/font-awesome-all.css');
    wp_register_style('owl-css', BPPF_PLUGIN_DIR .'public/css/owl.css');
    wp_register_style('bootstrap-css', BPPF_PLUGIN_DIR .'public/css/bootstrap-grid.min.css');
    wp_register_style('fancybox-css', BPPF_PLUGIN_DIR .'public/css/jquery.fancybox.min.css');
    wp_register_style('animate-css', BPPF_PLUGIN_DIR .'public/css/animate.css');
    wp_register_style('main-css', BPPF_PLUGIN_DIR .'public/css/style.css');

    // js 
    wp_register_script('owl-js', BPPF_PLUGIN_DIR .'public/js/owl.js', ['jquery'], BPPF_VER, true );
    wp_register_script('wow-js', BPPF_PLUGIN_DIR .'public/js/wow.js', ['jquery'], BPPF_VER, true );
    wp_register_script('fancybox-js', BPPF_PLUGIN_DIR .'public/js/jquery.fancybox.js', ['jquery'], BPPF_VER, true );
    wp_register_script('isotope-js', BPPF_PLUGIN_DIR .'public/js/isotope.js', ['jquery'], BPPF_VER, true );
    wp_register_script('main-js', BPPF_PLUGIN_DIR .'public/js/script.js', ['jquery'], BPPF_VER, true );

    // plugins assets enqueue
    wp_enqueue_style('fontawesome-css');
    wp_enqueue_style('owl-css');
    wp_enqueue_style('bootstrap-css');
    wp_enqueue_style('fancybox-css');
    wp_enqueue_style('animate-css');
    wp_enqueue_style('main-css');

    // js
    wp_enqueue_script('owl-js');
    wp_enqueue_script('wow-js');
    wp_enqueue_script('fancybox-js');
    wp_enqueue_script('isotope-js');
    wp_enqueue_script('main-js');
}
add_action('wp_enqueue_scripts', 'bportfolio_assets');

    
// Additional admin style
function bppf_admin_style()
{
    wp_register_style('admin-style-css', plugin_dir_url(__FILE__) . 'public/css/admin-style.css');
    wp_register_style('csf-style-css', plugin_dir_url(__FILE__) . 'public/css/csf.min.css');
    wp_enqueue_style('admin-style-css');
    wp_enqueue_style('csf-style-css');
}
add_action('admin_enqueue_scripts', 'bppf_admin_style');

// bPortfolio SHORTCODE FUNCTION
function bppf_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'id' => null,
	), $atts ) ); ob_start(); 

    // Fetch metadata for portfolio items
    $portfolio_opt = get_post_meta($id, '_bppfshortcode_', true);
        
    $limit      = isset($portfolio_opt['project_limit']) ? $portfolio_opt['project_limit'] : -1;
    $order      = isset($portfolio_opt['project_order']) ? $portfolio_opt['project_order'] : 'DESC';
    $include    = isset($portfolio_opt['project_include']) ? $portfolio_opt['project_include'] : '';
    $exclude    = isset($portfolio_opt['project_exclude']) ? $portfolio_opt['project_exclude'] : '';
    //$project_cat= isset($portfolio_opt['project_cat']) ? $portfolio_opt['project_cat'] : '';

    // PORTFOLIO QUERY ARGS
    $query = [
        'post_type'     => 'bportfolio',
        'posts_per_page'=> $limit,
        'order'         => $order,
    ];

    // LAYOUT CONTROL :: DATA
    $column     = isset($portfolio_opt['project_layout']) ? $portfolio_opt['project_layout'] : '4';
    $container  = isset($portfolio_opt['project_width']) ? $portfolio_opt['project_width'] : '';

    if( is_array($include) ){
        $query['post__in'] = $include;
    }
    if( is_array($exclude ) ){
        $query['post__not_in'] = $exclude;
    }
    // Show selected Categories
    if( isset($portfolio_opt['project_cat']) && is_array($portfolio_opt['project_cat']) ){
        $query['tax_query'] = array(
            array(
                'taxonomy' => 'bportfolio_cat',
                'field'    => 'id',
                'terms'    => $portfolio_opt['project_cat'],
            ),
        );
    }
    ?>
    <!-- portfolio-section -->
    <section class="portfolio-section" id="<?php echo esc_attr($id); ?>">
        <div class="<?php echo esc_attr($container); ?>container">
            <div class="sortable-masonry">
                <div class="filters">
                    <ul class="filter-tabs filter-btns centred clearfix">
                        <li class="active filter" data-role="button" data-filter=".all">All</li>

                        <?php 
                        // Fetch all categories from custom-post "bportfolio_cat"
                        $taxonomies = get_terms( array(
                            'taxonomy' => 'bportfolio_cat',
                            'hide_empty' => false
                        ) );

                        if( !empty( $taxonomies ) && ! is_wp_error( $taxonomies ) ):
                            foreach($taxonomies as $category) {
                                echo '<li class="filter" data-role="button" data-filter=".'.esc_attr($category->slug).'">'.esc_html($category->name).'</li>';
                            }
                        endif;
                        ?>
                    </ul>
                </div>
                <div class="items-container row clearfix">

                <!-- PORTFOLIO POST QUERY -->
                <?php 
                    $qry = new WP_Query( $query );
                ?>

                <?php if( $qry->have_posts() ): ?>
                    <?php while( $qry->have_posts() ): $qry->the_post(); 
                    $termsArray = get_the_terms( get_the_ID(), 'bportfolio_cat' );  //Get the terms for this particular item
                    $termsString = ""; //initialize the string that will contain the terms
                    if( is_array($termsArray) && !empty($termsArray )) {
                        foreach ( $termsArray as $term ) { // for each term 
                            $termsString .= $term->slug.' '; //create a string that has all the slugs
                        }
                    }
                    ?>
                    <!-- Start of single item -->
                    <div class="col-lg-<?php echo esc_attr($column); ?> col-md-6 col-sm-12 masonry-item small-column all <?php echo esc_attr($termsString); ?>">
                        <div class="portfolio-block-one">
                            <div class="image-box">
                                <figure class="image">
                                    <?php if( has_post_thumbnail())  the_post_thumbnail(); ?>
                                </figure>
                                <div class="content-box">
                                    <div class="inner">
                                        <div class="title"><?php echo esc_html($term->name); ?></div>
                                        <h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of single item -->
                    <?php endwhile; ?>
                <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
    <!-- portfolio-section end -->

    <!-- Portfolio Style Data -->
    <style>
    .portfolio-section .filter-btns li {
	border-radius: <?php echo esc_attr($portfolio_opt['btn_bdr_radius']); ?>px;
	color: <?php echo esc_attr($portfolio_opt['btn_text_color']); ?>; }

    .portfolio-section .filter-btns li.active{
	background: <?php echo esc_attr($portfolio_opt['btn_active_bg_color']); ?> !important; 
	color: <?php echo esc_attr($portfolio_opt['btn_hvr_text_color']); ?> !important;}

    .portfolio-section .filter-btns li:hover {
	background: <?php echo esc_attr($portfolio_opt['btn_hover_bg_color']); ?>;
	color: <?php echo esc_attr($portfolio_opt['btn_hvr_text_color']); ?>; }

    /* Portfolio Item */
    .portfolio-block-one .image-box,
    .portfolio-details .upper-box .image,
    .portfolio-details .image-content .image {
	background: <?php echo esc_attr($portfolio_opt['overlay_bg_color']); ?>;;}

    </style>
    <!-- .#Portfolio Style Data -->
<?php 

return ob_get_clean(); // End Shortcode content
}
add_shortcode( 'bPortfolio', 'bppf_shortcode' );

// CUSTOM POST TYPE
function bppf_post_type()
{
    $labels = array(
        'name'                  => __('bPortfolio', 'bportfolio'),
        'menu_name'             => __('bPortfolio', 'bportfolio'),
        'name_admin_bar'        => __('bPortfolio', 'bportfolio'),
        'add_new'               => __('Add New', 'bportfolio'),
        'add_new_item'          => __('Add New ', 'bportfolio'),
        'new_item'              => __('New Portfolio ', 'bportfolio'),
        'edit_item'             => __('Edit Portfolio ', 'bportfolio'),
        'view_item'             => __('View Portfolio ', 'bportfolio'),
        'all_items'             => __('All Portfolios', 'bportfolio'),
        'not_found'             => __('Sorry, we couldn\'t find the Feed you are looking for.')
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __('Portfolio Options.', 'bportfolio'),
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-format-image',
        'query_var'          => true,
        'rewrite'            => array('slug' => 'portfolio'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'publicly_queryable' => true,
        'hierarchical'       => true,
        'menu_position'      => 20,
        'supports'           => array('title', 'thumbnail'),
    );
    register_post_type('bportfolio', $args);

    // Register Taxonomy
	$labels = array(
		'name'              => _x( 'Portfolio Categories', 'taxonomy general name', 'bportfolio' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'bportfolio' ),
		'search_items'      => __( 'Search Portfolio Categories', 'bportfolio' ),
		'all_items'         => __( 'All Portfolio Categories', 'bportfolio' ),
		'parent_item'       => __( 'Parent Portfolio Category', 'bportfolio' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'bportfolio' ),
		'edit_item'         => __( 'Edit Portfolio Category', 'bportfolio' ),
		'update_item'       => __( 'Update Portfolio Category', 'bportfolio' ),
		'add_new_item'      => __( 'Add New Portfolio Category', 'bportfolio' ),
		'new_item_name'     => __( 'New Portfolio Category Name', 'bportfolio' ),
		'menu_name'         => __( 'Category', 'bportfolio' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Taxonomy for bportfolio plugin', 'bportfolio' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
	);
	register_taxonomy( 'bportfolio_cat', array('bportfolio'), $args );
}
add_action('init', 'bppf_post_type');

// CUSTOM POST TYPE FOR SHORTCODE GENERATOR
function bppf_post_type_for_shortcode()
{
    $labels = array(
        'name'                  => __('Portfolio Shortcode', 'bportfolio'),
        'menu_name'             => __('Portfolio Shortcode', 'bportfolio'),
        'name_admin_bar'        => __('Portfolio Shortcode', 'bportfolio'),
        'add_new'               => __('Add New Shortcode', 'bportfolio'),
        'add_new_item'          => __('Add New Shortcode ', 'bportfolio'),
        'new_item'              => __('New Portfolio Shortcode ', 'bportfolio'),
        'edit_item'             => __('Edit Portfolio Shortcode ', 'bportfolio'),
        'view_item'             => __('View Portfolio Shortcode ', 'bportfolio'),
        'all_items'             => __('Shortcodes', 'bportfolio'),
        'not_found'             => __('Sorry, we couldn\'t find the Feed you are looking for.')
    );
    $args = array(
        'labels'             => $labels,
        'description'        => __('Shortcode Options.', 'bportfolio'),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=bportfolio',
        'query_var'          => true,
        'rewrite'            => array('slug' => 'shortcode-gen'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_icon'          => 'dashicons-shortcode',
        'menu_position'      => 25,
        'supports'           => array('title'),
    );
    register_post_type('shortcode-generator', $args);

}
add_action('init', 'bppf_post_type_for_shortcode');

// Give Support single-custom post support
add_filter( 'single_template', 'override_single_template', 20 );
function override_single_template( $single_template ){
    global $post;
    $file = dirname(__FILE__) .'/single-'. $post->post_type .'.php';

    if( file_exists( $file ) ) $single_template = $file;
    return $single_template;
}


// Change 'set feature image' to 'Custom Text'
function bppf_post_thumbnail( $content ) {
    return $content = str_replace( __( 'Set featured image' ), __( 'Portfolio Thumbnail' ), $content); 
}
add_filter( 'admin_post_thumbnail_html', 'bppf_post_thumbnail' );


//
/*-------------------------------------------------------------------------------*/
/*   Include External Files
/*-------------------------------------------------------------------------------*/

// Option panel
require_once 'inc/codestar/csf-config.php';
require_once 'admin/ads/submenu.php';
if( class_exists( 'CSF' )) {
    require_once 'inc/bportfolio-options.php';
    require_once 'inc/bportfolio-shortcode.php';
    require_once 'inc/bportfolio-settings.php';
}

//
/*-------------------------------------------------------------------------------*/
/*   Additional Features
/*-------------------------------------------------------------------------------*/

// Hide & Disabled View, Quick Edit and Preview Button 
function bppf_remove_row_actions($idtions)
{
    global $post;
    if ($post->post_type == 'bportfolio' || 'shortcode-generator' ) {
        unset($idtions['view']);
        unset($idtions['inline hide-if-no-js']);
    }
    return $idtions;
}

if (is_admin()) {
    add_filter('post_row_actions', 'bppf_remove_row_actions', 10, 2);
}

// HIDE everything in PUBLISH metabox except Move to Trash & PUBLISH button
function bppf_hide_publishing_actions()
{
    $my_post_type = 'bportfolio' || 'shortcode-generator';
    global $post;
    if ($post->post_type == $my_post_type) {
        echo '
            <style type="text/css">
                #misc-publishing-actions,
                #minor-publishing-actions{
                    display:none;
                }
            </style>
        ';
    }
}
add_action('admin_head-post.php', 'bppf_hide_publishing_actions');
add_action('admin_head-post-new.php', 'bppf_hide_publishing_actions');

/*-------------------------------------------------------------------------------*/
// Remove post update massage and link 
/*-------------------------------------------------------------------------------*/

function bppf_updated_messages($messages)
{
    $messages['bportfolio'][1] = __('Portfolio Item updated ', 'bportfolio');
    $messages['shortcode-generator'][1] = __('Shortcode updated  ', 'bportfolio');
    return $messages;
}
add_filter('post_updated_messages', 'bppf_updated_messages');

/*-------------------------------------------------------------------------------*/
/* Change publish button to save.
/*-------------------------------------------------------------------------------*/
add_filter('gettext', 'bppf_change_publish_button', 10, 2);
function bppf_change_publish_button($translation, $text)
{
    if ('bportfolio' == get_post_type() || 'shortcode-generator' == get_post_type())
        if ($text == 'Publish')
            return 'Save';

    return $translation;
}

/*-------------------------------------------------------------------------------*/
/* Footer Review Request .
/*-------------------------------------------------------------------------------*/

add_filter('admin_footer_text', 'bppf_admin_footer');
function bppf_admin_footer($text)
{
    if ('bportfolio' || 'shortcode-generator' == get_post_type()) {
        $url = 'https://wordpress.org/plugins/bportfolio/reviews/?filter=5#new-post';
        $text = sprintf(__('If you like <strong> bPortfolio </strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'bportfolio'), $url);
    }
    return $text;
}

/*-------------------------------------------------------------------------------*/
/* Shortcode Generator area  .
/*-------------------------------------------------------------------------------*/

add_action('edit_form_after_title', 'bppf_shortcode_area');
function bppf_shortcode_area()
{
    global $post;
    if ($post->post_type == 'shortcode-generator') : ?>

        <div class="shortcode_gen">
            <label for="bppf_shortcode"><?php esc_html_e('Copy this shortcode and paste it into your post, page, text widget content  or custom-template.php', 'bportfolio') ?>:</label>

            <?php 
            
            echo '<span><input type="text" onfocus="this.select();" readonly="readonly" value="[bPortfolio id=&quot;'. esc_attr($post->ID) .'&quot;]"></span><span>
            <input type="text" onfocus="this.select();" readonly="readonly" value="&#60;&#63;php echo do_shortcode( &#39;[bPortfolio id=&quot;'. esc_attr($post->ID).'&quot;]&#39; ); &#63;&#62;" class="large-text code tlp-code-sc">
            </span>';
            ;
            ?>

        </div>
<?php endif; }


// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
add_filter('manage_shortcode-generator_posts_columns', 'bportfolio_columns_head_only', 10);
add_action('manage_shortcode-generator_posts_custom_column', 'bportfolio_columns_content_only', 10, 2);


// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
    function bportfolio_columns_head_only($defaults) {
        unset($defaults['date']);
        $defaults['directors_name'] = 'ShortCode';
        $defaults['date'] = 'Date';
        return $defaults;
    }

    function bportfolio_columns_content_only($column_name, $post_ID) {
        if ($column_name == 'directors_name') {
            echo '<div class="bportfolio_front_shortcode"><input onfocus="this.select();" style="text-align: center; border: none; outline: none; background-color: #1e8cbe; color: #fff; padding: 4px 10px; border-radius: 3px;" value="[bPortfolio  id='."'".esc_attr($post_ID)."'".']" ></div>';
    }
}

// After activation redirect
function bppf_plugin_activate() {
	add_option('bppf_plugin_do_activation_redirect', true);
}
register_activation_hook(__FILE__, 'bppf_plugin_activate');

function bppf_plugin_redirect() {
    if (get_option('bppf_plugin_do_activation_redirect', false)) {
        delete_option('bppf_plugin_do_activation_redirect');
        wp_redirect('edit.php?post_type=bportfolio&page=bppf-support');
    }
}
add_action('admin_init', 'bppf_plugin_redirect');
