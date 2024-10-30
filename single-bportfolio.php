    <?php 

        get_header();

        // FUNCTION FOR SHOWING PORTFOLIO CATEGORY
        function portfolio_category($id) {
            $categories = get_the_terms( $id, 'bportfolio_cat'); 
            $cat_list = join(', ', wp_list_pluck( $categories, 'name' ) );
            echo esc_html($cat_list);
        }
        // OPTION DATA FOR PORTFOLIO SETTINGS 
        $portfolio_settings = get_option('_bppfsettings_');
        // POST LOOP
        if( have_posts() ) :
            while(have_posts()) : the_post(); 
            $portfolio_metas = get_post_meta( get_the_ID(), '_bportfolio_', true );
    ?>

    <!-- portfolio-details -->
    <section class="portfolio-details">
        <div class="upper-box">
        <?php if( isset($portfolio_metas['project_screenshot']) && !empty($portfolio_metas['project_screenshot'])): ?>

            <div class="outer-container">
                <div class="two-column-carousel owl-carousel owl-dots-none owl-nav-none">

                    <?php 
                        // PROJECT SCREENSHOTS
                        $project_screenshots= explode( ',', $portfolio_metas['project_screenshot'] );
                        foreach( $project_screenshots as $screenshot_id ) {
                        $image_src_id = wp_get_attachment_image_src($screenshot_id, 'full', false);
                        echo '<figure class="image"><a data-fancybox="gallery" data-src="'.esc_url($image_src_id[0]).'" class="lightbox-image">
                                    <img src="'.esc_url($image_src_id[0]).'" alt="project-screenshot"></a>
                            </figure>';
                        }
                    ?>

                </div>
            </div>
        <?php endif; ?>

        </div>

        <div class="lower-box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-sm-12 image-column">
                        <div class="image-content">

                            <div class="title-box">
                                <span><?php portfolio_category(get_the_ID()); ?></span>
                                <h2><?php the_title(); ?></h2>
                            </div>

                            <?php
                                // POST THUMBNAIL
                            if( has_post_thumbnail()) {
                                    $portfolio_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full', false ); ?>

                                <div class="image-box wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                                    <figure class="image">
                                        <a data-fancybox="gallery" data-src="<?php echo esc_url($portfolio_thumb[0]); ?>"
                                            class="lightbox-image" >
                                            <img src="<?php echo esc_url($portfolio_thumb[0]); ?>" alt="project-thumb">
                                        </a>
                                    </figure>
                                </div>

                            <?php  }  ?>

                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12 content-column">
                    <?php if( isset($portfolio_metas) && !empty($portfolio_metas) ): ?>
                        <div class="content-box">
                            <h5><?php echo esc_html($portfolio_metas['project_dsc_heading']); ?></h5>
                            <div class="text">
                                <p><?php echo esc_html($portfolio_metas['project_dsc']); ?></p>
                            </div>
                            <ul class="info-list clearfix">
                                <li><span>Client</span><?php echo esc_html($portfolio_metas['client_name']); ?></li>
                                <li><span>Date</span><?php echo esc_html($portfolio_metas['project_date']); ?></li>
                                <li><span>Categories</span><?php portfolio_category(get_the_ID()); ?></li>
                                <li><span>Live demo</span><a href="<?php echo esc_html($portfolio_metas['project_link']); ?>"><?php echo esc_url($portfolio_metas['project_link']); ?></a></li>
                            </ul>
                            <ul class="social-icons">
                                <?php 

                                if( isset($portfolio_settings['facebook_link']) && !empty($portfolio_settings['facebook_link']) ) {
                                    echo '<li><a href="'.esc_url($portfolio_settings['facebook_link']).'"><i class="fab fa-facebook-square"></i></a></li>';
                                }

                                if( isset($portfolio_settings['twitter_link']) && !empty($portfolio_settings['twitter_link']) ) {
                                    echo '<li><a href="'.esc_url($portfolio_settings['twitter_link']).'"><i class="fab fa-twitter-square"></i></a></li>';
                                }

                                if( isset($portfolio_settings['linkedin_link']) && !empty($portfolio_settings['linkedin_link']) ) {
                                    echo '<li><a href="'.esc_url($portfolio_settings['linkedin_link']).'"><i class="fab fa-linkedin"></i></a></li>';
                                }

                                if( isset($portfolio_settings['dribble_link']) && !empty($portfolio_settings['dribble_link']) ) {
                                    echo '<li><a href="'.esc_url($portfolio_settings['dribble_link']).'"><i class="fab fa-dribbble-square"></i></a></li>';
                                }

                                if( isset($portfolio_settings['behance_link']) && !empty($portfolio_settings['behance_link']) ) {
                                    echo '<li><a href="'.esc_url($portfolio_settings['behance_link']).'"><i class="fab fa-behance"></i></a></li>';
                                }

                                if( isset($portfolio_settings['pinterest_link']) && !empty($portfolio_settings['pinterest_link']) ) {
                                    echo '<li><a href="'.esc_url($portfolio_settings['pinterest_link']).'"><i class="fab fa-pinterest-square"></i></a></li>';
                                } 
                            ?>
 
                            </ul>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="load-more-option">
                    <div class="clearfix">
                        <div class="prev-btn pull-left">
                            <?php previous_post_link('%link', '<i class="fa fa-arrow-left"></i> '.   $portfolio_settings['pagi_prev_txt'] ); ?>               
                        </div>
                        <div class="next-btn pull-right">
                            <?php next_post_link('%link', $portfolio_settings['pagi_next_txt'] .' <i class="fa fa-arrow-right"></i>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- portfolio-details end -->

    <style>
    /* Portfolio Item */
    .portfolio-block-one .image-box,
    .portfolio-details .upper-box .image,
    .portfolio-details .image-content .image {
	background: <?php echo esc_attr($portfolio_settings['overlay_bg_color']); ?>;}

    .portfolio-details .load-more-option a {
	color: <?php echo esc_attr($portfolio_settings['pagination_txt_color']); ?>;}
    .portfolio-details .load-more-option a:hover {
	color: <?php echo esc_attr($portfolio_settings['pagination_txt_hover']); ?>;}
    </style>
    
<?php endwhile; wp_reset_query(); ?>
<?php endif; ?>


<!-- main-footer -->
 <?php get_footer(); ?>