<?php
/**
 * One Sandbox Child Functions
 */
function one_sandbox_child_styles() {
  wp_enqueue_style('one-sandbox-child-main', get_stylesheet_directory_uri() . '/css/main.css', array());
}
add_action('wp_enqueue_scripts', 'one_sandbox_child_styles');