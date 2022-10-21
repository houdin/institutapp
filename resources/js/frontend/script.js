/* -----------------------------------------------------------------------------



File:           JS Core
Version:        1.0
Last change:    00/00/00
Author:         HTMLMATE Team

-------------------------------------------------------------------------------- */
(function () {
    "use strict";

    var Genius = {
        init: function () {
            // hljs.initHighlightingOnLoad()
            this.Basic.init();
        },

        Basic: {
            init: function () {
                // this.menuBar();
                // this.portfolioSlide();
                this.datePicker();
                this.bannerParalax();

                this.videoPopup();

                // this.bestproductSlide();
                this.rateReview();
                // this.categorySlide();

                // this.buttonSlide();
                // this.categorySlide_3();

                this.productRange();

                // this.mainSlide();
            },

            /* - Start of menu bar
            ================================================*/
            menuBar: function () {
                // $(window).on('scroll', function () {
                //     if ($(window).scrollTop() > 50) {
                //         $('.main-menu-container').addClass('menu-bg-overlay')
                //     } else {
                //         $('.main-menu-container').removeClass('menu-bg-overlay')
                //     }
                // })
            },

            /* - End of menu bar
            ================================================*/

            /* Start Of formation slide
            ================================================*/
            mainSlide: function () {
                $("#slider-item").owlCarousel({
                    items: 3,
                    margin: 0,
                    responsiveClass: true,
                    nav: true,
                    loop: $(this).children().length > 1,
                    dots: true,
                    autoplay: false,
                    navText: [
                        "<i class='fas fa-chevron-left'></i>",
                        "<i class='fas fa-chevron-right'></i>",
                    ],
                    smartSpeed: 1000,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        400: {
                            items: 1,
                        },
                        600: {
                            items: 1,
                        },
                        700: {
                            items: 1,
                        },
                        800: {
                            items: 1,
                        },
                        1000: {
                            items: 1,
                        },
                    },
                });
            },
            /* End Of formation slide
            ================================================*/

            /* Start Of formation slide
            ================================================*/
            portfolioSlide: function () {
                $("#portfolio-slide-item").owlCarousel({
                    margin: 10,
                    items: 4,
                    responsiveClass: true,
                    nav: true,
                    dots: false,
                    autoplay: false,
                    navText: [
                        "<i class='fas fa-chevron-left'></i>",
                        "<i class='fas fa-chevron-right'></i>",
                    ],
                    smartSpeed: 1000,
                    mergeFit: false,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        400: {
                            items: 1,
                        },
                        600: {
                            items: 2,
                        },
                        790: {
                            items: 2,
                        },
                        800: {
                            items: 3,
                        },
                        992: {
                            items: 4,
                        },
                    },
                });
            },
            /* End Of formation slide
            ================================================*/

            /* Start Of Date picker
            ================================================*/
            datePicker: function () {
                $("#datepicker").datepicker();
            },
            /* - End Start Of Date picker
            ================================================*/

            /* Start Of parallax
            ================================================*/
            bannerParalax: function () {
                $(".jarallax").jarallax({
                    speed: 0.5,
                });
            },
            /* End Of Preloader
            ================================================*/

            /* Start of popup
            ================================================*/
            videoPopup: function () {
                $(".popup-with-zoom-anim").magnificPopup({
                    disableOn: 200,
                    type: "iframe",
                    mainClass: "mfp-fade",
                    removalDelay: 160,
                    preloader: false,
                    fixedContentPos: false,
                });
            },
            /* End of popup
            ================================================*/

            /* Start Of best product
            ================================================*/
            bestproductSlide: function () {
                $("#best-product-slide-item").owlCarousel({
                    margin: 25,
                    responsiveClass: true,
                    nav: true,
                    dots: false,
                    autoplay: false,
                    navText: [
                        "<i class='fas fa-chevron-left'></i>",
                        "<i class='fas fa-chevron-right'></i>",
                    ],
                    smartSpeed: 1000,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        400: {
                            items: 1,
                        },
                        600: {
                            items: 2,
                        },
                        700: {
                            items: 2,
                        },
                        800: {
                            items: 2,
                        },
                        1000: {
                            items: 4,
                        },
                    },
                });
            },
            /* End Of best product
            ================================================*/

            /* End Of best product
            ================================================*/

            /* - Start of faq accordion
            ================================================*/
            rateReview: function () {
                $(":radio").change(function () {
                    console.log("New star rating: " + this.value);
                });
            },
            /* - End of faq accordion
            ================================================*/

            /* Start Of best product
            ================================================*/
            categorySlide: function () {
                $(".category-slide-item").owlCarousel({
                    margin: 25,
                    responsiveClass: true,
                    nav: true,
                    dots: false,
                    autoplay: false,
                    navText: [
                        "<i class='fas fa-chevron-left'></i>",
                        "<i class='fas fa-chevron-right'></i>",
                    ],
                    smartSpeed: 1000,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        400: {
                            items: 1,
                        },
                        600: {
                            items: 2,
                        },
                        700: {
                            items: 3,
                        },
                        1000: {
                            items: 4,
                        },
                    },
                });
            },
            /* End Of best product
            ================================================*/

            /* Start Of best product
            ================================================*/
            buttonSlide: function () {
                $(".button-tab").owlCarousel({
                    margin: 0,
                    responsiveClass: true,
                    nav: true,
                    dots: false,
                    autoplay: false,
                    navText: [
                        "<i class='fas fa-chevron-left'></i>",
                        "<i class='fas fa-chevron-right'></i>",
                    ],
                    smartSpeed: 1000,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        400: {
                            items: 2,
                        },
                        600: {
                            items: 4,
                        },
                        700: {
                            items: 5,
                        },
                        1000: {
                            items: 6,
                        },
                    },
                });
            },
            /* End Of best product
            ================================================*/

            /* Start Of category slide
            ================================================*/
            categorySlide_3: function () {
                $(".category-slide").owlCarousel({
                    margin: 0,
                    responsiveClass: true,
                    nav: true,
                    autoplay: false,
                    navText: [
                        "<i class='fas fa-chevron-left'></i>",
                        "<i class='fas fa-chevron-right'></i>",
                    ],
                    dots: false,
                    smartSpeed: 1000,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        400: {
                            items: 2,
                        },
                        600: {
                            items: 3,
                        },
                        700: {
                            items: 4,
                        },
                        1000: {
                            items: 5,
                        },
                    },
                });
            },
            /* End Of  category slide
            ================================================*/

            /* Start Of category slide
            ================================================*/
            productRange: function () {
                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: 800,
                    values: [175, 500],
                    slide: function (event, ui) {
                        $("#amount").val(
                            "$" + ui.values[0] + " - $" + ui.values[1]
                        );
                    },
                });
                $("#amount").val(
                    "$" +
                        $("#slider-range").slider("values", 0) +
                        " - $" +
                        $("#slider-range").slider("values", 1)
                );
            },
            /* End Of  category slide
            ================================================*/
        },
    };
    jQuery(function () {
        Genius.init();
    });
})();
