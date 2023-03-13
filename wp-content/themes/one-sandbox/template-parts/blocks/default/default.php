<?php

/**
 * ACF Flexible Content Block Template
 * https://www.advancedcustomfields.com/resources/blocks/
 * @package One_Sandbox
 */

if(have_rows('sections')): while(have_rows('sections')): the_row();

  if(have_rows('options')) {
    while(have_rows('options')) {
      the_row();

      $hide_layout = get_sub_field('hide_layout');

      $layout_utilities_group = get_sub_field('layout_utilities_group');
      $section_id = $layout_utilities_group['section_id']; // outer container
      $section_class = $layout_utilities_group['section_class']; // outer container
      $inner_content_classes = $layout_utilities_group['inner_content_classes'];
      
      $layout_appearance_group = get_sub_field('layout_appearance_group');
      $background_type = $layout_appearance_group['background_type'];
      $section_background_image = $layout_appearance_group['section_background_image'];
      $section_background_color = $layout_appearance_group['section_background_color'];
      $enable_background_parallax = $layout_appearance_group['enable_background_parallax'];
      $background_scroll_speed = $layout_appearance_group['background_scroll_speed'];

      $font_color = $layout_appearance_group['font_color'];


      $div_logic_outer = '';
      if($section_id) {
        $div_logic_outer .= 'id="' . $section_id . '"';
      }
      if($section_class && !$enable_background_parallax) {
        $div_logic_outer .= 'class="' . $section_class . '"';
      }
      if($section_class && $enable_background_parallax) {
        $div_logic_outer .= 'class="bg-parallax ' . $section_class . '"'; 
      }

      $div_logic_inner =  $inner_content_classes ? 'class="' . $inner_content_classes . '"' : '';

      $div_style = 'style="';
      if($background_type['value'] === 'image' && $section_background_image) {
        $div_style .= 'background-image: url(' . $section_background_image . '); background-repeat: no-repeat; background-size: cover; background-position: center;';
      } else if($background_type['value'] === 'color' && $section_background_color) {
        $div_style .= 'background-color: ' . $section_background_color . ';';
      }
      if($font_color)  {
        $div_style .= 'color: ' . $font_color . ';';
      }
      $div_style .= '"';
    }
  }
?>
<?php if(!$hide_layout): ?>
  <section 
    <?php echo $div_style . $div_logic_outer; ?>
    <?php 
      if($enable_background_parallax):
        echo 'data-scroll="' . $background_scroll_speed . '"';
      endif;
    ?>
  >
    <div <?php echo $div_logic_inner; ?>>
      <?php
        switch(get_row_layout()) {
          case 'wysiwyg':
            echo get_sub_field('content');
            break;
          default:
            return;
            break;
        }
      ?>
    </div>
  </section>
<?php endif; // hide_layout ?>
<?php
endwhile; // have_rows('sections')
else:
  echo 'No layouts here!';
endif; // have_rows('sections')