<?php

/**
 * Get permissions to view invite statement
 *
 * @param string $slug Unique slug
 * @return boolean
 */
function household_photos_get_permissions($album_id) {
	global $wpdb;

	$current_user = wp_get_current_user();
	if (!session_id()) {
		session_start();
	}

	if ($slug !== '' && $_SESSION['slug'] == $slug) {
		return true;
	}

	$sql = "SELECT * FROM {$wpdb->prefix}household_photos_users AS iulu 
		INNER JOIN {$wpdb->prefix}household_photos iul ON iul.invitation_id = iulu.ID
		WHERE user_id = %d";

	$invite = $wpdb->get_row(
		$wpdb->prepare($sql, $current_user->ID)
	);

	$sql = "SELECT * FROM {$wpdb->prefix}household_photos WHERE slug = %s";
	$invite = $wpdb->get_row(
		$wpdb->prepare($sql, $slug)
	);

	return false;
}

/**
 * Add permission to view last image created by referencing the slug
 *
 * @param string $slug Unique string md5 encoded
 * @return void
 */
function household_photos_add_permission($slug) {
	if (!session_id()) {
		session_start();
	}

	$_SESSION['slug'] = $slug;        
}
