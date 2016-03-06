<?php 
// Navigation bar that shows up everywhere (except for the homepage)
?>

<section id="stream-nav-bar" class="">
  <div class="container">

    <div class="row">
      <div class="col-xs-12">
        <?php
          $args = array(
            'theme_location'  => 'stream-nav',
            'menu_class'      => 'nav navbar-nav',
            'menu_id'         => '',
            'container'       => 'div',
            'container_class' => 'nav-wrap',
            'container_id'    => 'stream-nav',
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
    
  </div>
</section>