<?php 
/******************************** template-loader *********************************
Our theme file structure organises the theme code way better than WordPress's
default everything-at-one-level structure. Cool for code maintenance, but it
requires a bit of messing about with WP's template location functionality...

All pages use /index.php as the base template. It has the following structure:

  <head>          <- same for all pages
  <nav>           <- same for all pages
  <header>        <- varies across pages
  <main> (body)   <- varies across pages
  <footer>        <- same for all pages

The template hierarchy logic (umunandi_require_template() below) determines which
template is used for <header> and <main>. Template priority is:

1. CUSTOM template - if specified in the admin UI, e.g. Foo Bar template:
   - src/pages/custom-templates/foo-bar/header.php for <header>
   - src/pages/custom-templates/foo-bar/body.php   for <main>
2. SLUG template - If a custom template isn't set, or the corresponding template
   file doesn't exist, next option is a slug template, e.g. for a Hello World page:
   - src/pages/hello-world/header.php for <header>
   - src/pages/hello-world/body.php   for <main>
3. TYPE template - If no page (slug) specific template exists, we fall back to a
   template that corresponds to the page type, e.g. for a default page:
   - src/pages/default-page/header.php for <header>
   - src/pages/default-page/body.php   for <main>

You can mix-n-match different templates for the header and body, so you might define
a CUSTOM template for the body, leaving the header to fall back to the TYPE template.

CUSTOM TEMPLATES
To create a custom template, create a new folder in src/pages/custom-templates,
e.g. src/pages/custom-templates/foo-bar, and then add:
- header.php = custom header template, and/or
- body.php   = custom body template

To get the template to show up in the custom template list in the admin UI, include
the standard WordPress custom template identifier comment at the top of the file,
e.g. 'Template Name: Foo Bar'.

If you're adding both header and body templates, put the template identifier in the
body file ONLY, not the header, otherwise the template name will show up in the
template list twice.
***********************************************************************************/

const UMUNANDI_PAGE_TEMPLATE_PATH    = 'src/pages';
const UMUNANDI_CUSTOM_TEMPLATE_PATH  = 'src/pages/custom-templates';

// Template hierarchy - uses wp's locate_template() to pick the first match
function umunandi_require_template($header_or_body) {
  $templates = [];
  $page = UMUNANDI_PAGE_TEMPLATE_PATH;
  $section = $header_or_body === 'header' ? 'header' : 'body';
  $custom_template = get_page_template_slug(get_queried_object_id());
  $custom_template = preg_replace('/header|body/', $section, $custom_template);
  $slug = get_post_field('post_name', get_post());
  $type = umunandi_get_template_type();
                                                                    // Priority
  if ($custom_template) array_push($templates, $custom_template);   // 1. Custom template
  array_push($templates, "$page/$slug/$section.php");               // 2. Slug
  array_push($templates, "$page/$type/$section.php");               // 3. Type

  locate_template($templates, true);
}

// Load custom page templates from src/pages/custom_templates
// Note: this filter is actually called from the admin site
add_filter('theme_page_templates', 'umunandi_add_templates', 10, 4);
function umunandi_add_templates($post_templates, $wp_theme, $post, $post_type) {
  $template_files = get_template_directory() . '/' . UMUNANDI_CUSTOM_TEMPLATE_PATH .'/**/*.php';
  foreach (glob($template_files) as $file) {
    // Template name regex copied from wp-includes/class-wp-theme.php::get_post_templates()
    if (preg_match('|Template Name:(.*)$|mi', file_get_contents($file), $matches)) {
      $file = str_replace(get_template_directory() . '/', '', $file);
      $post_templates[$file] = _cleanup_header_comment($matches[1]);
    }
  }
  return $post_templates;
}

// Force custom page templates to load index.php instead -
// index.php itself then includes the custom page template in the right place
add_filter('template_include', 'umunandi_template_include');
function umunandi_template_include($template) {
  if (is_page_template()) $template = get_index_template();
  return $template;
}

// Get template type - list copied from src/wp-includes/template-loader.php
function umunandi_get_template_type() {
  $template_type = 'index';
  if     (is_embed()            ) : $template_type = 'embed';
  elseif (is_404()              ) : $template_type = '404';
  elseif (is_search()           ) : $template_type = 'search';
  elseif (is_front_page()       ) : $template_type = 'home';          // prev 'front-page'
  elseif (is_home()             ) : $template_type = 'blog';          // prev 'home'
  elseif (is_post_type_archive()) : $template_type = 'archive';
  elseif (is_tax()              ) : $template_type = 'taxonomy';
  elseif (is_attachment()       ) : $template_type = 'attachment';
  elseif (is_page()             ) : $template_type = 'default-page';  // prev 'page'
  elseif (is_singular()         ) : $template_type = 'singular';
  elseif (is_category()         ) : $template_type = 'category';
  elseif (is_tag()              ) : $template_type = 'tag';
  elseif (is_author()           ) : $template_type = 'author';
  elseif (is_date()             ) : $template_type = 'date';
  elseif (is_archive()          ) : $template_type = 'archive';
  endif;
  return $template_type;
}
