<?php
/**
 * Plugin Name:       Friendly Image Titles
 * Contributors:	  MikeHale
 * Description:       Automatically adds a friendly image Title and ALT tag based on image filename.
 * Version:           1.0
 * Author:            Mike Hale
 * Author URI:        http://www.mikehale.me/
 * Text Domain:       friendly-image-titles
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_filter( 'add_attachment', 'set_image_title_alt' );

function set_image_title_alt( $post_id ) {
	// only do this for images
	if ( wp_attachment_is_image( $post_id ) ) {
		
		// get current post title
		$attachment = get_post( $post_id );
		if ( ! $attachment ) {
			return;
		}
		$title = $attachment->post_title;

		// replace , _ or . and apply Title Casing 
		$delimiters = array( '.', '-', '_' );
		$friendly_title = ucwords( str_replace( $delimiters, ' ', strtolower( $title ) ) );

		// save title
		$attachment->post_title = $friendly_title;
		wp_update_post( $attachment );

		// save ALT
		update_post_meta( $post_id, '_wp_attachment_image_alt', $friendly_title );
	}
}
?>