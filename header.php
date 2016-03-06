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
    <!-- font-family: 'Alegreya', serif; -->
    <link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-family: 'Alegreya Sans', sans-serif; -->

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

    <section id="head" class="page">
      <div class="container">
       <div class="row">
         <div class="col-xs-12">
          <h1><a href="">Alexis Cuadrado</a></h1>
         </div>
       </div>
       <div class="row">
         <div class="col-xs-12">
          <?php
            $args = array(
              'theme_location'  => 'site-nav',
              'menu_class'      => 'nav',
              'menu_id'         => '',
              'container'       => 'div',
              'container_class' => 'nav-wrap',
              'container_id'    => 'site-nav',
              'echo'            => true,
              'before'          => '',
              'after'           => '',
              'link_before'     => '',
              'link_after'      => '',
              'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
            );
            wp_nav_menu( $args );
          ?>
         </div>
       </div>

       <div class="row">
         <div class="col-xs-12">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
         </div>
       </div>
      </div>
      <?php //include(INC . 'artbox.php'); ?>
    </section>
