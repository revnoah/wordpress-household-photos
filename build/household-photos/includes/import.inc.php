 <?php

/**
 * Import photos from folder defined in settings
 *
 * @return integer
 */
function household_photos_import(): int {
	$imported = household_photos_import_folder('');

	return $imported;
}

/**
 * Import photos from folder
 *
 * @param string $foldername
 * @return integer
 */
function household_photos_import_folder(string $foldername): int {
	$photo_path = get_option('household_photos_photo_path');
	$folder = 'wp-content/' . $photo_path . $foldername;

	echo 'checking folder: ' . $folder;
	$files = household_photos_import_folder_items($folder);

	foreach ($files as $file) {
		$file_id = household_photos_add_photo($file['path'] . '/' . $file['filename']);

		if ($file_id > 0) {
			echo 'Added file: ' . $file['filename'];
		}
	}

	return count($files);
}

/**
 * Get items in import
 *
 * @param string $folder
 * @return array
 */
function household_photos_import_folder_items(string $folder): array {
	$files = [];

	if (!is_dir(get_home_path() . $folder)) {
		return $files;
	}

	if ($dh = opendir(get_home_path() .$folder)) {
		while (($file = readdir($dh)) !== false) {
			if ($file[0] == '.') {
				continue;
			}

			if (is_dir(get_home_path() . $folder . '/' . $file)) {
				$folder_files = household_photos_import_folder_items($folder . '/' . $file);
				$files = array_merge($files, $folder_files);
			} else {
				$files[] = [
					'filename' => $file,
					'path' => $folder
				];
			}
		}
		closedir($dh);
	}

	return $files;
}
