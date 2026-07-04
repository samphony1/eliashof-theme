<?php
/**
 * Title: Hero (Förderverein - Seite)
 * Slug: eliashof/hero-blog-foerderverein
 * Categories: eliashof-sections
 * Description: Editable header section for the Förderverein page with featured image on the left, custom heading on the right, and balloon illustration.
 */
?>
<!-- wp:group {"align":"full","anchor":"hero-blog-foerderverein","className":"eliashof-hero-blog-schule bg-graph-blue eliashof-hero-blog-foerderverein","layout":{"type":"constrained"}} -->
<div id="hero-blog-foerderverein" class="wp-block-group alignfull eliashof-hero-blog-schule bg-graph-blue eliashof-hero-blog-foerderverein">

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
			<h1 class="wp-block-heading eliashof-hero-blog-schule-title">UNSER<br>FÖRDERVEREIN</h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		
		<!-- Balloon Illustration (spans over sections) -->
		<!-- wp:group {"className":"eliashof-hero-blog-schule-illustration eliashof-hero-foerderverein-balloon","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-illustration eliashof-hero-foerderverein-balloon">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Balloon.svg","className":"eliashof-balloon-desktop"} -->
			<figure class="wp-block-image size-full eliashof-balloon-desktop"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Balloon.svg" alt="Balloon" /></figure>
			<!-- /wp:image -->
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Balloon.svg","className":"eliashof-balloon-mobile"} -->
			<figure class="wp-block-image size-full eliashof-balloon-mobile"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Balloon.svg" alt="Balloon" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
