<?php
/**
 * custom theme settings
 * 
 * @package One_Sandbox
 */

// exit if accessed directly
defined('ABSPATH') || exit;

if(!function_exists('custom_theme_excerpt_length')):
  function custom_theme_excerpt_length($length) {
    return 10;
  }
endif;
add_filter('excerpt_length', 'custom_theme_excerpt_length');