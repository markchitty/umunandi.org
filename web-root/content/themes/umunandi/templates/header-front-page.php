<div class="home-banner">

  <div class="tagline">
    <h2>
      <?= umunandi_split_sentence(get_bloginfo('description'))[0] ?><br>
      <?= umunandi_split_sentence(get_bloginfo('description'))[1] ?>
    </h2>
  </div>

  <?php global $OVCs; $featured_kids = $OVCs->featured_kids(); ?>
  <div class="featured-kids">
    <ul>
    <?php while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
      <li class="kid">
        <a href="#content"
          data-scrollto="750"
          data-target="#carousel-ovcs"
          data-slide-to="<?= $featured_kids->current_post ?>">
          <div class="kid-face"><?= wp_get_attachment_image(get_field('head_shot'), 'thumbnail') ?></div>
          <div class="kid-name"><?php the_field('first_name') ?></div>
        </a>
      </li>
    <?php endwhile; wp_reset_postdata(); ?>
    </ul>
  </div>

  <div class="scroll-down">
    <a href=".body-top" data-scrollto="750"><span class="icon-arrow-down"></span></a>
  </div>

  <div class="explainer">
    <div class="term">umunandi</div>
    <div class="said">| uh &bull; muh  &bull; nan &bull; dee |</div>
    <div class="transl">my friend</div>
  </div>

</div>
