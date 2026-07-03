<?php
/**
 * Title: Sektion - Was wir tun
 * Slug: eliashof/section-was-wir-tun
 * Categories: eliashof-sections
 * Description: Section for the Förderverein page detailing what we do, with image on the left and description text on the right.
 */
?>
<!-- wp:group {"align":"full","anchor":"was-wir-tun","className":"eliashof-section bg-graph-orange section-was-wir-tun","layout":{"type":"constrained"}} -->
<div id="was-wir-tun" class="wp-block-group alignfull eliashof-section bg-graph-orange section-was-wir-tun">

	<!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		
		<!-- Left Column: Image -->
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-section-image"} -->
			<figure class="wp-block-image size-full eliashof-section-image"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Foerderverein-Stand-Sommerfest.jpg" alt="Förderverein Stand beim Sommerfest" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- Right Column: Description -->
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">WAS WIR TUN</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Als Förderverein unterstützen wir die Schule bei vielen Vorhaben und Veranstaltungen. Wir organisieren Feste, finanzieren zusätzliche Unterrichtsmaterialien und fördern Projekte, die das Schulleben bereichern.<br><br>Dazu gehören das alljährliche Sommerfest, Anschaffungen für die Pausengestaltung und die Unterstützung von Schul-AGs. Alle Projekte werden in enger Abstimmung mit der Schulleitung und der Elternvertretung umgesetzt.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
