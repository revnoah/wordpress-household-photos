Photos go here...

<?php

echo ' content page name: ' . $pagename;
echo ' content album: ' . $album;

$photos = household_photos_photos();

?>

<div class="container">
    <div class="row">
    <?php
    foreach ($photos as $photo) {
        ?>
    <div class="col-md-4">
    <div class="card mb-4 shadow-sm">
        <div class="card-image" style="background-image: url('<?php 
            echo get_site_url() . '/' . household_photos_get_thumbnail($photo['filename']); 
        ?>');">
        <a href="<?php
            echo get_site_url() . household_photos_get_photo($photo['filename']); 
        ?>" title="View Fullscreen" rel="lightbox"><?php echo $photo['title'] == '' ? $photo['filename'] : $photo['title']; ?></a>
        </div>
        <div class="card-body">
        <h4 class="card-text"><?php echo $photo['title']; ?></h4>
        <p class="card-text"><?php echo $photo['description']; ?></p>
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Like</button>
            </div>
            <small class="text-muted"><?php echo $photo['created']; ?></small>
        </div>
        </div>
    </div>
    </div>
        <?php
    }
    ?>
    </div>
</div>
<?php

?>

