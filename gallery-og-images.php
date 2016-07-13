<?php
/*
Plugin Name: Gallery Open Graph Images
Version: 0.1
Description: A short plugin for generating open graph image meta tags from gallery shortcode
Author: Dave Kim
Author URI: http://www.usefulparadigm.com
Plugin URI: http://wpguide.usefulparadigm.com
Text Domain: gallery-og-images
Domain Path: /languages
*/

function gogi_fb_og_images() {
    global $post;
 
    if( is_singular() ) {
        
        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID,
            'exclude' => get_post_thumbnail_id(), // excludeing featured image
            'orderby' => 'menu_order',
        ) );
        
        if ( $attachments ) {
            foreach ( $attachments as $attachment ) {
                $image = wp_get_attachment_url( $attachment->ID );
                echo '<meta property="og:image" content="'. $image .'"/>'. PHP_EOL;
            }
        }
    }    
}
add_action('wp_head', 'gogi_fb_og_images', 1);
