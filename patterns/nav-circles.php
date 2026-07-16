<?php
/**
 * Title: Nav Circles
 * Slug: eliashof/nav-circles
 * Categories: eliashof-startseite
 * Description: Three navigation circle SVGs on a graph-paper background. Drop in SVG images from the media library and set link URLs. Layout locked.
 */
?>
<!-- wp:group {"align":"full","anchor":"nav-circles","templateLock":"contentOnly","className":"eliashof-section eliashof-nav-circles","style":{"spacing":{"padding":{"top":"clamp(12px,2vw,28px)","bottom":"clamp(60px,8vw,100px)","left":"clamp(24px,7.2vw,138px)","right":"clamp(24px,7.2vw,138px)"}}},"layout":{"type":"constrained"}} -->
<div id="nav-circles" class="wp-block-group alignfull eliashof-section eliashof-nav-circles" style="padding-top:clamp(12px,2vw,28px);padding-bottom:clamp(60px,8vw,100px);padding-left:clamp(24px,7.2vw,138px);padding-right:clamp(24px,7.2vw,138px)">

	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":"100px"}}} -->
	<div class="wp-block-columns are-vertically-aligned-center">

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-element-se-schule.svg","href":"#"} -->
			<figure class="wp-block-image aligncenter size-full"><a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-element-se-schule.svg" alt="Unsere Schule"/></a></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-element-se-hort.svg","href":"#"} -->
			<figure class="wp-block-image aligncenter size-full"><a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-element-se-hort.svg" alt="Unser Hort"/></a></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-element-se-eltern.svg","href":"#"} -->
			<figure class="wp-block-image aligncenter size-full"><a href="#"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/link-element-se-eltern.svg" alt="Unsere Eltern"/></a></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
