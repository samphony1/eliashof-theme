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
	wp_add_inline_style(
		'eliashof-style',
		sprintf(
			':root { --eliashof-paperbg-dim: %s; }',
			esc_html( eliashof_get_paperbg_dim() )
		)
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
	wp_enqueue_script(
		'eliashof-spb-angebote',
		get_template_directory_uri() . '/assets/js/spb-angebote.js',
		[],
		filemtime( get_template_directory() . '/assets/js/spb-angebote.js' ),
		true
	);
	wp_enqueue_script(
		'eliashof-intern-drawer',
		get_template_directory_uri() . '/assets/js/intern-drawer.js',
		[],
		filemtime( get_template_directory() . '/assets/js/intern-drawer.js' ),
		true
	);
	wp_localize_script(
		'eliashof-intern-drawer',
		'eliashofInternDrawer',
		array(
			'restBase'    => esc_url_raw( rest_url( 'eliashof/v1/intern-posts/' ) ),
			'internPosts' => eliashof_get_intern_posts_for_drawer(),
			'labels'      => array(
				'loading' => __( 'Inhalt wird geladen…', 'eliashof' ),
				'error'   => __( 'Dieser Inhalt konnte gerade nicht geladen werden.', 'eliashof' ),
				'close'   => __( 'Schliessen', 'eliashof' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'eliashof_scripts' );

/**
 * Return the configured paper background dim value as a CSS-safe decimal.
 */
function eliashof_get_paperbg_dim() {
	$default = 70;
	$value   = get_theme_mod( 'eliashof_paperbg_dim', $default );
	$value   = is_numeric( $value ) ? (int) $value : $default;
	$value   = max( 0, min( 100, $value ) );

	return number_format( $value / 100, 2, '.', '' );
}

/**
 * Sanitize the paper background dim percentage stored in the Customizer.
 */
function eliashof_sanitize_paperbg_dim( $value ) {
	$value = is_numeric( $value ) ? (int) $value : 70;

	return max( 0, min( 100, $value ) );
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Eliashof_Paperbg_Dim_Control' ) ) {
	/**
	 * Customizer control with value indicator and reset button.
	 */
	class Eliashof_Paperbg_Dim_Control extends WP_Customize_Control {
		/**
		 * Control type.
		 *
		 * @var string
		 */
		public $type = 'eliashof_paperbg_dim';

		/**
		 * Render the control content.
		 */
		public function render_content() {
			$value   = is_numeric( $this->value() ) ? (int) $this->value() : 70;
			$default = isset( $this->setting->default ) && is_numeric( $this->setting->default ) ? (int) $this->setting->default : 70;
			$input_id = '_customize-input-' . $this->id;
			?>
			<div class="eliashof-paperbg-control" data-default-value="<?php echo esc_attr( $default ); ?>">
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>

				<div class="eliashof-paperbg-control__meta">
					<span class="eliashof-paperbg-control__current">
						<?php esc_html_e( 'Aktueller Wert:', 'eliashof' ); ?>
						<strong data-paperbg-current-value><?php echo esc_html( $value ); ?></strong>
					</span>
					<span class="eliashof-paperbg-control__default">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %d is the default dim value in percent. */
								__( 'Standard: %d (0.70)', 'eliashof' ),
								$default
							)
						);
						?>
					</span>
				</div>

				<input
					id="<?php echo esc_attr( $input_id ); ?>"
					class="eliashof-paperbg-control__slider"
					type="range"
					min="0"
					max="100"
					step="1"
					value="<?php echo esc_attr( $value ); ?>"
					<?php $this->link(); ?>
				/>

				<button type="button" class="button button-secondary eliashof-paperbg-control__reset" data-paperbg-reset>
					<?php esc_html_e( 'Auf Standard 0.70 zuruecksetzen', 'eliashof' ); ?>
				</button>
			</div>
			<?php
		}
	}
}

/**
 * Register a Customizer slider for the global paper background dimming.
 */
function eliashof_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'eliashof_design',
		array(
			'title'       => __( 'Eliashof Design', 'eliashof' ),
			'priority'    => 30,
			'description' => __( 'Globale Gestaltungsoptionen fuer den Seitenhintergrund.', 'eliashof' ),
		)
	);

	$wp_customize->add_setting(
		'eliashof_paperbg_dim',
		array(
			'default'           => 70,
			'sanitize_callback' => 'eliashof_sanitize_paperbg_dim',
			'transport'         => 'refresh',
			'type'              => 'theme_mod',
		)
	);

	$wp_customize->add_control(
		new Eliashof_Paperbg_Dim_Control(
			$wp_customize,
			'eliashof_paperbg_dim',
			array(
				'label'       => __( 'Papierhintergrund abdunkeln', 'eliashof' ),
				'description' => __( '0 = Hintergrund voll sichtbar, 100 = stark aufgehellt und sehr dezent.', 'eliashof' ),
				'section'     => 'eliashof_design',
			)
		)
	);
}
add_action( 'customize_register', 'eliashof_customize_register' );

/**
 * Add UI behavior and styling for the paper background Customizer control.
 */
