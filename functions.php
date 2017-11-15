<?php
/**
 * This File is highly inspired by html5blank theme
 * Go and give it a try !
 * Credit: Todd Motto -- https://github.com/html5blank/html5blank
 */


/**
 * Theme Support
 * -->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->
 */

if ( function_exists( 'add_theme_support' ) ) {
  // Thumbnails
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'large', 750, '', true );
    add_image_size( 'medium', 250, '', true );
    add_image_size( 'small', 125, '', true );
    // You may add custom-sizes here, see https://developer.wordpress.org/reference/functions/add_image_size/
    // add_image_size( string $name, int $width, int $height, bool|array $crop = false )
    //
  // RSS Feed
    add_theme_support( 'automatic-feed-links' );
  // HTML5 markup
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
}

/**
 * Scripts and Styles
 * -->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->
 */

function lmbp_main_scripts() {
  if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
    wp_register_script( 'masterscript', get_template_directory_uri() . '/js/masterscript.js', [], '1.0.0' );
    wp_enqueue_script( 'masterscript' );
  }
}

function lmbp_template_scripts() {
  if ( is_page_template( 'templatename' ) ) {
    wp_register_script( 'templatenamescript', get_template_directory_uri() . '/js/templatescripts/templatenamescript.js', [ 'jquery' ], '1.0.0' );
    wp_enqueue_script( 'templatenamescript' );
  }
}

function lmbp_page_scripts() {
  if ( is_page( 'pagename' ) ) {
    wp_register_script( 'pagenamescript', get_template_directory_uri() . '/js/pagescripts/pagenamescript.js', [ 'jquery' ], '1.0.0' );
    wp_enqueue_script( 'pagenamescript' );
  }
}

function lmpb_main_styles() {
  wp_register_style( 'masterstyle', get_template_directory_uri() . '/css/masterstyle.css', [], '1.0.0' );
  wp_enqueue_style( 'masterstyle' );
}


/**
 * Navigation and Menus
 * -->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->
 */

function lmbp_navigation() {
  wp_nav_menu([
    'theme_location'  => 'header-menu',
    'menu'            => '',
    'container'       => 'nav',
    'container_class' => 'nav-{menu slug}',
    'container_id'    => '',
    'menu_class'      => 'menu',
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul>%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
  ]);
}

function lmbp_register_menus() {
  register_nav_menus([
    'header-menu'  => 'Header Menu',
    'footer-menu'  => 'Footer Menu',
    'social-menu'  => 'Social Menu',
    'sidebar-menu' => 'Sidebar Menu'
  ]);
}

/**
 * Cleans Up dynamic Navigation a bit
 * -->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->
 */
// Removes navigation extra surrounding <div>
function lmbp_wp_nav_menu_args( $args = '' ) {
  $args['container'] = false;
  return $args;
}
// Removes unwanted classes and ids inside navigation <li> items
function lmbp_css_attributes_filter( $var ) {
  return is_array( $varcf ) ? array() : '';
}

function lmbp_remove_category_rel_from_category_list( $thelist ) {
  return str_replace( 'rel="category tag"', 'rel="tag"', $thelist );
}

function lmbp_add_page_slug_to_body_class( $classes ) {
  global $post;
  if ( is_home() ) {
    $key = array_search( 'blog', $classes, true );
    if ( $key > -1 ) unset( $classes[$key] );
  } elseif ( is_page() || is_singular() ) {
    $classes[] = sanitize_html_class( $post->post_name );
  }
  return $classes;
}

function lmbp_remove_images_width_and_height_attributes( $html ) {
  $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
  return $html;
}

function lmbp_remove_thumbnail_dimensions( $html ) {
  $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
  return $html;
}

function lmbp_remove_admin_bar() {
  return false;
}

/**
 * Actions and Filters
 * -->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->-->
 */

add_action( 'wp_enqueue_scripts', 'lmbp_main_scripts' );
add_action( 'wp_print_scripts', [ 'lmbp_template_scripts', 'lmbp_page_scripts' ] );
add_action( 'wp_enqueue_scripts', 'lmbp_main_styles' );
add_action( 'init', 'lmbp_register_menus' );

add_filter( 'body_class', 'lmbp_add_page_slug_to_body_class' );
add_filter( 'wp_nav_menu_args', 'lmbp_wp_nav_menu_args' );
add_filter( 'nav_menu_css_class', 'lmbp_css_attributes_filter', 100, 1 );
add_filter( 'nav_menu_item_id', 'lmbp_css_attributes_filter', 100, 1 );
add_filter( 'page_css_class', 'lmbp_css_attributes_filter', 100, 1 );
add_filter( 'the_category', 'lmbp_remove_category_rel_from_category_list' );
add_filter( 'show_admin_bar', 'lmbp_remove_admin_bar' );
add_filter( 'post_thumbnail_html', 'lmbp_remove_thumbnail_dimensions' );
add_filter( 'post_thumbnail_html', 'lmbp_remove_images_width_and_height_attributes' );
add_filter( 'image_send_to_editor', 'lmbp_remove_images_width_and_height_attributes' );

