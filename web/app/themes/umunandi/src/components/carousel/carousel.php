<div class="carousel slide <?= $atts['class'] ?>"
  id="<?= $atts['id'] ?>"
  data-ride="carousel"
  data-interval="<?= $atts['autoplay'] ?>">

  <div class="carousel-container container">
    <div class="carousel-inner" data-normalise-heights='.item'>

      <?php while($carousel_items->have_posts()) : $carousel_items->the_post(); ?>
      <div class="item <?= $carousel_items->current_post == 0 ? 'active' : '' ?>"
        id="<?= $carousel_items->post->post_name ?>">
        <div class="carousel-content">
          <?php $item_template(); ?>
        </div>
      </div>
      <?php endwhile; ?>

    </div>
    <?php if ($atts['indicator_template']) include $atts['indicator_template']; ?>
  </div>

  <a class="carousel-control left " href="#<?= $atts['id'] ?>"
    data-slide="prev"><span class="icon-arrow-left3" ></span></a>
  <a class="carousel-control right" href="#<?= $atts['id'] ?>"
    data-slide="next"><span class="icon-arrow-right3"></span></a>

</div>
