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
    
    <div class="row">
      <div class="col-xs-12">
        <footer class="entry-footer">
          <!-- Share Tools -->
          <?php ac_sharetools($id); ?>
        </footer><!-- .entry-meta -->
      </div>
    </div>

  </div>
</article> <!-- #post -->