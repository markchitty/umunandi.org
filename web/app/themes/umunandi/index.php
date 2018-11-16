<!doctype html>
<html <?php language_attributes(); ?>>

  <?php require('src/layout/head.php'); ?>

  <body <?php body_class(); ?>>
    <a name="top" id="top"></a>

    <?php require('src/layout/nav/nav.php'); ?>

    <?php do_action('get_header'); ?>
    <?php umunandi_require_template('header'); ?>

    <main role="main">
      <div class="body" role="document">
        <a name="body-top" class="body-top"></a>
        <?php umunandi_require_template('body'); ?>
      </div>
    </main>

    <?php require('src/layout/footer.php'); ?>

  </body>
</html>
