<?php
/**
 * Title: Hero (Eltern)
 * Slug: eliashof/hero-blog-eltern
 * Categories: eliashof-sections
 * Description: Header section for subpages with featured image on the left, post title on the right, and illustration 04.
 */
?>
<!-- wp:group {"align":"full","anchor":"hero-blog-eltern","className":"eliashof-hero-blog-schule bg-graph-yellow eliashof-hero-blog-eltern","layout":{"type":"constrained"}} -->
<div id="hero-blog-eltern" class="wp-block-group alignfull eliashof-hero-blog-schule bg-graph-yellow eliashof-hero-blog-eltern">

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
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration04.svg"} -->
			<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration04.svg" alt="Illustration" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
