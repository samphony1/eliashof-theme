<?php
/**
 * Title: Blog Hero
 * Slug: eliashof/hero-blog
 * Categories: eliashof-sections
 * Description: Header section for single blog posts with featured image on the left, post title on the right, and illustration.
 */
?>
<!-- wp:group {"align":"full","className":"eliashof-subpage-hero bg-graph-blue","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull eliashof-subpage-hero bg-graph-blue">
	<div class="eliashof-subpage-hero-container">
		
		<!-- Left column: Featured Image -->
		<div class="eliashof-subpage-hero-image-col">
			<!-- wp:post-featured-image {"className":"eliashof-subpage-featured-img"} /-->
		</div>
		
		<!-- Right column: Title and Illustration -->
		<div class="eliashof-subpage-hero-content-col">
			<!-- wp:post-title {"level":1,"className":"eliashof-subpage-title"} /-->
			
			<div class="eliashof-subpage-hero-illustration">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration" />
			</div>
		</div>
		
	</div>
</div>
<!-- /wp:group -->
