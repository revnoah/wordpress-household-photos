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
