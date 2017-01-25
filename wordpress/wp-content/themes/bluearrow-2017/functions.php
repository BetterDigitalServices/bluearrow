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

add_action('init','bluearrow_2017_init');

include 'class-blue-arrow-2017-menu-item-custom-fields.php';
Blue_Arrow_2017_Menu_Item_Custom_Fields::init();

function bluearrow_2017_scripts()
{
}
add_action( 'wp_enqueue_scripts', 'bluearrow_2017_scripts' );

function bluearrow_2017_reset_admin_bar_margin()
{
  echo "<style>html { margin-top: 0 !important; }</style>";
}

add_action('wp_head', 'bluearrow_2017_reset_admin_bar_margin', 100);

function bluearrow_2017_add_svg_support_to_uploader($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'bluearrow_2017_add_svg_support_to_uploader');

function bluearrow_2017_buttons_2( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}
add_filter( 'mce_buttons_2', 'bluearrow_2017_buttons_2' );

function bluearrow_2017_before_init_insert_formats( $init_array ) {
  $style_formats = [
    [
      'title' => 'Text hightlight',
      'inline'   => 'span',
      'classes' => 'text-highlight',
    ],
  ];
  $init_array['style_formats'] = json_encode( $style_formats );
  return $init_array;
}
add_filter( 'tiny_mce_before_init', 'bluearrow_2017_before_init_insert_formats' );

add_image_size( 'post-feature-image', 1440, 1440, true );
