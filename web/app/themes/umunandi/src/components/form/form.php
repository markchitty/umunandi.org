<form novalidate class="umunandi-form default-form <?= $type ?>-form <?= $class ?>"
  name="<?= $type ?>"
  action="<?= admin_url('admin-ajax.php') ?>"
  data-nonce="<?= $nonce ?>"
  data-wp-action="<?= $action ?>"
  data-error-generic="🧐 Something went wrong. Can you try that again?"
  data-error-timeout="⏳ Looks like the network is a bit flaky. Can you try that again?">
  <?php if ($is_sponsor) : ?>
  <div class="form-group sponsor-options-row">
    <div class="sponsor-options-label">
      <span>I would like to sponsor</span> 
      <span class="sponsor-options-product">...</span>
    </div>
    <div class="sponsor-options">
      <input type="radio" class="hidden-radio"
      name="product" required
      data-value-missing="&#x2191; Please choose one of these options &#x2191;">
    </div>
    <div class="sponsor-options-price">&nbsp;</div>
    <div class="input-msg" id="productInputMsg"></div>
  </div>
  <?php endif; ?>
  <div class="name-row">
    <div class="form-group first-name">
      <label for="firstName">First name</label>
      <div class="input-container sketch-box-input">
        <input type="text" class="form-control"
        id="firstName" name="firstName" required
        placeholder="Joe" data-value-missing="Please enter your first name">
        <span></span>
      </div>
      <div class="input-msg" id="firstNameInputMsg"></div>
    </div>
    <div class="form-group last-name">
      <label for="lastName">Last name</label>
      <div class="input-container sketch-box-input">
        <input type="text" class="form-control"
        id="lastName" name="lastName" required
        placeholder="Brown" data-value-missing="Please enter your last name">
        <span></span>
      </div>
      <div class="input-msg" id="lastNameInputMsg"></div>
    </div>
  </div>
  <div class="form-group email">
    <label for="email">Email</label>
    <div class="input-container sketch-box-input">
      <input type="email" class="form-control"
      id="email" name="email" required
      placeholder="joe.brown@fabulous.com"
      data-value-missing="Please enter your email address"
      data-type-mismatch="Hmm, that doesn't look like a valid email address">
      <span></span>
    </div>
    <div class="input-msg" id="emailInputMsg"></div>
  </div>
  <div class="form-group message">
    <label for="message">Message</label>
    <div class="input-container sketch-box-input">
      <textarea class="form-control"
      id="message" name="message"
      rows="3" maxlength="5000"></textarea>
      <span></span>
    </div>
  </div>
  <div class="form-error">
    <div class="msg"></div>
    <div class="reason"></div>
  </div>
  <button type="submit" class="btn btn-primary">
    <span class="words">
      <?php if ($is_sponsor) : ?>Sign me up &nbsp; 👍🏻
      <?php else : ?>Send &nbsp; ✉️<?php endif; ?>
    </span>
    <?= do_shortcode('[loader type=ellipsis]'); ?>
  </button>
</form>