function eliashof_customize_controls_assets() {
	?>
	<script>
		wp.customize.bind('ready', function () {
			var control = wp.customize.control('eliashof_paperbg_dim');

			if (!control || !control.container) {
				return;
			}

			var slider = control.container.find('.eliashof-paperbg-control__slider');
			var currentValue = control.container.find('[data-paperbg-current-value]');
			var resetButton = control.container.find('[data-paperbg-reset]');
			var defaultValue = parseInt(control.container.find('.eliashof-paperbg-control').attr('data-default-value'), 10);

			if (!slider.length || !currentValue.length || !resetButton.length) {
				return;
			}

			if (Number.isNaN(defaultValue)) {
				defaultValue = 70;
			}

			var updateValue = function (value) {
				currentValue.text(value);
			};

			updateValue(slider.val());

			slider.on('input change', function () {
				updateValue(this.value);
			});

			control.setting.bind(function (value) {
				slider.val(value);
				updateValue(value);
			});

			resetButton.on('click', function () {
				slider.val(defaultValue).trigger('input').trigger('change');
				control.setting.set(defaultValue);
			});
		});
	</script>
	<style>
		#customize-control-eliashof_paperbg_dim .eliashof-paperbg-control {
			display: grid;
			gap: 12px;
		}

		#customize-control-eliashof_paperbg_dim .eliashof-paperbg-control__meta {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 8px 12px;
			font-size: 13px;
			line-height: 1.4;
		}

		#customize-control-eliashof_paperbg_dim .eliashof-paperbg-control__current strong {
			font-size: 15px;
		}

		#customize-control-eliashof_paperbg_dim .eliashof-paperbg-control__slider {
			width: 100%;
		}

		#customize-control-eliashof_paperbg_dim .eliashof-paperbg-control__reset {
			margin-top: 12px;
			width: fit-content;
		}
	</style>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'eliashof_customize_controls_assets' );

/**
 * Return published intern posts for the drawer link matcher.
 */
function eliashof_get_intern_posts_for_drawer() {
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'category_name'  => 'intern',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	return array_map(
		static function( $post ) {
			$permalink = get_permalink( $post );
			$path      = wp_parse_url( $permalink, PHP_URL_PATH );

			return array(
				'id'        => (int) $post->ID,
				'permalink' => $permalink,
				'path'      => $path ? untrailingslashit( $path ) : '',
				'slug'      => $post->post_name,
				'title'     => get_the_title( $post ),
			);
		},
		$posts
	);
}

/**
 * Return data attributes for links that should open in the intern drawer.
 */
function eliashof_get_intern_link_attributes( $post_id ) {
	if ( ! has_category( 'intern', $post_id ) ) {
		return '';
	}

	return sprintf(
		' data-intern-post-trigger="true" data-intern-post-id="%d"',
		(int) $post_id
	);
}

/**
 * Resolve a permalink from a slug across posts and pages.
 */
function eliashof_get_permalink_by_slug( $slug ) {
	$post = get_page_by_path( $slug, OBJECT, array( 'post', 'page' ) );

	return $post ? get_permalink( $post ) : '';
}

/**
 * Resolve a URL from prioritized internal or direct candidates.
 */
function eliashof_resolve_link_target( $candidates ) {
	foreach ( (array) $candidates as $candidate ) {
		if ( ! is_string( $candidate ) || '' === $candidate ) {
			continue;
		}

		if ( 0 === strpos( $candidate, 'http://' ) || 0 === strpos( $candidate, 'https://' ) || 0 === strpos( $candidate, 'mailto:' ) ) {
			return $candidate;
		}

		if ( 0 === strpos( $candidate, '/#' ) || '#' === $candidate || 0 === strpos( $candidate, '/' ) ) {
			return $candidate;
		}

		$permalink = eliashof_get_permalink_by_slug( $candidate );
		if ( $permalink ) {
			return $permalink;
		}

		$post = get_page_by_title( $candidate, OBJECT, array( 'post', 'page' ) );
		if ( $post ) {
			return get_permalink( $post );
		}
	}

	return '';
}

/**
 * Link target map for placeholder links in locked patterns.
 */
function eliashof_get_placeholder_link_map() {
	return array(
		'hero' => array(
			'text' => array(
				'MEHR ERFAHREN' => array( 'unsere-schule' ),
			),
		),
		'nav-circles' => array(
			'alt' => array(
				'Unsere Schule' => array( 'unsere-schule' ),
				'Unser Hort'    => array( '/#spb-hort' ),
				'Unsere Eltern' => array( 'eltern' ),
			),
		),
		'downloads-terminkalender' => array(
			'text_sequence' => array(
				array( 'downloads' ),
				array( 'terminkalender' ),
			),
		),
		'spb-hort' => array(
			'text' => array(
				'MEHR ERFAHREN' => array( 'spb-hort', 'hort' ),
			),
		),
		'foerderverein' => array(
			'text' => array(
				'MEHR' => array( 'foerderverein' ),
			),
		),
		'section-lebenskunde-religion' => array(
			'text_sequence' => array(
				array( 'humanistische-lebenskunde', 'lebenskunde' ),
				array( 'religionsunterricht' ),
			),
		),
		'downloads-vorstand' => array(
			'text' => array(
				'HIER ENTLANG' => array( 'downloads' ),
			),
		),
		'section-eltern-infos' => array(
			'text' => array(
				'MITWIRKUNG VON ELTERN IN DER SCHULE'   => array( 'mitwirkung-von-eltern-in-der-schule' ),
				'AKTUELLES VOM BEZIRKSELTERNAUSSCHUSS:' => array( 'aktuelles-vom-bezirkselternausschuss' ),
				'AKTUELLES VOM LANDESELTERNAUSSCHUSS'   => array( 'aktuelles-vom-landeselternausschuss' ),
				'AKTUELLE ANGEBOTE DES SIBUZ FÜR ELTERN' => array( 'aktuelle-angebote-des-sibuz-fuer-eltern' ),
			),
		),
	);
}

