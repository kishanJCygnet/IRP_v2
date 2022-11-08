<?php
global $time_zone_list;

//call upcoming webinars function and store responses as variables
$transientName = 'gtw_upc_'.current_time( 'd', $gmt = 0 );
list($jsondata,$json_response) = wp_gotowebinar_upcoming_webinars($transientName, 86400);


if($json_response == 200){   

    $i = 0;
    
    foreach ($jsondata as $data) {
        
        //check for conditions
        if(wp_gotowebinar_timezone_check($webinar_timezone,$data['timeZone']) && wp_gotowebinar_include_exclude_check($include_webinars,$data['subject'],'include') && wp_gotowebinar_include_exclude_check($exclude_webinars,$data['subject'],'exclude')){ 
            
            foreach($data['times'] as $mytimes) {
                
            //checks if the webinar date is actually in the future - this is important for series and sequence webinars which have multiple dates and a previous webinar might have passed but the webinar is still showing in the feed.    
            if(strtotime($mytimes['startTime']) > time()) {
            
                
            $html = '<div class="upcoming-webinars-widget">'; 
            $html .= '<strong>'.wp_gotowebinar_hide_from_title($hide_title_webinars,$data['subject']).'</strong></br>';
            

                
                //date    
                $date = new DateTime($mytimes['startTime']); 
                $date->setTimeZone(new DateTimeZone($data['timeZone']));    
                $html .= '<span';
                
                if(!isset($options['gotowebinar_disable_tooltip'])){
             $html .= ' class="masterTooltip" title="'.date_i18n( 'l', strtotime($mytimes['startTime']) ).'"';} 
                
                $html .= '><i class="far fa-calendar-alt" aria-hidden="true"></i>'.$date->format(wp_gotowebinar_date_format()).'</span>';
                //time    
                $startingtime = new DateTime($mytimes['startTime']);
                $startingtime->setTimeZone(new DateTimeZone($data['timeZone']));    
                $html .= '<span ';
                if(!isset($options['gotowebinar_disable_tooltip'])){
                 $html .= 'class="masterTooltip" title="'.$startingtime->format('T').', GMT '.$time_zone_list[$data['timeZone']] .'"';         
                }
                
                //remove timezone from time
                $strippedTime = str_replace('T','',wp_gotowebinar_time_format());  
                $html .= '><i class="far fa-clock" aria-hidden="true"></i>'.$startingtime->format($strippedTime).'</span>';
               //registration page   
                if($options['gotowebinar_custom_registration_page'] == "default"){
                 $destinationUrl = '_blank" href="'.$data['registrationUrl'];
                } else {
                  $destinationUrl = '_self" href="'.get_permalink($options['gotowebinar_custom_registration_page'])."?webinarKey=".$data['webinarKey']."&hide=".$hide_title_webinars;  
                }   
                $html .= '<span id="webinar-registration-button"><a target="'.$destinationUrl.'">'.__( 'Register', 'wp-gotowebinar' ).' <i class="fas fa-arrow-right" aria-hidden="true"></i></a></span>';   
                $html .= '</div>';   
                echo $html;
                
                if(++$i == $max_webinars) break 2;
                    
                } //end time check
                
                
                } //end foreach($data['times'] as $mytimes)
            
        } //end main filter
                 
    } //end foreach ($jsondata as $data)
      
} //stop if status is 200 and display the below error message if an error is being sent from GoToWebinar
else {
     echo "Something's not working. It looks like the API call to GoToWebinar isn't succeeding. This may be because you are on a trial account. Unfortunately API calls can't be made to GoToWebinar accounts on a trial. If you do have a full GoToWebinar licence please try re-authenticating the plugin again by pressing the 'Click here to get Auth and Key' button in the plugin settings. You should also clear the cache or turn the cache off in the plugin settings and this should resolve the issue.";       
}
    
    
    
?>