<?php
$args = array(
  'post_type'      => 'page',
  'posts_per_page' => -1,
  'post_parent'    => $post->ID,
  'order'          => 'ASC',
  'orderby'        => 'menu_order'
);
$front_page_sections = new WP_Query($args);

while ($front_page_sections->have_posts()) {
  $front_page_sections->the_post();
  $sect = array(
    'class'   => $post->post_name . ' ' . get_post_meta($post->ID, 'umunandi_page_class', true),
    'style'   => umunandi_featured_image_bg_style(),
    'header'  => get_the_title(),
    'content' => apply_filters('the_content', get_the_content()) // also parse shortcodes in the content
  );
  $shortcode = '[section class="%s" style="%s" header="%s"]%s[/section]';
  echo do_shortcode(sprintf($shortcode, $sect['class'], $sect['style'], $sect['header'], $sect['content']));
}

wp_reset_postdata();
?>
