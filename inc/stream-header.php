<?php 
// Head — for the homepage
?>

<div id="stream-header" class="row">
  <h3>Latest News</h3>

  <div class="follow-btn follow-btn-tw">
    <p><a href="https://www.twitter.com/supchinanews" target="_blank"><i class="fa fa-twitter-square"></i> Follow @supchinanews</a></p>
  </div>

  <div class="follow-btn follow-btn-fb">
    <p><a href="https://www.facebook.com/supchinanews" target="_blank"><i class="fa fa-facebook-square"></i> Like SupChina</a></p>
  </div>

</div>
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