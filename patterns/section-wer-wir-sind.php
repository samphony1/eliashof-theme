<?php
/**
 * Title: Sektion - Wer wir sind
 * Slug: eliashof/section-wer-wir-sind
 * Categories: eliashof-sections
 * Description: Section for the Förderverein page detailing who we are, with description text on the left and the cyan T-shirt badge on the right.
 */
?>
<!-- wp:group {"align":"full","anchor":"wer-wir-sind","className":"eliashof-section bg-transparent section-wer-wir-sind","layout":{"type":"constrained"}} -->
<div id="wer-wir-sind" class="wp-block-group alignfull eliashof-section bg-transparent section-wer-wir-sind">

	<!-- wp:columns {"verticalAlignment":"center","className":"eliashof-wer-wir-sind-columns"} -->
	<div class="wp-block-columns are-vertically-aligned-center eliashof-wer-wir-sind-columns">
		
		<!-- Left Column: Description -->
		<!-- wp:column {"verticalAlignment":"center","width":"60%","className":"eliashof-wer-wir-sind-text-col"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-wer-wir-sind-text-col" style="flex-basis:60%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">WER WIR SIND</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Wir sind Eltern, Lehrkräfte, Erzieherinnen und Erzieher sowie Freunde unserer Schule. Gemeinsam engagieren wir uns dafür, den Kindern die bestmöglichen Voraussetzungen für eine erfolgreiche und schöne Schulzeit zu bieten.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- Right Column: T-Shirt Blurp Badge -->
		<!-- wp:column {"verticalAlignment":"center","width":"40%","className":"eliashof-wer-wir-sind-badge-col"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-wer-wir-sind-badge-col" style="flex-basis:40%">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-tshirt-badge"} -->
			<figure class="wp-block-image size-full eliashof-tshirt-badge"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/Blurp-T-Shirt.svg" alt="Jetzt anmelden - Ein kostenloses T-Shirt bekommen" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
