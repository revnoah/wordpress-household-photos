<?php

/**
 * Get photo album
 *
 * @param integer $album_id
 * @return array
 */
function household_photos_album(int $album_id): array {
	global $wpdb;

	$tablename = $wpdb->prefix . 'household_photos_albums';

	$sql = 'SELECT * FROM ' . $tablename . ' WHERE ID = ' . $album_id;
	$album = $wpdb->get_row($sql, ARRAY_A);

	return $album;
}

/**
 * Get photos in an album
 *
 * @param integer $album_id
 * @param integer $start
 * @param integer $num
 * @return iterable
 */
function household_photos_photos(int $album_id = 0, int $start = 0, int $num = 10): iterable {
	global $wpdb;

	$tablename = $wpdb->prefix . 'household_photos_photos';

	$sql = 'SELECT * FROM ' . $tablename;
	if ($album_id > 0) {
		$sql .= ' WHERE album_id = ' . $album_id;
	}
	$sql .= ' LIMIT ' . $num . ' OFFSET ' . $start;
	
	$photos = $wpdb->get_results($sql, ARRAY_A);

	return $photos;
}

/**
 * Add photo
 *
 * @param string $filename
 * @param string $title
 * @return int|void
 */
function household_photos_add_photo(string $filename): ?int {
	global $wpdb;

	$tablename = $wpdb->prefix . 'household_photos_photos';
	$data = [
		'filename' => $filename
	];
	$format = ['%s'];

	$sql = 'SELECT ID FROM ' . $tablename . ' WHERE filename = ' . $filename;
	$photo_id = $wpdb->get_col($sql);

	if (!$photo_id) {
		return $wpdb->insert($tablename, $data, $format);
	}
}

/**
 * Get photo
 *
 * @param string $filename
 * @return string
 */
function household_photos_get_photo(string $filename): string {
	$photo_path = get_option('household_photos_photo_path');

	return '/wp-content/' . $photo_path . '/' . $filename;
}

/**
 * Get photo thumbnail, existing or create new
 *
 * @param string $filename
 * @return string
 */
function household_photos_get_thumbnail(string $filename): string {
	$photo_path = get_option('household_photos_photo_path');
	$thumb_path = get_option('household_photos_thumb_path');

	$newwidth = 320; //$width/5;
	$newheight = 280; //$height/5;
	
	$filepath = 'wp-content/' . $photo_path . '/' . $filename;
	$thumbpath = 'wp-content/' . $thumb_path . '/' . $filename;

	$image_info = getimagesize(ABSPATH . $filepath);
	$image_type = $image_info['mime'];
	list($width, $height) = getimagesize(ABSPATH . $filepath);

	$source = household_photos_read_image(ABSPATH . $filepath, $image_type);

	$destination = imagecreatetruecolor($newwidth, $newheight);
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	household_photos_save_image($destination, $thumbpath, $image_type);
	imagedestroy($destination);

	return $thumbpath;
}

/**
 * Read image from file path
 *
 * @param string $filepath
 * @param string $image_type
 * @return void
 */
function household_photos_read_image(string $filepath, string $image_type) {
	if ($image_type == 'image/jpeg') {
		$source = imagecreatefromjpeg($filepath);
	} elseif ($image_type == 'image/png') {
		$source = imagecreatefrompng($filepath);
	}

	return $source;
}

/**
 * Save image to file path
 *
 * @param [type] $data
 * @param string $filepath
 * @param string $image_type
 * @return boolean
 */
function household_photos_save_image($data, string $filepath, string $image_type): bool {
	if ($image_type == 'image/jpeg') {
		return imagejpeg($data, $filepath, 65);	
	} elseif ($image_type == 'image/png') {
		return imagepng($data, $filepath);
	}

	return false;
}
