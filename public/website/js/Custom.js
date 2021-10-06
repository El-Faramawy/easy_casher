$(document).ready(function () {

    //SmoothScroll js
    var scroll = new SmoothScroll('a[href*="#"]');

    //WOW js
    new WOW().init();

    //materialSelect
    $('.mdb-select').materialSelect();

    //pickatime
    $('#input_starttime').pickatime({
        twelvehour: true,
    });

    //pickadate
    $('.datepicker').pickadate();


    $(function () {
        'use strict';

        $('#rightSlide.button-collapse').sideNav({
            edge: 'right'
        });
    });

    //navbar ainmation
    $(window).scroll(function () {
        var appScroll = $(document).scrollTop();

        if ((appScroll > 60) && (appScroll < 99999999999)) {
            $(".navbar").addClass("navAnimate");

        };
        if ((appScroll > 0) && (appScroll < 60)) {
            $(".navbar").removeClass("navAnimate");
        };
    });




});
$(document).ready(function () {

    $('.carousel').carousel({
        interval: 5000,
        pause: false,
    })

});






$(document).ready(function () {
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn'),
        allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-indigo').addClass('btn-default');
            $item.addClass('btn-indigo');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepSteps = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

            prevStepSteps.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i< curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-indigo').trigger('click');
});
//////app-img-carousel
$('.app-img-carousel').owlCarousel({
    loop: true,
    rtl: true,
    smartSpeed: 750,
    responsiveClass: true,
    autoplay: true,
    margin: 0,
    autoplayTimeout: 3000,
    dots: false,
    animateOut: 'fadeOut',
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 1,
      },
      767: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  //////user-carousel
  $('.user-carousel').owlCarousel({
    loop: true,
    rtl: true,
    smartSpeed: 750,
    responsiveClass: true,
    autoplay: true,
    margin: 0,
    dots: true,
    nav: true,
    responsive: {
      0: {
        items: 1,

      },
      576: {
        items: 1,

      },
      767: {
        items: 1,

      },
      1000: {
        items: 1,
      }
    }
  });

  var swiper = new Swiper('.swiper-container', {
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 200,
      modifier: 1,
      slideShadows : true,
    },
    spaceBetween:-40,
    loop:true,
    speed:800 ,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    autoplay: {
      delay: 2000,
      disableOnInteraction: false,
    },
  });

  
  