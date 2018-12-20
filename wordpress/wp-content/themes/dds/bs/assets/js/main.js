/* Author: @cpasdenom - Caroline Farges */

(function($) {

    $.dds = function() {};

    $.dds.prototype = {

        globals: {
            w_mobile: 768
        },

        init: function(params) {

            var self = this;

            if($('.home').length){
                var swiper_about = new Swiper('section.about .swiper-container', {
                  pagination: {
                    el: 'section.about .swiper-pagination',
                  },
                  navigation: {
                    nextEl: 'section.about .swiper-button-next',
                    prevEl: 'section.about .swiper-button-prev',
                  },
                  loop: true,
                  autoplay: {
                    delay: 10000,
                    disableOnInteraction: false,
                  }
                });
            }



            self.sizes();
            self.observe();
        },

        sizes: function() {

            var self = this,
                ww = $(window).width(),
                wh = $(window).height();

            
        },

        observe: function() {

            var self = this;

            if($('.home').length){
                $('.main-header nav').on('click', 'a', function(event) {
                    event.preventDefault();
                    /* Act on the event */
                    $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top - 40}, 500);
                });
            }

            //On window resize
            $(window).on('resize', function(e) {
                self.sizes();
            });
        }


    };

})(jQuery);

var $ = jQuery;
var dds = new $.dds();
dds.init();





/*
    RequestAnimationFrame Polyfill

    http://paulirish.com/2011/requestanimationframe-for-smart-animating/
    http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
    by Erik Möller, fixes from Paul Irish and Tino Zijdel

    MIT license
 */ 

(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if ( ! window.requestAnimationFrame ) {
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
            timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
    }

    if ( ! window.cancelAnimationFrame ) {
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
    }
}());


/*
    Sticky menu script
 */
(function(w,d,undefined){
    var el_html = d.documentElement,
        el_body = d.getElementsByTagName('body')[0],
        header = d.getElementById('header'),
        menuIsStuck = function(triggerElement) {
            var _scrollTop  = w.pageYOffset || el_body.scrollTop,
                regexp      = /(nav\-is\-stuck)/i,
                classFound  = el_html.className.match( regexp ),
                navHeight   = header.offsetHeight,
                bodyRect    = el_body.getBoundingClientRect(),
                scrollValue = triggerElement ? triggerElement.getBoundingClientRect().top - bodyRect.top - navHeight  : 400,
                scrollValFix = classFound ? scrollValue : scrollValue + navHeight;

            // if scroll down is 700 or more and nav-is-stuck class doesn't exist
            if ( _scrollTop > scrollValFix && !classFound ) {
                el_html.className = el_html.className + ' nav-is-stuck';
            }

            // if we are to high in the page and nav-is-stuck class exists
            if ( _scrollTop <= 2 && classFound ) {
                el_html.className = el_html.className.replace( regexp, '' );
            }
        },
        onScrolling = function() {
            // this function fires menuIsStuck()…
            menuIsStuck( d.getElementById('main') );
            // and could do more stuff below
        };


    el_html.className = el_html.className + ' js';

    // when you scroll, fire onScrolling() function
    w.addEventListener('scroll', function(){
        w.requestAnimationFrame( onScrolling );
    });
}(window, document));

     

/*
    Goolge map
       
var marker;
function initMap() {
  var map = new google.maps.Map(document.getElementById('me-trouver'), {
    zoom: 13,
    center: {lat: 59.325, lng: 18.070}
  });

  marker = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: {lat: 59.327, lng: 18.067}
  });
}
*/ 




