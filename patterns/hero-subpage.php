<?php
/**
 * Title: Subpage Hero (Unsere Schule)
 * Slug: eliashof/hero-subpage
 * Categories: eliashof-sections
 * Description: Header section for subpages with an image on the left, title on the right, and illustration.
 */
?>
<!-- wp:group {"align":"full","className":"eliashof-subpage-hero bg-graph-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull eliashof-subpage-hero bg-graph-blue">
	<div class="eliashof-subpage-hero-container">
		
		<!-- Left column: Image -->
		<div class="eliashof-subpage-hero-image-col">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-subpage-featured-img"} -->
			<figure class="wp-block-image size-full eliashof-subpage-featured-img"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/unsere-schule-hero.png" alt="Unsere Schule" /></figure>
			<!-- /wp:image -->
		</div>
		
		<!-- Right column: Title and Illustration -->
		<div class="eliashof-subpage-hero-content-col">
			<!-- wp:heading {"level":1,"className":"eliashof-subpage-title"} -->
			<h1 class="wp-block-heading eliashof-subpage-title">DIE GRUNDSCHULE IM ELIASHOF – EIN STANDORT MIT VIELEN STÄRKEN</h1>
			<!-- /wp:heading -->
			
			<div class="eliashof-subpage-hero-illustration">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration" />
			</div>
		</div>
		
	</div>
</div>
<!-- /wp:group -->
