<?php
$args = array(
  'post_type'      => 'page',
  'posts_per_page' => -1,
  'post_parent'    => $post->ID,
  'order'          => 'ASC',
  'orderby'        => 'menu_order'
);
$front_page_sections = new WP_Query($args);
?>

<?php while ($front_page_sections->have_posts()) : $front_page_sections->the_post(); ?>
<section class="section <?= $post->post_name ?> <?= get_post_meta($post->ID, 'umunandi_page_class', true) ?>"
  <?= umunandi_featured_image_bg_style() ?>>
  <a name="section-top" class="section-top"></a>
  <div class="container">
    <h3 class="section-header"><?php the_title(); ?></h3>
  </div>
  <div class="container">
    <?php the_content(); ?>
  </div>
</section>
<?php endwhile; wp_reset_postdata(); ?>