/**
 * Add intern drawer data attributes to Query Loop read-more links.
 */
function eliashof_mark_intern_read_more_links( $block_content, $block ) {
	$post_id = isset( $block['context']['postId'] ) ? (int) $block['context']['postId'] : 0;

	if ( ! $post_id || ! has_category( 'intern', $post_id ) ) {
		return $block_content;
	}

	$processor = new WP_HTML_Tag_Processor( $block_content );
	if ( ! $processor->next_tag( array( 'tag_name' => 'A' ) ) ) {
		return $block_content;
	}

	$processor->set_attribute( 'data-intern-post-trigger', 'true' );
	$processor->set_attribute( 'data-intern-post-id', (string) $post_id );

	return $processor->get_updated_html();
}
add_filter( 'render_block_core/read-more', 'eliashof_mark_intern_read_more_links', 10, 2 );

/**
 * Rewrite the static homepage downloads buttons with live post/page permalinks.
 */
function eliashof_rewrite_placeholder_links( $block_content, $block ) {
	$anchor = isset( $block['attrs']['anchor'] ) ? $block['attrs']['anchor'] : '';
	$link_map = eliashof_get_placeholder_link_map();

	if ( ! $anchor || ! isset( $link_map[ $anchor ] ) ) {
		return $block_content;
	}

	$processor = new WP_HTML_Tag_Processor( $block_content );
	$rules = $link_map[ $anchor ];
	$text_sequence_index = 0;

	while ( $processor->next_tag( array( 'tag_name' => 'A' ) ) ) {
		$current_href = $processor->get_attribute( 'href' );
		if ( '#' !== $current_href ) {
			continue;
		}

		$resolved_url = '';

		if ( isset( $rules['text_sequence'][ $text_sequence_index ] ) ) {
			$resolved_url = eliashof_resolve_link_target( $rules['text_sequence'][ $text_sequence_index ] );
			$text_sequence_index++;
		}

		if ( ! $resolved_url && ! empty( $rules['text'] ) ) {
			$text_content = '';
			if ( $processor->set_bookmark( 'eliashof-link-start' ) ) {
				while ( $processor->next_token() ) {
					if ( $processor->is_tag_closer() && 'A' === $processor->get_tag() ) {
						break;
					}
					if ( '#text' === $processor->get_token_name() ) {
						$text_content .= $processor->get_modifiable_text();
					}
				}

				$normalized_text = trim( wp_strip_all_tags( html_entity_decode( $text_content, ENT_QUOTES, 'UTF-8' ) ) );
				if ( isset( $rules['text'][ $normalized_text ] ) ) {
					$resolved_url = eliashof_resolve_link_target( $rules['text'][ $normalized_text ] );
				}

				$processor->seek( 'eliashof-link-start' );
				$processor->release_bookmark( 'eliashof-link-start' );
			}
		}

		if ( ! $resolved_url && ! empty( $rules['alt'] ) ) {
			if ( $processor->set_bookmark( 'eliashof-link-alt-start' ) ) {
				while ( $processor->next_tag( array( 'tag_name' => 'IMG' ) ) ) {
					$alt = $processor->get_attribute( 'alt' );
					if ( isset( $rules['alt'][ $alt ] ) ) {
						$resolved_url = eliashof_resolve_link_target( $rules['alt'][ $alt ] );
					}
					break;
				}
				$processor->seek( 'eliashof-link-alt-start' );
				$processor->release_bookmark( 'eliashof-link-alt-start' );
			}
		}

		if ( $resolved_url ) {
			$processor->set_attribute( 'href', $resolved_url );
		}
	}

	return $processor->get_updated_html();
}
add_filter( 'render_block_core/group', 'eliashof_rewrite_placeholder_links', 10, 2 );

/**
 * Register REST payload for public intern drawer content.
 */
function eliashof_register_intern_post_route() {
	register_rest_route(
		'eliashof/v1',
		'/intern-posts/(?P<id>\d+)',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'eliashof_get_intern_post_payload',
			'permission_callback' => '__return_true',
			'args'                => array(
				'id' => array(
					'validate_callback' => static function( $value ) {
						return is_numeric( $value ) && (int) $value > 0;
					},
				),
			),
		)
	);
}
add_action( 'rest_api_init', 'eliashof_register_intern_post_route' );

/**
 * Serve rendered content for published intern posts.
 */
function eliashof_get_intern_post_payload( WP_REST_Request $request ) {
	$post_id = (int) $request['id'];
	$post    = get_post( $post_id );

	if ( ! $post || 'post' !== $post->post_type || 'publish' !== $post->post_status || ! has_category( 'intern', $post ) ) {
		return new WP_Error(
			'eliashof_intern_post_not_found',
			__( 'Der angefragte Beitrag ist nicht verfuegbar.', 'eliashof' ),
			array( 'status' => 404 )
		);
	}

	return rest_ensure_response(
		array(
			'id'        => $post_id,
			'title'     => html_entity_decode( get_the_title( $post ), ENT_QUOTES, 'UTF-8' ),
			'content'   => apply_filters( 'the_content', $post->post_content ),
			'permalink' => get_permalink( $post ),
		)
	);
}

/**
 * Render the global intern drawer shell once per page.
 */
