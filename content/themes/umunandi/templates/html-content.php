  <div class="wrap">
    <div class="container" role="document">
      <div class="content row">

        <main class="main <?php echo roots_main_class(); ?>" role="main">
          <?php include roots_template_path(); ?>
        </main><!-- /.main -->

        <?php if (roots_display_sidebar()) : ?>
          <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
            <?php include roots_sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>

      </div><!-- /.content -->
    </div><!-- /.container -->
  </div><!-- /.wrap -->
