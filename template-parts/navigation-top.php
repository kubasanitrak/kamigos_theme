<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage kamigos_theme
 * @since 1.0
 * * @version 1.0
 */

?>


<!-- <input type="checkbox" id="menuBtnID" class="desktop-hide nav-switch" checked> -->
<input type="checkbox" id="menuBtnID" class="desktop-hide nav-switch">
<label for="menuBtnID" class="hamburger hamburger--htx desktop-hide">
	<span>menu</span>
</label>
<div class="menu-container">
	<?php
	
	wp_nav_menu( array(
		'theme_location' => 'main-menu',
		'container' => '',
		'menu_class' => 'main-nav-list nav-list list-none',
	 ) );
?>
	<div class="submenu">
	<?php
		wp_nav_menu( array(
			'theme_location' => 'follow-us',
			'container' => '',
			'menu_class' => 'nav-list sub-nav-list list-none desktop-hide',
		 ) );
	?>
		<!-- LOGIN / LOGOUT BTN -->
		<!-- <a href="#" class="btn btn-outline hover-bgr caps">Přihlásit se</a> -->
		<?php echo do_shortcode('[login_myaccount_link]'); ?>
	</div>
</div>