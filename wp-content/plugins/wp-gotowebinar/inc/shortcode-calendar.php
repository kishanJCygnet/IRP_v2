<?php
// shortcode
function go_to_webinar_calendar( $atts ) {

    $options = get_option('gotowebinar_settings');

    //start output
    $html = '';

    //enqueue styles and scripts
    wp_enqueue_style( array('font-awesome-icons','full-calendar-style','custom-style') );  
    wp_enqueue_script(array('jquery-ui','moment-gotowebinar','moment-timezone','full-calendar','full-calendar-locale','custom-script'));


    if($options['gotowebinar_button_background_color'] == "#ffffff"){
        $spinnerColor = $options['gotowebinar_button_text_color'];
    } else {
        $spinnerColor = $options['gotowebinar_button_background_color'];   
    }

    $colour_options = "
    .tooltip-gtw {
	background-color: {$options['gotowebinar_tooltip_background_color']};
	color: {$options['gotowebinar_tooltip_text_color']};
    border-color: {$options['gotowebinar_tooltip_border_color']};
    }
    .webinar-registration input[type=\"submit\"] {
    background-color: {$options['gotowebinar_button_background_color']};
	color: {$options['gotowebinar_button_text_color']};
    border-color: {$options['gotowebinar_button_border_color']};
    }
    .webinar-registration .fa-spinner {
    color: {$spinnerColor};
    }
    .upcoming-webinars fa, .upcoming-webinars a, .upcoming-webinars-widget fa, .upcoming-webinars-widget a, .webinar-registration a {
    color: {$options['gotowebinar_icon_color']};
    } 
    ";
    wp_add_inline_style( 'custom-style', $colour_options );




    $a = shortcode_atts( array(
            'timezone' => '',
            'include' => '',
            'exclude' => '',
            'hide' => '',
            'days' => '1825',
        ), $atts );
    global $time_zone_list;
    
    //call upcoming webinars function and store responses as variables    
    $transientName = 'gtw_upc_'.current_time( 'd', $gmt = 0 );
    list($jsondata,$json_response) = wp_gotowebinar_upcoming_webinars($transientName, 86400);    

    if($json_response == 200){   
        
        //only continue if webinars exist
        if(is_array($jsondata) && count($jsondata)>0){

            $calendarData = array();
            
            
            foreach ($jsondata as $data) {
                foreach($data['times'] as $mytimes) {
                    
                    $temporaryArray = array();
                    

                    //gets the variable days which is either default 9999 or user set and add it onto today's date       
                    $dateOne = date('Y-m-d', strtotime('+'.$a['days'].' days'));   
                    //gets the date of the webinar        
                    $dateTwo = $mytimes['startTime']; 
                    //convert the date of the webinar to the same format as the variable         
                    $dateTwoMod = date('Y-m-d', strtotime($dateTwo));   
                    //create new datetimes for the 2 date variables        
                    $ref = new DateTime($dateOne);
                    $date = new DateTime($dateTwoMod);
                    //get the difference between the 2 dates        
                    $diff = $ref->diff($date);  
                    
        
                    if( wp_gotowebinar_timezone_check($a['timezone'],$data['timeZone']) && wp_gotowebinar_include_exclude_check($a['include'],$data['subject'],'include') && wp_gotowebinar_include_exclude_check($a['exclude'],$data['subject'],'exclude') && $diff->format('%R%a') <0 ){
                        //webinar title
                        $webinarTitle = wp_gotowebinar_hide_from_title($a['hide'],$data['subject']);
                        //add title to temporary array
                        $temporaryArray['title'] = $webinarTitle;
                        //webinar registration link                       
                        if($options['gotowebinar_custom_registration_page'] == "default"){       
                            $webinarLink = $data['registrationUrl'];
                        } else {
                            $webinarLink = get_permalink($options['gotowebinar_custom_registration_page'])."?webinarKey=".$data['webinarKey']."&hide=".$a['hide'];
                        }
                        //add link to temporary array
                        $temporaryArray['url'] = $webinarLink;
                        //webinar id
                        $webinarId = $data['webinarKey'];
                        $temporaryArray['id'] = $webinarId;
                        //webinar start
                        $webinarStart = $mytimes['startTime'];
                        $temporaryArray['start'] = $webinarStart;
                        //webinar end
                        $webinarEnd = $mytimes['endTime'];
                        $temporaryArray['end'] = $webinarEnd;

                    } //end if condition
                    
                    if(count($temporaryArray)>0){
                        array_push($calendarData,$temporaryArray);
                    }
        

                } //end time loop
            } //end primary loop
            
            /* 
            highlight_string("<?php\n\$data =\n" . var_export($calendarData, true) . ";\n?>");
            */
            
            //output the right time for the calendar
            if( $options['gotowebinar_time_format'] == 'wordpress' ){
                $time_format = get_option('time_format');
            } else {
                $time_format =  $options['gotowebinar_time_format']; 
            }

            $first_letter_of_time_format = substr($time_format,0,1);

            // var_dump($first_letter_of_time_format);

            if($first_letter_of_time_format == 'g'){
                $calendar_time_format = 'h(:mm)a';
            } else {
                $calendar_time_format = 'H(:mm)a';    
            }

            //add a filter
            $calendar_time_format = apply_filters('wp_gotowebinar_calendar_time_format', $calendar_time_format);

            
            $html .= '<div id="calendar-data" data-calendar-time-format="'.$calendar_time_format.'"  data="'.base64_encode(json_encode($calendarData)).'"></div>';
            
            
            $html .= '<div id="calendar"></div>';
            
        } else {
            //the response was successful but there were no webinars
            $html .= apply_filters( 'wp_gotowebinar_no_webinars', '' );
        }
            
    } else {
        //stop if status is 200 and display the below error message if an error is being sent from GoToWebinar
        if(current_user_can('administrator')) { 
            $html .= "Something's not working. It looks like the API call to GoToWebinar isn't succeeding. This may be because you are on a trial account. Unfortunately API calls can't be made to GoToWebinar accounts on a trial. If you do have a full GoToWebinar licence please try re-authenticating the plugin again by pressing the 'Click here to get Auth and Key' button in the plugin settings. You should also clear the cache or turn the cache off in the plugin settings and this should resolve the issue.";
        }
        
    }
    
    return $html; 
    
}
add_shortcode('gotowebinar-calendar', 'go_to_webinar_calendar');
?>