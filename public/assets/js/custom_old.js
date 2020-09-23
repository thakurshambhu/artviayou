$(window).scroll(function() {
   if($(this).scrollTop()>60) {
       $( ".navbar-header" ).addClass("has-fixed");
    } else {
       $( ".navbar-header" ).removeClass("has-fixed");
   }
});

$('#bannerCarousel').carousel({
    interval: 8000
})

$(document).ready(function(){
  $(".bannerinner").prev(".navbar").addClass("navInner");
  
});

$('.artistCarousel').owlCarousel({
  loop:false, 
  dots: false,
  margin: 20,
  nav:true,
  responsiveClass:true,
  responsive:{
      1200:{
          items:3
      
      },
      767:{
          items:2
         
      },
      580:{
          items:1
         
      },
      480:{
          items:1
         
      },
      300:{
          items:1
         
      },
      990:{
          items:1
      }
  }
});

// $('#artwork-images').flexgal();

$('.panel-collapse').on('show.bs.collapse', function () {
  $(this).siblings('.panel-heading').addClass('active');
});

$('.panel-collapse').on('hide.bs.collapse', function () {
  $(this).siblings('.panel-heading').removeClass('active');
});



  
/*  Bootstrap Carousel and Animate.css */
(function($) {
    //Function to animate slider captions
    function doAnimations(elems) {
      //Cache the animationend event in a variable
      var animEndEv = "webkitAnimationEnd animationend";
  
      elems.each(function() {
        var $this = $(this),
          $animationType = $this.data("animation");
        $this.addClass($animationType).one(animEndEv, function() {
          $this.removeClass($animationType);
        });
      });
    }
  
    //Variables on page load
    var $myCarousel = $(".customCarousel"),
      $firstAnimatingElems = $myCarousel
        .find(".carousel-item:first")
        .find("[data-animation ^= 'animated']");
    //Initialize carousel
    $myCarousel.carousel();
    //Animate captions in first slide on page load
    doAnimations($firstAnimatingElems);
    //Other slides to be animated on carousel slide event
    $myCarousel.on("slide.bs.carousel", function(e) {
      var $animatingElems = $(e.relatedTarget).find(
        "[data-animation ^= 'animated']"
      );
      doAnimations($animatingElems);
    });
  })(jQuery);

// handle links with @href started with '#' only
jQuery(document).on('click', 'a[href^="#"]', function(e) {
  // target element id
  var id = jQuery(this).attr('href');
  
  // target element
  var $id = jQuery(id);
  if ($id.length === 0) {
      return;
  }
  
  // prevent standard hash navigation (avoid blinking in IE)
  e.preventDefault();
  
  // top position relative to the document
  var pos = $id.offset().top;
  
  // animated top scrolling
  jQuery('body, html').animate({scrollTop: pos});
});

