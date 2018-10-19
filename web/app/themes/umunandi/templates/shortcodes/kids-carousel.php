<svg viewBox="0 0 100 100" class="progressometer-defs">
  <defs>
    <circle cx="50" cy="50" r="50" id="circ-path" transform="translate(100,0) scale(-1, 1) rotate(-90, 50, 50)"></circle>
    <clipPath id="circ-clip"><use xlink:href="#circ-path"></use></clipPath>
    <filter id="blurry"><feGaussianBlur in="SourceGraphic" stdDeviation="4" /></filter>
  </defs>
</svg>

<div class="carousel slide js-kids-carousel">

  <div class="carousel-container container">
    <div class="carousel-inner">
    <?php global $OVCs; $featured_kids = $OVCs->featured_kids(); ?>
    <?php while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
      <div class="item <?= $featured_kids->current_post == 0 ? 'active' : '' ?>" id="<?= $post->post_name ?>">
        <div class="carousel-content">
          <a href="/sponsor" class="kid-face">
            <img src="<?= umunandi_get_image_src(get_field('head_shot'), 'square-300') ?>" alt="<?= get_the_title() ?>">
            <svg viewBox="0 0 100 100" class="progressometer">
              <use class="radial-bg" xlink:href="#circ-path" clip-path="url(#circ-clip)" filter="url(#blurry)"></use>
              <use class="radial-progress" xlink:href="#circ-path" clip-path="url(#circ-clip)"></use>
            </svg>
          </a>
          <div class="kid-info">
            <h2 class="name"><?php the_title() ?></h2>
            <div class="story"><?php the_field('story') ?></div>
            <div class="sponsor-btn">
              <a href="/sponsor" class="btn btn-default">Sponsor a child like <?php the_field('first_name') ?></a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
  </div>

  <a class="carousel-control left " href=".js-kids-carousel" data-slide="prev"><span class="icon-arrow-left3" ></span></a>
  <a class="carousel-control right" href=".js-kids-carousel" data-slide="next"><span class="icon-arrow-right3"></span></a>

  <ol class="carousel-indicators">
  <?php $featured_kids->rewind_posts(); while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
    <li data-target=".js-kids-carousel" data-slide-to="<?= $featured_kids->current_post ?>"
    class="<?= $featured_kids->current_post == 0 ? 'active' : '' ?>"></li>
  <?php endwhile; wp_reset_postdata(); ?>
  </ol>

</div>

