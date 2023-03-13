<?php

/**
 * Admin functions 
 * 
 * @package One_Sandbox
 */

 // exit if accessed directly
 defined('ABSPATH') || exit;

 function acf_options_init() {
  if(function_exists('acf_add_options_page')):
    
    /**
     * Add theme options page
     * 
     * $option_page Parent settings menu item
     * 
     * $option_subpage Subpages under the Theme Options admin menu
     * 
     * @param array Array of settings
     */

     $option_page = acf_add_options_page(array(
      'page_title'    =>  __('Theme General Settings', 'one-sandbox'),
      'menu_title'    =>  __('Theme Settings', 'one-sandbox'),
      'menu_slug'     =>  'theme-general-settings',
      'capability'    =>  'edit_posts',
      'redirect'      =>  false,
      'autoload'      =>  true
     ));

     // sub pages
     $option_subpage = acf_add_options_page(array(
      'page_title'  =>  __('Navbar Settings', 'one-sandbox'),
      'menu_title'  =>  __('Navbar'),
      'parent_slug' =>  $option_page['menu_slug'],
     ));

     $option_subpage = acf_add_options_page(array(
      'page_title'  =>  __('Footer Settings', 'one-sandbox'),
      'menu_title'  =>  __('Footer', 'one-sandbox'),
      'parent_slug' =>  $option_page['menu_slug'],
     ));

  endif;
 }
 add_action('acf/init', 'acf_options_init');

 function acf_register_block_types() {
  acf_register_block_type(array(
    'name'            =>  'acf-flex-content',
    'title'           =>  __('ACF Flexible Content Block', 'one-sandbox'),
    'description'     =>  __('Custom Gutenberg Block', 'one-sandbox'),
    'render_template' =>  'template-parts/blocks/default/default.php',
    'mode'            =>  'edit',
    'icon'            =>  'book-alt',
    'align'           =>  'full',
    'category'        =>  'formatting',
  ));
 }

 if(function_exists('acf_register_block_type')) {
  add_action('acf/init', 'acf_register_block_types');
 }

/**
 * remove wp logo from admin bar
 * from https://www.isitwp.com/remove-wordpress-logo-admin-bar/
 */
function remove_wp_admin_bar_logo() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_wp_admin_bar_logo', 0);

function no_howdy($wp_admin_bar) {
  $admin_acct = $wp_admin_bar->get_node('my-account');
  $newText = str_replace('Howdy', 'The truth is out there', $admin_acct->title);

  $wp_admin_bar->add_node(array(
    'id'  =>  'my-account',
    'title' =>  $newText,
  ));
}
add_filter('admin_bar_menu', 'no_howdy', 25);

if(!function_exists('one_sandbox_custom_menu')):
  /**
   * customize the order of menu items
   * @param array $menu_order   Array of menu items
   * @return array              return the array
   */
  function one_sandbox_custom_menu($menu_order) {
    if(!$menu_order) return true;

    return array(
      'index.php',
      'separator1',
      'edit.php?post_type=page',
      'edit.php',
      'upload.php',
      'separator2',
      'theme-general-settings',
      'nav-menus.php',
      'themes.php',
      'plugins.php',
      'separator3',
      'users.php',
      'separator-last',
      'tools.php',
      'options-general.php'
    );
  }
endif;
add_filter('custom_menu_order', 'one_sandbox_custom_menu');
add_filter('menu_order', 'one_sandbox_custom_menu');

function custom_acf_title($title, $image) {
  /**
   * customize acf flexible layout titles to help with organization on the backend
   * from https://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/
   * @var string
   * @return string
   */
  $title = '';

  if($value = get_sub_field('layout_title')) {
    return $title .= '<b>' . esc_html($value) . '</b>';
  } else if($get_thumbnail = get_sub_field('add_layout_thumbnail') && $image = get_sub_field('layout_thumbnail')) {
    // get thumbnail image
    // note: $get_thumbnail is a var used by acf
    $title .= '<span><img src="' . esc_url($image['sizes']['thumbnail']) . '" style="max-width: 100%; display: block; margin: auto;" /></span>';
  }
  return $title;
}
add_filter('acf/fields/flexible_content/layout_title', 'custom_acf_title', 10, 4);

function remove_widgets() {
  remove_submenu_page('themes.php', 'widgets.php');
}
add_action('admin_menu', 'remove_widgets', 999);

