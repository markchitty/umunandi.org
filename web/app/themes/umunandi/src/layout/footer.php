<?php do_action('get_footer'); ?>

<footer class="footer" role="contentinfo">

  <div class="footer-body">
    <div class="container">
      <div class="col-grid footer-cols">
        <div class="col nav">
          <div class="col-grid">
            <?php dynamic_sidebar('footer-nav'); ?>
          </div>
        </div>
        <div class="col contact">
          <?php dynamic_sidebar('footer-contact'); ?>
        </div>
      </div>
        
    </div>
  </div>

  <div class="footer-footer">
    <div class="container">
      <div class="col-grid">
        <div class="col copyright">
          <span>&copy; <?= date('Y'); ?> <?php bloginfo('name'); ?></span>
          <span class="charity-number"><?= get_option('widget_text')[3]['title'] ?></span>
        </div>
        <div class="col designed-by"><?= get_option('widget_text')[4]['text'] ?></div>
      </div>
    </div>
  </div>

</footer>

<div class="scripts-etc">
<?php wp_footer(); ?>
</div>
