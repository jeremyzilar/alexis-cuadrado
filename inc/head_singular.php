<?php 
// Head — for the homepage
?>

<section id="head" class="head-singular">
  <div class="container">
    <div id="head-title" class="row">
      <div class="col-xs-12">
        <h1>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <img class="img-responsive logo" src="<?php echo THEME . '/assets/img/supchina-logo.png'; ?>" alt="Sup China">
          </a>
          </a>
        </h1>

        <?php
          $args = array(
            'theme_location'  => 'site-nav',
            'menu_class'      => 'nav navbar-nav',
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
      <div class="col-xs-12 col-sm-6">
        <?php include(INC . 'newsletter-signup.php'); ?>
      </div>
      <div class="col-xs-12 col-sm-6">
        <?php include(INC . 'app-download.php'); ?>
      </div>
    </div>
  </div>
</section>