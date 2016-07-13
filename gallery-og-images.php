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

function gogi_og_images_from_attachments() {
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

function gogi_og_images_from_gallery() {
    global $post;
 
    if( is_singular() ) {
        
        $post_content = $post->post_content;
    	preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
    	$image_ids = explode(",", $ids[1]);
        
        if ( $image_ids ) {
            foreach ( $image_ids as $image_id ) {
                $image = wp_get_attachment_url( $image_id );
                echo '<meta property="og:image" content="'. $image .'"/>'. PHP_EOL;
            }
        }
    }    
}

add_action('wp_head', 'gogi_og_images_from_gallery', 1);
