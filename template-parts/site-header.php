<?php
/**
 * Site header: logo and main navigation.
 *
 * @package kamigos_theme
 *
 * @var array $args {
 *     @type string $theme Value for the data-theme attribute. Default 'default'.
 * }
 */

$theme = 'default';
if ( ! empty( $args['theme'] ) ) {
	$theme = $args['theme'];
}
?>
<div class="header" id="headerID" data-theme="<?php echo esc_attr( $theme ); ?>">
	<div class="logo-container">
		<div class="svg-container logo" id="logoID" style="--aspect-ratio: 800/212;">
			<?php get_template_part( 'template-parts/logo', 'top' ); ?>
		</div>
		<a class="abs-link" href="<?php echo esc_url( get_site_url() ); ?>"></a>
	</div>
	<?php get_template_part( 'template-parts/navigation', 'top' ); ?>
</div>
