<article id="post-<?php the_ID(); ?>" <?php post_class('entry album'); ?>>
  <div class="container">  

    <div class="row">
      <div class="col-xs-12 col-sm-6">
        
        <div class="entry-content">

          <!-- Album -->
          <h1 class="title"><?php the_title(); ?></h1>

          <?php
            $album_release_date = date_parse(get_post_meta( get_the_ID(), 'album_release_date', true ));
            $album_release_year = $album_release_date['year'];
          ?>
          <div class="album_release_year"><?php echo $album_release_year; ?></div>
          <div class="album_summary"><?php the_excerpt(); ?></div>
          <div class="album_notes"><?php echo wpautop(get_post_meta( get_the_ID(), 'album_notes', true )); ?></div>

          <p class="project-link"><a href="<?php the_permalink(); ?>">View Project »</a></p>

        </div><!-- .entry-content -->
      </div>
      <div class="col-xs-12 col-sm-6">
        <?php ac_featured_media('w500', get_the_ID()); ?>
      </div>
    </div>
    
    <div id="press" class="row">
      <div class="col-xs-12 col-sm-8">
        <?php
          $args = array (
            'post_status'   => 'publish',
            'post_type'     => array('press'),
            'posts_per_page' => -1,
            'meta_key'   => 'press_album',
            'meta_value' => get_the_ID()
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) {
            echo "<h4>Press</h4>";
            while ( $query->have_posts() ) {
              $query->the_post();
              get_template_part('content', 'press-clip' );
            }
          }
        ?>
      </div>
    </div>

  </div>
</article> <!-- #post -->