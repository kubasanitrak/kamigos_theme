
<div class="section scroll-trigger scroll-trigger--foter section-footer">
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
						'menu_class' => 'foot-nav-list nav-list list-none',
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
			<?php echo do_shortcode('[login_logout_link]'); ?>
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
			
		<script>
			(function() {

				// DEBOUNCE
			const debounce = function(func, delay){
				let timer;
				return function () {     //anonymous function
					const context = this; 
					const args = arguments;
					clearTimeout(timer); 
					timer = setTimeout(()=> {
						  func.apply(context, args)
						},
					delay);
				}
			}
			// THROTTLE
			const throttle = (func, limit) => {
				let lastFunc;
				let lastRan;
				return function() {
					const context = this;
					const args = arguments;
					if (!lastRan) {
					  func.apply(context, args)
					  lastRan = Date.now();
					} else {
					  clearTimeout(lastFunc);
					  lastFunc = setTimeout(function() {
						  if ((Date.now() - lastRan) >= limit) {
							func.apply(context, args);
							lastRan = Date.now();
						  }
					   }, limit - (Date.now() - lastRan));
					}
				}
			}
			const	wrapper = document.getElementById('wrapper-id'),
					content = document.getElementById("content_ID"),
					body = document.body,
					_siteHEADER = document.getElementById("headerID"),
					_siteLOGO = document.getElementById("logoID"),
					_hambBTN = document.getElementById("hmbrgID"),
					_logoBTN = document.getElementById("logoBtnID"),
					_siteTITLE = document.getElementById("site-titleID"),
					_menuBTN = document.getElementById("menuBtnID"),
					_mainNavBar = document.getElementById("main-nav-barID"),
					_scrollLink = document.getElementById("scrolllinkID"),
					_fadestrip = document.getElementById("bottomFade_ID");
			
			let		$scrollDir = "down",
					lastScrollTop,
					iOis_supp = false,
					_logoScaling = false,
					_scrollOnClick = true,
					offsetY,
					_len,
					$sT,
					_logoTransitionTime = 0.875,
					transT = 0.875,
					filterT = 0.65,
					_screenW,
					_btnSOS = document.getElementById("btn-sosID"),
					_projDet = document.getElementById("proj-detID"),
					_footer = document.getElementById("contact"),
					_winH,
					_scrollDist = 0,
					_scrollMin = 20,
					_scrollT,
					_navSwitches = document.querySelectorAll(".nav-switch"),
					_prevDefault = document.querySelectorAll(".prevent-default"),
					forcePause,
					videos = document.querySelectorAll(".inline-video"),
					_bgVideo = document.getElementById('bgvidID'),
					observedItem = document.querySelectorAll(".scroll-trigger");

				window.addEventListener('load', docLoaded);
				
				function toggleSOS() {
					if(!_btnSOS) return;
						
					$sT = document.scrollingElement.scrollTop;
					$scrollDir = $sT > lastScrollTop ? "down" : "up";
					lastScrollTop = $sT;
					if ($sT > 120 && $scrollDir == "down") {
						_btnSOS.classList.add('scroll-minified');
					} 
					if ($sT < 100 && $scrollDir == "up") {
						_btnSOS.classList.remove('scroll-minified');
					}
// console.log(document.scrollingElement.scrollTop);
				}
				function toggleMenu(slideUp) {
					if(window.innerWidth >= window.innerHeight) return;

					if(document.getElementById("navigation").checked === slideUp) return;
					$sT = document.scrollingElement.scrollTop;
					$scrollDir = $sT > lastScrollTop ? "down" : "up";
					lastScrollTop = $sT;
					if ($sT > 120) {
						document.getElementById("navigation").checked = slideUp;
					}
				}
				function toggleSiteHeader(param) {
					if(!_siteHEADER) return;

					if( param ) {
						_siteHEADER.classList.add("scrolled-OFF");
					} else {
						_siteHEADER.classList.remove("scrolled-OFF");
					}
					_menuBTN.checked = false;
				}

				function setStickyOffsetVariables() {
					const elements = document.querySelectorAll('.faq-item--headline');
					const viewportHeight = window.innerHeight;
					const totalHeight = Array.from(elements).reduce((sum, element) => sum + element.offsetHeight, 0);

					// Check if total height of all .faq-claim elements fits in the viewport
					if (totalHeight <= viewportHeight) {
						let previousHeight = 0;
						elements.forEach((element, index) => {
							previousHeight = element.offsetHeight * index;
							element.style.setProperty('--sticky-offset', `${previousHeight}`);
// console.log(element.offsetHeight);
						});
					} else {
					// Optional: Clear --sticky-offset variable if they don't fit
						elements.forEach((element) => {
							// element.style.removeProperty('--sticky-offset');
							element.style.setProperty('--sticky-offset', '1');
						});
					}
				}
				function prevenDefaults() {
					if(!_prevDefault) return;
					
					for(let i=0; i<_prevDefault.length; ++i) {
						_prevDefault[i].addEventListener("click", function(event){
							event.preventDefault();
						});
					}
				}
				function setUpIObserver() {
					var observer = new IntersectionObserver(
						function (entries, observer) {
							entries.forEach(function (entry) {
								// if (entry.intersectionRatio > 0) {
								if (entry.intersectionRatio > 0.2) {
									entry.target.classList.add("inView");
								} else {
									// entry.target.classList.remove("inView");
								}
							});
						},
						{
					        rootMargin: "-50% 0px -15% 0px",
					        // rootMargin: "-15% 0px -15% 0px",
					        threshold: [0, 0.25, 0.5, 0.75, 1]
						}
					);
					observedItem.forEach(function (obs) {
						// console.log("tick");
						observer.observe(obs);
					});
				}

				function addMenuBtnListeners() {
					if(!_navSwitches) return;

					for(let i=0; i<_navSwitches.length; ++i) {
						_navSwitches[i].addEventListener('click', menuBtnChange);
					}

					if(_scrollLink) {
						_scrollLink.addEventListener('click', scroll2Top);
					}
				}

				function loadVideoSrc() {


					if(!videos) return;
// console.log("video loading");

					videos.forEach((videoItem)=> {
						addSourceToVideo(videoItem, videoItem.dataset.videosrc_portrait + '.mp4', 'video/mp4', true);
						addSourceToVideo(videoItem, videoItem.dataset.videosrc_portrait + '.webm', 'video/webm', true);
						addSourceToVideo(videoItem, videoItem.dataset.videosrc + '.mp4', 'video/mp4', false);
						addSourceToVideo(videoItem, videoItem.dataset.videosrc + '.webm', 'video/webm', false);
					});
  
				}

				function addSourceToVideo(element, src, type, portrait) {
					var source = document.createElement('source');
					// LANDSCAPE & PORTRAIT
					source.src = src;
					source.type = type;
					// PORTRAIT ONLY
					if(portrait) {
						source.media = '(max-aspect-ratio: 1 / 1)';
					}


					element.appendChild(source);
				}

				Object.defineProperty(HTMLMediaElement.prototype, "playing", {
					get: function get() {
						return !!(
							this.currentTime > 0 &&
							!this.paused &&
							!this.ended &&
							this.readyState > 2
						);
					}
				});

				function menuBtnChange() {
			// console.log(event.target);
					for(let i=0; i<_navSwitches.length; ++i) {
						if( _navSwitches[i] != event.target ) {
							_navSwitches[i].checked = event.target.checked;
						}
					}
				}

				function addWindowListeners() {
					window.addEventListener('scroll', 
						throttle(function () {
							
							body.classList.remove("firsttime-load");

							_scrollT = document.scrollingElement.scrollTop;

							$scrollDir = _scrollT > lastScrollTop ? "down" : "up";
							
							if($scrollDir=="up") _scrollDist = lastScrollTop - _scrollT;
							lastScrollTop = _scrollT;
							if(($scrollDir=="up" && _scrollT < 150) || ($scrollDir == "up" && _scrollDist > _scrollMin)) {
								toggleSiteHeader(false);
								if(_btnSOS) _btnSOS.classList.add('scroll-minified'); 
							} else if($scrollDir=="down" && _scrollT > 150) {
								toggleSiteHeader(true);
							}
							if((_scrollT > (_winH * 1.15) && $scrollDir=="down")) {
								// fillNavBar(true);
								if(_bgVideo) {
									if(_bgVideo.playing) {
										_bgVideo.pause();
// console.log("pausing video");
									}
								}
								if(_siteHEADER) _siteHEADER.classList.add('scrolled');
// console.log(wrapper.offsetHeight);
// console.log(_scrollT);
								if(_scrollT >= (wrapper.offsetHeight * 0.8)) {

									if(_btnSOS) _btnSOS.classList.remove('scroll-minified');
								} else {
									if(_btnSOS) _btnSOS.classList.add('scroll-minified'); 
								}
								

							} else if((_scrollT < (_winH * 1.15) && $scrollDir=="up")) {
								// fillNavBar(false);
								if(_bgVideo) {
									if(!_bgVideo.playing) _bgVideo.play();
								}

								if(_siteHEADER) _siteHEADER.classList.remove('scrolled');
							}

						}, 500)
					);

					window.addEventListener('resize', 
						debounce(function () {
							// if(_screenW !== window.innerWidth) {
								// gridPrettyAlign(true);
							// }
							_screenW = window.innerWidth;
							_winH = window.innerHeight;
						}, 200)
					);
				}

			//*/ / / / / / / / / / / 
			// IOS and Android detection => ASUME MOBILE=TOUCH DEVICES
				const $isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
				const $isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
				
				const ua = navigator.userAgent.toLowerCase();
				const $isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
			//*/ / / / / / / / / / / 
			/*/ /PRODUCTION
				if(!$isIOS && !$isAndroid) {
			/*/ // DEVELOPMENT
				if(!$isSafari && !$isAndroid) {
			//*/
					wrapper.classList.add('is-desktop');
				}

			// const wrapper = document.getElementById('wrapper-id');

				function docLoaded() {
					window.removeEventListener('load', docLoaded);	
					if(wrapper.classList.contains('loading') ) {
						wrapper.classList.remove('loading');
						wrapper.classList.add('loaded');
					}
					if (!!window.IntersectionObserver) {
				      setUpIObserver();
				      iOis_supp = true;
				      document.body.classList.add("io-supported");
				    }
					_winH = window.innerHeight;

					addMenuBtnListeners();
					prevenDefaults();
					addWindowListeners();
					// toggleSOS();
					loadVideoSrc();

					setStickyOffsetVariables();
				}


			})();
		</script>

		<!-- <script type="module">
	        import { init } from '<?php #echo get_template_directory_uri(); ?>/assets/js/lite-light.min.js';
	
	        	init({
				    imageSelector: '.lightbox',     // CSS selector for images
				    imageUrlAttribute: 'data-gallery',      // Attribute with full-size URL
				    swipeThreshold: 75,                     // Swipe distance to navigate
				    fadeAnimationDuration: 200              // Animation duration (ms)
				});
	    </script>
 -->
	

	 <!-- START WP_FOOTER() -->
	<?php wp_footer(); ?>
	<!-- END WP_FOOTER() -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/wp-block-fix-style.css" />
</body>
</html>