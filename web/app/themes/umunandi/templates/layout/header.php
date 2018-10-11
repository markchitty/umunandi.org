<?php do_action('get_header'); ?>

<header class="header" <?= umunandi_featured_image_bg_style(is_page('test-page')) ?>>
  <div class="container">
    <?php get_template_part(sprintf('templates/pages/%s/header', umunandi_get_template_type())); ?>
  </div>
</header>
