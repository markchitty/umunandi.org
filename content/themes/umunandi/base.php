<?php // Special case - Holding page ?> 
<?php if (is_page('holding-page')) : ?>
<?php get_template_part('templates/html-begin'); ?>
<?php get_template_part('templates/front-page-banner'); ?>
<?php get_template_part('templates/html-end'); ?>

<?php // Special case - Front page ?> 
<?php elseif (is_front_page()) : ?>
<?php get_template_part('templates/html-begin'); ?>
<?php get_template_part('templates/navbar'); ?>
<?php get_template_part('templates/front-page-banner'); ?>
<?php get_template_part('templates/html-content-front-page'); ?>
<?php get_template_part('templates/html-end'); ?>

<?php // Normal layout ?> 
<?php else : ?>
<?php get_template_part('templates/html-begin'); ?>
<?php get_template_part('templates/navbar'); ?>
<?php get_template_part('templates/html-content'); ?>
<?php get_template_part('templates/html-end'); ?>

<?php endif; ?>