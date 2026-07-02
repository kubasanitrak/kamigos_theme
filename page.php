<?php
/**
 * Template Name: PAGE
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage kamigos_theme
 * @since 1.0
 * * @version 1.0
 */

get_header(); ?>

 


<!-- PAGE CONTENT -->

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php if(is_front_page()) : ?>
			<!-- <div class="page-title-container">
				<h1 class="page-title caps"><?php the_title(); ?></h1>
			</div> -->

			<!-- div.section.section-header.full-width.split-cols>.split-cols--item*2 -->
			<div class="section section-header full-bleed split-cols full-H" data-theme="ochre">
				<div class="split-cols--item">
					<!-- 
					h1.section-header--title
					h3.section-header--subtitle.border-top
					a.link-icon.link-icon--arrow.scroll-down
					-->
					<h1 class="section-header--title">Jsme beach  kolektiv</h1>
					<h4 class="section-header--subtitle border-T">Milujeme beach volejbal  a jeho umění předáváme dál.</h4>
					<a href="#" class="link-icon link-icon--arrow scroll-down"></a>
				</div>
				<div class="split-cols--item carousel">
					<div class="carousel-item carousel-item--img_container">
						<!-- <img decoding="async" data-src="" data-srcset="" sizes="auto"> -->
						<img decoding="async" src="//192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-768x512.webp" class="" alt="" loading="lazy" srcset="//192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-768x512.webp 768w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-300x200.webp 300w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-1024x683.webp 1024w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-1536x1024.webp 1536w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1.webp 1920w" sizes="(max-width: 640px) 100vw, 640px">
					</div>
				</div>
			</div>

				

		<?php endif; ?>

		<!-- <div class="section section-content"> -->
			<?php the_content(); ?>


			<div class="section section-offer full-width" data-theme="silky-blue">
				<h5 class="section-headline caps border-B">Tréninky</h5>
				<h5 class="section-perex">Chcete se potkávat pravidelně? Trénujeme dlouhodobě a systematicky. Dospělí během zimní i letní sezóny, děti v rámci sportovních kroužků. Přihlášky jsou vždy na půl roku nebo školní pololetí. Díky tomu má trénink smysl i kontinuitu a stává se přirozenou součástí vašeho týdne.</h5>

				<div class="cta-container">
					<div class="cta-item">
						<a href="#" class="cta-item--link btn btn-oval btn-outline btn-icon">
							<span class="cta-label h4">pro děti</span>
							<span class="icon icon-circ icon-arrow"></span>
						</a>
					</div>
					<div class="cta-item">
						<a href="#" class="cta-item--link btn btn-oval btn-outline btn-icon">
							<span class="cta-label h4">pro dospělé</span>
							<span class="icon icon-circ icon-arrow"></span>
						</a>
					</div>
				</div>
			</div>
			<div class="section section-about full-width" data-theme="default">
				<h5 class="section-headline caps border-B">Kdo jsme</h5>
				<div class="split-cols">
					<div class="split-cols--item split-cols--item_img">
						<div class="split-cols--img">
							<img decoding="async" src="//192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-768x512.webp" class="" alt="" loading="lazy" srcset="//192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-768x512.webp 768w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-300x200.webp 300w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-1024x683.webp 1024w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1-1536x1024.webp 1536w, //192.168.8.107:3000/kamigos.cz/wp-content/uploads/2026/06/kamigos-foto-akce-placeholder-1.webp 1920w" sizes="(max-width: 640px) 100vw, 640px">
						</div>
					</div>
					<div class="split-cols--item split-cols--item_caption">
						<h5 class="">Jsme beach kolektiv, který tvoří trenéři, zkušení hráči a sportovní nadšenci. Hrajeme, trénujeme a pořádáme akce pro děti i dospělé všech úrovní. A přitom nepočítáme jen body a vítězství. Jde o pohyb, který vás rozvíjí a dává vám větší sebejistotu. O prostředí, kde se cítíte dobře. A o lidi, kteří se navzájem inspirují na hřišti i mimo něj.</h5>
					</div>
				</div>
				<div class="section-row section-row--cta">
					<a href="#" class="btn btn-oval btn-outline caps hover-bgr hover-bgr--ochre">Zjistit víc</a>
				</div>
			</div>
			
			<div class="section section-join full-width" data-theme="silky-blue">
				<!-- h4.section-join--title -->
				<h4 class="section-join--title">Přidejte se ke kamigos</h4>
				<div class="section-join--cta">
					<a href="#" class="btn btn-oval btn-fill caps">Registrovat se</a>
					<p class="plain">Už máte účet?</p>
					<a href="#" class="textlink textlink-underline">Přihlaste se</a>
				</div>
			</div>
		<!-- </div> -->
		<!-- END SECTION CONTENT -->
		
	<?php endwhile; endif; ?>


	<?php get_footer(); ?>