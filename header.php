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

    <!-- Font: Alegreya — Google Fonts — https://www.google.com/fonts/specimen/Alegreya -->
    <link href='https://fonts.googleapis.com/css?family=Alegreya:400,400italic,700italic,700,900,900italic' rel='stylesheet' type='text/css'>
    <!-- Fonts: Lato / http://www.latofonts.com/ -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

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
    <div id="page">

    <section id="head">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <h1><a href="">Alexis Cuadrado</a></h1>
          </div>
        </div>
        <?php include(INC . 'stream-nav.php'); ?> 
       
      </div>
    </section>
