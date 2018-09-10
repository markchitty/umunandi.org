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

<section class="section kids-carousel fuzzy-edges">
  <a name="kids-carousel-section-top" class="section-top"></a>
  <div class="container">
    <h3 class="section-header">We help kids like...</h3>
  </div>
  <?php get_template_part('templates/front-page-carousel'); ?>
</section>

<?php while ($front_page_sections->have_posts()) : $front_page_sections->the_post(); ?>
<section class="section <?= $post->post_name ?> <?= get_post_meta($post->ID, 'umunandi_page_class', true) ?>"
  <?= umunandi_featured_image_bg_style() ?>>
  <div class="container">
    <?php the_content(); ?>
  </div>
</section>
<?php endwhile; wp_reset_postdata(); ?>
