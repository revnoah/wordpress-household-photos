<?php

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
		'Enhanced Body Class',
		'Enhanced Body Class',
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
 * Get settings fields
 *
 * @return array
 */
function _household_photos_settings_fields() {
	$settings = [
		'household_photos_add_roles',
		'household_photos_add_user_name',
		'household_photos_add_user_id',
		'household_photos_active_frontend',
		'household_photos_active_admin'
	];

	return $settings;
}

/**
 * Register custom settings
 *
 * @return void
 */
function household_photos_settings() {
	$settings = _household_photos_settings_fields();

	//register settings
	foreach ($settings as $setting) {
		register_setting('enhanced-body-class-settings-group', $setting);
	}
}

/**
 * Admin settings
 *
 * @return void
 */
function household_photos_admin() {
	//load user settings
	$household_photos_add_roles = get_option(
		'household_photos_add_roles', true
	);
	$household_photos_add_user_name = get_option(
		'household_photos_add_user_name', false
	);
	$household_photos_add_user_id = get_option(
		'household_photos_add_user_id', false
	);
	$household_photos_active_frontend = get_option(
		'household_photos_active_frontend', false
	);
	$household_photos_active_admin = get_option(
		'household_photos_active_admin', true
	);
	?>
	<div class="wrap">
	<h1><?php echo __('Enhanced Body Class'); ?></h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'enhanced-body-class-settings-group' ); ?>
		<?php do_settings_sections( 'enhanced-body-class-settings-group' ); ?>

		<h2><?php echo __('Enhanced Styles') ?></h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php echo __('Add User Role'); ?></th>
				<td>
					<input type="checkbox" 
						id="household_photos_add_roles" 
						name="household_photos_add_roles" 
						<?php echo ($household_photos_add_roles === 'on') ? 'checked' : ''; ?> 
					/>
					<br /><small><?php 
						echo __('Add a class to the body tag for the current user\'s role'); 
					?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo __('Add Username'); ?></th>
				<td>
					<input type="checkbox" 
						id="household_photos_add_user_name" 
						name="household_photos_add_user_name" 
						<?php 
							echo ($household_photos_add_user_name === 'on') 
								? 'checked' 
								: ''; 
						?>
					/>
					<br /><small><?php 
						echo __('Add a class to the body tag for the current user\'s username'); 
					?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo __('Add User ID'); ?></th>
				<td>
					<input type="checkbox" 
						id="household_photos_add_user_id" 
						name="household_photos_add_user_id" 
						<?php 
							echo ($household_photos_add_user_id === 'on') 
								? 'checked' 
								: ''; 
						?> 
					/>
					<br /><small><?php 
						echo __('Add a class to the body tag for the current user\'s ID'); 
					?></small>
				</td>
			</tr>
		</table>

		<h2><?php echo __('Visibility') ?></h2>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php echo __('Front End'); ?></th>
				<td>
					<input type="checkbox" 
						id="household_photos_active_frontend" 
						name="household_photos_active_frontend" 
						<?php 
							echo ($household_photos_active_frontend === 'on') ? 'checked' : ''; 
						?> 
					/>
					<br /><small><?php 
						echo __('Visibility on the frontend can affect website caching'); 
					?></small>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php echo __('Admin'); ?></th>
				<td>
					<input type="checkbox" 
						id="household_photos_active_admin" 
						name="household_photos_active_admin" 
						<?php 
							echo ($household_photos_active_admin === 'on') 
								? 'checked' 
								: ''; 
						?> 
					/>
					<br /><small><?php 
						echo __('Visibility on the backend or admin pages'); 
					?></small>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>

</div>
<?php
}
