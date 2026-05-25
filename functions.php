<?php
add_action( 'after_setup_theme', 'kamigos_theme_setup' );
function kamigos_theme_setup() {
	load_theme_textdomain( 'kamigos_theme', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;

	register_nav_menus( array(
		'main-menu'    => __( 'Hlavni Menu', 'kamigos_theme' ),
		// 'lang-menu'    => __( 'Languages Switch', 'kamigos_theme' ),
		'social-link' => __( 'Social links', 'kamigos_theme' ),
		// 'index-menu'    => __( 'Index Menu', 'kamigos_theme' ),
	) );
}

add_action( 'comment_form_before', 'kamigos_theme_enqueue_comment_reply_script' );
function kamigos_theme_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'kamigos_theme_title' );
function kamigos_theme_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}

/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* RESPONSIVE IMG LAZYLOAD RELATED SCRIPTS */
add_action( 'wp_enqueue_scripts', 'kamigos_theme_scripts' );
function kamigos_theme_scripts() {
    wp_enqueue_script(
        'kamigos_theme_lazyload',
        get_template_directory_uri() . '/assets/js/lazyload.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/lazyload.js' ),
        true
    );
}

function wp_example_excerpt_length( $length ) {
    return 12;
}
add_filter( 'excerpt_length', 'wp_example_excerpt_length');

// REMOVE HARDCODED WIDTH & HEIGHT INLINE IN THUMBNAIL
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
// END REMOVE WIDTH & HEIGHT

add_filter( 'wp_title', 'kamigos_theme_filter_wp_title' );
function kamigos_theme_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'kamigos_theme_widgets_init' );
function kamigos_theme_widgets_init() {
	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<!-- ',
		'after_title'   => ' -->',
		// 'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'before_widget' => ' ',
		// 'after_widget'  => '</div></div>',
		'after_widget'  => ' ',
	);

	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Footer', 'kamigos_theme' ),
				'id' => 'footer-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title">',
				// 'after_title' => '</h3>',
			)
		)
	);
	/*
	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Rezervace', 'kamigos_theme' ),
				'id' => 'rezervace-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title">',
				// 'after_title' => '</h3>',
			)
		)
	);
	*/
}
function kamigos_theme_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
	<?php 
}
add_filter( 'get_comments_number', 'kamigos_theme_comments_number' );

