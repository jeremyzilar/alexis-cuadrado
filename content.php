<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
  <div class="container">  

    <div class="row">
      <div class="col-xs-12 col-sm-8">
        
        <div class="entry-content">

          <!-- Headline -->
          <?php if ( is_single() ) { ?>
            <h1 class="head"><?php the_title(); ?></h1>
          <?php } else { ?>
            <h3 class="head">
              <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h3>
          <?php } ?>

          <div class="summary">
            <?php the_excerpt(); ?>  
          </div>

          <p class="project-link"><a href="<?php the_permalink(); ?>">View Project »</a></p>

        </div><!-- .entry-content -->
      </div>
      <div class="col-xs-12 col-sm-4">
        <?php ac_featured_media('w300', get_the_ID()); ?>
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