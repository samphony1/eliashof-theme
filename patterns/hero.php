<?php
/**
 * Title: Hero
 * Slug: eliashof/hero
 * Categories: eliashof-sections
 * Description: Full-width hero with heading, body text, image, and CTA button. Layout is locked — only text, image, and button label/link are editable.
 */
?>
<!-- wp:group {"align":"full","templateLock":"contentOnly","className":"eliashof-section bg-graph-yellow eliashof-hero-wrap","style":{"spacing":{"padding":{"top":"210px","bottom":"80px","left":"clamp(24px,6vw,100px)","right":"clamp(24px,6vw,100px)"}}},"layout":{"type":"constrained","wideSize":"1400px","contentSize":"1200px"}} -->
<div class="wp-block-group alignfull eliashof-section bg-graph-yellow eliashof-hero-wrap" style="padding-top:210px;padding-bottom:80px;padding-left:clamp(24px,6vw,100px);padding-right:clamp(24px,6vw,100px)">

	<!-- wp:image {"className":"eliashof-hero-drawing","sizeSlug":"full","linkDestination":"none"} -->
	<figure class="wp-block-image size-full eliashof-hero-drawing"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration01.svg" alt="Illustration von Schulkindern und Lehrern"/></figure>
	<!-- /wp:image -->

	<!-- wp:columns {"align":"wide","verticalAlignment":"top","style":{"spacing":{"blockGap":"6vw"}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-top relative-content">

		<!-- wp:column {"verticalAlignment":"top","width":"50%","className":"eliashof-hero-left-col"} -->
		<div class="wp-block-column is-vertically-aligned-top eliashof-hero-left-col" style="flex-basis:50%">
			<!-- wp:heading {"level":1,"style":{"typography":{"fontFamily":"'Neucha', cursive","fontSize":"clamp(40px, 5.5vw, 86px)","lineHeight":"1.1","letterSpacing":"0.05em"},"color":{"text":"#000000"},"spacing":{"margin":{"bottom":"40px"}}}} -->
			<h1 class="wp-block-heading" style="color:#000000;font-family:'Neucha',cursive;font-size:clamp(40px, 5.5vw, 86px);line-height:1.1;letter-spacing:0.05em;margin-bottom:40px;word-break:keep-all;">WILLKOMMEN IN<br>DER GRUNDSCHULE<br>IM ELIASHOF!</h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top","width":"50%","className":"eliashof-hero-right-col"} -->
		<div class="wp-block-column is-vertically-aligned-top eliashof-hero-right-col" style="flex-basis:50%">

			<!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"40px"},"spacing":{"margin":{"bottom":"40px"}}}} -->
			<figure class="wp-block-image size-large has-custom-border" style="border-radius:40px;margin-bottom:40px"><img src="" alt="Schulhof mit Kindern"/></figure>
			<!-- /wp:image -->

			<!-- wp:group {"className":"eliashof-hero-right-bottom","layout":{"type":"constrained"}} -->
			<div class="wp-block-group eliashof-hero-right-bottom">
				<!-- wp:paragraph {"style":{"typography":{"fontFamily":"'Montserrat', sans-serif","fontWeight":"300","fontSize":"24px","lineHeight":"1.7"},"color":{"text":"#000000"}}} -->
				<p style="color:#000000;font-family:'Montserrat',sans-serif;font-size:24px;font-weight:300;line-height:1.7">Hallo, wir sind eine Kiezschule im Herzen vom Prenzlauer Berg, in der schon manche Eltern der heutigen Schulkinder früher gelernt haben und die heute gemeinsam von Schulleitung, Lehrer*innen, Erzieher*innen, Eltern und Schüler*innen gestaltet wird. Bei uns lernen etwa 350 Schülerinnen und Schüler in den Klassen 1 bis 6.<br>Unser 40-köpfiges Team arbeitet professionell und Hand in Hand: Wir schätzen flache Hierarchien, direkte Kommunikation und umfangreiche Möglichkeiten der Partizipation.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"36px"} -->
				<div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
				<div class="wp-block-buttons is-content-justification-center">
					<!-- wp:button {"style":{"color":{"background":"#f8ac41","text":"#000000"},"border":{"radius":"40px","color":"#000000","width":"0.7px"},"typography":{"fontFamily":"'Neucha', cursive","fontSize":"25px","letterSpacing":"0.05em"},"spacing":{"padding":{"top":"8px","bottom":"8px","left":"55px","right":"55px"}}}} -->
					<div class="wp-block-button"><a class="wp-block-button__link has-background wp-element-button" href="#" style="background-color:#f8ac41;color:#000000;border-color:#000000;border-width:0.7px;border-radius:40px;font-family:'Neucha',cursive;font-size:25px;letter-spacing:0.05em;padding-top:8px;padding-right:55px;padding-bottom:8px;padding-left:55px">MEHR ERFAHREN</a></div>
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
