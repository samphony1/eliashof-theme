<?php
/**
 * Eliashof Theme — functions and definitions
 */

if ( ! function_exists( 'eliashof_support' ) ) :
	function eliashof_support() {
		add_theme_support( 'wp-block-styles' );
		add_editor_style( 'style.css' );
	}
endif;
add_action( 'after_setup_theme', 'eliashof_support' );

/**
 * Enqueue Google Fonts (Neucha + Montserrat) and theme stylesheet.
 */
function eliashof_scripts() {
	wp_enqueue_style(
		'eliashof-fonts',
		'https://fonts.googleapis.com/css2?family=Neucha&family=Montserrat:wght@300;400;600&display=swap',
		[],
		null
	);
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
}
add_action( 'wp_enqueue_scripts', 'eliashof_scripts' );

/**
 * Enqueue Google Fonts in the block editor so fonts render while editing.
 */
function eliashof_editor_assets() {
	wp_enqueue_style(
		'eliashof-editor-fonts',
		'https://fonts.googleapis.com/css2?family=Neucha&family=Montserrat:wght@300;400;600&display=swap',
		[],
		null
	);
}
add_action( 'enqueue_block_editor_assets', 'eliashof_editor_assets' );

/**
 * Register block pattern category "eliashof-sections".
 * Patterns themselves are auto-registered from the /patterns directory.
 */
function eliashof_register_pattern_categories() {
	register_block_pattern_category(
		'eliashof-sections',
		[ 'label' => __( 'Eliashof Sections', 'eliashof' ) ]
	);
}
add_action( 'init', 'eliashof_register_pattern_categories' );
