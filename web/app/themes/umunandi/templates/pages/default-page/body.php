<div class="container">
  <div class="row body-row">

    <main class="main col-xs-12" role="main">
      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </main>

  </div>
</div>
