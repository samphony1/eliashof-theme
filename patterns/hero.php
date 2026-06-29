<?php
/**
 * Title: Hero
 * Slug: eliashof/hero
 * Categories: eliashof-sections
 * Description: Full-width hero with heading, body text, image, and CTA button. Layout is locked — only text, image, and button label/link are editable.
 */
?>
<!-- wp:group {"align":"full","anchor":"hero","templateLock":"contentOnly","className":"eliashof-section bg-graph-yellow eliashof-hero-wrap","style":{"spacing":{"padding":{"top":"210px","bottom":"80px","left":"clamp(24px,6vw,100px)","right":"clamp(24px,6vw,100px)"}}},"layout":{"type":"constrained","wideSize":"1400px","contentSize":"1200px"}} -->
<div id="hero" class="wp-block-group alignfull eliashof-section bg-graph-yellow eliashof-hero-wrap" style="padding-top:210px;padding-bottom:80px;padding-left:clamp(24px,6vw,100px);padding-right:clamp(24px,6vw,100px)">

	<!-- wp:image {"className":"eliashof-hero-drawing","sizeSlug":"full","linkDestination":"none","url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration01.svg"} -->
	<figure class="wp-block-image size-full eliashof-hero-drawing"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration01.svg" alt="Illustration von Schulkindern und Lehrern"/></figure>
	<!-- /wp:image -->

	<!-- wp:columns {"align":"wide","verticalAlignment":"top","style":{"spacing":{"blockGap":"6vw"}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-top relative-content">

		<!-- wp:column {"verticalAlignment":"top","width":"50%","className":"eliashof-hero-left-col"} -->
		<div class="wp-block-column is-vertically-aligned-top eliashof-hero-left-col" style="flex-basis:50%">
			<!-- wp:heading {"level":1} -->
			<h1 class="wp-block-heading">WILLKOMMEN&nbsp;IN<br>DER&nbsp;GRUNDSCHULE<br>IM&nbsp;ELIASHOF!</h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top","width":"50%","className":"eliashof-hero-right-col"} -->
		<div class="wp-block-column is-vertically-aligned-top eliashof-hero-right-col" style="flex-basis:50%">

			<!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"40px"},"spacing":{"margin":{"bottom":"40px"}}}} -->
			<figure class="wp-block-image size-large has-custom-border" style="margin-bottom:40px"><img style="border-radius:40px" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:group {"className":"eliashof-hero-right-bottom","layout":{"type":"constrained"}} -->
			<div class="wp-block-group eliashof-hero-right-bottom">
				<!-- wp:paragraph -->
				<p>Hallo, wir sind eine Kiezschule im Herzen vom Prenzlauer Berg, in der schon manche Eltern der heutigen Schulkinder früher gelernt haben und die heute gemeinsam von Schulleitung, Lehrer*innen, Erzieher*innen, Eltern und Schüler*innen gestaltet wird. Bei uns lernen etwa 350 Schülerinnen und Schüler in den Klassen 1 bis 6.<br>Unser 40-köpfiges Team arbeitet professionell und Hand in Hand: Wir schätzen flache Hierarchien, direkte Kommunikation und umfangreiche Möglichkeiten der Partizipation.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"36px"} -->
				<div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
				<div class="wp-block-buttons is-content-justification-center">
					<!-- wp:button -->
					<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">MEHR ERFAHREN</a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
