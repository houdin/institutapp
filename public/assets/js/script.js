/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/frontend/script.js ***!
  \*****************************************/
/* -----------------------------------------------------------------------------



File:           JS Core
Version:        1.0
Last change:    00/00/00
Author:         HTMLMATE Team

-------------------------------------------------------------------------------- */
(function () {
  "use strict";

  var Genius = {
    init: function init() {
      this.Basic.init();
    },
    Basic: {
      init: function init() {
        // this.menuBar();
        this.onePageNav();
        this.quickScroll2();
        this.formationSlide();
        this.datePicker();
        this.bannerParalax();
        this.serviceSlide();
        this.videoPopup();
        this.bestproductSlide();
        this.faqTAB();
        this.rateReview();
        this.categorySlide();
        this.teacher2SLIDE();
        this.teacher3SLIDE();
        this.buttonSlide();
        this.categorySlide_3();
        this.advance3SLIDE();
        this.productRange();
        this.searchBAR();
        this.mobileMenu();
        this.mainSlide(); // this.countDown();

        this.quickScroll();
      },

      /* - Start of menu bar
      ================================================*/
      menuBar: function menuBar() {// $(window).on('scroll', function () {
        //     if ($(window).scrollTop() > 50) {
        //         $('.main-menu-container').addClass('menu-bg-overlay')
        //     } else {
        //         $('.main-menu-container').removeClass('menu-bg-overlay')
        //     }
        // })
      },
      onePageNav: function onePageNav() {
        $(window).on('scroll', function () {
          if ($(window).scrollTop() > 20) {
            $('.header_3').addClass('full-width-menu');
          } else {
            $('.header_3').removeClass('full-width-menu');
          }
        });
      },
      quickScroll2: function quickScroll2() {
        $('.quick-menu').on("click", "a", function () {
          if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

            if (target.length) {
              $('html, body').animate({
                scrollTop: target.offset().top - 65
              }, 1000);
              return false;
            }
          }
        });
      },

      /* - End of menu bar
      ================================================*/

      /* Start Of formation slide
      ================================================*/
      mainSlide: function mainSlide() {
        $('#slider-item').owlCarousel({
          items: 3,
          margin: 0,
          responsiveClass: true,
          nav: true,
          loop: $(this).children().length > 1,
          dots: true,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 1
            },
            700: {
              items: 1
            },
            800: {
              items: 1
            },
            1000: {
              items: 1
            }
          }
        });
      },

      /* End Of formation slide
      ================================================*/

      /* Start Of formation slide
      ================================================*/
      formationSlide: function formationSlide() {
        $('#formation-slide-item').owlCarousel({
          margin: 30,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 1
            },
            700: {
              items: 2
            },
            800: {
              items: 3
            },
            1000: {
              items: 3
            }
          }
        });
      },

      /* End Of formation slide
      ================================================*/

      /* Start Of Date picker
      ================================================*/
      datePicker: function datePicker() {
        $("#datepicker").datepicker();
      },

      /* - End Start Of Date picker
      ================================================*/

      /* Start Of parallax
      ================================================*/
      bannerParalax: function bannerParalax() {
        $('.jarallax').jarallax({
          speed: 0.5
        });
      },

      /* End Of Preloader
      ================================================*/

      /* Start Of service slide
      ================================================*/
      serviceSlide: function serviceSlide() {
        $('#service-slide-item').owlCarousel({
          margin: 85,
          responsiveClass: true,
          nav: false,
          autoplay: false,
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 1
            },
            700: {
              items: 2
            },
            1000: {
              items: 3
            }
          }
        });
      },

      /* End Of service slide
      ================================================*/

      /* Start of popup
      ================================================*/
      videoPopup: function videoPopup() {
        $('.popup-with-zoom-anim').magnificPopup({
          disableOn: 200,
          type: 'iframe',
          mainClass: 'mfp-fade',
          removalDelay: 160,
          preloader: false,
          fixedContentPos: false
        });
      },

      /* End of popup
      ================================================*/

      /* Start Of best product
      ================================================*/
      bestproductSlide: function bestproductSlide() {
        $('#best-product-slide-item').owlCarousel({
          margin: 25,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 2
            },
            700: {
              items: 2
            },
            800: {
              items: 2
            },
            1000: {
              items: 4
            }
          }
        });
      },

      /* End Of best product
      ================================================*/

      /* Start Of best product
      ================================================*/
      faqTAB: function faqTAB() {
        $(".tab-content-1").hide();
        $(".tab-content-1:first").show();
        /* if in tab mode */

        $("ul.product-tab").on("click", "li", function () {
          $(".tab-content-1").hide();
          var activeTab = $(this).attr("rel");
          $("#" + activeTab).fadeIn();
          $("ul.product-tab li").removeClass("active");
          $(this).addClass("active");
          $(".tab_drawer_heading").removeClass("d_active");
          $(".tab_drawer_heading[rel^='" + activeTab + "']").addClass("d_active");
        });
        /* if in drawer mode */

        $(".tab_drawer_heading").on("click", function () {
          $(".tab-content-1").hide();
          var d_activeTab = $(this).attr("rel");
          $("#" + d_activeTab).fadeIn();
          $(".tab_drawer_heading").removeClass("d_active");
          $(this).addClass("d_active");
          $("ul.product-tab li").removeClass("active");
          $("ul.product-tab li[rel^='" + d_activeTab + "']").addClass("active");
        });
        /* Extra class "tab_last"
           to add border to right side
           of last tab */

        $('ul.product-tab li').last().addClass("tab_last");
      },

      /* End Of best product
      ================================================*/

      /* - Start of faq accordion
      ================================================*/
      rateReview: function rateReview() {
        $(':radio').change(function () {
          console.log('New star rating: ' + this.value);
        });
      },

      /* - End of faq accordion
      ================================================*/

      /* Start Of best product
      ================================================*/
      categorySlide: function categorySlide() {
        $('.category-slide-item').owlCarousel({
          margin: 25,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 2
            },
            700: {
              items: 3
            },
            1000: {
              items: 4
            }
          }
        });
      },

      /* End Of best product
      ================================================*/

      /* Start Of teacher secoud Slide
      ================================================*/
      teacher2SLIDE: function teacher2SLIDE() {
        $('.teacher-secound-slide').owlCarousel({
          margin: 25,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 2
            },
            700: {
              items: 2
            },
            1000: {
              items: 4
            }
          }
        });
      },

      /* End Of teacher secoud Slide
      ================================================*/

      /* Start Of teacher thired Slide
      ================================================*/
      teacher3SLIDE: function teacher3SLIDE() {
        $('.teacher-third-slide').owlCarousel({
          margin: 30,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 2
            },
            700: {
              items: 3
            },
            1000: {
              items: 5
            }
          }
        });
      },

      /* End Of teacher thired Slide
      ================================================*/

      /* Start Of best product
      ================================================*/
      buttonSlide: function buttonSlide() {
        $('.button-tab').owlCarousel({
          margin: 0,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 2
            },
            600: {
              items: 4
            },
            700: {
              items: 5
            },
            1000: {
              items: 6
            }
          }
        });
      },

      /* End Of best product
      ================================================*/

      /* Start Of category slide
      ================================================*/
      categorySlide_3: function categorySlide_3() {
        $('.category-slide').owlCarousel({
          margin: 0,
          responsiveClass: true,
          nav: true,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          dots: false,
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 2
            },
            600: {
              items: 3
            },
            700: {
              items: 4
            },
            1000: {
              items: 5
            }
          }
        });
      },

      /* End Of  category slide
      ================================================*/

      /* Start Of teacher thired Slide
      ================================================*/
      advance3SLIDE: function advance3SLIDE() {
        $('.service-slide_3').owlCarousel({
          margin: 10,
          responsiveClass: true,
          nav: true,
          dots: false,
          autoplay: false,
          navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
          smartSpeed: 1000,
          responsive: {
            0: {
              items: 1
            },
            400: {
              items: 1
            },
            600: {
              items: 2
            },
            700: {
              items: 2
            },
            1000: {
              items: 3
            }
          }
        });
      },

      /* End Of teacher thired Slide
      ================================================*/

      /* Start Of category slide
      ================================================*/
      productRange: function productRange() {
        $("#slider-range").slider({
          range: true,
          min: 0,
          max: 800,
          values: [175, 500],
          slide: function slide(event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
          }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
      },

      /* End Of  category slide
      ================================================*/

      /* - Start of search bar
      ================================================*/
      searchBAR: function searchBAR() {
        $('.toggle-overlay').on('click', function () {
          $('.search-body').toggleClass('search-open');
        });
      },

      /* - End of search bar
      ================================================*/
      mobileMenu: function mobileMenu() {
        $('.mobile-menu nav').meanmenu();

        function slideMenu() {
          var activeState = $('#menu-container .menu-list').hasClass('active');
          $('#menu-container .menu-list').animate({
            right: activeState ? '0%' : '-100%',
            left: activeState ? '0%' : '-100%'
          }, 400);
        }

        $('.alt-menu-btn').on("click", function (event) {
          event.stopPropagation();
          $('.hamburger-menu').toggleClass('open');
          $('.menu-list').toggleClass('active');
          slideMenu();
          $('body').toggleClass('overflow-hidden');
        });
      },
      quickScroll: function quickScroll() {
        $(window).on("scroll", function () {
          if ($(this).scrollTop() > 200) {
            $('.scrollup').fadeIn();
          } else {
            $('.scrollup').fadeOut();
          }
        });
        $('.scrollup').on("click", function () {
          $("html, body").animate({
            scrollTop: 0
          }, 800);
          return false;
        });
      }
    }
  };
  jQuery(function () {
    Genius.init();
  });

  if ($('.mercado-google-maps').length == 1) {
    var wfm = document.createElement('script');
    wfm.src = 'http://maps.googleapis.com/maps/api/js?key=AIzaSyBpXkIHekTsMPHuS_yuG1cIK0j5TvVjFkE';
    wfm.type = 'text/javascript';
    var sm = document.getElementsByTagName('script')[0];
    sm.parentNode.insertBefore(wfm, sm);
  }

  var MERCADO_JS = {
    init: function init() {
      this.mercado_chosen();
      this.mercado_clone_all_zan_menus();
      this.mercado_control_mobile_menu();
      this.mercado_control_panel();
      this.mercado_tabs();
      this.mercado_countdown();
      this.mercado_better_equal_elems();
      this.mercado_toggle_slide_menu();
      this.mercado_price_range();
      this.mercado_price_quantity();
      this.mercado_remove_product_in_cart();
      this.mercado_product_slider();
      this.mercado_toggle_vertical_main_menu();
      this.mercado_sticky_menu();
      this.mercado_google_maps();
    },
    onReady: function onReady() {
      this.mercado_innit_carousel();
    },
    onResize: function onResize() {
      this.mercado_innit_carousel();
      this.mercado_better_equal_elems();
      this.mercado_product_slider();
      this.mercado_tabs();
      this.mercado_sticky_menu();
    },
    mercado_product_slider: function mercado_product_slider() {
      if ($(".product-gallery").length > 0) {
        $('.product-gallery').flexslider({
          animation: "slide",
          controlNav: "thumbnails"
        });
        var config = {
          margin: 10,
          nav: true,
          dots: false,
          loop: false,
          navText: ['<i class="fa fa-angle-left " aria-hidden="true"></i>', '<i class="fa fa-angle-right " aria-hidden="true"></i>']
        };
        config.responsive = {
          0: {
            items: "2"
          },
          370: {
            items: "3"
          },
          480: {
            items: "4"
          },
          768: {
            items: "4"
          },
          992: {
            items: "3"
          },
          1200: {
            items: "4"
          }
        };
        $(".flex-control-thumbs").owlCarousel(config);
      }
    },
    mercado_chosen: function mercado_chosen() {
      if ($('.wrap-search-form .wrap-list-cate').length > 0) {
        $('.wrap-search-form .wrap-list-cate').on('click', '.link-control', function (event) {
          event.preventDefault();
          $(this).siblings('ul').slideToggle();
        });
        $('.wrap-search-form .wrap-list-cate .list-cate').on('click', 'li', function (event) {
          var _this = $(this),
              _value = _this.attr('value'),
              _content = _this.text(),
              _title = _this.text();

          _content = _content.slice(0, 12);

          _this.parent().siblings('a').text(_content).attr('title', _title);

          _this.parent().siblings('input[name="product-cate"]').val(_value);

          _this.parent().slideUp();
        });
      }

      if ($("select:not(.except-chosen)").length > 0) {
        $("select:not(.except-chosen)").each(function () {
          $(this).chosen();
        });
      }
    },
    mercado_toggle_slide_menu: function mercado_toggle_slide_menu() {
      if ($(".widget .has-child-cate").length > 0) {
        $(document).on('click', ".widget .has-child-cate .toggle-control", function (el) {
          el.preventDefault();

          var _this = $(this);

          if (_this.parent().hasClass('open')) {
            _this.parent().removeClass('open');
          } else {
            _this.closest('.widget-content').find('.open').removeClass('open');

            _this.parent().addClass('open');
          }
        });
      }

      if ($(".widget .list-limited .default-hiden").length > 0) {
        $(document).on('click', '.widget .list-limited .btn-control', function (e) {
          e.preventDefault();

          var _this = $(this),
              _newlabel = _this.attr('data-label'),
              _currentlabel = _this.html();

          _this.parent().siblings('.default-hiden').slideToggle();

          _this.attr('data-label', _currentlabel).html(_newlabel);
        });
      }

      if ($(".toggle-slide-menu").length > 0) {
        $(".toggle-slide-menu").on('click', '.btn-control a', function (el) {
          el.preventDefault();

          var _this = $(this);

          _this.parent().siblings('.default-hiden').slideToggle(300);

          _this.find('i').toggleClass('fa-rotate-180');
        });
      }
    },
    mercado_price_range: function mercado_price_range() {
      if ($("#slider-range").length > 0) {
        $("#slider-range").slider({
          range: true,
          min: 0,
          max: 500,
          values: [75, 300],
          slide: function slide(event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
          }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
      }
    },

    /* ---------------------------------------------
    // Clone all Zan Menus for mobile
    ---------------------------------------------*/
    mercado_clone_all_zan_menus: function mercado_clone_all_zan_menus() {
      var i = 0,
          panels_html_args = Array();
      $('.clone-main-menu').each(function () {
        var $this = $(this),
            thisMenu = $this,
            this_menu_id = thisMenu.attr('id'),
            this_menu_clone_id = 'mercado-clone-' + this_menu_id;

        if (!$('#' + this_menu_clone_id).length) {
          var thisClone = $this.clone(true); // Clone Wrap

          thisClone.find('.menu-item').addClass('clone-menu-item');
          thisClone.find('[id]').each(function () {
            // Change all tab links with href = this id
            thisClone.find('.vc_tta-panel-heading a[href="#' + $(this).attr('id') + '"]').attr('href', '#' + MERCADO_JS.mercado_add_string_prefix($(this).attr('id'), 'mercado-clone-'));
            $(this).attr('id', MERCADO_JS.mercado_add_string_prefix($(this).attr('id'), 'mercado-clone-'));
          });
          thisClone.find('.mercado-menu').addClass('mercado-menu-clone');
          var thisMenuId = 'mercado-panel-' + $this.attr('id'),
              thisMenuname = $this.data('menuname'); // Create main panel if not exists

          if (!$('.mercado-clone-wrap .mercado-panels #mercado-main-panel').length) {
            $('.mercado-clone-wrap .mercado-panels').append('<div id="mercado-main-panel" class="mercado-panel mercado-main-panel"><ul class="depth-01"></ul></div>');
          }

          $('.mercado-clone-wrap .mercado-panels #mercado-main-panel ul').append('<li class="menu-item"><a data-target="#' + thisMenuId + '" class="mercado-next-panel" href="#' + thisMenuId + '"></a><a title="' + thisMenuname + '" class="mercado-item-title" href="#">' + thisMenuname + '</a></li>');

          if (!$('.mercado-clone-wrap .mercado-panels #mercado-panel-' + this_menu_id).length) {
            $('.mercado-clone-wrap .mercado-panels').append('<div id="mercado-panel-' + this_menu_id + '" class="mercado-panel mercado-hidden"><ul class="depth-01"></ul></div>');
          }

          var thisMainPanel = $('.mercado-clone-wrap .mercado-panels #mercado-panel-' + this_menu_id + ' ul');
          thisMainPanel.html(thisClone.html());
          MERCADO_JS.mercado_insert_children_panels_html_by_elem(thisMainPanel, i);
        }
      });
    },
    mercado_insert_children_panels_html_by_elem: function mercado_insert_children_panels_html_by_elem($elem, i) {
      var index = parseInt(i, 10);

      if ($elem.find('.menu-item-has-children').length) {
        $elem.find('.menu-item-has-children').each(function () {
          var thisChildItem = $(this);
          MERCADO_JS.mercado_insert_children_panels_html_by_elem(thisChildItem, index);
          var next_nav_target = 'mercado-panel-' + String(index); // Make sure there is no duplicate panel id

          while ($('#' + next_nav_target).length) {
            index++;
            next_nav_target = 'mercado-panel-' + String(index);
          } // Insert Next Nav


          thisChildItem.prepend('<a class="mercado-next-panel" href="#' + next_nav_target + '" data-target="#' + next_nav_target + '"></a>'); // Get sub menu html

          var submenu_html = $('<div>').append(thisChildItem.find('> .submenu,> .wrap-megamenu').clone()).html();
          thisChildItem.find('> .submenu,> .wrap-megamenu').remove();
          $('.mercado-clone-wrap .mercado-panels').append('<div id="' + next_nav_target + '" class="mercado-panel mercado-sub-panel mercado-hidden">' + submenu_html + '</div>');
        });
      }
    },
    mercado_control_panel: function mercado_control_panel() {
      $(document).on('click', '.mercado-next-panel', function (e) {
        var _this = $(this),
            thisItem = _this.closest('.menu-item'),
            thisPanel = _this.closest('.mercado-panel'),
            target_id = _this.attr('href');

        if ($(target_id).length) {
          thisPanel.addClass('mercado-sub-opened');
          $(target_id).addClass('mercado-panel-opened').removeClass('mercado-hidden').attr('data-parent-panel', thisPanel.attr('id'));
          typeof item_title == 'undefined'; // Insert current panel title

          var item_title = '',
              firstItemTitle = '';
          item_title = _this.siblings(".mercado-item-title").attr('title');

          if (typeof item_title == 'undefined') {
            item_title = 'mercado menu';
          }

          if ($('.mercado-panels-actions-wrap .mercado-current-panel-title').length > 0) {
            firstItemTitle = $('.mercado-panels-actions-wrap .mercado-current-panel-title').html();
          }

          $('.mercado-panels-actions-wrap').find('.mercado-current-panel-title').remove();
          $('.mercado-panels-actions-wrap').prepend('<span class="mercado-current-panel-title">' + item_title + '</span>'); // Back to previous panel

          $('.mercado-panels-actions-wrap .mercado-prev-panel').remove();
          $('.mercado-panels-actions-wrap').prepend('<a data-prenttitle="' + firstItemTitle + '" class="mercado-prev-panel" href="#' + thisPanel.attr('id') + '" data-cur-panel="' + target_id + '" data-target="#' + thisPanel.attr('id') + '"></a>');
        }

        e.preventDefault();
      }); // Go to previous panel

      $(document).on('click', '.mercado-prev-panel', function (e) {
        var $this = $(this),
            cur_panel_id = $this.attr('data-cur-panel'),
            target_id = $this.attr('href');
        $(cur_panel_id).removeClass('mercado-panel-opened').addClass('mercado-hidden');
        $(target_id).addClass('mercado-panel-opened').removeClass('mercado-sub-opened'); // Set new back button

        var new_parent_panel_id = $(target_id).attr('data-parent-panel');

        if (typeof new_parent_panel_id == 'undefined' || typeof new_parent_panel_id == false) {
          $('.mercado-panels-actions-wrap .mercado-prev-panel').remove();
          $('.mercado-panels-actions-wrap .mercado-current-panel-title').remove();
        } else {
          $('.mercado-panels-actions-wrap .mercado-prev-panel').attr('href', '#' + new_parent_panel_id).attr('data-cur-panel', target_id).attr('data-target', '#' + new_parent_panel_id); // Insert new panel title

          var item_title = '';
          item_title = $('#' + new_parent_panel_id).find('.mercado-next-panel[data-target="' + target_id + '"]').siblings('.mercado-item-title').attr('title');

          if (typeof item_title == 'undefined') {
            item_title = 'mercado menu';
          }

          $('.mercado-panels-actions-wrap').prepend('<span class="mercado-current-panel-title">' + item_title + '</span>');
        }

        e.preventDefault();
      });
    },
    mercado_control_mobile_menu: function mercado_control_mobile_menu() {
      // BOX MOBILE MENU
      $(document).on('click', '.mobile-navigation', function (el) {
        el.preventDefault();
        $('.mercado-clone-wrap').addClass('open');
        return false;
      }); // Close box menu

      $(document).on('click', '.mercado-clone-wrap .mercado-close-panels', function () {
        $('.mercado-clone-wrap').removeClass('open');
        return false;
      });
    },
    mercado_innit_carousel: function mercado_innit_carousel() {
      $(".owl-carousel").each(function (index, el) {
        var _this = $(this),
            _owl = _this,
            _config = _this.data(),
            _animateOut = _this.data('animateout'),
            _animateIn = _this.data('animatein'),
            _slidespeed = _this.data('slidespeed');

        _config.navText = ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'];

        if (typeof _animateOut != 'undefined') {
          _config.animateOut = _animateOut;
        }

        if (typeof _animateIn != 'undefined') {
          _config.animateIn = _animateIn;
        }

        if (typeof _slidespeed != 'undefined') {
          _config.smartSpeed = _slidespeed;
        }

        if ($('body').hasClass('rtl')) {
          _config.rtl = true;
        }

        _owl.on('drag.owl.carousel', function (event) {
          _owl.addClass('owl-changed');

          setTimeout(function () {
            _owl.removeClass('owl-changed');
          }, _config.smartSpeed);
        });

        _owl.owlCarousel(_config);
      });
    },
    mercado_tabs: function mercado_tabs() {
      if ($(".tab-control:not(.normal)").length > 0) {
        if ($(".tab-contents").length) {
          setTimeout(function () {
            $('.tab-contents:not(.tab-not-equal)').each(function () {
              var $this = $(this);

              if ($this.find('.tab-content-item').length) {
                $this.find('.tab-content-item').css({
                  'height': 'auto'
                });
                var elem_height = 0;
                $this.find('.tab-content-item').each(function () {
                  var this_elem_h = $(this).height();

                  if (parseInt(elem_height, 10) < parseInt(this_elem_h, 10)) {
                    elem_height = parseInt(this_elem_h, 10);
                  }
                });
                $this.find('.tab-content-item').height(elem_height);
              }
            });
          }, 1200);
        }

        $(document).on('click', '.tab-control .tab-control-item', function (ev) {
          ev.preventDefault();

          if (!$(this).hasClass('active')) {
            var _this = $(this),
                _link_content = _this.attr('href'),
                _tab_active = _this.closest('.wrap-product-tab').find('.tab-contents').find(_link_content);

            _this.siblings(".active").removeClass('active');

            _this.addClass('active');

            _this.closest('.wrap-product-tab').find('.tab-contents .active').removeClass('active');

            _tab_active.addClass('active');

            _tab_active.find('.wrap-products .owl-item').each(function (index) {
              var owl_item = $(this),
                  style = $(this).attr("style"),
                  tab_animated = 'zoomIn',
                  delay = parseInt(index, 10) * 100;
              owl_item.attr("style", style + ";-webkit-animation-delay:" + String(delay) + "ms;" + "-moz-animation-delay:" + String(delay) + "ms;" + "-o-animation-delay:" + String(delay) + "ms;" + "animation-delay:" + String(delay) + "ms;").addClass(tab_animated + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                owl_item.removeClass(tab_animated + ' animated');
                owl_item.attr("style", style);
              });
            });
          }
        });
      }

      if ($(".tab-control.normal").length > 0) {
        $(document).on('click', '.tab-control.normal .tab-control-item', function (ev) {
          ev.preventDefault();

          var _this = $(this);

          if (!_this.hasClass('active')) {
            _this.siblings(".active").removeClass('active');

            _this.addClass('active');

            _this.parents().siblings('.tab-contents').find('.active').removeClass('active');

            _this.parents().siblings('.tab-contents').find(_this.attr('href')).addClass('active');
          }
        });
      }
    },
    mercado_countdown: function mercado_countdown() {
      if ($(".mercado-countdown").length > 0) {
        $(".mercado-countdown").each(function (index, el) {
          var _this = $(this),
              _expire = _this.data('expire');

          _this.countdown(_expire, function (event) {
            $(this).html(event.strftime('<span><b>%D</b> Days</span> <span><b>%-H</b> Hrs</span> <span><b>%M</b> Mins</span> <span><b>%S</b> Secs</span>'));
          });
        });
      }
    },

    /* ---------------------------------------------
    EQUAL ELEM
    --------------------------------------------- */
    mercado_better_equal_elems: function mercado_better_equal_elems() {
      setTimeout(function () {
        $('.equal-container').each(function () {
          var _this = $(this),
              _children = _this.find('.equal-elem');

          if (_children.length) {
            _children.css('height', 'auto');

            var max_height = 0;

            _children.each(function () {
              var el_height = $(this).height();

              if (max_height < parseFloat(el_height)) {
                max_height = parseFloat(el_height);
              }
            });

            _children.height(parseInt(max_height, 10));
          }
        });
      }, 1000);
    },
    mercado_price_quantity: function mercado_price_quantity() {
      if ($(".quantity-input").length > 0) {
        $(".quantity-input").on('click', '.btn', function (event) {
          event.preventDefault();

          var _this = $(this),
              _input = _this.siblings('input[name=product-quatity]'),
              _current_value = _this.siblings('input[name=product-quatity]').val(),
              _max_value = _this.siblings('input[name=product-quatity]').attr('data-max');

          if (_this.hasClass('btn-reduce')) {
            if (parseInt(_current_value, 10) > 1) _input.val(parseInt(_current_value, 10) - 1);
          } else {
            if (parseInt(_current_value, 10) < parseInt(_max_value, 10)) _input.val(parseInt(_current_value, 10) + 1);
          }
        });
      }
    },
    mercado_remove_product_in_cart: function mercado_remove_product_in_cart() {
      if ($(".products-cart .pr-cart-item").length > 0) {
        $(document).on('click', '.pr-cart-item .delete .btn-delete', function (event) {
          event.preventDefault();
          $(this).closest('.pr-cart-item').remove();
        });
      }
    },
    mercado_toggle_vertical_main_menu: function mercado_toggle_vertical_main_menu() {
      if ($(".header.header-toggle .vertical-menu-toggle").length) {
        $('.header.header-toggle .vertical-menu-toggle').on('click', '.wrap-toggle-menu', function (event) {
          event.preventDefault();
          $(this).toggleClass('close-menu');
          /* Act on the event */
        });
      }
    },
    mercado_sticky_menu: function mercado_sticky_menu() {
      var _device_size = $(window).width();

      if (parseInt(_device_size, 10) > 1024 && $('.header-sticky').length > 0) {
        var header_height = $('.header').innerHeight(),
            vertical_menu_height = 0,
            vertical_menu_title_height = 0,
            _topSpacing = 0,
            header_sticky = $('.header-sticky'),
            vertical_menu = $('.primary-nav-section.vertical-menu-toggle');

        if (vertical_menu.length > 0) {
          vertical_menu_title_height = vertical_menu.innerHeight();
          vertical_menu_height = vertical_menu.find('.nav.primary').innerHeight();
          header_sticky.on('sticky-start', function () {
            vertical_menu.find('.wrap-toggle-menu').addClass('close-menu');
          });
        }

        if (parseInt(vertical_menu_height, 10) > 0) {
          _topSpacing = -1 * (parseInt(header_height, 10) + parseInt(vertical_menu_height, 10) - parseInt(vertical_menu_title_height, 10));
        }

        header_sticky.sticky({
          topSpacing: String(_topSpacing)
        });
      }
    },
    mercado_google_maps: function mercado_google_maps() {
      if ($('.mercado-google-maps').length == 1) {
        $('.mercado-google-maps').each(function () {
          var $this = $(this),
              $id = $this.attr('id'),
              $title_maps = $this.attr('data-title_maps'),
              $phone = $this.attr('data-phone'),
              $email = $this.attr('data-email'),
              $zoom = parseInt($this.attr('data-zoom')),
              $latitude = $this.attr('data-latitude'),
              $longitude = $this.attr('data-longitude'),
              $address = $this.attr('data-address'),
              $map_type = $this.attr('data-map-type'),
              $pin_icon = $this.attr('data-pin-icon'),
              $modify_coloring = $this.attr('data-modify-coloring') === "true" ? true : false,
              $saturation = $this.attr('data-saturation'),
              $hue = $this.attr('data-hue'),
              $map_height = $this.attr('data-map-height'),
              $map_style = $this.data('map-style'),
              $styles;

          if ($modify_coloring == true) {
            var $styles = [{
              stylers: [{
                hue: $hue
              }, {
                invert_lightness: false
              }, {
                saturation: $saturation
              }, {
                lightness: 1
              }, {
                featureType: "landscape.man_made",
                stylers: [{
                  visibility: "on"
                }]
              }]
            }, {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{
                color: '#46bcec'
              }]
            }];
          }

          var map,
              bounds = new google.maps.LatLngBounds(),
              mapOptions = {
            zoom: $zoom,
            panControl: false,
            zoomControl: false,
            mapTypeControl: false,
            scaleControl: false,
            draggable: true,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId[$map_type],
            styles: $styles
          };
          map = new google.maps.Map(document.getElementById($id), mapOptions);
          var map_dom = '#' + $id;
          $(map_dom).css({
            height: $map_height
          });
          map.setTilt(25);
          var markers = [],
              infoWindowContent = [];

          if ($latitude != '' && $longitude != '') {
            markers[0] = [$address, $latitude, $longitude];
            infoWindowContent[0] = [$address];
          }

          var infoWindow = new google.maps.InfoWindow(),
              marker,
              i;

          for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
              position: position,
              map: map,
              title: markers[i][0],
              icon: $pin_icon
            });

            if ($map_style == '1') {
              if (infoWindowContent[i][0].length > 1) {
                infoWindow.setContent('<div style="background-color:#fff; padding: 30px 30px 10px 25px; width:290px;line-height: 22px" class="mercado-map-info">' + '<h4 class="map-title">' + $title_maps + '</h4>' + '<div class="map-field"><i class="fa fa-map-marker"></i><span>&nbsp;' + $address + '</span></div>' + '<div class="map-field"><i class="fa fa-phone"></i><span>&nbsp;' + $phone + '</span></div>' + '<div class="map-field"><i class="fa fa-envelope"></i><span><a href="mailto:' + $email + '">&nbsp;' + $email + '</a></span></div> ' + '</div>');
              }

              infoWindow.open(map, marker);
            }

            if ($map_style == '2') {
              google.maps.event.addListener(marker, 'click', function (marker, i) {
                return function () {
                  if (infoWindowContent[i][0].length > 1) {
                    infoWindow.setContent('<div style="background-color:#fff; padding: 30px 30px 10px 25px; width:290px;line-height: 22px" class="mercado-map-info">' + '<h4 class="map-title">' + $title_maps + '</h4>' + '<div class="map-field"><i class="fa fa-map-marker"></i><span>&nbsp;' + $address + '</span></div>' + '<div class="map-field"><i class="fa fa-phone"></i><span>&nbsp;' + $phone + '</span></div>' + '<div class="map-field"><i class="fa fa-envelope"></i><span><a href="mailto:' + $email + '">&nbsp;' + $email + '</a></span></div> ' + '</div>');
                  }

                  infoWindow.open(map, marker);
                };
              }(marker, i));
            }

            map.setCenter(bounds.getCenter());
          }

          var boundsListener = google.maps.event.addListener(map, 'bounds_changed', function (event) {
            this.setZoom($zoom);
            google.maps.event.removeListener(boundsListener);
          });
        });
      }
    }
  };
  /* ---------------------------------------------
   Scripts on load
   --------------------------------------------- */

  window.onload = function () {
    MERCADO_JS.init();
  };
  /* ---------------------------------------------
   Scripts run when document are ready
   --------------------------------------------- */


  $(document).ready(function () {
    MERCADO_JS.onReady();
  });
  /* ---------------------------------------------
   Scripts resize
   --------------------------------------------- */

  $(window).on("resize", function () {
    MERCADO_JS.onResize();
  });
})();
/******/ })()
;