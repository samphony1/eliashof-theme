<?php
/**
 * Title: Höhepunkte (SPB)
 * Slug: eliashof/section-spb-hoehepunkte
 * Categories: eliashof-spb-hort
 * Description: Dynamisches SPB-Beitragskarussell mit organisch maskierten Beitragsbildern.
 * Keywords: SPB, Höhepunkte, Beiträge, Karussell
 */

$highlight_cat    = get_category_by_slug( 'highlight' );
$highlight_cat_id = $highlight_cat ? $highlight_cat->term_id : 0;
?>
<!-- wp:group {"align":"full","anchor":"spb-hoehepunkte","templateLock":"contentOnly","className":"eliashof-section eliashof-aktuelles eliashof-spb-hoehepunkte","style":{"color":{"background":"#9DE4F9"}},"layout":{"type":"constrained"}} -->
<div id="spb-hoehepunkte" class="wp-block-group alignfull eliashof-section eliashof-aktuelles eliashof-spb-hoehepunkte has-background" style="background-color:#9DE4F9">

	<!-- wp:heading {"level":2,"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">HÖHEPUNKTE</h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":4,"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo (int) $highlight_cat_id; ?>]}},"className":"eliashof-aktuelles-carousel eliashof-spb-hoehepunkte__carousel","layout":{"type":"default"}} -->
	<div class="wp-block-query eliashof-aktuelles-carousel eliashof-spb-hoehepunkte__carousel">
		<!-- wp:post-template -->
			<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:post-featured-image {"isLink":false,"sizeSlug":"large","className":"eliashof-spb-hoehepunkte__image"} /-->
				<!-- wp:post-title {"level":3,"textAlign":"center","isLink":false,"className":"eliashof-card-title"} /-->
				<!-- wp:post-excerpt {"excerptLength":20} /-->
				<!-- wp:read-more {"content":"MEHR","className":"wp-block-button__link wp-element-button"} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Aktuell sind keine SPB-Höhepunkte vorhanden.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
