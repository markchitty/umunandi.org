<form novalidate class="sponsor-form"
  action="<?= admin_url('admin-ajax.php') ?>"
  data-nonce="<?= $nonce ?>"
  data-wp-action="<?= $action ?>"
  data-error-generic="🧐 Something went wrong. Can you try that again?"
  data-error-timeout="⏳ Looks like the network is a bit flaky. Can you try that again?">
  <div class="form-group sponsor-options-row">
    <div class="sponsor-options-label">
      <span>I would like to sponsor</span> 
      <span class="sponsor-options-product">...</span>
    </div>
    <div class="sponsor-options">
      <input type="radio" name="product" required class="hidden-radio"
      data-value-missing="&#x2191; Please choose one of these options &#x2191;">
    </div>
    <div class="sponsor-options-price">&nbsp;</div>
    <div class="input-msg" id="productInputMsg"></div>
  </div>
  <div class="name-row">
    <div class="form-group first-name">
      <label for="firstName">First name</label>
      <div class="input-container sketch-box-input">
        <input type="text" required class="form-control" id="firstName" name="firstName"
        placeholder="Joe" data-value-missing="Please enter your first name">
        <span></span>
      </div>
      <div class="input-msg" id="firstNameInputMsg"></div>
    </div>
    <div class="form-group last-name">
      <label for="lastName">Last name</label>
      <div class="input-container sketch-box-input">
        <input type="text" required class="form-control" id="lastName" name="lastName"
        placeholder="Brown" data-value-missing="Please enter your last name">
        <span></span>
      </div>
      <div class="input-msg" id="lastNameInputMsg"></div>
    </div>
  </div>
  <div class="form-group email">
    <label for="email">Email</label>
    <div class="input-container sketch-box-input">
      <input type="email" required class="form-control" id="email" name="email"
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
      <textarea class="form-control" id="message" name="message" rows="3"></textarea>
      <span></span>
    </div>
  </div>
  <div class="form-error">
    <div class="msg"></div>
    <div class="reason"></div>
  </div>
  <button type="submit" class="btn btn-primary">
    <span class="words">Sign me up &nbsp; 👍🏻</span>
    <?= do_shortcode('[loader type=ellipsis]'); ?>
  </button>
</form>
