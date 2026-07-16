<?php
/**
 * Title: Sektion - Downloads & Vorstand
 * Slug: eliashof/section-foerderverein-vorstand
 * Categories: eliashof-foerderverein
 * Description: Section for the Förderverein page with download links on the left and board members on the right.
 */

$downloads_url = function_exists( 'eliashof_get_permalink_by_slug' ) ? eliashof_get_permalink_by_slug( 'downloads' ) : '';
$downloads_url = $downloads_url ? $downloads_url : '#';
?>
<!-- wp:group {"align":"full","anchor":"downloads-vorstand","className":"eliashof-section bg-graph-green section-foerderverein-vorstand","layout":{"type":"constrained"}} -->
<div id="downloads-vorstand" class="wp-block-group alignfull eliashof-section bg-graph-green section-foerderverein-vorstand">

	<!-- wp:columns {"align":"wide","verticalAlignment":"center"} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">

		<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"eliashof-grid-text foerderverein-downloads-column"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-grid-text foerderverein-downloads-column" style="flex-basis:50%">
			<!-- wp:heading {"level":2,"textAlign":"center"} -->
			<h2 class="wp-block-heading has-text-align-center">DOWNLOADS</h2>
			<!-- /wp:heading -->

			<!-- wp:buttons {"className":"foerderverein-downloads-buttons","layout":{"type":"flex","justifyContent":"center"}} -->
			<div class="wp-block-buttons foerderverein-downloads-buttons">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $downloads_url ); ?>">HIER ENTLANG</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"eliashof-grid-text foerderverein-vorstand-column"} -->
		<div class="wp-block-column is-vertically-aligned-center eliashof-grid-text foerderverein-vorstand-column" style="flex-basis:50%">
			<!-- wp:heading {"level":2,"textAlign":"center"} -->
			<h2 class="wp-block-heading has-text-align-center">UNSER VORSTAND</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center","className":"foerderverein-vorstand-copy"} -->
			<p class="has-text-align-center foerderverein-vorstand-copy">Vorsitz: Sandra Naumann<br>Stellvertretender Vorsitzender: Marco Kirsch<br>Kassenwärtin: Mia</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
