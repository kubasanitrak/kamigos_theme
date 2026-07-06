<?php
/**
 * Front-end and editor asset registration.
 *
 * @package kamigos_theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cache-busting version from file modification time.
 *
 * @param string $relative_path Path relative to theme root, e.g. '/assets/css/style.css'.
 */
function kamigos_asset_version( $relative_path ) {
	$path = get_template_directory() . $relative_path;

	return file_exists( $path ) ? (string) filemtime( $path ) : '1.0.0';
}

/**
 * Member / auth page slugs that use public.css (EAB forms, account).
 *
 * @return string[]
 */
function kamigos_public_asset_page_slugs() {
	return array(
		'registrace',
		'muj-ucet',
		'nastavte-si-heslo',
	);
}

/**
 * Whether the current view needs EAB / member-area styles.
 */
function kamigos_needs_public_assets() {
	if ( apply_filters( 'kamigos_enqueue_public_assets', false ) ) {
		return true;
	}

	if ( kamigos_is_auth_page() ) {
		return true;
	}

	if ( ! class_exists( 'EAB_Post_Types' ) ) {
		return false;
	}

	if ( is_singular( EAB_Post_Types::get_bookable_post_types() ) ) {
		return true;
	}

	if ( is_post_type_archive( EAB_Post_Types::get_bookable_post_types() ) ) {
		return true;
	}

	if ( is_singular( 'page' ) && kamigos_current_page_has_eab_shortcode() ) {
		return true;
	}

	return false;
}

/**
 * Auth-related pages outside EAB shortcode detection.
 */
function kamigos_is_auth_page() {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}

	$post = get_post();
	if ( ! $post ) {
		return false;
	}

	return in_array( $post->post_name, kamigos_public_asset_page_slugs(), true );
}

/**
 * Mirror EAB plugin shortcode detection for theme public.css.
 */
function kamigos_current_page_has_eab_shortcode() {
	$post = get_post();
	if ( ! $post || empty( $post->post_content ) ) {
		return false;
	}

	$shortcodes = array(
		'eab_events_grid',
		'eab_events_list',
		'eab_event_detail',
		'eab_book_button',
		'eab_register',
		'eab_login',
		'eab_set_password',
		'eab_checkout',
		'eab_dashboard',
		'eab_basket_count',
	);

	foreach ( $shortcodes as $shortcode ) {
		if ( has_shortcode( $post->post_content, $shortcode ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Enqueue front-end styles and scripts.
 */
function kamigos_enqueue_frontend_assets() {
	if ( is_admin() ) {
		return;
	}

	$theme_uri = get_template_directory_uri();

	wp_dequeue_style( get_stylesheet() );
	wp_deregister_style( get_stylesheet() );

	wp_enqueue_style(
		'kamigos-style',
		$theme_uri . '/assets/css/style.css',
		array(),
		kamigos_asset_version( '/assets/css/style.css' )
	);

	if ( kamigos_needs_public_assets() ) {
		wp_enqueue_style(
			'kamigos-public',
			$theme_uri . '/assets/css/public.css',
			array( 'kamigos-style' ),
			kamigos_asset_version( '/assets/css/public.css' )
		);
	}

	wp_register_style(
		'kamigos-wp-block-fix',
		$theme_uri . '/assets/css/wp-block-fix-style.css',
		array( 'kamigos-style' ),
		kamigos_asset_version( '/assets/css/wp-block-fix-style.css' )
	);

	wp_enqueue_script(
		'kamigos-lazyload',
		$theme_uri . '/assets/js/lazyload.js',
		array(),
		kamigos_asset_version( '/assets/js/lazyload.js' ),
		true
	);

	wp_enqueue_script(
		'kamigos-theme-front',
		$theme_uri . '/assets/js/theme-front.js',
		array(),
		kamigos_asset_version( '/assets/js/theme-front.js' ),
		true
	);

	if ( get_option( 'thread_comments' ) && is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kamigos_enqueue_frontend_assets', 20 );

/**
 * Shortcodes can render after wp_enqueue_scripts — load public.css in footer if needed.
 */
function kamigos_maybe_enqueue_public_assets_late() {
	if ( is_admin() || ! kamigos_needs_public_assets() ) {
		return;
	}

	if ( wp_style_is( 'kamigos-public', 'enqueued' ) || wp_style_is( 'kamigos-public', 'done' ) ) {
		return;
	}

	wp_enqueue_style(
		'kamigos-public',
		get_template_directory_uri() . '/assets/css/public.css',
		array( 'kamigos-style' ),
		kamigos_asset_version( '/assets/css/public.css' )
	);
}
add_action( 'wp_footer', 'kamigos_maybe_enqueue_public_assets_late', 1 );

/**
 * Non-critical Gutenberg fix stylesheet — printed at end of body.
 */
function kamigos_print_wp_block_fix_style() {
	if ( is_admin() || ! wp_style_is( 'kamigos-wp-block-fix', 'registered' ) ) {
		return;
	}

	wp_enqueue_style( 'kamigos-wp-block-fix' );
	wp_print_styles( 'kamigos-wp-block-fix' );
}
add_action( 'wp_footer', 'kamigos_print_wp_block_fix_style', 5 );

/**
 * Block editor only — not all wp-admin screens.
 */
function kamigos_enqueue_editor_styles() {
	wp_enqueue_style(
		'kamigos-editor',
		get_stylesheet_directory_uri() . '/assets/css/style-editor.css',
		array(),
		kamigos_asset_version( '/assets/css/style-editor.css' )
	);
}
add_action( 'enqueue_block_editor_assets', 'kamigos_enqueue_editor_styles' );
