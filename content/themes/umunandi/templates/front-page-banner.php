<div class="banner-fullpage parallax-container">
  <?php
  $bg_img     = (wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'));
  $bg_img_src = roots_root_relative_url($bg_img[0]);
  ?>
  <div class="fullpage-img parallax-bg-img homepage-img" data-stellar-ratio="0.3" style="background-image: url(<?= $bg_img_src ?>);"></div>

  <!-- banner-container is structured as CSS table to enable automatic even vertical spacing of the row contents -->
  <div class="table banner-container">

    <div class="tr banner-header">
      <span class="td">
        <b class="table">
          <b class="tr">
            <b class="td"><img class="home-logo" src="<?php bloginfo('template_directory'); ?>/assets/img/umunandi-logo-370.png"></b>
            <b class="td"><a href="/donate" class="btn donate">Donate</a></b>
          </b>
        </b>
      </span>
    </div><!-- /.banner-header -->

    <div class="tr tagline"><span class="td"><span class="wrapper"><h1 class="highlighted"><?php bloginfo('description') ?></h1></span></span></div>

    <?php global $OVCs; $featured_kids = $OVCs->featured_kids(); ?>
    <div class="tr featured-kids">
      <span class="td">
        <ul>
        <?php while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
          <li>
            <?php if (!is_page('holding-page')) { ?>
            <a class="kid" href="#content" class="scroll-down" data-scrollto="750"
            data-target="#carousel-ovcs" data-slide-to="<?php echo $featured_kids->current_post ?>">
            <?php } else { ?>
            <a class="kid" href="#">
            <?php } ?>
            <span class="kid-name"><?php the_title() ?></span>
            <span class="kid-face"><?php echo wp_get_attachment_image(get_field('head_shot'), 'thumbnail'); ?></span>
          </a></li>
        <?php endwhile; wp_reset_postdata(); ?>
        </ul>
      </span>
    </div><!-- /.featured-kids -->

    <div class="tr banner-footer-spacer"></div>
    
    <div class="tr banner-footer">
      <span class="td"><a href="#content" class="scroll-down" data-scrollto="750"><span class="icon-arrow-down"></span></a></span>
    </div>

  </div><!-- /.banner-container -->
</div><!-- /.banner-fullpage -->

