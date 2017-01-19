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

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        // Hide nav bar on scroll
        var myElement = document.querySelector(".header");
        var headroom  = new Headroom(myElement, { tolerance: 10 });
        headroom.init();

        jQuery('.header-mobile-nav-button').click(function () {
          jQuery('.mobile-nav-menu').toggleClass('mobile-nav-menu--active');
          jQuery('html').toggleClass('body-disable-scroll');
          jQuery('body').toggleClass('body-disable-scroll');
        });

        /* Hide navigation items when they overflow the navigation bar.
         * This way we don't need to hard code a certain px value and the
         * mobile menu shows up when it's needed regardless of the number
         * of the navigation items
         */

        function mobileMenuCheck() {
          var logoWidth = 136;
          if (jQuery('.header-right').position().left < logoWidth) {
            jQuery('.header').addClass('header--is-mobile');
            jQuery('.wrap.container').css('margin-top', '90px');
            jQuery('.header-right').css('visibility', 'hidden');
          } else {
            jQuery('.header').removeClass('header--is-mobile');
            jQuery('.wrap.container').css('margin-top', '136px');
            jQuery('.header-right').css('visibility', 'visible');
          }
        }

        jQuery( window ).resize(function() {
          mobileMenuCheck();
        });

        mobileMenuCheck();

      },
      finalize: function() {

      }
    },

    'categories': {
      init: function() {
        jQuery('.category-anchor-link').click(function (event) {
          var id = $(event.target).attr('href');
          jQuery('html, body').animate({
            scrollTop: jQuery(id).offset().top
          }, 1000);
          return false;
        });
      },
      finalize: function() {
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

})(jQuery); // Fully reference jQuery after this point.
