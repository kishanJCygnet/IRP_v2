<?php
// shortcode
function go_to_webinar( $atts ) {

    $options = get_option('gotowebinar_settings');

    //start output
    $html = '';
    
    //enqueue styles and scripts
    wp_enqueue_style( array('font-awesome-icons','custom-style') );  
    wp_enqueue_script(array('jquery-ui','moment-gotowebinar','moment-timezone','timezone-detection','custom-script'));

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

            //start printing table   
            //if timezone conversion is enabled show the conversion link
             

            if(array_key_exists('gotowebinar_enable_timezone_conversion',$options) && $options['gotowebinar_enable_timezone_conversion'] == 1){
                $html .= '<p><a class="timezone-convert-link">'.__( 'Convert to my timezone', 'wp-gotowebinar' ).'</a></p>';  
                $html .= '<span id="timezone_error_message" style="display:none;">';
                if(isset($options['gotowebinar_timezone_error_message']) && strlen($options['gotowebinar_timezone_error_message'])>0){
                    $html .= $options['gotowebinar_timezone_error_message'];     
                } else {   
                    $html .= 'Sorry, your location could not be determined.';
                }
                $html .= '</span>';
            }
            $html .= '<table class="upcoming-webinars">';
            $html .= '<colgroup>
                        <col class="large-column">
                        <col class="small-column">
                        <col class="small-column">
                        <col class="small-column">
                        <col class="small-column">
                    </colgroup>';
            $html .= '<tr class="table-head">';
            $html .= '<th class="upcoming-webinars-title">'.__( 'Title', 'wp-gotowebinar' ).'</th>';
            $html .= '<th class="upcoming-webinars-date">'.__( 'Date', 'wp-gotowebinar' ).'</th>';
            $html .= '<th class="upcoming-webinars-time">'.__( 'Start Time', 'wp-gotowebinar' ).'</th>';
            $html .= '<th class="upcoming-webinars-duration">'.__( 'Duration', 'wp-gotowebinar' ).'</th>';
            $html .= '<th class="upcoming-webinars-register">'.__( 'Register', 'wp-gotowebinar' ).'</th>';
            $html .= '</tr>';   
            
                
            // var_dump($jsondata);
            $jsondata = apply_filters('wp_gotowebinar_shortcode_jsondata', $jsondata);

            
            //start loops
            foreach ($jsondata as $data) {
                foreach($data['times'] as $mytimes) {
                    

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
            


                    //runs main filter            
                    if(wp_gotowebinar_timezone_check($a['timezone'],$data['timeZone']) && wp_gotowebinar_include_exclude_check($a['include'],$data['subject'],'include') && wp_gotowebinar_include_exclude_check($a['exclude'],$data['subject'],'exclude') && $diff->format('%R%a') <0){ 
                        
                
                        $html .= '<tr>';
                        //subject    
                        $html .= '<td class="upcoming-webinars-title"><span class="webinar-title">'.wp_gotowebinar_hide_from_title($a['hide'],$data['subject'])."</span>"; 
                        
                        

                        if(strlen($data['description']) > 0) {    
                        $html .= '<a class="information-icon">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        </a>';
                        }
                        $html .= '<em style="display:block; margin-top:15px;">'.nl2br($data['description']).'</em></td>';       
                            //date    
                            $html .= '<td class="upcoming-webinars-date">';
                            $html .= '<span';
                            $date = new DateTime($mytimes['startTime']); 
                            $date->setTimeZone(new DateTimeZone($data['timeZone']));

                            if(!isset($options['gotowebinar_disable_tooltip'])){
                            $html .= ' class="masterTooltip webinar-date" title="'.$date->format('l').'"';
                            } else { 
                            $html .= ' class="webinar-date"';
                            }

                            $html .= '>'.$date->format(wp_gotowebinar_date_format()).'</span><span style="display:none;" class="webinar-date-format">'.wp_gotowebinar_date_format().'</span>';
                            $html .= '</td>'; 


                            //time    
                            $html .= '<td class="upcoming-webinars-time">';
                            $startingtime = new DateTime($mytimes['startTime']);
                            $startingtime->setTimeZone(new DateTimeZone($data['timeZone'])); 
                            $html .= '<span';
                            if(!isset($options['gotowebinar_disable_tooltip'])){
                            $html .= ' class="masterTooltip webinar-time" title="GMT '.$time_zone_list[$data['timeZone']] .'"';  
                            } else {
                                $html .= ' class="webinar-time"'; 
                            }

                            $html .= '>'.$startingtime->format(wp_gotowebinar_time_format()).'</span><span class="webinars-moment" style="display:none;">'.$mytimes['startTime'].'</span><span class="webinar-time-format" style="display:none;">'.wp_gotowebinar_time_format().'</span>';
                            $html .= '</td>'; 


                            //duration    
                            $html .= '<td class="upcoming-webinars-duration"><span class="webinar-duration">';
                            $time_diff = strtotime($mytimes['endTime']) - strtotime($mytimes['startTime']);

                            if($time_diff/60/60 < 1) {
                                $html .= round($time_diff/60,0) . ' '.__( 'minutes', 'wp-gotowebinar' ).'<br>';  
                            } else if ($time_diff/60/60 == 1) {
                                $html .= $time_diff/60/60 . ' '.__( 'hour', 'wp-gotowebinar' ).'<br>';
                            } else {
                                $html .= round($time_diff/60/60, 1) . ' '.__( 'hours', 'wp-gotowebinar' ).'<br>';
                            }    
                            
                            $html .= '</span></td>';

                    //register
                            if($options['gotowebinar_custom_registration_page'] == "default"){
                        $destinationUrl = '_blank" href="'.$data['registrationUrl'];
                        } else {
                        $destinationUrl = '_self" href="'.get_permalink($options['gotowebinar_custom_registration_page'])."?webinarKey=".$data['webinarKey']."&hide=".$a['hide'];  
                        }   
                        $html .= '<td class="upcoming-webinars-register"><a target="'.$destinationUrl.'">'.__( 'Register', 'wp-gotowebinar' ).' <i class="fas fa-arrow-right" aria-hidden="true"></i></a></td>'; 
                        $html .= '</tr>';   
                        
                    } //ends main filter
                }
            } //end loops
                

            $html .= '</table>';
        
            
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
add_shortcode('gotowebinar', 'go_to_webinar');
?>