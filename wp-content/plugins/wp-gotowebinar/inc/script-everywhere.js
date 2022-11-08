jQuery(document).ready(function ($) {

    if ($('.gotowebinar-top-toolbar').length){    
        
        var countDownTime = $('.webinar-countdown-clock').attr('data');    
        var autoStart = $('.webinar-countdown-clock').attr('auto-start');
        var days = $('.webinar-countdown-clock').attr('days');
        
        console.log(days);

        var autoStart = (autoStart.toLowerCase() === 'true');
        
        if(days == 'true'){
            //do webinar countdown clock    
            var clock = $('.webinar-countdown-clock').FlipClock(countDownTime, {
                clockFace: 'DailyCounter',
                countdown: true,
                autoStart: autoStart
            }); 
        } else {
            //do webinar countdown clock    
            var clock = $('.webinar-countdown-clock').FlipClock(countDownTime, {
                countdown: true,
                autoStart: autoStart
            }); 
        }

        




        //close toolbar on close click
        if ($.cookie('hide-webinar-toolbar')!="true") { 

            $('.gotowebinar-top-toolbar').show();

            $("#close-gotowebinar-toolbar").click(function (event) {
                event.preventDefault();
                $('.gotowebinar-top-toolbar').slideUp();


                var expiryHours = $('.webinar-countdown-clock').attr('data-expiry');

                var date = new Date();
                date.setTime(date.getTime() + expiryHours * 60 * 60 * 1000); 
                $.cookie('hide-webinar-toolbar', "true", { expires: date });

            });
        }

    }

}); //end documentreadyfunction