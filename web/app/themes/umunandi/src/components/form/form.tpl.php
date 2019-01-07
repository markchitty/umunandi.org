<form novalidate class="umunandi-form default-form <?= $name ?>-form <?= $class ?>"
  name="<?= $name ?>"
  action="<?= admin_url('admin-ajax.php') ?>"
  data-nonce="<?= $nonce ?>"
  data-wp-action="<?= $action ?>"
  data-response-page="<?= $response_page ?>"
  data-error-generic="🧐 Something went wrong. Can you refresh the page and try again?"
  data-error-timeout="⏳ Looks like the network is a bit flaky. Can you try that again?">

  <?= $content ?>

  <?php include $template ?>

  <div class="form-error">
    <div class="msg"></div>
    <div class="reason"></div>
  </div>

  <button type="submit" class="btn btn-primary">
    <span class="words"><?= $button_text ?> &nbsp;<?= $button_icon ?></span>
    <?= do_shortcode('[loader type=ellipsis]'); ?>
  </button>

</form>
