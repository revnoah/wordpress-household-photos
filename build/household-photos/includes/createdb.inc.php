<?php
/**
 * Create database tables
 *
 * @return void
 */
function household_photos_create_db() {
	global $wpdb;
	$version = get_option( 'householdphotos_version', '1.0.0' );
	$charset_collate = $wpdb->get_charset_collate();
  $table_photos_photos = $wpdb->prefix . 'household_photos_photos';
  $table_photos_albums = $wpdb->prefix . 'household_photos_albums';
  $table_photos_album_photo = $wpdb->prefix . 'household_photos_album_photo';

	$sql = "CREATE TABLE $table_photos_photos (
		ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    filename varchar(255) NOT NULL,
    title varchar(255) NOT NULL,
    description TEXT NULL,
    location varchar(80) NULL,
    lat decimal(10, 8) NULL DEFAULT 0,
    lng decimal(11, 8) NULL DEFAULT 0,
    active tinyint(1) NOT NULL DEFAULT 0,
    created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated timestamp NULL,
		UNIQUE KEY id (ID)
  ) $charset_collate;
  CREATE TABLE $table_photos_albums (
    ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    description TEXT NULL,
    active tinyint(1) NOT NULL DEFAULT 0,
    created timestamp DEFAULT CURRENT_TIMESTAMP,
		UNIQUE KEY id (ID)
  ) $charset_collate;
  CREATE TABLE $table_photos_album_photo (
    ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    photo_id bigint(20) unsigned NOT NULL,
    album_id bigint(20) unsigned NOT NULL,
    featured tinyint(1) unsigned NOT NULL DEFAULT 0,
    created timestamp DEFAULT CURRENT_TIMESTAMP,
		UNIQUE KEY id (ID),
    CONSTRAINT fk_household_photos_photo_id
      FOREIGN KEY (photo_id)
      REFERENCES {$table_photos_photos}(ID)
      ON DELETE CASCADE,
    CONSTRAINT fk_household_photos_album_id
      FOREIGN KEY (album_id)
      REFERENCES {$table_photos_albums}(ID)
      ON DELETE CASCADE    
  ) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

