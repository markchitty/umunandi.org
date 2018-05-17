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
<section class="section">
  <?php get_template_part('templates/front-page-carousel'); ?>
</section>

<?php while ($front_page_sections->have_posts()) : $front_page_sections->the_post(); ?>
<section class="section <?= $post->post_name ?>" <?= umunandi_featured_image_bg_style() ?>>
  <div class="container">
    <?php the_content(); ?>
  </div>
</section>
<?php endwhile; wp_reset_postdata(); ?>
