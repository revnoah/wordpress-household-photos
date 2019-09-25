<?php

/**
 * Define settings fields
 *
 * @return array
 */
function household_photos_settings_fields() {
	$settings = [
		'id' => 'household_photos',
		'kabob' => 'household-photos',
		'label' => __('Household Photos'),
		'settings' => [
			[
				'id' => 'household_photos_photo_path',
				'label' => __('Photo Path'),
				'description' => 
					__('Photo path, relative to the wp-content folder'),
				'type' => 'text'
			], [
				'id' => 'household_photos_add_user_name',
				'label' => __('Add Username'),
				'description' => 
					__('Add a class to the body tag for the current user\'s username'),
				'type' => 'boolean',
				'default' => false
			], [
				'id' => 'household_photos_add_user_id',
				'label' => __('Add User ID'),
				'description' => 
					__('Add a class to the body tag for the current user\'s ID'),
				'type' => 'boolean',
				'default' => false
			], [
				'id' => 'household_photos_active_frontend',
				'label' => __('Active On Frontend'),
				'description' => 
					__('Active on the frontend of the website'),
				'type' => 'boolean',
				'default' => false
			], [
				'id' => 'household_photos_active_admin',
				'label' => __('Active On Backend/Admin'),
				'description' => 
					__('Active on the backend or admin pages'),
				'type' => 'boolean',
				'default' => true
			]
		]
	];

	return $settings;
}

/**
 * action admin_menu
 */
add_action('admin_menu', 'household_photos_create_menu');

/**
 * Create admin menu item
 *
 * @return void
 */
function household_photos_create_menu() {
	add_submenu_page(
		'options-general.php',
		'Household Photos',
		'Household Photos',
		'administrator',
		__FILE__,
		'household_photos_admin',
		plugins_url('/images/icon.png', __FILE__)
	);
}

/**
 * action admin_init
 */
add_action('admin_init', 'household_photos_settings');

/**
 * Register custom settings
 *
 * @return void
 */
function household_photos_settings() {
	$settings = household_photos_settings_fields();

	//register settings
	foreach ($settings['settings'] as $setting) {
		register_setting($settings['kabob'] . '-settings-group', $setting['id']);
	}	
}

/**
 * Admin settings
 *
 * @return void
 */
function household_photos_admin() {
	//load user settings
	$settings = household_photos_settings_fields();
	?>
	<div class="wrap">
	<h1><?php echo $settings['label']; ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields($settings['kabob'] . '-settings-group'); ?>
		<?php do_settings_sections($settings['kabob'] . '-settings-group'); ?>

		<table class="form-table">
			<?php
			foreach ($settings['settings'] as $setting) {
				$setting['saved'] = get_option($setting['id'], $setting['default']);
				echo household_photos_get_formatted_field($setting);
				?>
			<?php
			}
			?>
		</table>

		<?php submit_button(); ?>
	</form>

</div>
<?php
}
