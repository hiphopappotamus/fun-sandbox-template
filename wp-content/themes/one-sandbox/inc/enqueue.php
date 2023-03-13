<?php
/**
 * Enqueue scripts and styles
 */
// exit if accessed directly
defined('ABSPATH') || exit;

function one_sandbox_scripts() {
  /**
   * Enqueue scripts and styles.
   */
  wp_enqueue_script('jquery');

  // custom js array
  // TODO: set up a minifier
  $js_dir = '/js';
  $js_files = array(
    '/bootstrap.bundle.min.js'
  );

  foreach($js_files as $file) {
    wp_enqueue_script(str_replace(['/', '.', 'js'], '', $file), get_template_directory_uri() . $js_dir . $file, null, null, true);
  }

  wp_enqueue_style('one-sandbox-style', get_stylesheet_uri(), array(), _S_VERSION);
  wp_style_add_data('one-sandbox-style', 'rtl', 'replace');

  wp_enqueue_script('one-sandbox-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

  wp_enqueue_style('one-sandbox-mainstyle', get_template_directory_uri() . '/css/main.css', array());

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'one_sandbox_scripts');