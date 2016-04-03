<header>
  <div class="container">
    <div class="row">
      <div id="hed" class="col-xs-12 col-sm-6">
        <h1>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>
          </a>
        </h1>
        <?php if (is_home()) { ?>
        <h2><?php echo esc_attr( get_bloginfo( 'description' ) ); ?></h2>
        <?php } ?>
        
        <?php include(INC . 'site-nav.php'); ?> 

      </div>
    </div>
    
   
  </div>
</header>