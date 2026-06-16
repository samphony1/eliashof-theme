<?php
/**
 * Eliashof Theme — functions and definitions
 */

if ( ! function_exists( 'eliashof_support' ) ) :
	function eliashof_support() {
		add_theme_support( 'wp-block-styles' );
		add_editor_style( 'style.css' );
		add_post_type_support( 'post', 'page-attributes' );

		// Disable core block patterns
		remove_theme_support( 'core-block-patterns' );
	}
endif;
add_action( 'after_setup_theme', 'eliashof_support' );

// Disable remote block patterns from wordpress.org directory
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Enqueue Google Fonts (Neucha + Montserrat) and theme stylesheet.
 */
function eliashof_scripts() {

	wp_enqueue_style(
		'eliashof-style',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_script(
		'eliashof-carousel',
		get_template_directory_uri() . '/assets/js/carousel.js',
		[],
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_enqueue_script(
		'eliashof-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		[],
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'eliashof_scripts' );



/**
 * Register block pattern category "eliashof-sections".
 * Patterns themselves are auto-registered from the /patterns directory.
 */
function eliashof_register_pattern_categories() {
	register_block_pattern_category(
		'eliashof-sections',
		[ 'label' => __( 'Eliashof Sections', 'eliashof' ) ]
	);

	// Unregister default core pattern categories to prevent editor confusion
	if ( function_exists( 'unregister_block_pattern_category' ) ) {
		$default_categories = [
			'buttons',
			'columns',
			'gallery',
			'header',
			'text',
			'uncategorized',
			'posts',
			'footer',
			'query'
		];
		foreach ( $default_categories as $category ) {
			unregister_block_pattern_category( $category );
		}
	}
}
add_action( 'init', 'eliashof_register_pattern_categories', 11 );

add_action( 'init', function() {
	// 1. Delete pattern cache to force WordPress to load the latest templates
	if ( function_exists( 'wp_get_theme' ) ) {
		wp_get_theme()->delete_pattern_cache();
	}

	// 2. Automatically clean up homepage database content in-place
	$homepage_id = get_option( 'page_on_front' );
	if ( $homepage_id ) {
		$post = get_post( $homepage_id );
		if ( $post ) {
			$content = $post->post_content;
			$original_content = $content;

			// A. Inject missing "url" attribute in all user-selected image blocks
			$content = preg_replace_callback(
				'/(<!-- wp:image (\{[^\}]+\}) -->)(\s*<figure[^>]*>\s*(?:<a[^>]*>)?\s*<img src="([^"]+)"[^>]*\/>)/s',
				function( $matches ) {
					$attrs = json_decode( $matches[2], true );
					if ( is_array( $attrs ) && ! isset( $attrs['url'] ) ) {
						$attrs['url'] = $matches[4];
						$new_json = json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
						return '<!-- wp:image ' . $new_json . ' -->' . $matches[3];
					}
					return $matches[0];
				},
				$content
			);

			// B. Fix Hero illustration drawing (missing url in comment JSON)
			$old_drawing_comment = '<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"eliashof-hero-drawing"} -->';
			$new_drawing_comment = '<!-- wp:image {"className":"eliashof-hero-drawing","sizeSlug":"full","linkDestination":"none","url":"' . esc_url( get_template_directory_uri() ) . '/assets/images/illustration01.svg"} -->';
			$content = str_replace( $old_drawing_comment, $new_drawing_comment, $content );

			// C. Fix Aktuelles (Query loop / post template structure)
			$pattern_post_template = '/<!-- wp:post-template {"layout":{"type":"default"}} -->\s*<!-- wp:group {"style":{"spacing":{"blockGap":"33px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->\s*<div class="wp-block-group is-layout-flex is-vertical is-content-justification-left is-align-items-center wp-block-group-is-layout-flex" style="--wp--style--block-gap:33px;max-width:100%">/s';
			$replacement_post_template = '<!-- wp:post-template -->
		<li class="wp-block-post">
			<!-- wp:group {"style":{"spacing":{"blockGap":"33px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->
			<div class="wp-block-group">';
			$content = preg_replace( $pattern_post_template, $replacement_post_template, $content );

			$pattern_post_template_close = '/<\/div>\s*<!-- \/wp:group -->\s*<!-- \/wp:post-template -->/s';
			$replacement_post_template_close = '</div><!-- /wp:group --></li><!-- /wp:post-template -->';
			$content = preg_replace( $pattern_post_template_close, $replacement_post_template_close, $content );

			// D. Fix Ansprechpartner empty image containers in database
			$content = preg_replace( '/<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"contact-image"} -->\s*<figure class="wp-block-image size-full contact-image"><\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} /-->', $content );
			$content = preg_replace( '/<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"contact-image"} -->\s*<figure class="wp-block-image size-full contact-image"><img src="" alt="[^"]*"\/>\s*<\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} /-->', $content );

			// E. Fix Links empty image containers in database
			$content = preg_replace( '/<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom"} -->\s*<figure class="wp-block-image aligncenter size-full"><a href="#"><img src="" alt="[^"]*"\/>\s*<\/a><\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom"} /-->', $content );
			$content = preg_replace( '/<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom"} -->\s*<figure class="wp-block-image aligncenter size-full"><\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"custom"} /-->', $content );

			// F. Fix Partner empty image containers in database
			$content = preg_replace( '/<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none"} -->\s*<figure class="wp-block-image aligncenter size-full"><img src="" alt="[^"]*"\/>\s*<\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none"} /-->', $content );
			$content = preg_replace( '/<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none"} -->\s*<figure class="wp-block-image aligncenter size-full"><\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"align":"center","sizeSlug":"full","linkDestination":"none"} /-->', $content );

			// G. Fix Förderverein empty image containers in database
			$content = preg_replace( '/<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->\s*<figure class="wp-block-image size-full"><img src="" alt="[^"]*"\/>\s*<\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} /-->', $content );
			$content = preg_replace( '/<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} -->\s*<figure class="wp-block-image size-full"><\/figure>\s*<!-- \/wp:image -->/s', '<!-- wp:image {"sizeSlug":"full","linkDestination":"none"} /-->', $content );

			if ( $content !== $original_content ) {
				wp_update_post( [
					'ID'           => $homepage_id,
					'post_content' => $content,
				] );
			}
		}
	}
} );
