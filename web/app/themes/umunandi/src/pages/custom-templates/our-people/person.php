<div class="person-profile col-grid col-grid-fluid">
  <div class="person-card col">
    <div class="round-img"><?= the_post_thumbnail() ?></div>
    <h4 class="name"><?= the_title() ?></h4>
    <h5 class="title"><?= the_field('strap_line') ?></h5>
    <?php if (get_post_field('country') === 'Zambia') : ?>
      <div class="country-flag">🇿🇲</div>
    <?php endif; ?>
    <div class="org"><?= get_post_field('organisation') ?></div>
  </div>
  <div class="biog col" data-is-scrollable>
    <?php the_content() ?>
  </div>
</div>
