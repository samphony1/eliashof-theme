<?php
/**
 * Title: Sektion - Unsere Treffen
 * Slug: eliashof/section-foerderverein-treffen
 * Categories: eliashof-sections
 * Description: Section for Förderverein page showing meeting schedule and contact details, with floating badge.
 */
?>
<!-- wp:group {"align":"full","anchor":"unsere-treffen","className":"eliashof-section section-highlight section-foerderverein-treffen","layout":{"type":"constrained"}} -->
<div id="unsere-treffen" class="wp-block-group alignfull eliashof-section section-highlight section-foerderverein-treffen">

	<!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center">
		
		<!-- Left Column: Treffen -->
		<!-- wp:column {"verticalAlignment":"top","width":"50%","className":"eliashof-grid-text"} -->
		<div class="wp-block-column is-vertically-aligned-top eliashof-grid-text" style="flex-basis:50%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">UNSERE TREFFEN</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Zur Verwirklichung unserer Ideen treffen wir uns alle sechs Wochen um 19:30 Uhr in der <strong>Pizzeria „Zoe“ in der Senefelderstrasse</strong>. Die Termine werden den Mitgliedern hier und per Mail bekannt gegeben und hängen im Eingangsbereich des Hortes am schwarzen Brett.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"className":"treffen-highlight-text"} -->
			<p class="treffen-highlight-text">NÄCHSTES TREFFEN: 24.06.26, 19:30 UHR</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- Right Column: Kontakt & Spenden -->
		<!-- wp:column {"verticalAlignment":"top","width":"50%","className":"eliashof-grid-text"} -->
		<div class="wp-block-column is-vertically-aligned-top eliashof-grid-text" style="flex-basis:50%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">KONTAKT</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><a href="mailto:foerderverein@eliashof.net">foerderverein@eliashof.net</a></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"style":{"spacing":{"margin":{"top":"40px"}}}} -->
			<h2 class="wp-block-heading" style="margin-top:40px">SPENDENKONTO</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><strong>Förderverein Grundschule im Eliashof e.V.</strong><br>IBAN: DE51 1005 0000 0191 339687<br>Berliner Sparkasse</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

	<!-- Floating Badge overlay -->
	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-treffen-badge"} -->
	<figure class="wp-block-image size-full eliashof-treffen-badge"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/Blurp-Wir%20foerdern%20Zukunft.svg' ); ?>" alt="Wir fördern Zukunft" /></figure>
	<!-- /wp:image -->

</div>
<!-- /wp:group -->
