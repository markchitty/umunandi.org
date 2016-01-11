<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  // Favicons
  $favicon_path = get_template_directory_uri() . '/assets/img/favicon/';
  ?>
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $favicon_path; ?>apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo $favicon_path; ?>apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="<?php echo $favicon_path; ?>favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="<?php echo $favicon_path; ?>favicon-16x16.png" sizes="16x16" />
  <meta name="application-name" content="Umunandi | We help kids in Zambia get a better start in life"/>
  <meta name="msapplication-TileColor" content="#CCCCCC" />
  <meta name="msapplication-TileImage" content="<?php echo $favicon_path; ?>mstile-144x144.png" />

  <?php wp_head(); ?>

  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
</head>

<body <?php body_class(); ?>>
<a name="top" id="top"></a>

<!--[if lt IE 8]>
  <div class="alert alert-warning">
    <?php _e('You are using an outdated browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
  </div>
<![endif]-->

<?php do_action('get_header'); ?>

