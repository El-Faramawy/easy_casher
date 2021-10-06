//navbar ainmation
$(window).scroll(function () {
  var appScroll = $(document).scrollTop();

  if ((appScroll > 20) && (appScroll < 99999999999)) {
    $(".main-header .logo-box").addClass("navAnimate");

  };
  if ((appScroll > 0) && (appScroll < 20)) {
    $(".main-header .logo-box ").removeClass("navAnimate");
  };
});

// $(".main-sidebar").hover(function () {
//     $("body ").toggleClass("sidebar-collapse");
// });


function goBack() {
  window.history.back();
}



var swiper = new Swiper(".mySwiper", {
  spaceBetween: 30,

  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  speed: 1000,


  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});



// // loader 

// var loader;

// function loadNow(opacity) {
// 	if (opacity <= 0) {
// 		displayContent();
// 	} else {
// 		loader.style.opacity = opacity;
// 		window.setTimeout(function() {
// 			loadNow(opacity - 0.05);
// 		}, 50);
// 	}
// }

// function displayContent() {
// 	loader.style.display = 'none';
// }

// document.addEventListener("DOMContentLoaded", function() {
// 	loader = document.getElementById('loader');
// 	loadNow(1);
// });



$(document).ready(function () {

  $('#viewType1').change(function() {
    if ($(this).prop('checked') == true) {
      $(".selectColor").slideDown('slow');
      $(".selectImg").slideUp('fast');
    }
  });
  
  $('#viewType2').change(function() {
    if ($(this).prop('checked') == true) {
      $(".selectImg").slideDown('slow');
      $(".selectColor").slideUp('fast');
    }
  });


  $('#stockType1').change(function() {
    if ($(this).prop('checked') == true) {
      $(".inStock").slideDown('slow');
    }
  });
  
  $('#stockType2').change(function() {
    if ($(this).prop('checked') == true) {
      $(".inStock").slideUp('fast');
    }
  });


  $('.searchInput').click(function() {

    $(".searchResult").slideDown('slow');
    
  });

  $('.addClintBtn').click(function() {

    $(".addClintSection").addClass('addClintSectionOpen');
    
  });




  
  



});





  // Input Plus & Minus Number JS
  $('.input-counter').each(function () {
    var spinner = jQuery(this),
      input = spinner.find('input[type="number"]'),
      btnUp = spinner.find('.plus-btn'),
      btnDown = spinner.find('.minus-btn'),
      min = input.attr('min'),
      max = input.attr('max');
    btnUp.on('click', function () {
      var oldValue = parseFloat(input.val());
      if (oldValue >= max) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue + 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });
    btnDown.on('click', function () {
      var oldValue = parseFloat(input.val());
      if (oldValue <= min) {
        var newVal = oldValue;
      } else {
        var newVal = oldValue - 1;
      }
      spinner.find("input").val(newVal);
      spinner.find("input").trigger("change");
    });
  });


  


  //dropify
  $('.dropify').dropify();
