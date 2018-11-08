<?php
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

function umunandi_get_template($path, $name) {
  global $post;
  $custom_template = get_page_template_slug($post);
  if ($name == 'body' && $custom_template) {
    include $custom_template;
  }
  else {
    $type = umunandi_get_template_type();
    get_template_part("$path/$type/$name");
  }
}
