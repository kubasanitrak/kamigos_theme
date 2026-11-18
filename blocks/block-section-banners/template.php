<?php
/**
 * Block Name: BLOCK-section-banners
 *
 * Stack of image cards. Each card scrolls to a section anchor on this page.
 *
 * @param array $block The block settings and attributes.
 */

$classes = 'section-banners split-cols--item split-cols--item_banners';
if ( ! empty( $block['className'] ) ) {
	$classes .= ' ' . $block['className'];
}

if ( ! have_rows( 'banner_items' ) ) {
	if ( ! empty( $is_preview ) ) {
		echo '<p class="section-banners__empty">' . esc_html__( 'Přidejte banner.', 'kamigos_theme' ) . '</p>';
	}
	return;
}
?>
<div
	<?php
	echo wp_kses_data(
		get_block_wrapper_attributes(
			array(
				'class' => esc_attr( $classes ),
			)
		)
	);
	?>
>
	<?php
	while ( have_rows( 'banner_items' ) ) :
		the_row();

		$label  = get_sub_field( 'banner_label' );
		$image  = get_sub_field( 'banner_image' );
		$anchor = get_sub_field( 'banner_section_anchor' );
		$anchor = is_string( $anchor ) ? ltrim( trim( $anchor ), '#' ) : '';
		$anchor = preg_match( '/^[A-Za-z][\w:.-]*$/', $anchor ) ? $anchor : '';

		if ( $anchor ) {
			printf( '<a class="section-banner" href="#%s">', esc_attr( $anchor ) );
		} else {
			echo '<div class="section-banner ">';
		}
		?>
			<span class="section-banner__head">
				<?php if ( $label ) : ?>
					<h2 class="section-banner__title"><?php echo esc_html( $label ); ?></h2>
				<?php endif; ?>
				<span class="icon icon-circ icon-arrow" aria-hidden="true"></span>
			</span>
			<span class="section-banner__media">
				<?php
				$image_id = 0;
				if ( is_numeric( $image ) ) {
					$image_id = (int) $image;
				} elseif ( is_array( $image ) && ! empty( $image['ID'] ) ) {
					$image_id = (int) $image['ID'];
				}
				if ( $image_id ) :
					$img_src    = wp_get_attachment_image_url( $image_id, 'medium' );
					$img_srcset = wp_get_attachment_image_srcset( $image_id, 'large' );
					$img_alt    = $label ? '' : (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					?>
					<img
						class="section-banner__img lazyload"
						data-src="<?php echo esc_url( $img_src ); ?>"
						<?php if ( $img_srcset ) : ?>
							data-srcset="<?php echo esc_attr( $img_srcset ); ?>"
						<?php endif; ?>
						data-sizes="auto"
						alt="<?php echo esc_attr( $img_alt ); ?>"
					>
				<?php endif; ?>
			</span>
		<?php
		echo $anchor ? '</a>' : '</div>';
	endwhile;
	?>
</div>
