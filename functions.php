<?php
require_once get_template_directory() . '/inc/theme-assets.php';

add_action( 'after_setup_theme', 'kamigos_theme_setup' );
function kamigos_theme_setup() {
	// load_theme_textdomain( 'kamigos_theme', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;

	register_nav_menus( array(
		'main-menu'    => __( 'Main Menu', 'kamigos_theme' ),
		'footer-menu'    => __( 'Footer Menu', 'kamigos_theme' ),
		// 'lang-menu'    => __( 'Languages Switch', 'kamigos_theme' ),
		'follow-us' => __( 'Follow us', 'kamigos_theme' ),
		// 'get-in-touch' => __( 'Ozvete se', 'kamigos_theme' ),
	) );
}

add_filter( 'the_title', 'kamigos_theme_title' );
function kamigos_theme_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
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
			// $shared_args,
			array (
				'name' => __( 'Get In Touch', 'kamigos_theme' ),
				'id' => 'getintouch-widget-area',
				'before_widget' => ' ',
				'after_widget'  => ' ',
				'before_title' => '<h5 class="widget-title caps">',
				'after_title' => '</h5>',
			)
		)
	);
	register_sidebar( 
		array_merge(
			// $shared_args,
			array (
				'name' => __( 'Follow us', 'kamigos_theme' ),
				'id' => 'followus-widget-area',
				'before_widget' => ' ',
				'after_widget'  => ' ',
				'before_title' => '<h5 class="widget-title caps">',
				'after_title' => '</h5>',
			)
		)
	);
	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Newsleter', 'kamigos_theme' ),
				'id' => 'nl-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title caps">',
				// 'after_title' => '</h3>',
			)
		)
	);
	/*
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
		if ( is_dir( $block_path ) ) {
			register_block_type( $block_path );
		}
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
require_once get_template_directory() . '/inc/kamigos-auth.php';



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


function kamigos_hide_admin_bar_for_subscribers() {
	// if ( ! current_user_can( 'subscriber' ) ||  current_user_can( 'member' )) {
	if ( ! current_user_can( 'administrator' ) ) {
		show_admin_bar( false );
	}
}
add_action( 'after_setup_theme', 'kamigos_hide_admin_bar_for_subscribers' );

function kamigos_logout_shortcode() {
	if ( is_user_logged_in() ) {
		$link = wp_logout_url( home_url() );
		$text = __( 'Odhlásit se', 'kamigos_theme' );
		return '<a class="btn btn-outline btn-oval hover-bgr caps" href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
	}
}
add_shortcode( 'logout_link', 'kamigos_logout_shortcode' );

function kamigos_login_myaccount_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'type' => 'btn',
		),
		$atts,
		'login_myaccount_link'
	);

	if ( is_user_logged_in() ) {
		$link = home_url( '/muj-ucet/' );
		$text = __( 'Můj účet', 'kamigos_theme' );
	} else {
		$link = kamigos_auth_login_url();
		$text = __( 'Přihlásit se', 'kamigos_theme' );
	}

	if ( 'txt' === $atts['type'] ) {
		return '<a class="plain textlink textlink-underline" href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
	}

	return '<a class="btn btn-outline btn-oval hover-bgr caps" href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>';
}
add_shortcode( 'login_myaccount_link', 'kamigos_login_myaccount_shortcode' );