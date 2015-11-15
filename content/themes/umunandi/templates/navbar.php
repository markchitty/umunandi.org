<header class="main-nav navbar-fixed-top js-fadeOnScroll" role="banner">
  <div class="container">

    <div class="navbar-header">
      <a class="navbar-toggle collapsed" href="#" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-menu"></span>
      </a>
      <a class="Logo" href="<?php echo (is_front_page() ? '#top" data-scrollto="750' : home_url() . "/"); ?>"
      title="Home"><img src="<?php bloginfo('template_directory'); ?>/assets/img/umunandi-logo-156.png"></a>
    </div>

    <nav class="collapse navbar-collapse navbar-right" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'primary-nav nav navbar-nav'));
        endif;
      ?>
      <div class="share-icons addthis_toolbox addthis_default_style">
        <a class="addthis_button_facebook" title="Like" ><i class="share-icon icon-facebook"></i></a>
        <a class="addthis_button_twitter"  title="Tweet"><i class="share-icon icon-twitter" ></i></a>
        <a class="addthis_button_expanded" title="Share"><i class="share-icon icon-plus"    ></i></a>
      </div>
      <ul class="nav navbar-nav">
        <li>
          <a href="/donate" class="donate" title="Donate"><span class="btn">Donate</span></a>
        </li>
      </ul>
    </nav>

  </div><!-- /.container -->
</header>

