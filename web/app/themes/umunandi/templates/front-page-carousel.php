<div id="" class="carousel slide container js-carouselOvcs" data-interval="12000">

  <!-- Slides -->
  <div class="carousel-inner">
  <?php global $OVCs; $featured_kids = $OVCs->featured_kids(); ?>
  <?php while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
    <div class="item <?php echo $featured_kids->current_post == 0 ? 'active' : '' ?>"
      id="<?php echo $post->post_name ?>">
      <div class="carousel-content">
        <a href="/sponsor" class="kid-face">
          <?php echo wp_get_image_tag(get_field('head_shot'), 'square-300', false, get_the_title()) ?>
        </a>
        <div class="kid-info">
          <h2 class="kid-info--name"><?php the_title() ?></h2>
          <div class="kid-info--story"><?php the_field('story') ?></div>
          <div class="kid-info--sponsor">
            <a href="/sponsor" class="btn btn-default">Sponsor a child like <?php the_field('first_name') ?></a>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  </div><!-- /.carousel-inner -->

  <!-- Controls -->
  <a class="carousel-control left " href=".js-carouselOvcs" data-slide="prev"><span class="icon-arrow-left3" ></span></a>
  <a class="carousel-control right" href=".js-carouselOvcs" data-slide="next"><span class="icon-arrow-right3"></span></a>

  <ol class="carousel-indicators">
  <?php $featured_kids->rewind_posts(); while($featured_kids->have_posts()) : $featured_kids->the_post(); ?>
    <li data-target=".js-carouselOvcs" data-slide-to="<?php echo $featured_kids->current_post ?>"
    class="<?php echo $featured_kids->current_post == 0 ? 'active' : '' ?>"></li>
  <?php endwhile; wp_reset_postdata(); ?>
  </ol>

  <!-- <div class="carousel-progress-bar js-carouselProgressBar"><div class="progress"></div></div> -->

</div><!-- /.carousel -->

