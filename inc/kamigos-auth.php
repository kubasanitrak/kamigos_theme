<?php
/**
 * Custom wp-login.php styling.
 *
 * Registration is handled by the Events and Bookings plugin.
 *
 * @package kamigos_theme
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registration page URL (EAB plugin).
 */
function kamigos_auth_register_url() {
	// if ( class_exists( 'EAB_Event' ) ) {
		// return EAB_Event::get_register_url();
	// }

	return home_url( '/registrace/' );
}

/**
 * Login page URL (EAB plugin or wp-login.php).
 *
 * @param string $redirect Optional redirect target.
 */
function kamigos_auth_login_url( $redirect = '' ) {
	if ( class_exists( 'EAB_Event' ) ) {
		return EAB_Event::get_login_url( $redirect );
	}

	return wp_login_url( $redirect );
}

/**
 * Enqueue login screen assets.
 */
function kamigos_login_enqueue_assets() {
	$theme_uri = get_template_directory_uri();
	$theme_dir = get_template_directory();

	wp_enqueue_style(
		'kamigos-login',
		$theme_uri . '/assets/css/login.css',
		array(),
		filemtime( $theme_dir . '/assets/css/login.css' )
	);

	wp_enqueue_script(
		'kamigos-login',
		$theme_uri . '/assets/js/login.js',
		array(),
		filemtime( $theme_dir . '/assets/js/login.js' ),
		true
	);
}
add_action( 'login_enqueue_scripts', 'kamigos_login_enqueue_assets' );

function kamigos_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'kamigos_login_logo_url' );

function kamigos_login_logo_title() {
	return esc_attr( get_bloginfo( 'name' ) );
}
add_filter( 'login_headertext', 'kamigos_login_logo_title' );

function kamigos_login_body_class( $classes ) {
	$classes[] = 'kamigos-login';
	return $classes;
}
add_filter( 'login_body_class', 'kamigos_login_body_class' );

/**
 * Custom footer on login screen — registration prompt.
 */
function kamigos_login_footer_markup() {
	$register_url = kamigos_auth_register_url();
	?>
	<div class="kamigos-login-footer">
		<p class="kamigos-login-footer__text"><?php esc_html_e( 'Nemáte ještě účet?', 'kamigos_theme' ); ?></p>
		<a class="kamigos-login-footer__link" href="<?php echo esc_url( $register_url ); ?>">
			<?php esc_html_e( 'Zaregistrujte se', 'kamigos_theme' ); ?>
		</a>
	</div>
	<?php
}
add_action( 'login_footer', 'kamigos_login_footer_markup' );

/**
 * Change login button label.
 */
function kamigos_login_form_defaults( $defaults ) {
	$defaults['label_username'] = __( 'E-mail', 'kamigos_theme' );
	$defaults['label_password'] = __( 'Heslo', 'kamigos_theme' );
	$defaults['label_log_in']   = __( 'Přihlásit se', 'kamigos_theme' );
	return $defaults;
}
add_filter( 'login_form_defaults', 'kamigos_login_form_defaults' );

/**
 * Forgot-password link below the password field.
 */
function kamigos_login_forgot_link() {
	?>
	<p class="kamigos-login-forgot">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">
			<?php esc_html_e( 'Zapomněli jste heslo?', 'kamigos_theme' ); ?>
		</a>
	</p>
	<?php
}
add_action( 'login_form', 'kamigos_login_forgot_link' );
