jQuery(document).ready(function(){
  wow = new WOW({
    boxClass: 'wow', // default
    animateClass: 'animated', // default
    offset: 0, // default
    mobile: false, // default
    live: true // default
  })
  wow.init();
  jQuery('.search-icon .overlay').click(function(){
     jQuery('.search-icon').toggleClass('show');
  }); 

  jQuery('.navbar-toggler').click(function(){
    jQuery('html').toggleClass('overflow-h');
  });  
  
  jQuery(function() {
    jQuery('a[href*=\\#]:not([href=\\#]):not(.tab-within-tab-section a)').click(function() {
      if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
  && location.hostname == this.hostname) {
  
        var target = jQuery(this.hash);
        target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          jQuery('html,body').animate({
            scrollTop: target.offset().top - 185 //offsets for fixed header
          }, 300);
          return false;
        }
      }
    });
    //Executed on page load with URL containing an anchor tag.
    if(jQuery(location.href.split("#")[1])) {
        var target = jQuery('#'+location.href.split("#")[1]);
        if (target.length) {
          jQuery('html,body').animate({
            scrollTop: target.offset().top - 185 //offset height of header here too.
          },300 );
          return false;
        }
      }
  });

  jQuery(window).scroll(function() {
    var sticky = jQuery('header .navbar'),
      scroll = jQuery(window).scrollTop();
  
    if (scroll >= 48) sticky.addClass('fixed');
    else sticky.removeClass('fixed');
  });

});

function AddReadMore() {
  //This limit you can set after how much characters you want to show Read More.
  var carLmt = 20;
  // Text to show when text is collapsed
  var readMoreTxt = " Read More";
  // Text to show when text is expanded
  var readLessTxt = " Read Less";
  
  //Traverse all selectors with this class and manupulate HTML part to show Read More
  jQuery(".icon-box .description:not(.no-readmore .icon-box .description):not(.automation-experience .icon-box .description):not(.benifits .icon-box .description):not(.desktop-commands .icon-box .description):not(.Integrations-section .icon-box .description):not(.capabilitie-section .icon-box .description)").each(function() {
    
    //alert(words.length);
      if (jQuery(this).find(".firstSec").length)
          return;

      var allstr = jQuery(this).text().split(" ");
      var firstSet = '';
      var secdHalf = '';
        for (var i=0;i<allstr.length;i++)
        {
          if(i < carLmt){
            firstSet += allstr[i]+' ';
          } else {
            secdHalf += allstr[i]+' ';
          }
        }        
          
        if(secdHalf != ''){
            var strtoadd = firstSet + "<span class='dot'>...</span>" + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
         }
         else{
          var strtoadd = firstSet;
        
         }
          jQuery(this).html(strtoadd);
         
  });
  //Read More and Read Less Click Event binding
  jQuery(document).on("click", ".readMore, .readLess", function() {
      jQuery(this).closest(".icon-box .description").toggleClass("showlesscontent showmorecontent");
  });
}
jQuery(function() {
  //Calling function after Page Load
  AddReadMore();
}); 



jQuery(function() {

  //cache a reference to the tabs
  var tabs = jQuery('.sygnature-type-content .nav-tabs li .nav-link');

  //on click to tab, turn it on, and turn previously-on tab off
  tabs.click(function() { jQuery(this).addClass('active').parent('li').siblings('li').children('.active').removeClass('active'); });

  //auto-rotate every 5 seconds
  setInterval(function() {

          //get currently-on tab
      var onTab = tabs.filter('.active');

          //click either next tab, if exists, else first one
      var nextTab = onTab.index() < tabs.length-1 ? onTab.next() : tabs.first();
      nextTab.click();
  }, 5000);
});

// function solution(){
//   var windowWidth = jQuery(window).width();
//   var secWidth = jQuery('.solution .tab-content').width();
//   var marginSet = (secWidth - windowWidth) / 2;
//   jQuery('.solution .tab-content').css({marginLeft: marginSet, marginRight: marginSet});
// }

jQuery(document).ready(function(){
  jQuery(".accordion_section.faq-accordian:nth-child(2) .accordion-content-item:first-child").find('.accordion-collapse').addClass("show");
  jQuery(".accordion_section.faq-accordian:nth-child(2) .accordion-content-item:first-child").find('.accordion-button').removeClass("collapsed");

  //solution();

  setTimeout(() => { jQuery('#contact_us').addClass('shake-btn') }, 400); 
      jQuery('#contact_us').addClass('shake-btn')
     
      setTimeout(function() {
        jQuery('#contact_us').removeClass('shake-btn')
      }, 10000);

      jQuery('#primary-menu-list > .menu-item-has-children > a').click(function(){
        jQuery(this).parent('li').toggleClass('show-menu');
      });
      jQuery('.loader').fadeOut();

      jQuery('input[name=phrase]').change(function() { 
          if(jQuery('input[name=phrase]').val().length > 0){
            jQuery('.search-icon .overlay').hide();
          }
          else{
            jQuery('.search-icon .overlay').show();
          }
      });
      // jQuery('.testimonials h2 a').attr("href","#");
      // jQuery('.testimonials h2 a').attr("href","#");

      jQuery('.banner-content.digital-transformation-banner .inner-text ul li:first-child').addClass('active animate__animated animate__fadeIn');
  });
