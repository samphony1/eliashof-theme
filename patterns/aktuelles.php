<?php
/**
 * Title: Aktuelles / News Carousel
 * Slug: eliashof/aktuelles
 * Categories: eliashof-sections
 * Description: Live Query Loop carousel. Editors set post type and tag in the block sidebar. Card layout is locked — only query parameters are configurable.
 */
?>
<!-- wp:group {"align":"full","className":"eliashof-section eliashof-aktuelles","style":{"color":{"background":"#8cc8d1"},"spacing":{"padding":{"top":"clamp(60px,8vw,100px)","bottom":"clamp(60px,8vw,100px)"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull eliashof-section eliashof-aktuelles has-background" style="background-color:#8cc8d1;padding-top:clamp(60px,8vw,100px);padding-bottom:clamp(60px,8vw,100px)">

	<!-- wp:heading {"level":2,"textAlign":"center","style":{"typography":{"fontFamily":"'Neucha', cursive","fontSize":"50px","letterSpacing":"2.5px","lineHeight":"1.2","textTransform":"uppercase"},"color":{"text":"#241f21"},"spacing":{"margin":{"top":"0","bottom":"52px"}}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="color:#241f21;font-family:'Neucha',cursive;font-size:50px;letter-spacing:2.5px;line-height:1.2;text-transform:uppercase;margin-top:0;margin-bottom:52px">AKTUELLES</h2>
	<!-- /wp:heading -->

	<!-- wp:query {"queryId":1,"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"className":"eliashof-aktuelles-carousel","layout":{"type":"default"}} -->
	<div class="wp-block-query eliashof-aktuelles-carousel">

		<!-- wp:post-template {"layout":{"type":"default"}} -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"33px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->
			<div class="wp-block-group is-layout-flex is-vertical is-content-justification-left is-align-items-center wp-block-group-is-layout-flex" style="--wp--style--block-gap:33px;max-width:100%">

				<!-- wp:post-title {"level":3,"textAlign":"center","isLink":false,"className":"eliashof-card-title","style":{"typography":{"fontFamily":"'Neucha', cursive","fontSize":"36px","letterSpacing":"0.05em","lineHeight":"1.1","textTransform":"uppercase"},"color":{"text":"#000000"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->

				<!-- wp:post-excerpt {"excerptLength":20,"style":{"typography":{"fontFamily":"'Montserrat', sans-serif","fontWeight":"300","fontSize":"24px","lineHeight":"1.4"},"color":{"text":"#000000"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->

				<!-- wp:read-more {"content":"MEHR"} /-->

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
