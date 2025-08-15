$(document).ready(function(){
        $(window).scroll(function () {
          h = $(window).scrollTop();
          if (h > 0) {
              $('.header_section').addClass('sticky');
          }
          else {
              $('.header_section').removeClass('sticky');
          }
      })


      // ---------- scroll to top
      $(window).scroll(function () {
        let h = $(window).scrollTop();
        if (h > 120) {
            $('#scroll').stop().animate({ opacity: 1, bottom: '50px' }, 200); // Animate to visible state
        } else {
            $('#scroll').stop().animate({ opacity: 0, bottom: '10px' }, 200); // Animate to hidden state
        }
    });

    $('#scroll').click(function () {
      $("html, body").animate({ scrollTop: 0 }, 600);
      return false;
   });

    // ----------  menu
    $(".sub-menu , .mobile-sub-menu").hide();
    $(".peta-menu , .mobile-peta-menu").hide();
	
    $('body').click( function(){
      $('.sub-menu , .peta-menu ').slideUp();
     })
     $(".nav-main > li > a ").click(function (event) {
     event.stopPropagation();
  });
	
    $('.nav-main > li > a , .mobile-nav-main > li > a').click(function () {
      var $ul = $(this).siblings('ul');
      var $icon = $(this).find('.fa-solid'); 
      if ($ul.length > 0) {
          $ul.slideToggle();
          $icon.toggleClass('fa-chevron-up fa-chevron-down');
          $(".sub-menu, .mobile-sub-menu").not($ul).slideUp();
          $(".nav-main > li > a .fa-solid, .mobile-nav-main > li > a .fa-solid")
              .not($icon)
              .removeClass('fa-chevron-up')
              .addClass('fa-chevron-down');
          
          return false;
      }
    });
    $('body').click(function () {
      $(".nav-main ul, .mobile-nav-main ul").slideUp();
      $(".nav-main > li > a .fa-solid, .mobile-nav-main > li > a .fa-solid")
          .removeClass('fa-chevron-up')
          .addClass('fa-chevron-down');
 });

    // $('.sub-menu > li > a , .mobile-sub-menu > li > a').click(function () {
    //   var $ul = $(this).siblings('ul');
    //   if ($ul.length > 0) {
    //       $ul.slideToggle();
    //       $(".peta-menu , .mobile-peta-menu").not($ul).slideUp();
    //       return false;
    //   }
    // });
    $('.sub-menu > li > a, .mobile-sub-menu > li > a').click(function () {
      var $ul = $(this).siblings('ul'); 
      var $icon = $(this).find('.fa-solid'); 
      if ($ul.length > 0) {
          $ul.slideToggle(); 
  
          $icon.toggleClass('fa-chevron-up fa-chevron-down');
  
          $(".sub-menu ul, .mobile-sub-menu ul").not($ul).slideUp();
          $(".sub-menu > li > a .fa-solid, .mobile-sub-menu > li > a .fa-solid")
              .not($icon)
              .removeClass('fa-chevron-up')
              .addClass('fa-chevron-down');
          
          return false;
      }
  });
    $('body').click(function () {
      $(".sub-menu ul, .mobile-sub-menu ul").slideUp();
      $(".sub-menu > li > a .fa-solid, .mobile-sub-menu > li > a .fa-solid")
          .removeClass('fa-chevron-up')
          .addClass('fa-chevron-down');
  });
  
  //   $('.sub-menu > li , .mobile-sub-menu > li ').click(function () {
  //     $('.sub-menu > li , .mobile-sub-menu > li ').removeClass('active');
  //     $(this).addClass('active');
  // });

    //   $('.nav ul.nav-main li').click(function () {
    //     $('.nav ul.nav-main li').removeClass('active');
    //     $(this).addClass('active');
    // });
    // --------------  user dropdown 

    $('.user_menu').hide();

    $('body').click( function(){
      if ($('.user_menu').is(':visible')) {
       $('.user_menu ').slideUp();
       $('.account_btn > i').toggleClass('fa-chevron-down fa-chevron-up');
      } 
    })
    $(".account_btn ,.mo_account_btn").click(function (event) {
      event.stopPropagation();
    });

    $('.account_btn , .mo_account_btn').click(function (){
        $('.user_menu ').slideToggle();
        $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
    })

      // ------ -- offcanvas 
   
    $(document).ready(function () {
      $('.mobile-nav-main li a').click(function () {
          // Check if the link has a specific class or attribute to prevent conflicts
          if ($(this).attr('href') === 'javascript:void(0);') {
            offcanvasInstance.show();
          }
  
          // Close the Bootstrap Offcanvas
          var offcanvasElement = $('.offcanvas')[0]; // Select the first Offcanvas element
          var offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasElement);
          if (offcanvasInstance) {
              offcanvasInstance.hide();
          }
      });
  });
  

    // -------------- banner slider start -------------- 
    $('#banner-slider').owlCarousel({
      loop:true,
      autoplay:true,
      startPosition:0,
      // rewind:true,
      nav:true,
      autoplayTimeout:8000,
      dots:false,
    //   navText:[<i class="flaticon-play-button"></i>","<img src='../image/subtract.png'>"],
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
  })  
  
  // ---------------- music pro slider ---------------

  $('#music_pro_slider').owlCarousel({
    items:4,
    loop:true,
    margin:20,
    autoplay:true,
    nav:true,
    dots:false,
  //   navText:[<i class="flaticon-play-button"></i>","<img src='../image/subtract.png'>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        800:{
          items:2
        },
        1024:{
            items:3
        },
        1500: {
          items:4
        }
       
    }
})  
});