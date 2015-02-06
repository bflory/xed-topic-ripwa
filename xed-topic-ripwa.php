<?php
/*
	Plugin Name: GPS KonnectED Prospecting Topic - Retirement Income Planning with Annuities
	Author: Bryce Flory
	Author URI: http://gradientps.com
	Description: Retirement Income Planning with Annuities Topic
	Version: 1.1
*/

// Create Topic on Activation
function ripwa_create_topic() {

	xed_topic_post_type();
	
	require('lib/topic.php');
	require('lib/topic-meta.php');

	$post_id = wp_insert_post($topic, $wp_error);
	foreach ($topic_meta as $topic_meta_title => $topic_meta_options) {
		if($topic['post_title'] == $topic_meta_title) {
			foreach ($topic_meta_options as $key => $value) {
				add_post_meta($post_id, $key, $value);
			}
		}
	}
	// Flush rewrite rules on activation
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ripwa_create_topic');

// Remove Topic on Deactivation
function ripwa_remove_topic() {
	require('lib/topic.php');
	
	$post = get_page_by_title($topic['post_title'], OBJECT, 'topic');
	wp_delete_post($post->ID, TRUE);

	// Flush rewrite rules on deactivation
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'ripwa_remove_topic');