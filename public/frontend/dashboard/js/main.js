// Show the first tab and hide the rest 1st
$('#big-nav .box:first-child').addClass('active');
$('.tab-content-st').hide();
$('.tab-content-st:first').show();
$('#big-nav .box').click(function () {
  $('#big-nav .box').removeClass('active');
  $(this).addClass('active');
  $('.tab-content-st').hide();
  var activeTab = $(this).find('a').attr('href');
  $(activeTab).fadeIn();
  return false;
});

$(document).ready(function () {
  // Show the first tab and hide the rest
  $('#tabs-nav li:first-child').addClass('active');
  $('.tab-content').hide();
  $('.tab-content:first').show();
  $('#tabs-nav li').click(function () {
    $('#tabs-nav li').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();
    var activeTab = $(this).find('a').attr('href');
    $(activeTab).fadeIn();
    return false;
  });

  // page scroll
  $('.page-scroller').click(function () {
    $("html, body").animate({ scrollTop: 0 }, 300);
    return false;
  });
  // Choose any 3 to Compare Business
  // Show the first tab and hide the rest --- Compliances under Foreign Exchange Management Act

  $('#ftabs-nav li:first-child').addClass('active');
  $('.ftab-content').hide();
  $('.ftab-content:first').show();
  $('#ftabs-nav li').click(function () {
    $('#ftabs-nav li').removeClass('active');
    $(this).addClass('active');
    $('.ftab-content').hide();
    var activeTab = $(this).find('a').attr('href');
    $(activeTab).fadeIn();
    return false;
  });

  // dashboard mobile resize add remove class
  $(window).bind("resize", function () {
    console.log($(this).width())
    if ($(this).width() < 500) {
      $('.drop-btn.ddrop-btn').removeClass('dmtoggle').addClass('dmhide')
    } else {
      $('.drop-btn.ddrop-btn').removeClass('dmhide').addClass('dmtoggle')
    }
  }).trigger('resize');

});

// mobile dropmenu
$(function () {
  $('.mobile-dropmenu .dropdown-menu.mmenu').slideUp();
  $('.mdbtn.active').next().slideDown();
  $('.mdbtn').click(function (j) {
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $('.mdbtn').removeClass('is-active');
      $(this).next().slideUp();
    }

    else {
      $('.mdbtn').removeClass('active');
      $('.dropdown-menu.mmenu').slideUp();
      $(this).addClass('active');
      $(this).next().slideDown();
    }
  });
});


// asidemenuscroll
$(function () {
  $('.sub-list').slideUp();
  $('.drop-menu.active').next().slideDown();
  $('.drop-menu').click(function (j) {
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $('.drop-menu').removeClass('is-active');
      $(this).next().slideUp();
    }
    else {
      $('.drop-menu').removeClass('active');
      $('.sub-list').slideUp();
      $(this).addClass('active');
      $(this).next().slideDown();

    }
  });
});

// profiletoggle_menu
$(function () {
  $("#drop-profile").on("click", function (e) {
    $(".profile_menu, .drop-profile, .ddrop-btn").toggleClass("active");
  });
  $(document).on("click", function (e) {
    if ($(e.target).is(".profile_menu, #drop-profile") === false) {
      $(".profile_menu, .drop-profile").removeClass("active");
    }
  });
});

// toggleclass javascript
function toggleActive(Id, db) {
  var element = document.querySelector(Id);
  element.classList.toggle(db);
}

// dashboard service menu toggle
const $menu = $('.ddrop-btn');

$(document).mouseup(function (e) {
  if (!$menu.is(e.target) // if the target of the click isn't the container...
    && $menu.has(e.target).length === 0) // ... nor a descendant of the container
  {
    $menu.removeClass('is-active');
  }
});

$('.ddrop-btn').on('click', () => {
  $menu.toggleClass('is-active');
});

// onclick and scroll tabsactive add remove
$(document).ready(function () {
  $(document).ready(function () {
    $('.textbox a').on('click', function () {
      var page = $(this).attr('href');
      var offset = 100;
      $('html, body').animate({
        scrollTop: $(page).offset().top - offset
      },); // Go
      return false;
    });
  });
  const sections = document.querySelectorAll(".tab_content[id]");
  window.addEventListener("scroll", navHighlighter);
  function navHighlighter() {
    let scrollY = window.pageYOffset;
    sections.forEach(current => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = (current.getBoundingClientRect().top + window.pageYOffset) - 150;
      sectionId = current.getAttribute("id");
      if (
        scrollY > sectionTop &&
        scrollY <= sectionTop + sectionHeight
      ) {
        document.querySelector(".textbox a[href*=" + sectionId + "]").classList.add("active");
      } else {
        document.querySelector(".textbox a[href*=" + sectionId + "]").classList.remove("active");
      }
    });
  }
});

// all slider
// $(document).ready(function () {
//   const owl = $('.owl-carousel.whychoose-crousel')
//   $('.owl-carousel.whychoose-crousel').owlCarousel({
//     loop: true,
//     margin: 10,
//     dots: false,
//     nav: false,
//     responsive: {
//       0: {
//         items: 1
//       },
//       600: {
//         items: 1
//       },
//       1000: {
//         items: 1
//       }
//     }
//   });
//   $('.owl-carousel__next').click(() => owl.trigger('next.owl.carousel'))
//   $('.owl-carousel__prev').click(() => owl.trigger('prev.owl.carousel'))

//   $('.owl-carousel.foundation-carousel').owlCarousel({
//     loop: true,
//     autoplay: true,
//     margin: 20,
//     nav: false,
//     dots: false,
//     center: true,
//     responsive: {
//       0: {
//         items: 1
//       },
//       600: {
//         items: 1
//       },
//       1000: {
//         items: 3
//       }
//     }
//   });

//   $('.owl-carousel.related-carousel').owlCarousel({
//     loop: true,
//     autoplay: true,
//     nav: false,
//     dots: false,
//     responsive: {
//       0: {
//         items: 1
//       },
//       600: {
//         items: 2
//       },
//       1000: {
//         items: 3
//       }
//     }
//   });

// });

// $('.owl-carousel.usertastimonial').owlCarousel({
//   loop: true,
//   margin: 10,
//   nav: true,
//   autoplay: true,
//   autoplayTimeout: 5000,
//   autoplayHoverPause: true,
//   responsive: {
//     0: {
//       items: 1
//     },
//     600: {
//       items: 1
//     },
//     1000: {
//       items: 1
//     }
//   }
// });

// data table
$(document).ready(function () {
  $('#datatable').DataTable();
});
$('#datatable').dataTable({ searching: false, paging: false, info: false });
