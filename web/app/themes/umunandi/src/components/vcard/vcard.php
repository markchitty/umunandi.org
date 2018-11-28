<div class="vcard">
  <a class="org url" href="<?= home_url('/') ?>"><?php bloginfo('name') ?></a>
  <a class="email" href="mailto:<?= $instance['email'] ?>">
    <?= svg_icon('email') ?>
    <?= $instance['email'] ?>
  </a>
  <span class="tel">
    <?= svg_icon('tel') ?>
    <span class="value"><?= $instance['tel'] ?></span>
  </span>
  <span class="adr">
    <?= svg_icon('house') ?>
    <span class="street-address"><?= $instance['street_address'] ?></span>
    <span class="locality"><?= $instance['locality'] ?></span>
    <span class="region"><?= $instance['region'] ?></span>
    <span class="postal-code"><?= $instance['postal_code'] ?></span>
    <span class="country"><?= $instance['country'] ?></span>
  </span>
</div>
<div class="notes"><?= do_shortcode($instance['notes']) ?></div>
