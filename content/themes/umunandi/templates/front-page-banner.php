<div class="fullpage-banner <?php if (is_page('holding-page')) echo "holding-page"; ?>">

	<div class="fullpage-image" data-stellar-ratio="0.5" style="background: url(<?php umunandi_the_featured_img_src(); ?>) 13% 100% no-repeat;"></div>

	<?php // banner-container is structured as CSS table to enable automatic even vertical spacing of the row contents ?>
  <div class="banner-container">

		<div class="banner-header">
			<span>
        <b><b>
          <b><img class="home-logo" src="<?php bloginfo('template_directory'); ?>/assets/img/umunandi-logo-370.png"></b>
  			  <b><button class="donate-button">Donate</button></b>
        </b></b>
      </span>
		</div>

		<div class="tagline"><span><span class="wrapper"><h1 class="highlighted"><?php bloginfo('description') ?></h1></span></span></div>

    <div class="featured-kids">
      <span>
        <ul>
        <?php foreach(umunandi_featured_kids() as $page) { ?>
          <li><a class="kid" href="<?php echo (is_page('holding-page')) ? '#' : $page->post_name; ?>">
            <span class="kid-name"><?php echo $page->post_title; ?></span>
            <span class="kid-face"><?php echo wp_get_attachment_image(get_post_thumbnail_id($page->ID), 'thumbnail'); ?></span>
          </a></li>
        <?php } ?>
        </ul>
      </span>
    </div>

    <div class="banner-footer"><span><a href="#" class="next-page"><span class="glyphicon glyphicon-chevron-down"></span></a></span></div>

  </div>

</div>