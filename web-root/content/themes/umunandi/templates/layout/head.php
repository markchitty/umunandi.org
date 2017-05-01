<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php $favicon_path = get_template_directory_uri() . '/assets/img/favicon/'; ?>
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $favicon_path ?>apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?= $favicon_path ?>apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="<?= $favicon_path ?>favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="<?= $favicon_path ?>favicon-16x16.png" sizes="16x16" />
  <meta name="application-name" content="<?php bloginfo('name'); ?> | <?php bloginfo('description') ?>"/>
  <meta name="msapplication-TileColor" content="#CCCCCC" />
  <meta name="msapplication-TileImage" content="<?= $favicon_path ?>mstile-144x144.png" />

  <?php wp_head(); ?>
</head>
