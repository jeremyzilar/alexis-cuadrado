<?php
  // Press Query
  $args = array (
    'post_status'   => 'publish',
    'post_type'     => array('press'),
    'posts_per_page' => -1,
    'meta_key'   => 'press_work',
    'meta_value' => get_the_ID()
  );
  $pressquery = new WP_Query( $args );
  $press_post_count = $pressquery->post_count;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry work'); ?>>
  <div class="container">  

    <div class="row project-details">
      <div class="col-xs-12 col-sm-6">        
        <!-- Album -->
        <h1 class="title"><?php the_title(); ?></h1>

        <?php
          $project_release_date = date_parse(get_post_meta( get_the_ID(), 'project_release_date', true ));
          $project_release_year = $project_release_date['year'];
        ?>
        <div class="project_release_year"><?php echo $project_release_year; ?></div>
        <div class="project_summary"><?php the_excerpt(); ?></div>

        <?php if ($press_post_count !== 0) { ?>
        <div class="project_links"><a href="#press" class="press_link">Press and Reviews</a></div>
        <?php } ?>
        
        <div class="project_notes"><?php echo wpautop(get_post_meta( get_the_ID(), 'project_notes', true )); ?></div>
        <div class="buy-buttons">
          <a href="#"><img src="<?php echo IMG . 'US_Listen_on_Apple_Music_Badge.svg'; ?>" alt="Buy on iTunes"></a>
          <a href="#"><img src="<?php echo IMG . 'Get_it_on_iTunes_Badge_US_1114.svg'; ?>" alt="Buy on iTunes"></a>
        </div>
      </div>

      <div class="col-xs-12 col-sm-6">
        <?php ac_featured_media('sq500', get_the_ID()); ?>
      </div>

    </div>

    <?php if($post->post_content !== "") {
      include(INC . 'project-body.php');
    } ?>

  </div>
</article> <!-- #post -->


<?php if ($press_post_count !== 0) {
  include(INC . 'press-clips.php');
} ?>
