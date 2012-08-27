<?php
define("WPSC_DISABLE_IMAGE_SIZE_FIXES", false);

include 'resources/path.php';
require_once (TK_FILEPATH . '/admin/admin-functions.php');
require_once (TK_FILEPATH . '/admin/admin-interface.php');
require_once (TK_FILEPATH . '/admin/theme-options.php');
require_once (TK_FILEPATH . '/admin/theme-functions.php');
require_once (TK_FILEPATH . '/admin/theme-enqueue.php');

include_once TK_RESOURCE_DIR.'/core.php';
include_once TK_RESOURCE_DIR.'/widget-category.php';

function show_posts_nav() {
   global $wp_query;
   return ($wp_query->max_num_pages > 1);
}

################################################################################
// Add theme sidebars
################################################################################

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
	  	'name' => __( 'Placeholder (Ignore)' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>',
	));
	
	register_sidebar(array(
	  	'name' => __( 'Product Page' ),
                'before_widget' => '<section id="%1$s" class="widget product-page-widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title"><a href="#">',
                'after_title' => '</a></h3>',
	));
	
	register_sidebar(array(
	  	'name' => __( 'Placeholder (Ignore)' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	
	register_sidebar(array(
	  	'name' => __( 'Homepage Left Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	
	register_sidebar(array(
	  	'name' => __( 'Homepage Right Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'Footer Right Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'Inverview Left Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'Inverview Right Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'Blog Left Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'Blog Right Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'IlivE Left Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'IlivE Right Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'IdiE Left Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	register_sidebar(array(
	  	'name' => __( 'IdiE Right Side' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget' => '</section>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
	));
	
}

################################################################################
// Add theme support
################################################################################

if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 60,    60,     true ); // Normal post thumbnails
		add_theme_support( 'post-formats', array( 'aside', 'gallery' ) ); // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.

		add_image_size( 'large' , 600,  '',     true ); // Large thumbnails
		add_image_size( 'medium', 300,  '',     true ); // Medium thumbnails
		add_image_size( 'small' , 125,  '',     true ); // Small thumbnails
		add_image_size( 'slider' , 988,  350,    true ); // slider thumbnail
		
		add_theme_support( 'automatic-feed-links' );    // Add default posts and comments RSS feed links to head
}


################################################################################
// Configure WP2.9+ Navigation Menus
################################################################################

register_nav_menus( 
	array( 
            'header'      => __( 'Main Menu', 'ieclothing' )
) );

################################################################################
// Comment formatting
################################################################################

function theme_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
   	<li>
     <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
       <header class="comment-author vcard">
          <?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?>
          <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
          <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></time>
          <?php edit_comment_link(__('(Edit)'),'  ','') ?>
       </header>
       <?php if ($comment->comment_approved == '0') : ?>
          <em><?php _e('Your comment is awaiting moderation.') ?></em>
          <br />
       <?php endif; ?>

       <?php comment_text() ?>

     </article>
    <!-- </li> is added by wordpress automatically -->
    <?php
}

	

function my_wpsc_products_shortcode($atts) {
	$number_per_page = get_option('use_pagination') ? get_option('wpsc_products_per_page') : 0;
	$query = shortcode_atts(array(
		'category_id' => isset($atts['cat']) ? $atts['cat'] : 0,
		'limit_of_items' => 0,
		'sort_order' => null,
		'number_per_page' => $number_per_page,
		'page' => 0,
	), $atts);
 
	return wpsc_display_products_page($query);
}
add_shortcode('wpsc_category', 'my_wpsc_products_shortcode');
################################################################################
// Actions + Filters
################################################################################

// Remove links to the extra feeds (e.g. category feeds)
remove_action( 'wp_head', 'feed_links_extra', 3 );
// Remove links to the general feeds (e.g. posts and comments)
remove_action( 'wp_head', 'feed_links', 2 );
// Remove link to the RSD service endpoint, EditURI link
remove_action( 'wp_head', 'rsd_link' );
// Remove link to the Windows Live Writer manifest file
remove_action( 'wp_head', 'wlwmanifest_link' );
// Remove index link
remove_action( 'wp_head', 'index_rel_link' );
// Remove prev link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// Remove start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// Display relational links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
// Remove XHTML generator showing WP version
remove_action( 'wp_head', 'wp_generator' );


function custom_excerpt($text) {
	return str_replace('[...]', ' <a href="'. get_permalink($post->ID) . '" class="more">' . 'More&nbsp;&raquo;' . '</a>', $text);
}
add_filter('the_excerpt', 'custom_excerpt');


// Allow HTML in descriptions
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
	remove_filter($filter, 'wp_filter_kses');
}



################################################################################
// Checking Plugin WPEC
################################################################################


/**
 * sometimes on multisite of WordPress setting, the plugin of WPEC is not installed automatically,
 * So this function is for install the plugin.
 * checking if the plugin has installed.
 *
 * @author Onnay Okheng (@onnayokheng)
 * @since July 14, 2012. When the sky is dark ;)
 */
if ( function_exists('wpsc_core_setup_globals') && is_multisite() ) {

	// get option setup themes.
	$setup  = get_option('tk_setup_plugin');

	if(empty($setup)){ // checking if option is empty.
		add_option('tk_setup_plugin', 0);
		add_action('init', 'tk_setup_plugin' ); // call 'tk_setup_plugin' function.
	}

	function tk_setup_plugin(){
		global $wpdb;
		// get option setup themes.
		$setup  = get_option('tk_setup_plugin');
		$count  = $wpdb->get_var('SELECT COUNT(*) FROM `'.WPSC_TABLE_CURRENCY_LIST.'`'); // get count of 'WPSC_TABLE_CURRENCY_LIST' from table.

		if($setup != 1 && $count < 1){
			$wpec   = new WP_eCommerce(); // create new class.
			$wpec->install(); // install wpec plugin data.

			update_option('tk_setup_plugin', 1);
		}
	}
}

function nav_menu_first_last( $items ) {
	 $position = strrpos($items, 'class="menu-item', -1);
	 $items=substr_replace($items, 'menu-item-last ', $position+7, 0);
	 $position = strpos($items, 'class="menu-item');
	 $items=substr_replace($items, 'menu-item-first ', $position+7, 0);
	 return $items;
	 }
 add_filter( 'wp_nav_menu_items', 'nav_menu_first_last' );
?>
