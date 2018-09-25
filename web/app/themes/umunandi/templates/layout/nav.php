<nav class="main-nav navbar js-main-nav">

  <input type="checkbox" class="nav-toggle-checkbox" name="navToggle" id="navToggle">
  <label class="hamburger" for="navToggle"><span></span><span></span><span></span></label>
  
  <div class="container">
    <div class="main-nav-container">
      <div class="main-nav-header">
        <a class="logo-link" title="Home" href="<?= is_front_page() ? '#top' : '/' ?>"
        <?= is_front_page() ? 'data-scrollto="750"' : '' ?>>
          <?php include(locate_template('assets/img/umunandi-logo.svg')) ?>
        </a>
      </div>
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary_navigation',
        'menu_class' => 'main-nav-menu',
        'walker' => new Umunandi_Nav_Walker()
      ));
      ?>
    </div>
  </div>

</nav>
