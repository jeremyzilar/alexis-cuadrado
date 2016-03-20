<div class="press-clip">
  <?php 
    $source = get_post_meta( get_the_ID(), 'press_source', true );
    $source_url = get_post_meta( get_the_ID(), 'press_source_url', true );
    if (empty($source_url)) {
      $source_txt = $source;
    } else {
      $source_txt = '<a href="'.$source_url.'">'.$source.'</a>';
    }
  ?>
  <blockquote>
    <?php echo wpautop(get_post_meta( get_the_ID(), 'press_blurb', true )); ?>
    <cite>— <?php echo $source_txt; ?></cite>
  </blockquote>
</div>