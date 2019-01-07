
<div class="col <?= $atts['class'] ?>">
  <div class="price-box sketch-box">
    <div class="price-box-header"
      data-product-id="<?= $atts['product_id'] ?>"
      data-product-name="<?= $atts['product_name'] ?>"
      data-price="<?= $atts['price'] ?>">
      <?php foreach($atts['imgs'] as $img): ?>
      <div class="round-img sketch-circle <?= $img['class'] ?>"><?= $img['tag'] ?></div>
      <?php endforeach; ?>
      <h3><span class="smaller">Sponsor</span> <?= $atts['product_name'] ?></h3>
      <div class="price-box-price">
        <?php // Annoying DOM syntax to avoid unwanted spaces ?>
        <span
        class="currency"><?= $atts['currency'] ?></span><span
        class="amount"><?= $atts['price'] ?></span><span
        class="period"> a <?= $atts['period'] ?></span>
      </div>
    </div>
    <div class="price-box-body"><?= $content ?></div>
    <a href="#" class="btn btn-default">Sign up&nbsp; &#x25be;</a>
  </div>
</div>
