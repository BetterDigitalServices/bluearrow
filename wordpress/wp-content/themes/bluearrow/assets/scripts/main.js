/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Expontential moving average function from http://oroboro.com/irregular-ema/
  function EMA(alpha) {
    // Add defaults
    alpha = alpha || 0.2;
    var prevSample = 0;
    var emaPrev = 0;

    return function(sample, deltaTime) {
      var a = deltaTime / alpha;
      var u = Math.exp(a * -1);
      var v = (1 - u) / a;
      emaPrev = (u * emaPrev) + ((v - u) * prevSample) + ((1.0 - v) * sample);
      return emaPrev;
    };
  }

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        // Hide menu when not active
        var lastScrollTop = 0;
        var lastScroll = new Date();
        var averager = EMA(0.2);

        $(window).scroll(function(event){
           var st = $(this).scrollTop();
           var now = new Date();

           // Scroll speed - pixels per (milli)second
           var diff = averager(st - lastScrollTop, now-lastScroll);

           // React only for for bigger changes when toggling the bar
           if (Math.abs(diff) > 40) {
             if (st < lastScrollTop) {
                $('.nav-primary').addClass('navbar-fixed-top');
                $('.nav-primary').removeClass('navbar-static-top');
             } else {
                $('.nav-primary').removeClass('navbar-fixed-top');
                $('.nav-primary').addClass('navbar-static-top');
             }
           }
           lastScrollTop = st;
           lastScroll = now;
        });

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

  // Bind to Bootstrap navigation collapse
  $(function(){
  var nav = $('nav .collapse');
    nav.on('click', 'a', null, function () {
      nav.collapse('hide');
    });
  });

  // Add Google Analytics
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63940259-2', 'auto');
  ga('send', 'pageview');

})(jQuery); // Fully reference jQuery after this point.
