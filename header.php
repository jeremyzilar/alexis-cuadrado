<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>

    <title><?php wp_title( '|', true, 'right' ); ?> | <?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></title>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />

    <meta http-equiv="Content-Type" content="text/html" charset="<?php bloginfo( 'charset' ); ?>" />

    <meta name="keywords" content="<?php echo get_meta_keywords(); ?>" />
  	<meta name="description" content="<?php echo get_meta_description(); ?>" />
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="canonical" href="">

    <!-- Fonts: Lato / https://www.google.com/fonts#UsePlace:use/Collection:Lato -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>

    <!-- Open Graph Tags -->
    <?php include INC . 'opengraph.php'; ?>

  	<!-- RSS -->
  	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

    <?php wp_head(); ?>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  
  <body <?php body_class(); ?>>
    
    <?php //include(INC . 'artbox.php'); ?>

    <style type="text/css" media="screen">
      <?php page_color(); ?>
    </style>
    <div id="page">
      <div id="page-overlay">
      </div> <!-- end #page-overlay -->
      <?php include(INC . 'head.php'); ?> 