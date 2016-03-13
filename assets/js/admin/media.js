(function($){
  jQuery(document).ready(function() {
    $('#album_release_date').datepicker({
      dateFormat : 'yy-mm-dd'
    });

    $('#show_date').datepicker({
      dateFormat : 'yy-mm-dd'
    });

    $('#refresh_headline').click(function(e) {
      e.preventDefault();
      var title = $('#title').attr('value');
      $('#card_headline').attr('value', title);
    });

    $('#refresh_deck').click(function(e) {
      e.preventDefault();
      var excerpt = $('#excerpt').val();
      $('#deck').val(excerpt);
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