<?php
/**
 * custom functions for One Sandbox
 * 
 * @package One_Sandbox
 */

// exit if accessed directly
defined('ABSPATH') || exit;

if (!function_exists('bidirectional_acf_update_value')):
  /**
   * set up bidirectional fields for post relationships
   * from https://www.advancedcustomfields.com/resources/bidirectional-relationships/
   * @param string  $value
   * @param int $post_id
   * @param string  $field
   * @return  string  $value
   */

   function bidirectional_acf_update_value($value, $post_id, $field) {
    //vars
    $field_name = $field['name'];
    $field_key  = $field['key'];
    $global_name  = 'is_updating_' . $field_name;

    if(!empty($GLOBALS[$global_name])) return $value;

    $GLOBALS[$global_name] = 1;

    if(is_array($value)) {
      foreach($value as $post_id2) {
        $value2 = get_field($field_name, $post_id2, false);

        if(empty($value2)) {
          $value2 = array();
        }

        if(in_array($post_id, $value2)) continue;

        $value2[] = $post_id;

        update_field($field_key, $value2, $post_id2);
      }
    }

    $old_value = get_field($field_name, $post_id, false);

    if(is_array($old_value)) {
      foreach($old_value as $post_id2) {
        if(is_array($value) && in_array($post_id2, $value)) continue;

        $value2 = get_field($field_name, $post_id2, false);

        if(empty($value2)) continue;

        $pos = array_search($post_id, $value2);

        unset($value2[$pos]);

        update_field($field_key, $value2, $post_id2);
      }
    }

    $GLOBALS[$global_name] = 0;

    return $value;
   }
endif;
add_filter('acf/update_value/name=posts_loader', 'bidirectional_acf_update_value', 10, 3);

if(!function_exists('filetype_mimecheck')):

  function filetype_mimecheck() {
    /**
     * check file/mimetype of featured image, add svg-img to img-fluid class, wrap everything in a conditional
     * @var WP_Query; 
     */

    $mime_post = new WP_Query;

    $id = get_post_thumbnail_id($mime_post->ID);
    $type = get_post_mime_type($id);
    $mime_type = explode('/', $type);

    if(has_post_thumbnail($mime_post->ID)) {
      $image_class = $mime_type['1'] === 'svg+xml' ? 'svg-img img-fluid card-img-top rounded-0' : 'img-fluid card-img-top rounded-0';

      return $post_image = get_the_post_thumbnail($mime_post->ID, 'thumbnail', array('class' => $image_class, 'alt' => get_the_title()));
    }

    wp_reset_postdata();
  }
endif;

if(!function_exists('svg_mime_support')):

  function svg_mime_support($file_types) {
    /**
     * enable uploading of svg files to media library
     * 
     * from https://www.eruditeworks.com/2021/08/26/how-to-enable-svg-image-in-wordpress/
     * @var array $file_types Set file types to be overridden
     * 
     * @return array
     */
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;

  }

endif;
add_filter('upload_mimes', 'svg_mime_support');

if(!function_exists('custom_excerpt')):
  function custom_excerpt($excerpt) {
    $post_excerpt = str_replace('<p>', '<p class="post-excerpt">', $excerpt);

    return $post_excerpt;
  }
endif;
add_filter('the_excerpt', 'custom_excerpt', 10, 1);
