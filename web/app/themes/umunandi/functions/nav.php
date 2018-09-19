<?php
// Preserve 'ancestor' class on active ancestor menu links
// Priority 9 is important as this needs to happen before roots_nav_menu_css_class
add_filter('nav_menu_css_class', 'umunandi_nav_menu_css_class', 9);
function umunandi_nav_menu_css_class($classes) {
  $classes = preg_replace('/(current-menu-ancestor)/', 'ancestor', $classes);
  return $classes;
}

class Umunandi_Nav_Walker extends Walker_Nav_Menu {
  private static $arc_svg;
  
  public function __construct() {
    self::$arc_svg = file_get_contents(locate_template('assets/img/line-arc.svg'));
  }
  
  function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);
    
    // Change absolute urls to root relative
    $item_html = preg_replace_callback('/(<a href=")([^"]*)/', function($matches) {
      return $matches[1] . wp_make_link_relative($matches[2]);
    }, $item_html);
    
    // Change /home link behaviour on home page to scroll instead of reload
    if ($item->title === 'Home' && is_front_page()) {
      $item_html = preg_replace('/<a href="[^"]*"/', '<a href="#top" data-scrollto="750"', $item_html);
    }

    // Add arc <svg> to non-button L0 nav items
    if ($depth == 0 && !in_array('link-btn', $item->classes)) {
      $item_html = str_replace('</a>', self::$arc_svg . '</a>', $item_html);
    }

    // Copy 'link-xxx'classes from nav <li> tag to child <a> tag:
    // turns this <li class="link-foo link-bar menu"><a href="/">Home</a></li>
    // into  this <li class="link-foo link-bar menu"><a class="foo bar" href="/">Home</a></li>
    $link_classes = array_reduce($item->classes, function($classes, $cls) {
      if (substr($cls, 0, 5) === "link-") $classes[] = substr($cls, 5);
      return $classes;
    }, []);
    if (count($link_classes) > 0) {
      $item_html = str_replace('<a', sprintf('<a class="%s"', join(' ', $link_classes)), $item_html);
    }

    $output .= $item_html;
  }
}
