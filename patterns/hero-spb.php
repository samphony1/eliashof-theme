<?php
/**
 * Title: Hero SPB
 * Slug: eliashof/hero-spb
 * Categories: eliashof-spb-hort
 * Description: Bearbeitbarer Hero für SPB/Hort mit Beitragsbild, Überschrift, Illustration und frei wählbarer Theme-Farbe mit Multiply-Overlay.
 */
?>
<!-- wp:group {"align":"full","anchor":"hero-spb","className":"eliashof-hero-blog-schule eliashof-hero-blog-schule-page eliashof-hero-spb bg-graph-blue","layout":{"type":"constrained"}} -->
<div id="hero-spb" class="wp-block-group alignfull eliashof-hero-blog-schule eliashof-hero-blog-schule-page eliashof-hero-spb bg-graph-blue">

	<!-- wp:group {"className":"eliashof-hero-blog-schule-container","layout":{"type":"default"}} -->
	<div class="wp-block-group eliashof-hero-blog-schule-container">

		<!-- wp:group {"className":"eliashof-hero-blog-schule-image-col","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-image-col">
			<!-- wp:group {"className":"eliashof-hero-blog-schule-featured-img-container","layout":{"type":"default"}} -->
			<div class="wp-block-group eliashof-hero-blog-schule-featured-img-container">
				<!-- wp:post-featured-image {"className":"eliashof-hero-blog-schule-featured-img"} /-->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"eliashof-hero-blog-schule-content-col","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-content-col">
			<!-- wp:heading {"level":1,"placeholder":"Titel eingeben...","className":"eliashof-hero-blog-schule-title"} -->
			<h1 class="wp-block-heading eliashof-hero-blog-schule-title">UNSER HORT – GEMEINSAM SPIELEN, ENTDECKEN UND DEN NACHMITTAG GESTALTEN</h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"eliashof-hero-blog-schule-illustration","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-hero-blog-schule-illustration">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg"} -->
			<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration mit Kindern" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
