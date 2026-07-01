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
		filemtime( get_template_directory() . '/style.css' )
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

			// C. Fix Aktuelles (Query loop / post template structure - remove li wrappers)
			$pattern_post_template = '/<!-- wp:post-template {"layout":{"type":"default"}} -->\s*<!-- wp:group {"style":{"spacing":{"blockGap":"33px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->\s*<div class="wp-block-group is-layout-flex is-vertical is-content-justification-left is-align-items-center wp-block-group-is-layout-flex" style="--wp--style--block-gap:33px;max-width:100%">/s';
			$replacement_post_template = '<!-- wp:post-template -->
			<!-- wp:group {"style":{"spacing":{"blockGap":"33px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"left","alignItems":"center"}} -->
			<div class="wp-block-group">';
			$content = preg_replace( $pattern_post_template, $replacement_post_template, $content );

			$pattern_post_template_close = '/<\/div>\s*<!-- \/wp:group -->\s*<!-- \/wp:post-template -->/s';
			$replacement_post_template_close = '</div><!-- /wp:group --><!-- /wp:post-template -->';
			$content = preg_replace( $pattern_post_template_close, $replacement_post_template_close, $content );

			// Also clean up any hardcoded <li> wrappers inside wp:post-template blocks if they were already written
			$content = preg_replace(
				'/<!-- wp:post-template -->\s*<li[^>]*>\s*(<!-- wp:group)/s',
				'<!-- wp:post-template -->$1',
				$content
			);
			$content = preg_replace(
				'/(<\/div>\s*<!-- \/wp:group -->)\s*<\/li>\s*<!-- \/wp:post-template -->/s',
				'$1<!-- /wp:post-template -->',
				$content
			);

			// D. Expand empty or invalid image blocks to valid Gutenberg markup
			$content = preg_replace_callback(
				'/<!-- wp:image (\{[^\}]+\}) -->(\s*<figure[^>]*>(?:(?!<img).)*?<\/figure>)\s*<!-- \/wp:image -->/s',
				function( $matches ) {
					$attrs = json_decode( $matches[1], true );
					if ( is_array( $attrs ) ) {
						$align = isset( $attrs['align'] ) ? $attrs['align'] : '';
						$size = isset( $attrs['sizeSlug'] ) ? $attrs['sizeSlug'] : 'full';
						$dest = isset( $attrs['linkDestination'] ) ? $attrs['linkDestination'] : 'none';
						$classes = 'wp-block-image';
						if ( $align ) {
							$classes .= ' align' . $align;
						}
						if ( $size ) {
							$classes .= ' size-' . $size;
						}
						$style_attr = '';
						$img_style_attr = '';
						if ( isset( $attrs['style'] ) ) {
							$styles = $attrs['style'];
							$style_parts = [];
							if ( isset( $styles['spacing']['margin']['bottom'] ) ) {
								$style_parts[] = 'margin-bottom:' . $styles['spacing']['margin']['bottom'];
							}
							if ( $style_parts ) {
								$style_attr = ' style="' . esc_attr( implode( ';', $style_parts ) ) . '"';
							}
							$img_style_parts = [];
							if ( isset( $styles['border']['radius'] ) ) {
								$img_style_parts[] = 'border-radius:' . $styles['border']['radius'];
								$classes .= ' has-custom-border';
							}
							if ( $img_style_parts ) {
								$img_style_attr = ' style="' . esc_attr( implode( ';', $img_style_parts ) ) . '"';
							}
						}
						$html = '<figure class="' . esc_attr( $classes ) . '"' . $style_attr . '>';
						if ( $dest === 'custom' ) {
							$html .= '<a href="#"><img' . $img_style_attr . ' alt=""/></a>';
						} else {
							$html .= '<img' . $img_style_attr . ' alt=""/>';
						}
						$html .= '</figure>';
						return '<!-- wp:image ' . $matches[1] . ' -->' . "\n" . $html . "\n" . '<!-- /wp:image -->';
					}
					return $matches[0];
				},
				$content
			);

			$content = preg_replace_callback(
				'/<!-- wp:image (\{[^\}]+\}) (?:\/-->|-->\s*<!-- \/wp:image -->)/s',
				function( $matches ) {
					$attrs = json_decode( $matches[1], true );
					if ( is_array( $attrs ) ) {
						$align = isset( $attrs['align'] ) ? $attrs['align'] : '';
						$size = isset( $attrs['sizeSlug'] ) ? $attrs['sizeSlug'] : 'full';
						$dest = isset( $attrs['linkDestination'] ) ? $attrs['linkDestination'] : 'none';
						$classes = 'wp-block-image';
						if ( $align ) {
							$classes .= ' align' . $align;
						}
						if ( $size ) {
							$classes .= ' size-' . $size;
						}
						$style_attr = '';
						$img_style_attr = '';
						if ( isset( $attrs['style'] ) ) {
							$styles = $attrs['style'];
							$style_parts = [];
							if ( isset( $styles['spacing']['margin']['bottom'] ) ) {
								$style_parts[] = 'margin-bottom:' . $styles['spacing']['margin']['bottom'];
							}
							if ( $style_parts ) {
								$style_attr = ' style="' . esc_attr( implode( ';', $style_parts ) ) . '"';
							}
							$img_style_parts = [];
							if ( isset( $styles['border']['radius'] ) ) {
								$img_style_parts[] = 'border-radius:' . $styles['border']['radius'];
								$classes .= ' has-custom-border';
							}
							if ( $img_style_parts ) {
								$img_style_attr = ' style="' . esc_attr( implode( ';', $img_style_parts ) ) . '"';
							}
						}
						$html = '<figure class="' . esc_attr( $classes ) . '"' . $style_attr . '>';
						if ( $dest === 'custom' ) {
							$html .= '<a href="#"><img' . $img_style_attr . ' alt=""/></a>';
						} else {
							$html .= '<img' . $img_style_attr . ' alt=""/>';
						}
						$html .= '</figure>';
						return '<!-- wp:image ' . $matches[1] . ' -->' . "\n" . $html . "\n" . '<!-- /wp:image -->';
					}
					return $matches[0];
				},
				$content
			);

			// Standardise empty image blocks that lack leading/trailing newlines
			$content = preg_replace_callback(
				'/<!-- wp:image (\{[^\}]+\}) -->(\s*<figure[^>]*>(?:<a href="#"><img[^>]*\/><\/a>|<img[^>]*\/>)<\/figure>\s*)<!-- \/wp:image -->/s',
				function( $matches ) {
					// Check if it is empty (no src tag)
					if ( strpos( $matches[2], 'src="' ) === false ) {
						// Check if it's already properly formatted with newlines on both sides
						if ( substr( $matches[2], 0, 1 ) === "\n" && substr( $matches[2], -1 ) === "\n" ) {
							return $matches[0];
						}
						$attrs = json_decode( $matches[1], true );
						if ( is_array( $attrs ) ) {
							$align = isset( $attrs['align'] ) ? $attrs['align'] : '';
							$size = isset( $attrs['sizeSlug'] ) ? $attrs['sizeSlug'] : 'full';
							$dest = isset( $attrs['linkDestination'] ) ? $attrs['linkDestination'] : 'none';
							$classes = 'wp-block-image';
							if ( $align ) {
								$classes .= ' align' . $align;
							}
							if ( $size ) {
								$classes .= ' size-' . $size;
							}
							$style_attr = '';
							$img_style_attr = '';
							if ( isset( $attrs['style'] ) ) {
								$styles = $attrs['style'];
								$style_parts = [];
								if ( isset( $styles['spacing']['margin']['bottom'] ) ) {
									$style_parts[] = 'margin-bottom:' . $styles['spacing']['margin']['bottom'];
								}
								if ( $style_parts ) {
									$style_attr = ' style="' . esc_attr( implode( ';', $style_parts ) ) . '"';
								}
								$img_style_parts = [];
								if ( isset( $styles['border']['radius'] ) ) {
									$img_style_parts[] = 'border-radius:' . $styles['border']['radius'];
									$classes .= ' has-custom-border';
								}
								if ( $img_style_parts ) {
									$img_style_attr = ' style="' . esc_attr( implode( ';', $img_style_parts ) ) . '"';
								}
							}
							$html = '<figure class="' . esc_attr( $classes ) . '"' . $style_attr . '>';
							if ( $dest === 'custom' ) {
								$html .= '<a href="#"><img' . $img_style_attr . ' alt=""/></a>';
							} else {
								$html .= '<img' . $img_style_attr . ' alt=""/>';
							}
							$html .= '</figure>';
							return '<!-- wp:image ' . $matches[1] . ' -->' . "\n" . $html . "\n" . '<!-- /wp:image -->';
						}
					}
					return $matches[0];
				},
				$content
			);

			// E. Fix nested paragraph tags
			$content = preg_replace_callback(
				'/<p([^>]*)>\s*<p[^>]*>(.*?)<\/p>\s*<\/p>/s',
				function( $matches ) {
					return '<p' . $matches[1] . '>' . $matches[2] . '</p>';
				},
				$content
			);

			// F. Fix Hero and Links heading / button validation errors in the database
			$content = preg_replace(
				'/<h1 class="wp-block-heading[^>]*>.*?WILLKOMMEN.*?DER.*?ELIASHOF!.*?<\/h1>/s',
				'<h1 class="wp-block-heading">WILLKOMMEN&nbsp;IN<br>DER&nbsp;GRUNDSCHULE<br>IM&nbsp;ELIASHOF!</h1>',
				$content
			);

			$content = str_replace(
				'<div class="wp-block-button"><a class="wp-block-button__link has-background wp-element-button" href="#" style="background-color:#f8ac41;color:#000000;border-color:#000000;border-width:0.7px;border-radius:40px;font-family:\'Neucha\',cursive;font-size:25px;letter-spacing:0.05em;padding-top:8px;padding-right:55px;padding-bottom:8px;padding-left:55px">MEHR ERFAHREN</a></div>',
				'<div class="wp-block-button"><a class="wp-block-button__link has-text-color has-background has-border-color has-custom-font-size wp-element-button" href="#" style="border-color:#000000;border-width:0.7px;border-radius:40px;color:#000000;background-color:#f8ac41;padding-top:8px;padding-right:55px;padding-bottom:8px;padding-left:55px;font-family:\'Neucha\', cursive;font-size:25px;letter-spacing:0.05em">MEHR ERFAHREN</a></div>',
				$content
			);

			$content = str_replace(
				'<h2 class="wp-block-heading has-text-align-center" style="color:#241f21;font-family:\'Neucha\',cursive;font-size:50px;letter-spacing:2.5px;line-height:1.2;margin-bottom:34px">LINKS</h2>',
				'<h2 class="wp-block-heading has-text-align-center has-text-color" style="color:#241f21;margin-bottom:34px;font-family:\'Neucha\', cursive;font-size:50px;letter-spacing:2.5px;line-height:1.2">LINKS</h2>',
				$content
			);

			// G. Fix Nav Circles Links
			$content = str_replace(
				'<a href="#"><img src="http://eliashof.local/wp-content/themes/eliashof-theme/assets/images/link-element-se-schule.svg" alt="Unsere Schule" /></a>',
				'<a href="/unsere-schule/"><img src="http://eliashof.local/wp-content/themes/eliashof-theme/assets/images/link-element-se-schule.svg" alt="Unsere Schule" /></a>',
				$content
			);
			$content = str_replace(
				'<a href="#"><img src="http://eliashof.local/wp-content/themes/eliashof-theme/assets/images/link-element-se-hort.svg" alt="Unser Hort" /></a>',
				'<a href="/#spb-hort"><img src="http://eliashof.local/wp-content/themes/eliashof-theme/assets/images/link-element-se-hort.svg" alt="Unser Hort" /></a>',
				$content
			);
			$content = str_replace(
				'<a href="#"><img src="http://eliashof.local/wp-content/themes/eliashof-theme/assets/images/link-element-se-eltern.svg" alt="Unsere Eltern" /></a>',
				'<a href="/#eltern"><img src="http://eliashof.local/wp-content/themes/eliashof-theme/assets/images/link-element-se-eltern.svg" alt="Unsere Eltern" /></a>',
				$content
			);

			if ( $content !== $original_content ) {
				wp_update_post( [
					'ID'           => $homepage_id,
					'post_content' => $content,
				] );
			}
		}
	}

	// 2.5. Automatically clean up "Unsere Schule" page (ID 106) database content
	$schule_page_id = 106;
	if ( get_post_status( $schule_page_id ) ) {
		$post = get_post( $schule_page_id );
		if ( $post ) {
			$content = $post->post_content;
			$original_content = $content;

			// If the content has double wrapper or old left-over blocks before the textbox section, replace it
			if ( strpos( $content, '<!-- wp:group {"align":"full","className":"eliashof-hero-blog-schule bg-graph-blue"' ) !== false && strpos( $content, 'section-textbox' ) !== false ) {
				$parts = explode( '<!-- wp:group {"metadata":{"categories":["eliashof-sections"],"patternName":"eliashof/section-textbox"', $content, 2 );
				if ( count( $parts ) === 2 ) {
					$new_hero = '<!-- wp:group {"metadata":{"categories":["eliashof-sections"],"patternName":"eliashof/hero-blog-schule-page","name":"Hero (Unsere Schule - Seite)"},"align":"full","className":"eliashof-hero-blog-schule bg-graph-blue eliashof-hero-blog-schule-page","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull eliashof-hero-blog-schule bg-graph-blue eliashof-hero-blog-schule-page" id="hero-blog-schule-page"><!-- wp:group {"className":"eliashof-hero-blog-schule-container","layout":{"type":"default"}} -->
<div class="wp-block-group eliashof-hero-blog-schule-container"><!-- wp:group {"className":"eliashof-hero-blog-schule-image-col","layout":{"type":"default"}} -->
<div class="wp-block-group eliashof-hero-blog-schule-image-col"><!-- wp:group {"className":"eliashof-hero-blog-schule-featured-img-container","layout":{"type":"default"}} -->
<div class="wp-block-group eliashof-hero-blog-schule-featured-img-container"><!-- wp:post-featured-image {"className":"eliashof-hero-blog-schule-featured-img"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"eliashof-hero-blog-schule-content-col","layout":{"type":"default"}} -->
<div class="wp-block-group eliashof-hero-blog-schule-content-col"><!-- wp:heading {"level":1,"placeholder":"Titel eingeben...","className":"eliashof-hero-blog-schule-title"} -->
<h1 class="wp-block-heading eliashof-hero-blog-schule-title">UNSERE SCHULE</h1>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"eliashof-hero-blog-schule-illustration","layout":{"type":"default"}} -->
<div class="wp-block-group eliashof-hero-blog-schule-illustration"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"' . esc_url( get_template_directory_uri() ) . '/assets/images/illustration-children-line.svg"} -->
<figure class="wp-block-image size-full"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/illustration-children-line.svg" alt="Illustration"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

';
					$content = $new_hero . '<!-- wp:group {"metadata":{"categories":["eliashof-sections"],"patternName":"eliashof/section-textbox"' . $parts[1];
				}
			}

			if ( $content !== $original_content ) {
				wp_update_post( [
					'ID'           => $schule_page_id,
					'post_content' => $content,
				] );
			}
		}
	}

	// 3. Programmatically clean up and update the Primary Menu items
	if ( get_post_status( 111 ) ) {
		wp_delete_post( 111, true );
	}
	if ( get_post_status( 98 ) ) {
		update_post_meta( 98, '_menu_item_url', '/unsere-schule/' );
	}
	if ( get_post_status( 97 ) ) {
		update_post_meta( 97, '_menu_item_url', '/#aktuelles' );
	}
	if ( get_post_status( 99 ) ) {
		update_post_meta( 99, '_menu_item_url', '/#spb-hort' );
	}
	if ( get_post_status( 100 ) ) {
		update_post_meta( 100, '_menu_item_url', '/#eltern' );
	}
	if ( get_post_status( 101 ) ) {
		update_post_meta( 101, '_menu_item_url', '/#foerderverein' );
	}
	if ( get_post_status( 102 ) ) {
		update_post_meta( 102, '_menu_item_url', '/#unsere-partner' );
	}
	if ( get_post_status( 103 ) ) {
		update_post_meta( 103, '_menu_item_url', '/#kontakt' );
	}
} );

