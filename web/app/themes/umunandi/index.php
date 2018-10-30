<!doctype html>
<html <?php language_attributes(); ?>>

  <?php get_template_part('src/layout/head'); ?>

  <body <?php body_class(); ?>>
    <a name="top" id="top"></a>

    <?php get_template_part('src/layout/nav/nav'); ?>

    <?php if (is_page('donate')) : ?>
      <?php get_template_part('src/pages/donate/donate'); ?>

    <?php else : ?>
      <header class="header" style="<?= umunandi_featured_image_bg_style(is_page('test-page')) ?>">
        <?php do_action('get_header'); ?>
        <?php get_template_part(sprintf('src/pages/%s/header', umunandi_get_template_type())); ?>
      </header>

      <main role="main">
        <div class="body" role="document">
          <a name="body-top" class="body-top"></a>
          <?php get_template_part(sprintf('src/pages/%s/body', umunandi_get_template_type())); ?>
        </div>
      </main>
    <?php endif; ?>

    <?php get_template_part('src/layout/footer'); ?>

  </body>
</html>
