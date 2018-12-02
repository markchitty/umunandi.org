<ol class="carousel-indicators">
<?php $carousel_items->rewind_posts(); while($carousel_items->have_posts()) : $carousel_items->the_post(); ?>
  <li data-target="#<?= $atts['id'] ?>" data-slide-to="<?= $carousel_items->current_post ?>"
  class="<?= $carousel_items->current_post == 0 ? 'active' : '' ?>"></li>
<?php endwhile; wp_reset_postdata(); ?>
</ol>
