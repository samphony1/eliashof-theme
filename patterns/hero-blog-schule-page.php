<?php
/**
 * Title: Hero (Unsere Schule - Seite)
 * Slug: eliashof/hero-blog-schule-page
 * Categories: eliashof-sections
 * Description: Editable header section for the Schule page with featured image on the left, custom heading on the right, and illustration.
 */
?>
<!-- wp:group {"align":"full","anchor":"hero-blog-schule-page","className":"eliashof-hero-blog-schule bg-graph-blue eliashof-hero-blog-schule-page","layout":{"type":"constrained"}} -->
<div id="hero-blog-schule-page" class="wp-block-group alignfull eliashof-hero-blog-schule bg-graph-blue eliashof-hero-blog-schule-page">

	<!-- wp:group {"className":"eliashof-hero-blog-schule-container","layout":{"type":"default"}} -->
	<div class="wp-block-group eliashof-hero-blog-schule-container">
		
		<!-- Left column: Featured Image -->
		<!-- wp:group {"className":"eliashof-hero-blog-schule-image-col","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-image-col">
			
			<!-- wp:group {"className":"eliashof-hero-blog-schule-featured-img-container","layout":{"type":"default"}} -->
			<div class="wp-block-group eliashof-hero-blog-schule-featured-img-container">
				<!-- wp:post-featured-image {"className":"eliashof-hero-blog-schule-featured-img"} /-->
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->
		
		<!-- Right column: Title -->
		<!-- wp:group {"className":"eliashof-hero-blog-schule-content-col","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-content-col">
			<!-- wp:heading {"level":1,"placeholder":"Titel eingeben...","className":"eliashof-hero-blog-schule-title"} -->
			<h1 class="wp-block-heading eliashof-hero-blog-schule-title">UNSERE SCHULE</h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		
		<!-- Illustration (anchored bottom right) -->
		<!-- wp:group {"className":"eliashof-hero-blog-schule-illustration","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-illustration">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg"} -->
			<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
