<?php do_action('get_footer'); ?>

<footer class="footer" role="contentinfo">

  <div class="footer-body">
    <div class="container">
      <div class="row">
        <?php dynamic_sidebar('sidebar-footer'); ?>
      </div>
    </div>
  </div>

  <div class="footer-footer">
    <div class="container">
      <span class="copy">&copy; <?= date('Y'); ?> <?php bloginfo('name'); ?></span>
      <span class="charity-number"><?= get_option('widget_text')[3]['title'] ?></span>
    </div>
  </div>

</footer>

<?php wp_footer(); ?>
