
  <section class="section donate-section" <?= umunandi_featured_image_bg_style() ?>>
  <h2>Donate</h2>
    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </section>


