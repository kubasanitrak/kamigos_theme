<?php 
	$DATA_THEME = get_field('data-theme') ? get_field('data-theme') : 'default';
?>
<div class="section scroll-trigger scroll-trigger--foter section-footer" data-theme="<?php echo $DATA_THEME; ?>">
	<div class="section-footer--row">
		<div class="section-footer--col section-footer--col_logo">
			<!-- LOGO -->
			<div class="logo-container" style="--logo-ratio: 800/212;">
				<div class="svg-container logo" id="logoID" style="--aspect-ratio: 800/212;">
					<!-- LOGO SVG -->
					<?php get_template_part( 'template-parts/logo', 'top' ); ?>
					<!-- LOGO SVG -->
				</div>
			</div>
		</div>
		<div class="section-footer--col section-footer--col_nav">
			<div class="menu">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'main-menu',
						'container' => '',
						'menu_class' => 'foot-nav-list cols-2 nav-list list-none',
					 ) );
				?>
			</div>
			
		</div>
	</div>
	<div class="section-footer--row section-footer--row_cols">
		<div class="section-footer--col section-footer--col_50 border-T">
			<!-- WIDGET GET IN TOUCH -->
			<?php
				if ( is_active_sidebar( 'getintouch-widget-area' ) ) :
					dynamic_sidebar( 'getintouch-widget-area' );
				endif;
			?>
		</div>
		<div class="section-footer--col section-footer--col_50 border-T">
			<!-- WIDGET FOLLOW US -->
			<?php
				if ( is_active_sidebar( 'followus-widget-area' ) ) :
					dynamic_sidebar( 'followus-widget-area' );
				endif;
			?>
		</div>
	</div>
	<div class="section-footer--row">
		<div class="section-footer--col section-footer--col_log-in-out">
			<?php echo do_shortcode('[login_myaccount_link]'); ?>
		</div>

		<div class="section-footer--col section-footer--col_newsletter">
			<!-- WIDGET NEWSLETTER -->
			<?php
				if ( is_active_sidebar( 'nl-widget-area' ) ) :
					dynamic_sidebar( 'nl-widget-area' );
				endif;
			?>
		</div>
	</div>
	<div class="section-footer--row border-T">
		<div class="section-footer--col section-footer--col_nav">			
			<?php				
				wp_nav_menu( array(
					'theme_location' => 'footer-menu',
					'container' => '',
					'menu_class' => 'foot-nav-list nav-list list-none',
				 ) );
			?>
		</div>
		<div class="section-footer--col">
			<?php 
				$CURR_YEAR = date('Y');
			?>
			<p class="copyright">©&nbsp;<?php echo strval($CURR_YEAR); ?>&nbsp;<?php echo get_bloginfo( 'name' ); ?></p>
		</div>
		
	</div>

</div>
</div> <!-- END WRAPPER -->

	<?php wp_footer(); ?>
</body>
</html>