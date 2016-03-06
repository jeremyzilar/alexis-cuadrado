<?php $classes = (get_post_meta( $id, 'link_out', true ) == 'on') ? 'link-out entry' : 'entry' ; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
  <div class="container">  

  
  <?php 
    if (get_post_display() === 'featured') { ?>
    <!-- Feature Image for Featured Post Display -->
    <div class="row">
      <div class="col-xs-12">
      <?php sup_article_media('featured'); ?>
      </div>
    </div>

  <?php } ?>

    <div class="row">
      <div class="col-xs-12 col-sm-3">
        <div class="entry-meta">
          <!-- Kicker -->
          <?php sup_kicker(); ?>

          <div class="hidden-xs">
            <!-- Byline -->
            <?php sup_byline(); ?>

            <?php supchina_entry_date(); ?>

            <?php sup_editlink($id); ?> 
            
            <!-- Share Tools -->
            <?php sup_sharetools($id); ?> 


          </div>          
        </div>
      </div>
      <div class="col-xs-12 col-sm-9">

        <div class="entry-content">
          <?php if (get_post_display() === 'inline') { ?>
            <!-- Inline Image for Default Post Display -->
            <?php sup_article_media('w200'); ?>
          <?php } ?>

          <!-- Headline -->
          <?php if ( is_single() ) { ?>
            <h1 class="head"><?php the_title(); ?></h1>
          <?php } else { ?>
            <h3 class="head">
              <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h3>
          <?php } ?>

          <!-- Deck -->
          <?php sup_deck(); ?>

          <div class="hidden-sm hidden-md hidden-lg">
            <!-- Byline -->
            <?php sup_byline(); ?>
          </div>

          <?php
            $content = get_the_content();
            if (empty($content)) {
              the_excerpt();
            } else {
              the_content();
            }
            
            sup_publication($id);
          ?>

        </div><!-- .entry-content -->


        <footer class="entry-footer">
          
          <!-- Share Tools -->
          <?php sup_sharetools($id); ?>

        </footer><!-- .entry-meta -->


      </div>
      
    </div>
  </div>
</article> <!-- #post -->