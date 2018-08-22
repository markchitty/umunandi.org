<div class="body" role="document">
  <a name="body-top" class="body-top"></a>

  <section class="section donate-section" <?= umunandi_featured_image_bg_style() ?>>
    <main class="container">
      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </main>
  </section>

</div>

