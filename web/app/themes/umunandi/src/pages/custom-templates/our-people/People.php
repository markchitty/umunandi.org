<?php
class Umunandi_People {

  private $groups = [];

	public function __construct($post_id) {
    $query_args = array(
      'post_type'      => 'page',
      'post_status'    => array('private', 'publish'),
      'posts_per_page' => -1,
      'order'          => 'ASC',
      'orderby'        => 'menu_order',
    );

    $people_groups = new WP_Query(array_merge($query_args, ['post_parent' => $post_id]));

    while ($people_groups->have_posts()) {
      $people_groups->the_post();
      $people_query = new WP_Query(array_merge($query_args, ['post_parent' => get_the_ID()]));
      if ($people_query->have_posts()) {
        $this->groups[] = [
          'title'   => get_the_title(),
          'country' => get_field('strap_line'),
          'people'  => $people_query,
        ];
      }
    }
	}

  public function get_people_grouped() {
    return $this->groups;
  }

  public function get_people() {
    $merged_posts = [];
    foreach ($this->groups as $group) {
      foreach ($group['people']->posts as $post) {
        $post->parent_title = $group['title'];
        $post->country      = $group['country'];
      }
      $merged_posts = array_merge($merged_posts, $group['people']->posts);
    }

    // create a new empty query and populate it with the grouped queries
    $wp_query = new WP_Query();
    $wp_query->posts = $merged_posts;
    $wp_query->post_count = count($merged_posts);
    return $wp_query;
  }

}
