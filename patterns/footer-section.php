<?php
/**
 * Title: Footer
 * Slug: eliashof/footer-section
 * Categories: eliashof-allgemein
 * Description: Rebuilt responsive footer with children illustration and two-column contact details.
 */
?>
<!-- wp:group {"align":"full","anchor":"footer","className":"eliashof-footer","layout":{"type":"default"}} -->
<div id="footer" class="wp-block-group alignfull eliashof-footer">

	<!-- wp:group {"className":"eliashof-footer-main","layout":{"type":"default"}} -->
	<div class="wp-block-group eliashof-footer-main">

		<!-- wp:group {"className":"eliashof-footer-container","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-footer-container">

			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-footer-illustration"} -->
			<figure class="wp-block-image size-full eliashof-footer-illustration"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration02.svg" alt="Illustration" /></figure>
			<!-- /wp:image -->

			<!-- wp:group {"className":"eliashof-footer-content","layout":{"type":"default"}} -->
			<div class="wp-block-group eliashof-footer-content">

				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-footer-logo-img"} -->
				<figure class="wp-block-image size-full eliashof-footer-logo-img"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo-eliashof_text.svg" alt="Logo Eliashof" /></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"className":"eliashof-footer-address"} -->
				<p class="eliashof-footer-address">Senefelderstraße 6 | 10437 Berlin-Pankow</p>
				<!-- /wp:paragraph -->

				<!-- wp:group {"className":"eliashof-footer-sprechzeiten","layout":{"type":"default"}} -->
				<div class="wp-block-group eliashof-footer-sprechzeiten">
					<!-- wp:paragraph {"className":"sprechzeiten-title"} -->
					<p class="sprechzeiten-title">Sprechzeiten Büro:</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"sprechzeiten-hours"} -->
					<p class="sprechzeiten-hours">7.45 – 8.15 Uhr &amp; 11.00 – 12.30 Uhr</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"sprechzeiten-tel"} -->
					<p class="sprechzeiten-tel">Tel: 030 / 40 50 48 00</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"sprechzeiten-separator"} -->
					<p class="sprechzeiten-separator"> | </p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"sprechzeiten-fax"} -->
					<p class="sprechzeiten-fax">Fax: 030 / 40 30 18 89</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"sprechzeiten-email-container"} -->
					<p class="sprechzeiten-email-container"><a href="mailto:sekretariat@03g46.schule.berlin.de" class="sprechzeiten-email">sekretariat@03g46.schule.berlin.de</a></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

				<!-- wp:group {"className":"eliashof-footer-spb","layout":{"type":"default"}} -->
				<div class="wp-block-group eliashof-footer-spb">
					<!-- wp:paragraph {"className":"spb-title"} -->
					<p class="spb-title">Sozialpädagogischer Bereich:</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"spb-tel"} -->
					<p class="spb-tel">Tel: 030 / 40 30 19 18</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"spb-email-container"} -->
					<p class="spb-email-container"><a href="mailto:eliashof@tjfbg.de" class="spb-email">eliashof@tjfbg.de</a></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"eliashof-footer-copyright","layout":{"type":"default"}} -->
	<div class="wp-block-group eliashof-footer-copyright">
		<!-- wp:group {"className":"eliashof-footer-copyright-container","layout":{"type":"default"}} -->
		<div class="wp-block-group eliashof-footer-copyright-container">
			<!-- wp:paragraph {"className":"copyright-text"} -->
			<p class="copyright-text">@ copyright 2026</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<button id="back-to-top" class="back-to-top" aria-label="Nach oben scrollen">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
		</svg>
	</button>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->
