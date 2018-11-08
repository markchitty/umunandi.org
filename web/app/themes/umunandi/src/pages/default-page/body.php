<?php
// add a <section> wrapper to the content
add_filter('the_content', 'wpse_the_content_filter', 20);
function wpse_the_content_filter($content) {
   return do_shortcode(sprintf('[section class="fuzzy-edges"]%s[/section]', $content));
}
?>

<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
<?php endwhile; ?>
