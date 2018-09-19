<nav class="main-nav-container navbar floating js-navMain">
  <div class="container">

    <div class="navbar-header">
      <a class="navbar-toggle collapsed" href="#" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="logo-link" title="Home" href="<?= is_front_page() ? '#top' : '/' ?>"
        <?= is_front_page() ? 'data-scrollto="750"' : '' ?>>
        <?php include(locate_template('assets/img/umunandi-logo.svg')) ?>
      </a>
    </div>

    <div class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array(
            'theme_location' => 'primary_navigation',
            'menu_class' => 'main-nav nav navbar-nav navbar-right',
          ));
        endif;
      ?>
    </div>

  </div>
</nav>
