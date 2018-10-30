
<div class="price-box sketch-box <?= $atts['class'] ?>">
  <div class="price-box-header">
    <?php foreach($atts['imgs'] as $img): ?>
    <div class="round-img sketch-circle <?= $img['class'] ?>"><?= $img['tag'] ?></div>
    <?php endforeach; ?>
    <h3><span class="smaller">Sponsor</span> <?= $atts['title'] ?></h3>
    <div class="price">
      <?php // Annoying DOM syntax to avoid unwanted spaces ?>
      <span
      class="currency"><?= $atts['currency'] ?></span><span
      class="amount"><?= $atts['price'] ?></span><span
      class="period">per <?= $atts['period'] ?></span>
    </div>
  </div>
  <div class="price-box-body"><?= $content ?></div>
  <a href="#" class="btn btn-default">Sign up&nbsp; &#x25be;</a>
</div>
