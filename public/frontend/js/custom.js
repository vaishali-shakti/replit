$(document).ready(function () {

    // $(".select_city_menu .main_city_submenu").css("display","none");

    $('body').click(function () {
        $(".select_city_menu .main_city_submenu").slideUp();
    });
    $(".select_city_menu").click(function (event) {
        event.stopPropagation();
        $(".main_content_filter .main_filter_location").slideUp();
    });

    $(".select_city_menu").click(function () {
        $(".select_city_menu .main_city_submenu").slideToggle();
    });


    // ---------filter menu------------

    $('body').click(function () {
        $(".main_content_filter .main_filter_location").slideUp();
    });
    $(".filter_main_location").click(function () {
        $(".main_content_filter .main_filter_location").slideToggle();
    });
    $(".filter_main_location").click(function (event) {
        event.stopPropagation();
        $(".select_city_menu .main_city_submenu").slideUp();

    });

    // ----toggle bar -------

    // $('body').click(function () {
    //     $(".mobile_right_nav").slideUp();
    // });
    // $(".nav-mobile-toggle").click(function (event) {
    //     event.stopPropagation();
    // });
    // $('.nav-mobile-toggle').click(function () {
    //     $('.mobile_right_nav').slideToggle()
    // })

    // --------- topbar sticky-----------
    $(window).scroll(function () {
        h = $(window).scrollTop();
        if (h > 0) {
            $('.main_nav').addClass('sticky');
        }
        else {
            $('.main_nav').removeClass('sticky');
        }
    })

    var city_submenu = document.querySelectorAll(".main_city_submenu")

    if (city_submenu > 240) {
        city_submenu.style.O
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function () {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

    //testimonial
    $('.main_slide_testimonial').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    $('.main_slide_testimonial .owl-dots .owl-dot').each(function (index) {
        $(this).attr('aria-label', 'testimonial Slide ' + (index + 1));
    });

    //showcase slider
    $('.main_slide_screen').owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        autoplay: true,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1
            },
            575: {
                items: 2
            },
            767: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    $('.main_slide_screen .owl-dots .owl-dot').each(function (index) {
        $(this).attr('aria-label', 'Slide ' + (index + 1));
    });


    const rangeInput = document.querySelectorAll(".range-input input"),
        priceInput = document.querySelectorAll(".price-input input"),
        range = document.querySelector(".slider .progress");
    let priceGap = 1000;

    priceInput.forEach((input) => {
        input.addEventListener("input", (e) => {
            let minPrice = parseInt(priceInput[0].value),
                maxPrice = parseInt(priceInput[1].value);

            if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
                if (e.target.className === "input-min") {
                    rangeInput[0].value = minPrice;
                    range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                } else {
                    rangeInput[1].value = maxPrice;
                    range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                }
            }
        });
    });

    rangeInput.forEach((input) => {
        input.addEventListener("input", (e) => {
            let minVal = parseInt(rangeInput[0].value),
                maxVal = parseInt(rangeInput[1].value);

            if (maxVal - minVal < priceGap) {
                if (e.target.className === "range-min") {
                    rangeInput[0].value = maxVal - priceGap;
                } else {
                    rangeInput[1].value = minVal + priceGap;
                }
            } else {
                priceInput[0].value = minVal;
                priceInput[1].value = maxVal;
                range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
                range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
            }
        });
    });

});
