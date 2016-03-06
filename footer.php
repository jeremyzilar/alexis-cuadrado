
  <section id="footer" class="hidden">
    <div class="container">

      <div class="row">
        <div class="col-xs-12">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
          <?php
            $args = array(
              'theme_location'  => 'footer-nav',
              'menu_class'      => 'nav navbar-nav',
              'menu_id'         => '',
              'container'       => 'div',
              'container_class' => 'nav-wrap',
              'container_id'    => 'footer-nav',
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

  <!-- Google Analytics -->
  

  <?php wp_footer(); ?>

  
  </body>
</html>