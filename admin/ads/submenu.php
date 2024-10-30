<?php
/**
 * Register and enqueue a custom stylesheet in the WordPress admin.
 */
function bppf_enqueue_custom_admin_style() {
    wp_register_style( 'bppf_admin_custom_css', plugin_dir_url(__FILE__) . 'style.css', false, '1.0.0' );
    wp_enqueue_style( 'bppf_admin_custom_css' );
}
add_action( 'admin_enqueue_scripts', 'bppf_enqueue_custom_admin_style' );

//-----------------------------------------------
// Helps 
//-----------------------------------------------


add_action('admin_menu', 'bppf_support_page');

function bppf_support_page()
{
    add_submenu_page('edit.php?post_type=bportfolio', 'Help ', 'Help', 'manage_options', 'bppf-support', 'bppf_support_page_callback');
}

function bppf_support_page_callback()
{
    ?>
    <div class="bplugins-container">
        <div class="row">
            <div class="bplugins-features">
                <div class="col col-12">
                    <div class="bplugins-feature center">
                        <div style="background:white;overflow:hidden;">
                            <div style="width:128px;heigh:128px;overflow:hidden;float:left;">
                                <img src="https://ps.w.org/bportfolio/assets/icon-128x128.png?rev=2618720" alt="Logo" width="100" height="100">
                            </div>
                            <div style="float:left; overflow:hidden;text-align:left;">
                                <h1><?php echo esc_html__('Thanks for Installing bPortfolio.', 'bportfolio'); ?></h1>
                                <p> <?php echo esc_html__('Please follow the links below to get some helpful resources.', 'bportfolio'); ?></p>
                            </div>
                        </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="bplugins-container">
    <div class="row">
        <div class="bplugins-features">
            <div class="col col-4">
                <div class="bplugins-feature center">
                    <i class="fa fa-life-ring"></i>
                    <h3>Need any Assistance?</h3>
                    <p>Our Expert Support Team is always ready to help you out promptly.</p>
                    <a href="https://bplugins.com/support/" target="_blank" class="button
                    button-primary">Contact Support</a>
                </div>
            </div>
            <div class="col col-4">
                <div class="bplugins-feature center">
                    <i class="fa fa-file-text"></i>
                    <h3>Looking for Documentation?</h3>
                    <p>We have detailed documentation on every aspects of the plugin.</p>
                    <a href="https://wordpress.org/plugins/bportfolio/#description" target="_blank" class="button button-primary">Documentation</a>
                </div>
            </div>

            <div class="col col-4">
                <div class="bplugins-feature center">
                    <i class="fa fa-thumbs-up"></i>
                    <h3>Liked This Plugin?</h3>
                    <p>Glad to know that, you can support us by leaving a 5 &#11088; rating.</p>
                    <a href="https://wordpress.org/support/plugin/bportfolio/reviews/#new-post" target="_blank" class="button
                    button-primary">Rate the Plugin</a>
                </div>
            </div>            
        </div>
    </div>
</div>

<div class="bplugins-container">
    <div class="row">
        <div class="bplugins-features">
            <div class="col col-12">
                <div class="bplugins-feature center">
                    <h1>Video Tutorials</h1><br/>
                    <div class="embed-container"><iframe width="100%" height="700px" src="https://www.youtube.com/embed/oAV34KgoDHY" frameborder="0"
                    allowfullscreen></iframe></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}




