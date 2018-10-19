<section class="section <?= $atts['class'] ?>" style="<?= $atts['style'] ?>">
  <a name="section-top" class="section-top"></a>
  <?php if (isset($atts['header'])) : ?>
  <div class="container"><h3 class="section-header"><?= $atts['header'] ?></h3></div>
  <?php endif; ?>
  <div class="container section-content"><?= do_shortcode($content) ?></div>
</section>

