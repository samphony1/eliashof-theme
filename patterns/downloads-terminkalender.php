<?php
/**
 * Title: Downloads & Terminkalender
 * Slug: eliashof/downloads-terminkalender
 * Categories: eliashof-startseite
 * Description: Two-column section on an orange background — Downloads left, Terminkalender right. Layout locked.
 */

$downloads_url      = function_exists( 'eliashof_get_permalink_by_slug' ) ? eliashof_get_permalink_by_slug( 'downloads' ) : '';
$terminkalender_url = function_exists( 'eliashof_get_permalink_by_slug' ) ? eliashof_get_permalink_by_slug( 'terminkalender' ) : '';
$downloads_url      = $downloads_url ? $downloads_url : '#';
$terminkalender_url = $terminkalender_url ? $terminkalender_url : '#';
?>
<!-- wp:group {"align":"full","anchor":"downloads-terminkalender","templateLock":"contentOnly","className":"eliashof-section section-downloads bg-graph-orange","layout":{"type":"constrained"}} -->
<div id="downloads-terminkalender" class="wp-block-group alignfull eliashof-section section-downloads bg-graph-orange">

	<!-- wp:columns {"align":"wide","verticalAlignment":"center"} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">

		<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"eliashof-grid-text"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-grid-text" style="flex-basis:50%">
			<!-- wp:heading {"level":2,"textAlign":"center"} -->
			<h2 class="wp-block-heading has-text-align-center">DOWNLOADS</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Hier finden Sie eine Sammlung aller Downloads: von „A“ wie Abmeldung bis „S“ wie Schulplatzanfrage.</p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="wp-block-buttons">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $downloads_url ); ?>">HIER ENTLANG</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"eliashof-grid-text"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-grid-text" style="flex-basis:50%">
			<!-- wp:heading {"level":2,"textAlign":"center"} -->
			<h2 class="wp-block-heading has-text-align-center">TERMINKALENDER</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Alle Termine des laufenden Schuljahres gibt es gesammelt und zum Abonnieren hier.</p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="wp-block-buttons">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $terminkalender_url ); ?>">HIER ENTLANG</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
