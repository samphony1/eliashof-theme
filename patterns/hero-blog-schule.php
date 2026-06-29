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
	<div class="eliashof-hero-blog-schule-container">
		
		<!-- Left column: Featured Image -->
		<div class="eliashof-hero-blog-schule-image-col">
			<div class="eliashof-hero-blog-schule-featured-img-container">
				<!-- wp:post-featured-image {"className":"eliashof-hero-blog-schule-featured-img"} /-->
			</div>
		</div>
		
		<!-- Right column: Title -->
		<div class="eliashof-hero-blog-schule-content-col">
			<!-- wp:post-title {"level":1,"className":"eliashof-hero-blog-schule-title"} /-->
		</div>
		
		<!-- Illustration (anchored bottom right) -->
		<div class="eliashof-hero-blog-schule-illustration">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration" />
		</div>
		
	</div>
</div>
<!-- /wp:group -->
