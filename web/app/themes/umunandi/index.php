<!doctype html>
<html <?php language_attributes(); ?>>

  <?php get_template_part('templates/layout/head'); ?>

  <body <?php body_class(); ?>>
    <a name="top" id="top"></a>

    <?php get_template_part('templates/layout/ie-warning'); ?>
    <?php get_template_part('templates/layout/nav'); ?>

    <?php if (is_page('donate')) : ?>
      <?php get_template_part('templates/pages/donate'); ?>
    <?php else : ?>

      <?php get_template_part('templates/layout/header'); ?>

      <div class="body fuzzy-edges" role="document">
        <a name="body-top" class="body-top"></a>
        <?php get_template_part(sprintf('templates/pages/%s/body', umunandi_get_template_type())); ?>
      </div>

    <?php endif; ?>

    <?php get_template_part('templates/layout/footer'); ?>

  </body>
</html>
