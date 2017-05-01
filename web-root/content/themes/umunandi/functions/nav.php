<?php
// Copy 'link-xxx'classes from nav <li> tag to child <a> tag:
// turns this <li class="link-foo link-bar menu"><a href="/">Home</a></li>
// into  this <li class="link-foo link-bar menu"><a class="foo bar" href="/">Home</a></li>
function umunandi_apply_nav_link_classes($nav_html) {
  $html = str_get_html($nav_html);
  foreach ($html->find('li[class*="link-"]') as $li) {
    preg_match_all('/(link-([-\w]+) ?)/', $li->class, $matches);
    $li->find('a', 0)->class = join(' ', $matches[2]);
  }
  return $html;
}
add_filter('wp_nav_menu_items', 'umunandi_apply_nav_link_classes');

// Change home link behaviour on home page to scroll instead of reload
function umunandi_home_nav_scroll($nav_html, $args) {
  if ($args->menu->slug == 'primary-navigation' && is_front_page()) {
    $html = str_get_html($nav_html);
    $a = $html->find('li.menu-home a', 0);
    $a->href = '#top';
    $a->{'data-scrollto'} = 750;
    return $html;
  }
  return $nav_html;
}
add_filter('wp_nav_menu_items', 'umunandi_home_nav_scroll', 10, 2);

// Root-relative urls - roots.io implementation ain't working on nav
function umunandi_root_relative_nav($nav_html) {
  $html = str_get_html($nav_html);
  foreach ($html->find('a[href]') as $a) {
    $a->href = wp_make_link_relative($a->href);
  }
  return $html;
}
add_filter('wp_nav_menu_items', 'umunandi_root_relative_nav');

// Preserve 'ancestor' class on active ancestor menu links
// Priority 9 is important as this needs to happen before roots_nav_menu_css_class
function umunandi_nav_menu_css_class($classes) {
  $classes = preg_replace('/(current-menu-ancestor)/', 'ancestor', $classes);
  return $classes;
}
add_filter('nav_menu_css_class', 'umunandi_nav_menu_css_class', 9);
