<?php
/**
 * Title: Sektion - Werden Sie Mitglied
 * Slug: eliashof/section-foerderverein-mitglied
 * Categories: eliashof-sections
 * Description: Section explaining membership options with text on the left and image on the right.
 */
?>
<!-- wp:group {"align":"full","anchor":"werden-sie-mitglied","className":"eliashof-section bg-graph-green section-foerderverein-mitglied","layout":{"type":"constrained"}} -->
<div id="werden-sie-mitglied" class="wp-block-group alignfull eliashof-section bg-graph-green section-foerderverein-mitglied">

	<!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		
		<!-- Left Column: Content -->
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">WERDEN SIE MITGLIED</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"mitglied-highlight-text"} -->
			<p class="mitglied-highlight-text">Für nur 30 € im Jahr können Sie Mitglied werden:</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"mitglied-text"} -->
			<p class="mitglied-text"><strong>Stilles Mitglied:</strong> Sie unterstützen unsere Arbeit mit Ihrer jährlichen Spende in Höhe von 30 € und bekommen regelmäßige Updates über unsere Aktivitäten.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"mitglied-text"} -->
			<p class="mitglied-text"><strong>Aktives Mitglied:</strong> Zusätzlich nehmen Sie an unseren Treffen teil, bringen Ideen ein, planen und gestalten das Schulleben aktiv mit.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- Right Column: Image -->
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-section-image"} -->
			<figure class="wp-block-image size-full eliashof-section-image"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/img_0575.jpg" alt="Werden Sie Mitglied" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
