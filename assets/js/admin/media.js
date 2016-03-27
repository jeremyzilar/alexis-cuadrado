(function($){
  jQuery(document).ready(function() {
    $('#album_release_date').datepicker({
      dateFormat : 'yy-mm-dd'
    });

    $('#show_date').datepicker({
      dateFormat : 'yy-mm-dd'
    });


    function get_colors(thumb){
      // console.log(thumb);
      imgsrc = thumb.attr('src');
      // console.log(imgsrc);
      var myImage = new Image();
      myImage.src = imgsrc;
      var colorThief = new ColorThief();
      $colors = colorThief.getPalette(myImage, 12);
      return $colors;
    }

    function sort_colors(thumb){
      $colors = get_colors(thumb);
      $sorted_colors = {};  
      $.each( $colors, function( key, value ) {
        var total = 0;
        for (var i = 0; i < value.length; i++) {
          total += value[i] << 0;
        }
        $sorted_colors[total] = value;
      });
      // console.log($sorted_colors);
      return $sorted_colors;
    }

    function display_colors(thumb){
      // $colors = get_colors(thumb);
      $colors = sort_colors(thumb);

      $('#album_colors').attr('value', JSON.stringify($colors));
      $.each( $colors, function( i, value ) {
        $('.color_palette').append('<div class="color_block" data-rgb="'+ value +'" style="background:rgba('+ value +',.5);">').fadeIn('slow');
        $('.color_preview').attr('style', 'background:rgba('+ value +',.5);').fadeIn('slow');
      });
    }

    // 
    $('.get_colors').click(function(event) {
      event.preventDefault();
      var thumb = $(".color_preview img");
      if (thumb.length && $('.color_palette').contents().length == 0) {
        // console.log(thumb);
        display_colors(thumb);
        $('.color_block').click(function(event) {
          $rgb = $(this).attr('data-rgb');
          $('#primary_color').attr('value', $rgb);
          $('.color_preview').attr('style', 'background:rgba('+ $rgb +',.5);').fadeIn('slow');
        });
      }
    });
    

    
    // // Hides "Link to" and "Alignment" in WP Media Viewer
    // (function() {
    //   var _AttachmentDisplay = wp.media.view.Settings.AttachmentDisplay;
    //   wp.media.view.Settings.AttachmentDisplay = _AttachmentDisplay.extend({
    //     render: function() {
    //       _AttachmentDisplay.prototype.render.apply(this, arguments);
    //       this.$el.find('select.link-to').val('none');
    //       this.model.set('link', 'none');
    //       this.updateLinkTo();
    //       this.$el.find('select.link-to').parent('label').hide();

    //       this.$el.find('select.alignment').parent('label').hide();
    //       this.model.set('size', 'none');
    //       this.updateLinkTo();
    //     }
    //   });
    // })();
    
  });
})(jQuery);