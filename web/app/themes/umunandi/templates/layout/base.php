<!doctype html>
<html <?php language_attributes(); ?>>

  <?php get_template_part('templates/layout/head'); ?>

  <body <?php body_class(); ?>>
    <a name="top" id="top"></a>

    <div class="ie-warning">
      <!--[if IE]>
      <div class="alert alert-warning">
        You are using an <strong>outdated</strong> browser.
        Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
      </div>
      <![endif]-->
    </div>

    <?php get_template_part('templates/layout/nav'); ?>

    <header class="header table" <?= umunandi_featured_image_bg_style(is_page('test-page')) ?>>
      <div class="td">
        <div class="container">
          <?php do_action('get_header'); ?>
          <?php include new Roots_Wrapping('templates/header.php'); ?>
        </div>
      </div>
    </header>

    <div class="body" role="document">
      <a name="body-top" class="body-top"></a>
      <?php include roots_template_path(); ?>
    </div>

    <?php get_template_part('templates/layout/footer'); ?>

  </body>
</html>