function eliashof_render_intern_drawer_shell() {
	?>
	<div class="eliashof-intern-drawer" data-intern-drawer hidden>
		<div class="eliashof-intern-drawer__backdrop" data-intern-drawer-close></div>
		<aside
			class="eliashof-intern-drawer__panel"
			role="dialog"
			aria-modal="true"
			aria-labelledby="eliashof-intern-drawer-title"
			tabindex="-1"
		>
			<div class="eliashof-intern-drawer__handle" aria-hidden="true"></div>
			<button
				type="button"
				class="eliashof-intern-drawer__close"
				data-intern-drawer-close
				aria-label="<?php esc_attr_e( 'Schliessen', 'eliashof' ); ?>"
			>
				<span aria-hidden="true">×</span>
			</button>
			<div class="eliashof-intern-drawer__header">
				<h2 id="eliashof-intern-drawer-title" class="eliashof-intern-drawer__title"></h2>
			</div>
			<div class="eliashof-intern-drawer__body" data-intern-drawer-body></div>
		</aside>
	</div>
	<?php
}
add_action( 'wp_footer', 'eliashof_render_intern_drawer_shell' );

/**
 * Add custom block editor controls for section background colors.
 */
function eliashof_enqueue_block_editor_assets() {
	wp_enqueue_script(
		'eliashof-editor-section-colors',
		get_template_directory_uri() . '/assets/js/editor-section-colors.js',
		array(
			'wp-block-editor',
			'wp-blocks',
			'wp-components',
			'wp-compose',
			'wp-element',
			'wp-hooks',
			'wp-i18n',
		),
		filemtime( get_template_directory() . '/assets/js/editor-section-colors.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'eliashof_enqueue_block_editor_assets' );

/**
 * Render custom theme background colors for blocks on the frontend.
 */
function eliashof_render_custom_block_background( $block_content, $block ) {
	if ( empty( $block_content ) || empty( $block['attrs']['eliashofThemeBg'] ) ) {
		return $block_content;
	}

	$theme_bg = $block['attrs']['eliashofThemeBg'];
	$allowed  = array(
		'blue'        => '#8cc8d1',
		'green'       => '#c5d799',
		'beige'       => '#eec58d',
		'orange'      => '#f8ac41',
		'transparent' => 'transparent',
	);

	if ( ! isset( $allowed[ $theme_bg ] ) ) {
		return $block_content;
	}

	$processor = new WP_HTML_Tag_Processor( $block_content );
	if ( ! $processor->next_tag() ) {
		return $block_content;
	}

	$processor->add_class( 'has-eliashof-theme-bg' );
	$processor->add_class( 'has-eliashof-theme-bg-' . $theme_bg );
	$processor->set_attribute( 'style', '--eliashof-theme-bg:' . $allowed[ $theme_bg ] . ';' );

	return $processor->get_updated_html();
}
add_filter( 'render_block', 'eliashof_render_custom_block_background', 10, 2 );



/**
 * Register block pattern categories grouped by page usage.
 * Patterns themselves are auto-registered from the /patterns directory.
 */
function eliashof_register_pattern_categories() {
	register_block_pattern_category(
		'eliashof-startseite',
		[ 'label' => __( 'Eliashof Startseite', 'eliashof' ) ]
	);
	register_block_pattern_category(
		'eliashof-eltern',
		[ 'label' => __( 'Eliashof Eltern', 'eliashof' ) ]
	);
	register_block_pattern_category(
		'eliashof-foerderverein',
		[ 'label' => __( 'Eliashof Förderverein', 'eliashof' ) ]
	);
	register_block_pattern_category(
		'eliashof-spb-hort',
		[ 'label' => __( 'Eliashof SPB/Hort', 'eliashof' ) ]
	);
	register_block_pattern_category(
		'eliashof-unsere-schule',
		[ 'label' => __( 'Eliashof Unsere Schule', 'eliashof' ) ]
	);
	register_block_pattern_category(
		'eliashof-aktuelles',
		[ 'label' => __( 'Eliashof Aktuelles', 'eliashof' ) ]
	);
	register_block_pattern_category(
		'eliashof-allgemein',
		[ 'label' => __( 'Eliashof Allgemein', 'eliashof' ) ]
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

/**
 * Build fresh editable block markup for the Eltern page GEV section.
 *
 * We intentionally generate full block HTML here instead of storing a pattern
 * reference so Gutenberg can re-open the section as normal editable blocks.
 *
 * @return string
 */
function eliashof_get_eltern_page_gev_markup() {
	$image_url = esc_url( get_template_directory_uri() . '/assets/images/illustration-children-line-2.png' );

	return '<!-- wp:group {"align":"full","anchor":"section-gev","templateLock":"contentOnly","className":"eliashof-section section-gev bg-graph-green-light","layout":{"type":"constrained"}} -->
<div id="section-gev" class="wp-block-group alignfull eliashof-section section-gev bg-graph-green-light">

	<!-- wp:heading {"level":2,"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">DIE GEV = GESAMTELTERNVERTRETUNG</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"verticalAlignment":"center"} -->
	<div class="wp-block-columns are-vertically-aligned-center">

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">

			<!-- wp:paragraph -->
			<p>Die gewählten Elternvertretungen aller Klassen organisieren sich in der Gesamtelternvertretung (GEV). Dort bündeln wir die Interessen der Schülerinnen und Schüler sowie ihrer Familien. Unsere GEV ist damit ein wichtiges Bindeglied zwischen Eltern und Schule.<br><br>Als GEV stehen wir im regelmäßigen Dialog mit der Schulleitung, den Lehrkräften und dem Sozialpädagogischen Bereich (SPB/Hort). In unseren Sitzungen besprechen wir aktuelle Entwicklungen und bringen Anregungen konstruktiv ein. Dabei ist uns eine offene, respektvolle und lösungsorientierte Zusammenarbeit besonders wichtig.<br><br>Ein zentraler Bestandteil unserer Arbeit ist es, Informationen transparent weiterzugeben und den Austausch unter den Eltern zu unterstützen. Über Elternabende, Protokolle und weitere Kommunikationswege sorgen wir dafür, dass wichtige Themen alle Familien erreichen.</p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","url":"' . $image_url . '"} -->
			<figure class="wp-block-image size-full"><img src="' . $image_url . '" alt="Illustration zur Elternvertretung" /></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->';
}

/**
 * Build fresh editable block markup for the Eltern Infos section.
 *
 * @return string
 */
function eliashof_get_eltern_page_infos_markup() {
	return '<!-- wp:group {"align":"full","anchor":"section-eltern-infos","className":"eliashof-section section-eltern-infos bg-graph-white","layout":{"type":"constrained"}} -->
<div id="section-eltern-infos" class="wp-block-group alignfull eliashof-section section-eltern-infos bg-graph-white">
	<!-- wp:group {"className":"eliashof-eltern-infos-container","layout":{"type":"default"}} -->
	<div class="wp-block-group eliashof-eltern-infos-container">
		
		<!-- wp:heading {"level":2,"textAlign":"center","style":{"spacing":{"margin":{"top":"0","bottom":"52px"}}}} -->
		<h2 class="wp-block-heading has-text-align-center" style="margin-top:0;margin-bottom:52px">ELTERN INFOS</h2>
		<!-- /wp:heading -->

		<!-- wp:columns {"className":"eliashof-eltern-infos-columns","style":{"spacing":{"blockGap":"60px"}}} -->
		<div class="wp-block-columns eliashof-eltern-infos-columns">

			<!-- wp:column {"className":"eliashof-eltern-infos-col"} -->
			<div class="wp-block-column eliashof-eltern-infos-col">
				<!-- wp:heading {"level":3,"textAlign":"center","className":"eliashof-eltern-infos-subtitle"} -->
				<h3 class="wp-block-heading has-text-align-center eliashof-eltern-infos-subtitle">ANSPRECHPARTNERINNEN</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"className":"eliashof-eltern-infos-item"} -->
				<p class="eliashof-eltern-infos-item">GEV-VORSITZ: Frau Fosco<br>STELLVERTRETUNG: Frau Zitzmann, Frau Kern<br>KONTAKT: <a href="mailto:gev-vorstand@eliashof.net">gev-vorstand@eliashof.net</a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"className":"eliashof-eltern-infos-col"} -->
			<div class="wp-block-column eliashof-eltern-infos-col">
				<!-- wp:heading {"level":3,"textAlign":"center","className":"eliashof-eltern-infos-subtitle"} -->
				<h3 class="wp-block-heading has-text-align-center eliashof-eltern-infos-subtitle">LINKS</h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"className":"eliashof-eltern-infos-item"} -->
				<p class="eliashof-eltern-infos-item"><a href="#">MITWIRKUNG VON ELTERN IN DER SCHULE</a><br><br><a href="#">AKTUELLES VOM BEZIRKSELTERNAUSSCHUSS:</a><br><br><a href="#">AKTUELLES VOM LANDESELTERNAUSSCHUSS</a><br><br><a href="#">AKTUELLE ANGEBOTE DES SIBUZ FÜR ELTERN</a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:column -->

		</div>
		<!-- /wp:columns -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->';
}

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

			// H. Restrict homepage Aktuelles carousel to the "aktuelles" category
			$aktuelles_cat = get_category_by_slug( 'aktuelles' );
			$aktuelles_cat_id = $aktuelles_cat ? (int) $aktuelles_cat->term_id : 0;
			if ( $aktuelles_cat_id > 0 ) {
				$content = preg_replace(
					'/<!-- wp:query \{"queryId":1,"query":\{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":\[\],"sticky":"","inherit":false\},"className":"eliashof-aktuelles-carousel","layout":\{"type":"default"\}\} -->/',
					'<!-- wp:query {"queryId":1,"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"taxQuery":{"category":[' . $aktuelles_cat_id . ']}},"className":"eliashof-aktuelles-carousel","layout":{"type":"default"}} -->',
					$content,
					1
				);
			}

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

	// 2.55. Repair broken Eltern page blocks that Gutenberg can no longer open/edit
	$eltern_page = get_post( 209 );
	if ( ! $eltern_page || 'page' !== $eltern_page->post_type ) {
		$eltern_by_slug = get_page_by_path( 'eltern' );
		if ( $eltern_by_slug instanceof WP_Post ) {
			$eltern_page = $eltern_by_slug;
		}
	}

	if ( $eltern_page instanceof WP_Post ) {
		$content          = $eltern_page->post_content;
		$original_content = $content;
		$fresh_gev        = eliashof_get_eltern_page_gev_markup();
		$fresh_infos      = eliashof_get_eltern_page_infos_markup();

		$gev_section = '';
		if ( preg_match( '/<!-- wp:group \{[^\\n]*"anchor":"section-gev"[\s\S]*?<!-- \/wp:group -->/m', $content, $gev_matches ) ) {
			$gev_section = $gev_matches[0];
		}

		$infos_section = '';
		if ( preg_match( '/<!-- wp:group \{[^\\n]*"anchor":"section-eltern-infos"[\s\S]*?<!-- \/wp:group -->/m', $content, $infos_matches ) ) {
			$infos_section = $infos_matches[0];
		}

		$needs_gev_repair = false;
		if ( $gev_section ) {
			$needs_gev_repair =
				strpos( $gev_section, '<figure class="wp-block-image size-full"><img alt=""/></figure>' ) !== false ||
				(
					strpos( $gev_section, '<!-- wp:image ' ) !== false &&
					strpos( $gev_section, '<img src="' ) === false
				);
		}

		$needs_infos_repair = false;
		if ( $infos_section ) {
			$needs_infos_repair =
				strpos( $infos_section, '"verticalAlignment":null' ) !== false;
		}

		// Replace only genuinely broken stored sections, not valid user edits.
		if ( $needs_gev_repair ) {
			$content = preg_replace(
				'/<!-- wp:group \{[^\\n]*"anchor":"section-gev"[\s\S]*?<!-- \/wp:group -->/m',
				$fresh_gev,
				$content,
				1
			);
		}

		if ( $needs_infos_repair ) {
			$content = preg_replace(
				'/<!-- wp:group \{[^\\n]*"anchor":"section-eltern-infos"[\s\S]*?<!-- \/wp:group -->/m',
				$fresh_infos,
				$content,
				1
			);
		}

		// If old broken raw content is still present without the new wrappers, swap the text blocks by heading.
		if ( strpos( $content, 'anchor":"section-gev"' ) === false && strpos( $content, 'DIE GEV = GESAMTELTERNVERTRETUNG' ) !== false ) {
			$content = preg_replace(
				'/<!-- wp:heading \{"level":2[^\\n]*\} -->\s*<h2[^>]*>DIE GEV = GESAMTELTERNVERTRETUNG<\/h2>[\s\S]*?(?=<!-- wp:heading \{"level":2[^\\n]*\} -->\s*<h2[^>]*>ELTERN INFOS<\/h2>|$)/m',
				$fresh_gev . "\n\n",
				$content,
				1
			);
		}

		if ( strpos( $content, 'anchor":"section-eltern-infos"' ) === false && strpos( $content, '>ELTERN INFOS<' ) !== false ) {
			$content = preg_replace(
				'/<!-- wp:heading \{"level":2[^\\n]*\} -->\s*<h2[^>]*>ELTERN INFOS<\/h2>[\s\S]*$/m',
				$fresh_infos,
				$content,
				1
			);
		}

		if ( $content !== $original_content ) {
			wp_update_post( [
				'ID'           => $eltern_page->ID,
				'post_content' => $content,
			] );
		}
	}

	// 2.6. Automatically create the "Förderverein" page if it doesn't exist
	$foerderverein_page = get_page_by_path( 'foerderverein' );
	if ( ! $foerderverein_page ) {
		$foerderverein_id = wp_insert_post( [
			'post_title'   => 'Förderverein',
			'post_name'    => 'foerderverein',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<!-- wp:pattern {"slug":"eliashof/page-foerderverein"} /-->',
		] );
		if ( $foerderverein_id && ! is_wp_error( $foerderverein_id ) ) {
			set_post_thumbnail( $foerderverein_id, 150 );
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
		update_post_meta( 97, '_menu_item_url', '/aktuelles/' );
	}
	if ( get_post_status( 99 ) ) {
		update_post_meta( 99, '_menu_item_url', '/#spb-hort' );
	}
	if ( get_post_status( 100 ) ) {
		update_post_meta( 100, '_menu_item_url', '/#eltern' );
	}
	if ( get_post_status( 101 ) ) {
		update_post_meta( 101, '_menu_item_url', '/foerderverein/' );
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
	echo '<li><a href="/aktuelles/">ALLE BEITRÄGE</a></li>';
	echo '<li><a href="/unsere-schule/">UNSERE SCHULE</a></li>';
	echo '<li><a href="/#spb-hort">SPB / HORT</a></li>';
	echo '<li><a href="/foerderverein/">FÖRDERVEREIN</a></li>';
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

		// 5. Rename the archive page in navigation to a clearer user-facing label
		if ( eliashof_url_matches_path( $item->url, array( '/aktuelles' ) ) ) {
			$item->title = 'ALLE BEITRÄGE';
		}

		$filtered[] = $item;
	}
	return $filtered;
}
add_filter( 'wp_nav_menu_objects', 'eliashof_filter_menu_items', 10, 2 );

/**
 * Return a normalized internal referer URL when it points to this site.
 */
function eliashof_get_internal_referer_url() {
	$referer = wp_get_referer();

	if ( ! $referer ) {
		return '';
	}

	$home_host    = wp_parse_url( home_url(), PHP_URL_HOST );
	$referer_host = wp_parse_url( $referer, PHP_URL_HOST );

	if ( $home_host && $referer_host && strtolower( $home_host ) !== strtolower( $referer_host ) ) {
		return '';
	}

	return $referer;
}

/**
 * Check whether a URL path matches one of the given internal paths.
 */
function eliashof_url_matches_path( $url, $paths ) {
	$url_path = wp_parse_url( $url, PHP_URL_PATH );
	$url_path = $url_path ? untrailingslashit( $url_path ) : '/';

	foreach ( (array) $paths as $path ) {
		$normalized = untrailingslashit( $path );
		$normalized = '' === $normalized ? '/' : $normalized;

		if ( $url_path === $normalized ) {
			return true;
		}
	}

	return false;
}

/**
 * Resolve the single-post navigation context based on the post categories.
 */
function eliashof_get_post_navigation_context( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id ) {
		return array(
			'slug'             => 'aktuelles',
			'fallback_back_url' => eliashof_resolve_link_target( array( '/#aktuelles', 'aktuelles', '/aktuelles/', '/' ) ),
		);
	}

	$contexts = array(
		'foerderverein' => array(
			'fallback_back_url' => eliashof_resolve_link_target( array( '/foerderverein/#weitere-infos', 'foerderverein', '/foerderverein/', '/' ) ),
		),
		'eltern' => array(
			'fallback_back_url' => eliashof_resolve_link_target( array( '/#eltern', 'eltern', '/' ) ),
		),
		'aktuelles' => array(
			'fallback_back_url' => eliashof_resolve_link_target( array( '/#aktuelles', 'aktuelles', '/aktuelles/', '/' ) ),
		),
	);

	foreach ( $contexts as $slug => $context ) {
		if ( has_category( $slug, $post_id ) ) {
			return array(
				'slug'              => $slug,
				'fallback_back_url' => $context['fallback_back_url'],
			);
		}
	}

	return array(
		'slug'              => 'aktuelles',
		'fallback_back_url' => eliashof_resolve_link_target( array( '/#aktuelles', 'aktuelles', '/aktuelles/', '/' ) ),
	);
}

/**
 * Resolve the best back target for a single post.
 */
function eliashof_get_post_back_target( $post_id = 0 ) {
	$post_id  = $post_id ? (int) $post_id : get_the_ID();
	$context  = eliashof_get_post_navigation_context( $post_id );
	$referer  = eliashof_get_internal_referer_url();
	$fallback = ! empty( $context['fallback_back_url'] ) ? $context['fallback_back_url'] : home_url( '/' );

	if ( ! $referer ) {
		return array(
			'url'   => $fallback,
			'label' => __( 'ZURÜCK', 'eliashof' ),
		);
	}

	$matched_urls = array();

	if ( 'aktuelles' === $context['slug'] ) {
		$matched_urls = array(
			home_url( '/#aktuelles' ),
			home_url( '/aktuelles/' ),
		);
	} elseif ( 'foerderverein' === $context['slug'] ) {
		$matched_urls = array(
			home_url( '/foerderverein/#weitere-infos' ),
			home_url( '/foerderverein/' ),
		);
	} elseif ( 'eltern' === $context['slug'] ) {
		$matched_urls = array(
			home_url( '/#eltern' ),
		);
	}

	foreach ( $matched_urls as $candidate ) {
		if ( $referer === $candidate ) {
			return array(
				'url'   => $referer,
				'label' => __( 'ZURÜCK', 'eliashof' ),
			);
		}
	}

	if ( eliashof_url_matches_path( $referer, array( '/', '/aktuelles', '/foerderverein', '/eltern' ) ) ) {
		return array(
			'url'   => $referer,
			'label' => __( 'ZURÜCK', 'eliashof' ),
		);
	}

	return array(
		'url'   => $fallback,
		'label' => __( 'ZURÜCK', 'eliashof' ),
	);
}

/**
 * Fetch the previous or next post inside the resolved single-post context.
 */
function eliashof_get_context_adjacent_post( $post_id, $direction = 'previous' ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return null;
	}

	$context = eliashof_get_post_navigation_context( $post_id );
	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'date' => 'DESC',
				'ID'   => 'DESC',
			),
			'tax_query'      => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => array( $context['slug'] ),
				),
			),
		)
	);

	if ( empty( $posts ) ) {
		return null;
	}

	$post_ids = array_values(
		array_map(
			static function( $candidate ) {
				return (int) $candidate->ID;
			},
			$posts
		)
	);

	$current_index = array_search( $post_id, $post_ids, true );
	if ( false === $current_index ) {
		return null;
	}

	$target_index = 'previous' === $direction ? $current_index + 1 : $current_index - 1;

	if ( ! isset( $posts[ $target_index ] ) ) {
		return null;
	}

	return $posts[ $target_index ];
}

