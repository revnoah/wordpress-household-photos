<?php

/**
 * Define settings fields
 *
 * @return array
 */
function household_photos_settings_fields() {
	global $wp_roles;
	
	$roles = $wp_roles->roles;

	$items = [
		[
			'id' => 'household_photos_photo_path',
			'label' => __('Photo Path'),
			'description' => 
				__('Photo path, relative to the wp-content folder'),
			'type' => 'text'
		],
		[
			'id' => 'household_photos_thumb_path',
			'label' => __('Thumbnail Path'),
			'description' => 
				__('Thumbnail path, relative to the wp-content folder'),
			'type' => 'text'
		]
	];
	foreach ($roles as $key => $role) {
		$items[] = [
			'id' => 'household_photos_role_' . $key,
			'label' => $role['name'],
			'type' => 'boolean',
			'description' => 
				__('Visible to users with the ' . $role['name'] . ' role'),
		];
	}

	$settings = [
		'id' => 'household_photos',
		'kabob' => 'household-photos',
		'label' => __('Household Photos'),
		'settings' => $items
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
	add_menu_page(
		'Household Photos',
		'Household Photos',
		'administrator',
		'household-photos',
		'household_photos_admin'
	);

	add_submenu_page(
		'household-photos',
		'Photo Albums',
		'Photo Albums',
		'administrator',
		'household-photos-albums',
		'household_photos_albums'
	);

	add_submenu_page(
		'household-photos',
		'Import Photos',
		'Import Photos',
		'administrator',
		'household-photos-import',
		'household_photos_import'
	);

	/*
	add_submenu_page(
		'options-general.php',
		'Household Photos',
		'Household Photos',
		'administrator',
		__FILE__,
		'household_photos_admin',
		plugins_url('/images/icon.png', __FILE__)
	);
	*/
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
