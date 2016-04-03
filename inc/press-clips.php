<section id="press">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="wrap">
          <div class="row">
            <div class="col-xs-12 col-sm-8">
              <?php
                if ( $pressquery->have_posts() ) {
                  echo "<h4>Press</h4>";
                  while ( $pressquery->have_posts() ) {
                    $pressquery->the_post();
                    get_template_part('content', 'press-clip' );
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>