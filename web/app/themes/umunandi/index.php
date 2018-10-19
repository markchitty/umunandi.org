<!doctype html>
<html <?php language_attributes(); ?>>

  <?php get_template_part('templates/layout/head'); ?>

  <body <?php body_class(); ?>>
    <a name="top" id="top"></a>

    <?php get_template_part('templates/layout/nav'); ?>

    <?php if (is_page('donate')) : ?>
      <?php get_template_part('templates/pages/donate'); ?>
    <?php else : ?>

      <header class="header" style="<?= umunandi_featured_image_bg_style(is_page('test-page')) ?>">
        <?php do_action('get_header'); ?>
        <?php get_template_part(sprintf('templates/pages/%s/header', umunandi_get_template_type())); ?>
      </header>

      <div class="body" role="document">
        <a name="body-top" class="body-top"></a>
        <?php get_template_part(sprintf('templates/pages/%s/body', umunandi_get_template_type())); ?>
      </div>

    <?php endif; ?>

    <?php get_template_part('templates/layout/footer'); ?>

  </body>
</html>
