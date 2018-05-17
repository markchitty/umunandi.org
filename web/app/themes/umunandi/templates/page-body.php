<div class="container">
  <div class="row body-row equal-height-cols">

    <aside class="sidebar col-sm-3 hidden-xs" role="complementary">
      <?php get_template_part('templates/layout/sidebar'); ?>
    </aside>

    <main class="main col-xs-12 col-sm-9" role="main">
      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </main>

  </div>
</div>
