<?php
/**
 * Title: Ansprechpartner / Kontakte
 * Slug: eliashof/ansprechpartner
 * Categories: eliashof-startseite
 * Description: Four organic portrait cards with name and role. White background. Layout locked.
 */
?>
<!-- wp:group {"align":"full","anchor":"ansprechpartner","className":"eliashof-section section-ansprechpartner bg-graph-white","layout":{"type":"constrained"}} -->
<div id="ansprechpartner" class="wp-block-group alignfull eliashof-section section-ansprechpartner bg-graph-white">

	<!-- wp:heading {"level":2,"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">IHRE ANSPRECHPARTNER</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"verticalAlignment":"top"} -->
	<div class="wp-block-columns are-vertically-aligned-top">

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"templateLock":"contentOnly","className":"eliashof-contact-card card-sekretariat","layout":{"type":"constrained"}} -->
			<div class="wp-block-group eliashof-contact-card card-sekretariat">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration01.svg"} -->
				<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration01.svg" alt="Sekretariat Platzhalter" /></figure>
				<!-- /wp:image -->
				<!-- wp:heading {"level":4,"textAlign":"center"} -->
				<h4 class="wp-block-heading has-text-align-center">FRAU NEUMANN</h4>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textAlign":"center"} -->
				<p class="has-text-align-center contact-role">SEKRETARIAT</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"templateLock":"contentOnly","className":"eliashof-contact-card card-schulleitung","layout":{"type":"constrained"}} -->
			<div class="wp-block-group eliashof-contact-card card-schulleitung">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration02.svg"} -->
				<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration02.svg" alt="Schulleitung Platzhalter" /></figure>
				<!-- /wp:image -->
				<!-- wp:heading {"level":4,"textAlign":"center"} -->
				<h4 class="wp-block-heading has-text-align-center">ARMIN GEISSLER</h4>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textAlign":"center"} -->
				<p class="has-text-align-center contact-role">SCHULDIREKTOR</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"templateLock":"contentOnly","className":"eliashof-contact-card card-hortleitung","layout":{"type":"constrained"}} -->
			<div class="wp-block-group eliashof-contact-card card-hortleitung">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration04.svg"} -->
				<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration04.svg" alt="Hortleitung Platzhalter" /></figure>
				<!-- /wp:image -->
				<!-- wp:heading {"level":4,"textAlign":"center"} -->
				<h4 class="wp-block-heading has-text-align-center">HERR SEGETH</h4>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textAlign":"center"} -->
				<p class="has-text-align-center contact-role">LEITUNG HORT/SPB</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"templateLock":"contentOnly","className":"eliashof-contact-card card-schulhund","layout":{"type":"constrained"}} -->
			<div class="wp-block-group eliashof-contact-card card-schulhund">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg"} -->
				<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Schulhund Platzhalter" /></figure>
				<!-- /wp:image -->
				<!-- wp:heading {"level":4,"textAlign":"center"} -->
				<h4 class="wp-block-heading has-text-align-center">MAJA</h4>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textAlign":"center"} -->
				<p class="has-text-align-center contact-role">SCHULHUND</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
