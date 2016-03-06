(function($){
  jQuery(document).ready(function() {

    $('#collection-list').height($('#topic-list').height());
    $('#topic-list, #collection-list').sortable({
      opacity: 0.6,
      revert: true,
      cursor: 'move',
      connectWith: '.connected_list',
      stop: function(e, ui) {
        var index = new Array();
        $('#collection-list li').each(function() {
          var id = $(this).attr('data-id');
          index.push(id);
        });
        $('#collection_index').attr('value', index);
        $('#collection-list').height($('#topic-list').height());
      }
    }).disableSelection();


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