// jQuery(window).on('resize', function(){
//   solution();
// });
setInterval(function()
{
    // Remove .active class from the active li, select next li sibling.
    var next = jQuery('.banner-content.digital-transformation-banner .inner-text ul > li.active').removeClass('active animate__animated animate__fadeIn').next('li');

    // Did we reach the last element? Of so: select first sibling
    if (!next.length) next = next.prevObject.siblings('li:first-child');

    // Add .active class to the li next in line.
    next.addClass('active animate__animated animate__fadeIn');
    
}, 5000);


jQuery(window).scroll(function() {    
  var scroll = jQuery(window).scrollTop();

  if (scroll >= 300) {
      jQuery('#contact_us').addClass('shake-btn');     
      setTimeout(function() {
        jQuery('#contact_us').removeClass('shake-btn')
      }, 10000);
  } else if(scroll >= 600) {
      jQuery('#contact_us').addClass('shake-btn');     
      setTimeout(function() {
        jQuery('#contact_us').removeClass('shake-btn')
      }, 10000);
  }
  else if(scroll >= 900) {
    jQuery('#contact_us').addClass('shake-btn');     
    setTimeout(function() {
      jQuery('#contact_us').removeClass('shake-btn')
    }, 10000);
}
else if(scroll >= 1200) {
  jQuery('#contact_us').addClass('shake-btn');     
  setTimeout(function() {
    jQuery('#contact_us').removeClass('shake-btn')
  }, 10000);
}
});
// jQuery('.testimonial-slider > li:first-child').addClass('active');
// setInterval(function()
// {
//     // Remove .active class from the active li, select next li sibling.
//     var next = jQuery('.testimonial-slider > li.active').removeClass('active').next('li');
//     // Did we reach the last element? Of so: select first sibling
//     if (!next.length) next = next.prevObject.siblings('li:first-child');
//     // Add .active class to the li next in line.
//     next.addClass('active');    
// }, 40000);

// jQuery('.testimonial .nav-arrow .arrow-prev').click(function(){
//   // Remove .active class from the active li, select next li sibling.
//   var prev = jQuery('.testimonial-slider > li.active').removeClass('active').prev('li');
//   // Did we reach the last element? Of so: select first sibling
//   if (!prev.length) prev = prev.prevObject.siblings('li:last-child');
//   // Add .active class to the li next in line.
//   prev.addClass('active');  
// });
// jQuery('.testimonial .nav-arrow .arrow-next').click(function(){
//     // Remove .active class from the active li, select next li sibling.
//     var next = jQuery('.testimonial-slider > li.active').removeClass('active').next('li');
//     // Did we reach the last element? Of so: select first sibling
//     if (!next.length) next = next.prevObject.siblings('li:first-child');
//     // Add .active class to the li next in line.
//     next.addClass('active');  
// });

    jQuery('.ac-back').click(function(e) {
          e.preventDefault();
          jQuery('.product-feature-tab ul').animate({
            scrollLeft: "+=200px"
          }, "slow");
      });

     jQuery('.ac-fow').click(function(e) {
      e.preventDefault();
      jQuery('.product-feature-tab ul').animate({
        scrollLeft: "-=200px"
      }, "slow");
   });
   jQuery('.btn').append( '<span class="effect"></span>' );
   jQuery('.btn').on('mouseenter', function(e) {
     var parentOffset = jQuery(this).offset(),
         relX = e.pageX - parentOffset.left,
         relY = e.pageY - parentOffset.top;
         jQuery(this).find('span.effect').css({top:relY, left:relX})
   }).on('mouseout', function(e) {
     var parentOffset = jQuery(this).offset(),
         relX = e.pageX - parentOffset.left,
         relY = e.pageY - parentOffset.top;
         jQuery(this).find('span.effect').css({top:relY, left:relX})
   });

   jQuery('.circle-anim1').append('<span class="circle-animation"><span class="span1"></span><span class="span2"></span><span class="span3"></span><span class="span4"></span></span>');
   jQuery('.circle-anim2').append('<span class="circle-animation canim-2"><span class="span1"></span><span class="span2"></span><span class="span3"></span><span class="span4"></span></span>');

// if (typeof videos.loop == 'boolean') { // loop supported
//   videos.loop = true;
// } else { // loop property not supported
//   videos.addEventListener('ended', function () {
//     this.currentTime = 0;
//     this.play();
//   }, false);
// }
// //...
// videos.play();

jQuery('.counter').each(function() {
  var $this = jQuery(this),
      countTo = $this.attr('data-count');
  
      jQuery({ countNum: $this.text()}).animate({
    countNum: countTo
  },  
  {  
    duration: 4000,
    easing:'linear',
    step: function() {
      $this.text(Math.floor(this.countNum));
    },
    complete: function() {
      $this.text(this.countNum);
      //alert('finished');
    }
  });  
});
 
jQuery(document).ready(function(){

  // Select and loop the container element of the elements you want to equalise
  jQuery('.case-studies-slider').each(function(){  
    
    // Cache the highest
    var highestBox = 0;
    
    // Select and loop the elements you want to equalise
    jQuery('.insights-card', this).each(function(){
      
      // If this box is higher than the cached highest then store it
      if(jQuery(this).height() > highestBox) {
        highestBox = jQuery(this).height(); 
      }
    
    });  
          
    // Set the height of all those children to whichever was highest 
    jQuery('.insights-card',this).height(highestBox);
                  
  }); 

});

