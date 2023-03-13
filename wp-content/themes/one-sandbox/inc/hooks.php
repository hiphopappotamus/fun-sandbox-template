<?php
/**
 * Custom hooks
 * 
 * @package One_Sandbox
 */

// exit if accessed directly
defined('ABSPATH') || exit;

if(!function_exists('one_sandbox_site_info')):
  /**
   * add site info hook to WP hook library
   */
  function one_sandbox_site_info() {
    do_action('one_sandbox_site_info');
  }
endif;
add_action('one_sandbox_add_site_info', 'one_sandbox_site_info');

if(!function_exists('one_sandbox_add_site_info')):
  function one_sandbox_add_site_info() {
    $the_theme = wp_get_theme();

    $site_info = sprintf(
      '<a href="%1$s">%2$s</a><span class="sep"> | </span>%3$s(%4$s)', esc_url(__('http://wordpress.org', 'one-sandbox')),
      sprintf(
        /* translators: WordPress */
        esc_html__('Happily cooked up by %s', 'one-sandbox'), 'WordPress'
      ),
      sprintf( // WPCS: XSS ok.
        /* translators: 1: Theme name, 2: theme author */
        esc_html('Theme: %1$s by %2$s.', 'one-sandbox'),
        $the_theme->get('Name'),
        'a href="' . esc_url(__('https://underscores.me', 'one-sandbox')) . '">Made from an Underscores Starter Theme.</a>"'
      ),
      sprintf(// WPCS: XSS ok.
        /* translators: Theme version */
        esc_html__('Version: %1$s', 'one-sandbox'),
        $the_theme->get('Version')
      )
    );
    echo apply_filters('one_sandbox_site_info', $site_info); // phpcs: ignore WordPress.Security.EscapeOutput.OutputNotEscaped
  }
endif;