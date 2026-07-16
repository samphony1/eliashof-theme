<?php
/**
 * Title: Unsere Partner
 * Slug: eliashof/unsere-partner
 * Categories: eliashof-startseite
 * Description: A 3-column logo row showcasing school partners. White background. Layout locked.
 */
?>
<!-- wp:group {"align":"full","anchor":"unsere-partner","templateLock":"contentOnly","className":"eliashof-section section-partners bg-graph-white","style":{"spacing":{"padding":{"top":"62px","bottom":"62px","left":"clamp(24px,7.2vw,138px)","right":"clamp(24px,7.2vw,138px)"}}},"layout":{"type":"constrained"}} -->
<div id="unsere-partner" class="wp-block-group alignfull eliashof-section section-partners bg-graph-white" style="padding-top:62px;padding-bottom:62px;padding-left:clamp(24px,7.2vw,138px);padding-right:clamp(24px,7.2vw,138px)">

	<!-- wp:heading {"level":2,"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Unsere Partner</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center">

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-header.svg"} -->
			<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-header.svg" alt="Partner Platzhalter 1" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-eliashof_text.svg"} -->
			<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-eliashof_text.svg" alt="Partner Platzhalter 2" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration02.svg"} -->
			<figure class="wp-block-image aligncenter size-full"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration02.svg" alt="Partner Platzhalter 3" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
