<?php
/**
 * @package HouseholdPhotos
 * @version 1.0.0
 */

/*
Plugin Name: Household Photos
Plugin URI: http://householdphotos.com/
Description: Plugin to manage and share private photo albums
Author: Noah Stewart
Version: 1.0.0
Author URI: http://householdphotos.com/
*/

//define constants for plugin
define("PLUGIN_DIR", __DIR__);

//load required includes
require_once realpath(__DIR__) . '/includes/helpers.inc.php';
require_once realpath(__DIR__) . '/includes/createdb.inc.php';
require_once realpath(__DIR__) . '/includes/form.inc.php';
require_once realpath(__DIR__) . '/includes/permissions.inc.php';
require_once realpath(__DIR__) . '/includes/photos.inc.php';
require_once realpath(__DIR__) . '/includes/import.inc.php';
require_once realpath(__DIR__) . '/includes/admin.inc.php';

//register rewrite hook
register_activation_hook(__FILE__, 'household_photos_rewrite_activation');
register_activation_hook( __FILE__, 'household_photos_create_db');
register_deactivation_hook(__FILE__, 'household_photos_rewrite_activation');

/**
 * Handle rewrite rules
 *
 * @return void
 */
function household_photos_rewrite_activation() {
	flush_rewrite_rules();
}

add_action('init', 'household_photos_rewrite_add_rewrites');
//add_action('init', 'household_photos_stylesheet');

/**
 * Add rewrites
 *
 * @return void
 */
function household_photos_rewrite_add_rewrites() {
  add_rewrite_rule(
	'household-photos/([^/]+)/?',
	'index.php?pagename=household-photos&album=$matches[1]',
	'top'
  );
}

add_action('wp_enqueue_scripts', 'household_photos_scripts');

/**
 * Load plugin scripts
 *
 * @return void
 */
function household_photos_scripts() {
	wp_enqueue_style('household-photos-style', site_url() . '/wp-content/plugins/household-photos/css/style.min.css');
	wp_enqueue_script('household-photos-script', site_url() . '/wp-content/plugins/household-photos/js/script.js', array('jquery'));
}

/**
 * Redirect page template
 *
 * @param [type] $template
 * @return void
 */
function household_photos_redirect_page_template($template) {
	$template_name = 'page-household-photos.php';

	if ($template_name == basename($template)) {
		$template = __DIR__ . '/templates/' . $template_name;
	}

	return $template;
}

/**
 * add page template filter
 */
add_filter ('page_template', 'household_photos_redirect_page_template');

//filter for query vars passed to index.php
add_filter('query_vars', 'household_photos_query_vars');

/**
 * Handle query params
 *
 * @param array $vars Query vars
 * @return array
 */
function household_photos_query_vars(array $vars): array {
  $vars[] = 'album';

  return $vars;
}

// load custom template, generate image and redirect based on query vars
add_action('template_redirect', 'household_photos_catch_vars');

/**
 * Core page functionality
 *
 * @return void
 */
function household_photos_catch_vars(): void {
	global $wpdb, $wp_query, $errors;
	$current_user = wp_get_current_user();
	$template_file = '';
	session_start();

	$pagename = get_query_var('pagename');
	$album = get_query_var('album');
	$errors = [];
 
	if ($pagename !== 'household-photos') {
		return;
	}

	$template_name = 'page-household-photos.php';
	$template_path = household_photos_locate_template([$template_name], true);
}
