<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

echo ' page name: ' . $pagename;
echo ' album: ' . $album;

print_r($errors);

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<div class="alert alert-error">
	<?php		
	foreach ($errors as $error) {
		echo '<p>' . $error . '</p>';
	}
	?>
	</div>

	<article class="post type-post status-publish format-standard hentry category-uncategorized entry">
			<header class="entry-header">
				<h2 class="entry-title">Household Photos</h2>
			</header>
			<div class="entry-content">
				<p class="description text-muted">
					Getting ready to display your household photos.
				</p>
				<?php
					// Include the page content template.
					household_photos_get_template_part('household-photos', 'content');
				?>
			</div>
		</article>

	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>