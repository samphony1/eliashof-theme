<?php
/**
 * Title: Seite Unsere Schule
 * Slug: eliashof/page-unsere-schule
 * Categories: eliashof-sections
 * Description: Complete layout for the "Unsere Schule" subpage including hero, transparent textbox, and Über Uns grid rows.
 */
?>
<!-- wp:pattern {"slug":"eliashof/hero-blog-schule"} /-->

<!-- wp:group {"align":"full","className":"bg-graph-green","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull bg-graph-green">
	
	<!-- wp:group {"className":"eliashof-transparent-card","layout":{"type":"default"}} -->
	<div class="wp-block-group eliashof-transparent-card">
		<!-- wp:paragraph -->
		<p>Die Vorbereitung unserer Schülerinnen und Schüler auf das Leben hat für uns zentrale Bedeutung. Unsere pädagogische Arbeit zielt daher immer auch darauf, die Fähigkeiten zum eigenständigen Handeln zu fördern. Wir ermutigen die Kinder zur Übernahme von Verantwortung und bieten Raum zur Mitgestaltung des Schullebens.</p>
		<!-- /wp:paragraph -->
		
		<!-- wp:paragraph -->
		<p>Unsere Schule ist personell und materiell sehr gut aufgestellt. Es stehen Fachräume für Nawi und die Computernutzung zur Verfügung. Es gibt zudem Tablets in Klassenstärke. Digitale Medien ergänzen an unserer Schule sinnvoll den klassischen Unterricht.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:heading {"level":2,"className":"eliashof-section-title"} -->
	<h2 class="wp-block-heading eliashof-section-title">Über unsere Schule</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"verticalAlignment":"center","className":"eliashof-grid-row"} -->
	<div class="wp-block-columns are-vertically-aligned-center eliashof-grid-row">
		<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"eliashof-grid-text"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-grid-text" style="flex-basis:50%">
			<!-- wp:paragraph -->
			<p>Der Schulalltag im Eliashof ist geprägt von Vertrauen, Toleranz und gegenseitiger Wertschätzung. Unsere pädagogische Arbeit zielt darauf ab, die Stärken jedes einzelnen Kindes zu fördern und es auf seinem Lernweg zu begleiten.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>Wir arbeiten eng mit den Eltern zusammen, um eine optimale Lernumgebung zu schaffen. Gemeinsam gestalten wir das Schulleben aktiv und zukunftsorientiert.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:group {"className":"eliashof-rounded-img-container","layout":{"type":"default"}} -->
			<div class="wp-block-group eliashof-rounded-img-container">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
				<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/unsere-schule-hero.png" alt="Klassenzimmer" /></figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"verticalAlignment":"center","className":"eliashof-grid-row"} -->
	<div class="wp-block-columns are-vertically-aligned-center eliashof-grid-row">
		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:group {"className":"eliashof-rounded-img-container","layout":{"type":"default"}} -->
			<div class="wp-block-group eliashof-rounded-img-container">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->
				<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/unsere-schule-hero.png" alt="Schulhof" /></figure>
				<!-- /wp:image -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"eliashof-grid-text"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-grid-text" style="flex-basis:50%">
			<!-- wp:paragraph -->
			<p>Wir bieten unseren Schülerinnen und Schülern ein vielfältiges Angebot an Arbeitsgemeinschaften und Projekten, in denen sie ihre Interessen vertiefen können.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>Unser Außengelände bietet zudem zahlreiche Möglichkeiten für Bewegung, Spiel und soziales Lernen in den Pausen.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
