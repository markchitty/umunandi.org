<div class="person-profile col-grid col-grid-fluid">
  <div class="person-card col">
    <div class="round-img"><?= the_post_thumbnail() ?></div>
    <h4 class="name"><?= the_title() ?></h4>
    <h5 class="title"><?= the_field('strap_line') ?>, <?= get_post_field('parent_title') ?></h5>
    <div class="country-flag">
      <?php if (get_post_field('country') === 'Zambia') : ?>🇿🇲<?php endif; ?>
    </div>
  </div>
  <div class="biog col" data-is-scrollable>
    <?php the_content() ?>
  </div>
</div>
