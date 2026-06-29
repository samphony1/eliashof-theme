<?php
/**
 * Title: Hero (Blog & Schule)
 * Slug: eliashof/hero-blog-schule
 * Categories: eliashof-sections
 * Description: Header section for single blog posts and subpages with featured image on the left, post title on the right, and illustration.
 */
?>
<!-- wp:group {"align":"full","className":"eliashof-hero-blog-schule bg-graph-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull eliashof-hero-blog-schule bg-graph-blue">

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
			<!-- wp:post-title {"level":1,"className":"eliashof-hero-blog-schule-title"} /-->
		</div>
		<!-- /wp:group -->
		
		<!-- Illustration (anchored bottom right) -->
		<!-- wp:group {"className":"eliashof-hero-blog-schule-illustration","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-illustration">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
