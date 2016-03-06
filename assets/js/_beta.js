// jQuery
(function($){
  jQuery(document).ready(function() {

    function wbox_info(e){
      var wboxinfo = $('<div/>', {
          'class':'wbox-info',
      }).appendTo(e);
      wbox_label(e, wboxinfo);
      wbox_type(e, wboxinfo);
      wbox_size(e, wboxinfo);
      wbox_desc(e, wboxinfo);
    }

    function wbox_label(e, wboxinfo){
      var wboxlabel = $(e).attr('wbox-label');
      $('<h3/>', {
          'class':'wbox-label',
          'text':wboxlabel,
      }).appendTo(wboxinfo);
    }

    function wbox_type(e, wboxinfo){
      var wboxtype = $(e).attr('wbox-type');
      $(e).addClass(wboxtype);
    }

    function wbox_size(e, wboxinfo){
      var wboxsize = $(e).attr('wbox-size');
      $(e).addClass(wboxsize);
    }

    function wbox_desc(e, wboxinfo){
      var wboxdesc = $(e).attr('wbox-desc');
      if (typeof wboxdesc !== 'undefined') {
        $('<p/>', {
          'class':'wbox-desc',
          'text':wboxdesc,
        }).appendTo(wboxinfo);
      }
    }

    $('.wbox').each(function(){
      wbox_info(this);
    });

  });

})(jQuery);
