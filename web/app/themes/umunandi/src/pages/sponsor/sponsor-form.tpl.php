<div class="form-group sponsor-options-row">
  <div class="sponsor-options-label">
    <span>I would like to sponsor</span> 
    <span class="sponsor-options-product-name">...</span>
  </div>
  <div class="sponsor-options">
    <input type="hidden" name="productName">
    <input type="radio" class="hidden-radio"
    name="productId" required
    data-value-missing="&#x2191; Please choose one of these options &#x2191;">
  </div>
  <div class="sponsor-options-price">&nbsp;</div>
  <div class="input-msg" id="productIdInputMsg"></div>
</div>

<?php include dirname(__DIR__) . '/contact/contact-form.tpl.php' ?>
