<?php do_action('get_header'); ?>

<header class="header table" <?= umunandi_featured_image_bg_style(is_page('test-page')) ?>>
  <div class="td">
    <div class="container">
      <?php get_template_part(sprintf('templates/%s-header', umunandi_get_template_type())); ?>
    </div>
  </div>
</header>