/**
 * Render context-sensitive navigation for single posts.
 */
function eliashof_render_post_navigation() {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	$post_id  = get_the_ID();
	$context  = eliashof_get_post_navigation_context( $post_id );
	$back     = eliashof_get_post_back_target( $post_id );
	$previous = eliashof_get_context_adjacent_post( $post_id, 'previous' );
	$next     = eliashof_get_context_adjacent_post( $post_id, 'next' );

	ob_start();
	?>
	<div class="eliashof-post-navigation" aria-label="<?php echo esc_attr__( 'Beitragsnavigation', 'eliashof' ); ?>">
		<div class="eliashof-post-nav-prev">
			<?php if ( $previous ) : ?>
				<a href="<?php echo esc_url( get_permalink( $previous ) ); ?>"<?php echo eliashof_get_intern_link_attributes( $previous->ID ); ?>><?php esc_html_e( 'VORHERIGER BEITRAG', 'eliashof' ); ?></a>
			<?php else : ?>
				<span class="eliashof-post-nav-placeholder" aria-hidden="true"></span>
			<?php endif; ?>
		</div>
		<div class="eliashof-post-nav-home">
			<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $back['url'] ); ?>"><?php echo esc_html( $back['label'] ); ?></a>
		</div>
		<div class="eliashof-post-nav-next">
			<?php if ( $next ) : ?>
				<a href="<?php echo esc_url( get_permalink( $next ) ); ?>"<?php echo eliashof_get_intern_link_attributes( $next->ID ); ?>><?php esc_html_e( 'NÄCHSTER BEITRAG', 'eliashof' ); ?></a>
			<?php else : ?>
				<span class="eliashof-post-nav-placeholder" aria-hidden="true"></span>
			<?php endif; ?>
		</div>
	</div>
	<?php

	return ob_get_clean();
}
add_shortcode( 'eliashof_post_navigation', 'eliashof_render_post_navigation' );

