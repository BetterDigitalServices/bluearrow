<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function bluearrow_2017_excerpt_more( $more ) {
  return '...';
}
add_filter( 'excerpt_more', 'bluearrow_2017_excerpt_more' );

// Fix pagination when using {category}/{slug} formatted permalinks
function bluearrow_2017_init() {
  global $wp_rewrite;
  add_rewrite_rule("author/([^/]+)/page/?([0-9]{1,})/?$",'index.php?author_name=$matches[1]&paged=$matches[2]','top');
  add_rewrite_rule("(.+?)/page/?([0-9]{1,})/?$",'index.php?category_name=$matches[1]&paged=$matches[2]','top');
  $wp_rewrite->flush_rules(false);
}

include 'class-blue-arrow-2017-menu-item-custom-fields.php';
Blue_Arrow_2017_Menu_Item_Custom_Fields::init();

add_action('init','bluearrow_2017_init');

// Fixes social media meta tags plugin, sometimes media picker fails to load
function bluearrow_2017_init_media() {
  wp_enqueue_media();
}
add_action('admin_init', 'bluearrow_2017_init_media');
