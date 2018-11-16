<header class="header" style="<?= umunandi_featured_image_bg_style() ?>">
  <div class="home-page-header container">

    <div class="tagline">
      <h2><?= str_replace(" get", "<br>get", get_bloginfo('description')) ?></h2>
      <a class="learn-more btn btn-primary" href=".body-top" data-scrollto="750" data-scrolloffset="10">
        Learn more &nbsp;&#x25be;
      </a>
    </div>

    <?php global $OVCs; $featured_kids = $OVCs->featured_kids(); ?>
    <div class="featured-kids">
      <?php while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
      <div class="kid">
        <a href=".body-top"
          data-scrollto="750"
          data-scrolloffset="10"
          data-target=".js-kids-carousel"
          data-slide-to="<?= $featured_kids->current_post ?>">
          <div class="round-img"><?= wp_get_attachment_image(get_field('head_shot'), 'small') ?></div>
          <div class="kid-name"><?php the_field('first_name') ?></div>
        </a>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <div class="scroll-down">
      <a href=".body-top" data-scrollto="750" data-scrolloffset="10"><span class="icon-arrow-down"></span></a>
    </div>

    <?php /* 
    <div class="explainer">
      <div class="term">umunandi</div>
      <div class="said">| uh &bull; muh  &bull; nan &bull; dee |</div>
      <div class="transl">my friend</div>
    </div>
    */ ?>

  </div>
</header>
