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

//load required includes
require_once realpath(__DIR__) . '/includes/helpers.inc.php';
require_once realpath(__DIR__) . '/includes/createdb.inc.php';
require_once realpath(__DIR__) . '/includes/form.inc.php';
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
function household_photos_rewrite_activation(){
	flush_rewrite_rules();
}