/**
 * Register Classic Navigation Menu.
 * This makes the classic "Design > Menüs" screen visible in the WP admin backend.
 */
function eliashof_register_menus() {
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'eliashof' ),
	) );
}
add_action( 'after_setup_theme', 'eliashof_register_menus' );

/**
 * Shortcode to render the primary classic menu with list markup.
 * Use [eliashof_menu] in block templates or content editor.
 */
function eliashof_render_menu_shortcode() {
	ob_start();
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => false,
		'menu_class'     => '',
		'fallback_cb'    => 'eliashof_fallback_menu',
	) );
	return ob_get_clean();
}
add_shortcode( 'eliashof_menu', 'eliashof_render_menu_shortcode' );

/**
 * Fallback menu callback when no custom menu is assigned in backend.
 */
function eliashof_fallback_menu() {
	echo '<ul>';
	echo '<li><a href="/#aktuelles">AKTUELLES</a></li>';
	echo '<li><a href="/unsere-schule/">UNSERE SCHULE</a></li>';
	echo '<li><a href="/#spb-hort">SPB / HORT</a></li>';
	echo '<li><a href="/#foerderverein">FÖRDERVEREIN</a></li>';
	echo '<li><a href="/#unsere-partner">UNSERE PARTNER</a></li>';
	echo '<li><a href="/#kontakt">KONTAKT</a></li>';
	echo '</ul>';
}

/**
 * Filter menu objects to enforce uppercase, remove inactive/duplicate links, and format anchors.
 */
function eliashof_filter_menu_items( $sorted_menu_items, $args ) {
	$filtered = array();
	foreach ( $sorted_menu_items as $item ) {
		// 1. Remove 'ELTERN' (not live)
		if ( strcasecmp( $item->title, 'ELTERN' ) === 0 || $item->url === '#eltern' || $item->url === '/#eltern' ) {
			continue;
		}

		// 2. Remove redundant 'UNSERE SCHULE' custom anchor item (prefer the live page link)
		if ( $item->url === '#unsere-schule' || $item->url === '/#unsere-schule' ) {
			continue;
		}

		// 3. Make sure relative anchor links start with a slash / so they work from other pages
		if ( strpos( $item->url, '#' ) === 0 ) {
			$item->url = '/' . $item->url;
		}

		// 4. Force title to uppercase
		$item->title = mb_strtoupper( $item->title, 'UTF-8' );

		$filtered[] = $item;
	}
	return $filtered;
}
add_filter( 'wp_nav_menu_objects', 'eliashof_filter_menu_items', 10, 2 );
