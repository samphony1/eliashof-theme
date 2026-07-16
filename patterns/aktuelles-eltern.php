<?php
/**
 * Title: Aktuelles (Eltern)
 * Slug: eliashof/aktuelles-eltern
 * Categories: eliashof-eltern
 * Description: News Carousel filtered for the Eltern category.
 */

$eltern_cat = get_category_by_slug('eltern');
$eltern_cat_id = $eltern_cat ? $eltern_cat->term_id : 0;
?>
<!-- wp:group {"align":"full","anchor":"aktuelles-eltern","templateLock":"contentOnly","className":"eliashof-section eliashof-aktuelles","style":{"color":{"background":"#9DE4F9"},"spacing":{"padding":{"top":"clamp(60px,8vw,100px)","bottom":"clamp(60px,8vw,100px)"}}},"layout":{"type":"constrained"}} -->
<div id="aktuelles-eltern" class="wp-block-group alignfull eliashof-section eliashof-aktuelles has-background" style="background-color:#9DE4F9;padding-top:clamp(60px,8vw,100px);padding-bottom:clamp(60px,8vw,100px)">

	<!-- wp:heading {"level":2,"textAlign":"center","style":{"spacing":{"margin":{"top":"0","bottom":"52px"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="margin-top:0;margin-bottom:52px">AKTUELLES FÜR ELTERN</h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":2,"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[<?php echo (int) $eltern_cat_id; ?>]}},"className":"eliashof-aktuelles-carousel","layout":{"type":"default"}} -->
	<div class="wp-block-query eliashof-aktuelles-carousel">

		<!-- wp:post-template -->
			<!-- wp:group {"style":{"spacing":{"blockGap":"33px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->
			<div class="wp-block-group">

				<!-- wp:post-title {"level":3,"textAlign":"center","isLink":false,"className":"eliashof-card-title","style":{"typography":{"fontFamily":"'Neucha', cursive","fontSize":"36px","letterSpacing":"0.05em","lineHeight":"1.1","textTransform":"uppercase"},"color":{"text":"#000000"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->

				<!-- wp:post-excerpt {"excerptLength":20,"style":{"typography":{"fontFamily":"'Montserrat', sans-serif","fontWeight":"300","fontSize":"24px","lineHeight":"1.4"},"color":{"text":"#000000"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->

				<!-- wp:read-more {"content":"MEHR","className":"wp-block-button__link wp-element-button"} /-->

			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
		<!-- wp:paragraph {"style":{"typography":{"fontFamily":"'Montserrat', sans-serif","fontWeight":"300","fontSize":"24px"},"color":{"text":"#000000"},"spacing":{"padding":{"left":"clamp(24px,6vw,100px)","right":"clamp(24px,6vw,100px)"}}}} -->
		<p style="color:#000000;font-family:'Montserrat',sans-serif;font-size:24px;font-weight:300;padding-left:clamp(24px,6vw,100px);padding-right:clamp(24px,6vw,100px)">Aktuell sind keine Beiträge vorhanden.</p>
		<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->

	</div>
	<!-- /wp:query -->

</div>
<!-- /wp:group -->
