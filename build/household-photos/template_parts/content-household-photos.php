Photos go here...

<?php

echo ' content page name: ' . $pagename;
echo ' content album: ' . $album;

$photos = household_photos_photos();
print_r($photos);

?>