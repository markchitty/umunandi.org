<div class="kid-pic">
  <a href="/sponsor" class="round-img">
    <img src="<?= umunandi_get_image_src(get_field('head_shot'), 'square-300') ?>"
      alt="<?= get_the_title() ?>">
  </a>
  <h3 class="name"><?php the_title() ?></h3>
</div>
<div class="kid-info">
  <div class="story"><?php the_field('story') ?></div>
  <div class="sponsor-btn">
    <a href="/sponsor" class="btn btn-default">Sponsor a child like <?php the_field('first_name') ?></a>
  </div>
</div>
