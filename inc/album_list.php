<section id="album_list">
  <div class="container">
    <div class="row">
      <?php
        $args = array (
          'post_status'   => 'publish',
          'post_type'     => array('album'),
          'posts_per_page' => 4
        );
        $query = new WP_Query( $args );
      ?>

      <!-- Featured Album -->
      <div class="col-xs-12 col-sm-5">
        <div class="album_feature">
          <h4>Albums</h4>
          <?php
            $i = 0;
            if ( $query->have_posts() ) {
              while ( $query->have_posts() ) {
                $query->the_post();
                if ($i == 0) {
                  $album_release_date = date_parse(get_post_meta( get_the_ID(), 'album_release_date', true ));
                  $album_release_year = $album_release_date['year'];
                  echo '<h3>'.get_the_title().' ('.$album_release_year.')</h3>';
                  echo '<div class="album_summary">'.get_the_excerpt(),'</div>';
                }
                $i++;
              }
            }
          ?>
          <p class="more"><a href="#">See all Albums »</a></p>
        </div>
      </div>

      <!-- COVERS -->
      <div class="col-xs-12 col-sm-7">
        <div class="album_covers">
          <?php
            if ( $query->have_posts() ) {
              while ( $query->have_posts() ) {
                $query->the_post();
                get_template_part('content', 'album-cover' );
              }
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>