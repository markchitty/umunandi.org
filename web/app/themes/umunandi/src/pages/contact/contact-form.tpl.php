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

<?php /* Add this back in when we wire up the MailChimp API
<div class="form-group newsletter">
  <div class="sketch-box-checkbox">
    <input type="checkbox" id="newsletter">
    <label for="newsletter">Subscribe to the Umunandi newsletter</label>
  </div>
</div>
*/ ?>