function kamigos_theme_comments_number( $count ) {
	if ( !is_admin() ) {
		global $id;
		$temp_comments = get_comments( 'status=approve&post_id=' . $id );
		$comments_by_type = separate_comments( $temp_comments );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* WRAP THE POST CONTENT IN CUSTOM DIV */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
// function wrap_content_in_div($content) {
//     global $post;
//     return '<div class="flow">'.$content.'</div>';
// }
// add_filter('the_content', 'wrap_content_in_div');

/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */


/*   — — —  — — — — — — — — — — — — */
/*   — — —  — — — — — — — — — — — — */
/*   — — —  — — — — — — — — — — — — */
/*   — — —  — — — — — — — — — — — — */
/* ACF CUSTOM BLOCKS
/*   — — —  — — — — — — — — — — — — */
add_action( 'init', 'register_acf_blocks', 5 );
function register_acf_blocks() {
    foreach ( glob( __DIR__ . '/blocks/block-*' ) as $block_path ) {
        register_block_type( $block_path );
    }
    // $globals = $GLOBALS;
    // foreach ($globals as $key => $value) {
    //     $GLOBALS[$key] = $value;
    // }
    // Register js files in block directories
    // You'll have to name your js file "josh-my-block-name.js" so that it adds the right name space for the block.
    foreach ( glob(__DIR__ . '/blocks/block-*/*.js') as $path) {
        $file_name = pathinfo($path, PATHINFO_FILENAME);
        // wp_register_script( $file_name, get_stylesheet_directory_uri() . '/blocks/' . $file_name . '/' . $file_name . '.js', '', $GLOBALS['version']);
        wp_register_script( $file_name, get_stylesheet_directory_uri() . '/blocks/' . $file_name . '/' . $file_name . '.js', '');
    }
}
// REMOVE INNER DIV WRAPPER INSIDE ACF-BLOCKS
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2 );
function acf_should_wrap_innerblocks( $wrap, $name ) {
    // if ( $name == 'acf/test-block' ) {
        // return true;
    // }
    return false;
}
// Gutenberg custom stylesheet
function custom_gutenberg_editor_styles() {
    wp_enqueue_style(
        'admin-styles',
        get_stylesheet_directory_uri().'/assets/css/style-editor.css?v03-05-2026.01'
    );
}
add_action( 'admin_enqueue_scripts', 'custom_gutenberg_editor_styles' );


/* / — / — / — / — / — / – */
/* / — / — / — / — / — / – */
/* CUSTOMIZE WP LOGIN PAGE */
/* / — / — / — / — / — / – */

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 111 28'%3E%3Cpath fill='%23000' d='m14.706 6.946-6.224 7.119 6.711 7.628H9.671l-5.37-6.547v6.547H0V.67h4.301v12.283l5.126-6.007z'/%3E%3Cpath fill='%23000' d='M14.706 17.579c0-3.094 2.746-4.776 6.956-4.776h1.921v-.27c0-1.322-1.067-2.222-2.867-2.222-1.617 0-3.142.69-3.997 1.712l-2.35-2.493c1.282-1.682 3.845-2.884 6.347-2.884 4.24 0 6.925 2.433 6.925 5.977v9.07h-4.058v-1.741c-.914 1.381-2.288 2.041-4.21 2.041-2.684 0-4.667-1.951-4.667-4.414m8.877-2.012H21.48c-1.923 0-2.96.54-2.96 1.62 0 .872.702 1.443 1.8 1.443 1.923 0 3.264-1.232 3.264-2.703z'/%3E%3Cpath fill='%23000' d='M53.3 21.693h-4.303v-8.169c0-1.742-1.006-2.823-2.562-2.823-1.465 0-2.715.93-2.715 2.823v8.169h-4.302v-8.169c0-1.742-1.007-2.823-2.624-2.823-1.373 0-2.624.901-2.624 2.823v8.169H29.87V6.946h4.301V8.69c1.13-1.592 2.898-2.043 4.272-2.043 1.922 0 3.325.63 4.24 2.163.884-1.261 2.624-2.163 4.515-2.163 3.57 0 6.102 2.313 6.102 5.887z'/%3E%3Cpath fill='%23000' d='M59.899 1.967C60.28.565 61.779-.287 63.202.089c1.455.383 2.289 1.85 1.907 3.252-.373 1.372-1.84 2.232-3.295 1.848-1.424-.375-2.289-1.85-1.915-3.222'/%3E%3Cpath fill='%23000' d='M59.343 6.404 55.18 7.468l3.891 14.755 4.163-1.064z'/%3E%3Cpath fill='%23000' d='m65.328 25.658 2.105-2.943c1.342 1.02 3.051 1.501 4.79 1.501 1.83 0 3.935-1.081 3.935-3.334V19.23c-1.037 1.473-2.654 2.313-4.728 2.313-3.874 0-6.956-3.364-6.956-7.449 0-4.144 3.082-7.448 6.956-7.448 2.074 0 3.691.812 4.728 2.312V6.917h4.303v13.965c0 4.475-3.692 7.118-8.238 7.118-2.44 0-5.4-.871-6.895-2.343m10.83-11.564c0-2.041-1.646-3.543-3.752-3.543-2.075 0-3.752 1.531-3.752 3.543 0 1.983 1.677 3.514 3.752 3.514 2.106 0 3.752-1.5 3.752-3.514'/%3E%3Cpath fill='%23000' d='M97.667 14.335c0 4.385-3.386 7.658-7.78 7.658-4.423 0-7.779-3.273-7.779-7.658s3.356-7.689 7.78-7.689c4.393 0 7.779 3.304 7.779 7.689m-11.38 0c0 2.042 1.557 3.604 3.6 3.604 2.015 0 3.57-1.562 3.57-3.604 0-2.072-1.555-3.634-3.57-3.634-2.043 0-3.6 1.562-3.6 3.634'/%3E%3Cpath fill='%23000' d='m98.156 19.921 1.617-3.244c1.129 1.022 3.448 1.743 5.095 1.743 1.068 0 1.769-.42 1.769-1.022 0-1.892-7.87-.45-7.87-5.886 0-2.883 2.531-4.866 6.101-4.866 2.105 0 4.362.54 5.858 1.712l-1.618 3.334c-1.311-.991-3.356-1.471-4.423-1.471q-1.648 0-1.648.9c0 1.863 7.963.902 7.963 6.127 0 2.763-2.532 4.745-6.04 4.745-2.564 0-5.279-.81-6.804-2.072'/%3E%3C/svg%3E") center center no-repeat;
                width: calc(111px + (148 - 111) * ((100vw - 320px) / (2560 - 320)));
                height: calc(30px + (40 - 30) * ((100vw - 320px) / (2560 - 320)));
				background-size: contain;
				padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return esc_attr( get_bloginfo( 'name' ) );
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

/* / — / — / — / — / — / – */
/* END CUSTOMIZE WP LOGIN PAGE */
/* / — / — / — / — / — / – */
/* / — / — / — / — / — / – */



/* / — / — / — / — / — / – / — / — / — / */
/* / — / — / — / — / — / – / — / — / — / */
/* ADDS SUPPORT FOR EDITOR COLOR PALETTE */
/* / — / — / — / — / — / – / — / — / — / */

function my_theme_color_features() {

    // The new colors we are going to add
    $newColorPalette = [
        [
            'name'  => __( 'Black', 'kamigos_theme' ),
			'slug'  => 'black',
			'color'	=> '#000000',
        ],
		[
			'name'	=>	__( 'Ochre', 'kamigos_theme'),
			'slug'	=>	'ochre',
			'color'	=>	'#D49A2D',
		],
		[
			'name'	=>	__( 'Sky blue', 'kamigos_theme'),
			'slug'	=>	'sky-blue',
			'color'	=>	'#D5EBFF',
		],
		[
			'name'	=>	__( 'Blue', 'kamigos_theme'),
			'slug'	=>	'blue',
			'color'	=>	'#2A79DF',
		],
		[
			'name'	=>	__( 'Dark green', 'kamigos_theme'),
			'slug'	=>	'dark-green',
			'color'	=>	'#00766C',
		],
		[
			'name'	=>	__( 'Off white', 'kamigos_theme'),
			'slug'	=>	'off-white',
			'color'	=>	'#FAF7F5',
		],
		[
			'name'	=>	__( 'Sandy lavender', 'kamigos_theme'),
			'slug'	=>	'sandy-lavender',
			'color'	=>	'#A67CB2',
		],
    ];

    // Apply the color palette containing the original colors and 2 new colors:
    add_theme_support( 'editor-color-palette', $newColorPalette);
    // Disables color picker in block color palette.
    add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'my_theme_color_features' );

/* / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / — / — / – / — / — / — / — / – */
/* KEEP TAGS ORDER AS INSERTED IN POST DETAILS */
/* / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / — / — / – / — / — / — / — / – */
#require_once('includes/SlashAdmin.php');
#$class = new TaxonomyOrder();

/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* WORKAROUND WP NASTY BUG PREPENDING AUTO TO SIZES ATTR */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
add_filter(
    'wp_content_img_tag',
    static function ( $image ) {
	    return str_replace( ' sizes="auto, ', ' sizes="', $image );
    }
);
add_filter(
    'wp_get_attachment_image_attributes',
    static function ( $attr ) {
		if ( isset( $attr['sizes'] ) ) {
			$attr['sizes'] = preg_replace( '/^auto, /', '', $attr['sizes'] );
		}
		return $attr;
    }
);
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* END WORKAROUND WP NASTY BUG PREPENDING AUTO TO SIZES ATTR */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */