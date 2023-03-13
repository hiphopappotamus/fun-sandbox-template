<?php
/**
 * One Sandbox wysiwyg editor style settings
 * 
 * @package One_Sandbox
 */

// exit if accessed directly
defined('ABSPATH') || exit;

if(!function_exists('add_one_sandbox_editor_style_format')):
  /**
   * reveal tinymce formats dropdown
   * @param array $buttons  Array of button ids
   * @return array
   */
  function add_one_sandbox_editor_style_format($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
  }
endif;
add_filter('mce_buttons_2', 'add_one_sandbox_editor_style_format');

if(!function_exists('one_sandbox_tinymce_before_init')):
  function one_sandbox_tinymce_before_init($settings) {
    $style_formats = array(
      array(
        'title'     =>  'Display-1',
        'selector'  =>  'h1',
        'classes'   =>  'display-1',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Display-2',
        'selector'  =>  'h2',
        'classes'   =>  'display-2',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Display-3',
        'selector'  =>  'h3',
        'classes'   =>  'display-3',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Display-4',
        'selector'  =>  'h4',
        'classes'   =>  'display-4',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Display-5',
        'selector'  =>  'h5',
        'classes'   =>  'display-5',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Display-6',
        'selector'  =>  'h6',
        'classes'   =>  'display-6',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Lead Paragraph',
        'selector'  =>  'p',
        'classes'   =>  'lead',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Small',
        'inline'    =>  'small',
      ),
      array(
        'title'     =>  'Blockquote',
        'block'     =>  'blockquote',
        'classes'   =>  'blockquote',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Blockquote Footer',
        'block'     =>  'figcaption',
        'classes'   =>  'blockquote-footer',
        'wrapper'   =>  true,
      ),
      array(
        'title'     =>  'Cite',
        'inline'    =>  'cite',
      ),
    );

    if(isset($settings['style_formats'])) {
      $orig_style_formats = json_decode($settings['style_formats'], true);
      $style_formats = array_merge($orig_style_formats, $style_formats);
    }

    $settings['style_formats'] = wp_json_encode($style_formats);
    return $settings;
  }
endif;
add_filter('tiny_mce_before_init', 'one_sandbox_tinymce_before_init');