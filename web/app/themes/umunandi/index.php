<!doctype html>
<html <?php language_attributes(); ?>>

  <?php get_template_part('templates/layout/head'); ?>

  <body <?php body_class(); ?>>
    <a name="top" id="top"></a>

    <?php get_template_part('templates/ie-warning'); ?>
    <?php get_template_part('templates/layout/nav'); ?>

      <?php get_template_part('templates/layout/header'); ?>
      <div class="body" role="document">
        <a name="body-top" class="body-top"></a>
        <?php get_template_part(sprintf('templates/%s-body', umunandi_get_template_type())); ?>
      </div>

    <?php get_template_part('templates/layout/footer'); ?>

  </body>
</html>
