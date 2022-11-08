jQuery(document).ready(function ($) {

    // when clicking the copy from billing button copy data from billing details over to webinar fields    
    $("#copy-from-billing").click(function (event) {

        event.preventDefault();    

        // these field replacements are just occuring on the first item of each new webinar   
        $('.1-firstName input').each(function() {
        $(this).val($('#billing_first_name').val());    
        }); 

        $('.1-lastName input').each(function() {
        $(this).val($('#billing_last_name').val());    
        }); 
            
        $('.1-phone input').each(function() {
        $(this).val($('#billing_phone').val());    
        });

        $('.1-email input').each(function() {
        $(this).val($('#billing_email').val());    
        });       
            
        // these field replacements are occuring on all webinar fields
        $('.organization input').each(function() {
        $(this).val($('#billing_company').val());    
        });   


        var billingCountry = $('#billing_country option:selected').text();
        $(".country select option").filter(function() {
            return $(this).text() == billingCountry; 
        }).prop('selected', true);     

            
        var billingState = $('#billing_state option:selected').text();
        $(".state select option").filter(function() {
            return $(this).text() == billingState; 
        }).prop('selected', true);      
                
            
        $('.address input').each(function() {
        $(this).val($('#billing_address_1').val()+' '+$('#billing_address_2').val());    
        });      
            
        $('.city input').each(function() {
        $(this).val($('#billing_city').val());    
        });        
            

        $('.zipCode input').each(function() {
        $(this).val($('#billing_postcode').val());    
        });      
                 
    }); //end copy from billing button click
}); //end documentreadyfunction