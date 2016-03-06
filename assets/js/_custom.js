
// App Menu Trigger
// via http://codepen.io/jasonhowmans/pen/dykhL
// see also: http://www.queness.com/post/14244/side-out-sidebar-navigation-javascript-solutions


(function() {
  var $body = document.body
  , $app_menu_trigger = $body.getElementsByClassName('app-menu-trigger')[0];

  if ( typeof $app_menu_trigger !== 'undefined' ) {
    $app_menu_trigger.addEventListener('click', function() {
      $body.className = ( $body.className === 'menu-active' )? '' : 'menu-active';
    });
  }
}).call(this);


// jQuery
(function($){
  jQuery(document).ready(function() {
    
    $('.affix-box').each(function(){
      
      var offsetAd = ($('.ad-wrap').offset().top - $('#sticky-bar').height() - 5);
      console.log(offsetAd);


      $(this).affix({
        offset: {
          top: offsetAd,
          bottom: function () {
            return (this.bottom = $('#footer').outerHeight(true));
          }
        }
      });
      
    });


    // Sticky Header Bar    
    $(function () {
      $stickybar = $('#sticky-bar');
      $stickybar.hide();
      $(window).scroll(function () {
        // set distance user needs to scroll before we fadeIn navbar
        if ($(this).scrollTop() > 200) {
          $stickybar.show();
        } else {
          $stickybar.hide();
        }
      });
    });



    $('.mailing-list .form-control').focus(function() {
      $('.form-group').show('fast');
    });







    $('.btn-share').click(function(event) {
      var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = this.href,
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;
      
      window.open(url, 'twitter', opts);
   
      return false;
    });

    // Infinite Scroll — brought to you by Jet Pack plugin.
    // Adding classes to existing markup to help style the 'load more' button
    var $infinite_handle = $('#infinite-handle');
    var $infinite_handle_label = $infinite_handle.find('button');
    $infinite_handle_label.addClass('btn').text('show more');

  });

})(jQuery);