/**
 * Shortcode to render the dynamic Aktuelles (News) Archive page with real-time category filters.
 * Use [eliashof_aktuelles_archiv] in block content.
 */
function eliashof_render_aktuelles_archiv() {
	// 1. Get all categories (include empty ones so they appear immediately when created)
	$categories = get_categories( array(
		'hide_empty' => false,
	) );

	// Filter out the 'uncategorized' / 'allgemein' category if desired
	$categories = array_filter( $categories, function( $cat ) {
		return strcasecmp( $cat->slug, 'allgemein' ) !== 0 && strcasecmp( $cat->slug, 'uncategorized' ) !== 0;
	} );

	ob_start();
	?>
	<div class="eliashof-archive-wrapper">
		<!-- Filter Bar -->
		<div class="eliashof-archive-filter-bar">
			<button class="wp-element-button wp-block-button__link eliashof-filter-btn active" data-filter="all">ALL</button>
			<?php foreach ( $categories as $cat ) : ?>
				<button class="wp-element-button wp-block-button__link eliashof-filter-btn" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
					<?php echo esc_html( mb_strtoupper( $cat->name, 'UTF-8' ) ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<!-- Posts Grid -->
		<div class="eliashof-archive-grid">
			<?php
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => 100, // Load enough posts for client-side real-time filtering
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : $query->the_post();
					$post_cats = get_the_category();
					$cat_slugs = array();
					foreach ( $post_cats as $pc ) {
						$cat_slugs[] = $pc->slug;
					}
					$cat_data = implode( ' ', $cat_slugs );
					$has_image = has_post_thumbnail();
					?>
					<div class="eliashof-archive-card" data-categories="<?php echo esc_attr( $cat_data ); ?>">
						<div class="eliashof-archive-card-inner">
							<?php if ( $has_image ) : ?>
								<div class="eliashof-archive-card-image-wrapper">
									<a href="<?php the_permalink(); ?>"<?php echo eliashof_get_intern_link_attributes( get_the_ID() ); ?>>
										<?php the_post_thumbnail( 'full' ); ?>
									</a>
								</div>
							<?php else : 
								// Cycle between Pale Blue, Brand Yellow, and Pale Green
								$colors = array( '#8cc8d1', '#eec68e', '#c5d799' );
								$fallback_color = $colors[ get_the_ID() % count( $colors ) ];
								?>
								<div class="eliashof-archive-card-image-wrapper fallback-bg" style="background-color: <?php echo esc_attr( $fallback_color ); ?> !important;">
									<a href="<?php the_permalink(); ?>"<?php echo eliashof_get_intern_link_attributes( get_the_ID() ); ?>>
										<div class="eliashof-archive-card-fallback-inner">
											<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/illustration-children-line.svg" alt="Illustration" class="eliashof-archive-card-fallback-illustration" />
										</div>
									</a>
								</div>
							<?php endif; ?>
							
							<h3 class="eliashof-archive-card-title"><?php the_title(); ?></h3>
							
							<div class="eliashof-archive-card-excerpt">
								<p><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
							</div>
							
							<div class="eliashof-archive-card-button-wrapper">
								<a class="wp-element-button wp-block-button__link" href="<?php the_permalink(); ?>"<?php echo eliashof_get_intern_link_attributes( get_the_ID() ); ?>>MEHR</a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<p class="eliashof-archive-no-results">Keine Beiträge gefunden.</p>
			<?php endif; ?>
		</div>
	</div>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		const buttons = document.querySelectorAll('.eliashof-filter-btn');
		const cards = document.querySelectorAll('.eliashof-archive-card');

		buttons.forEach(btn => {
			btn.addEventListener('click', function() {
				if (this.classList.contains('active')) return;

				buttons.forEach(b => b.classList.remove('active'));
				this.classList.add('active');

				const filterValue = this.getAttribute('data-filter');

				// Fade out all cards
				cards.forEach(card => {
					card.style.opacity = '0';
					card.style.transform = 'scale(0.95)';
				});

				// Wait for fade out to complete, toggle visibility, then fade in
				setTimeout(() => {
					cards.forEach(card => {
						const cats = (card.getAttribute('data-categories') || '').split(' ');
						if (filterValue === 'all' || cats.includes(filterValue)) {
							card.style.setProperty('display', 'flex', 'important');
							// Force browser layout reflow
							card.offsetHeight;
							card.style.opacity = '1';
							card.style.transform = 'scale(1)';
						} else {
							card.style.setProperty('display', 'none', 'important');
						}
					});
				}, 200);
			});
		});
	});
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'eliashof_aktuelles_archiv', 'eliashof_render_aktuelles_archiv' );
