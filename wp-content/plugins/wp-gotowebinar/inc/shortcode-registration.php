<?php
// shortcode
function go_to_webinar_registration( $atts ) {

    $options = get_option('gotowebinar_settings');

    //enqueue styles and scripts
    wp_enqueue_script(array('jquery-ui','jquery-effects-shake','moment-gotowebinar','moment-timezone','timezone-detection','custom-script'));
    wp_enqueue_style( array('font-awesome-icons','custom-style') );  

    if(strlen($options['gotowebinar_recaptcha_site_key']) > 0){ 
        wp_enqueue_script(array('google-recaptcha-gotowebinar'));
    }


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





    global $time_zone_list;
    global $gotowebinar_is_pro;
      
    
    
    if(isset($options['gotowebinar_mailchimp_default_list'])){
        $mailChimpDefaultList = $options['gotowebinar_mailchimp_default_list'];
    } else {
        $mailChimpDefaultList = "";    
    }
    
    if(isset($options['gotowebinar_constantcontact_default_list'])){
        $constantContactDefaultList = $options['gotowebinar_constantcontact_default_list'];
    } else {
        $constantContactDefaultList = "";    
    }
    
    if(isset($options['gotowebinar_activecampaign_default_list'])){
        $activeCampaignDefaultList = $options['gotowebinar_activecampaign_default_list'];
    } else {
        $activeCampaignDefaultList = "";    
    }
    
    if(isset($options['gotowebinar_campaignmonitor_default_list'])){
        $campaignMonitorDefaultList = $options['gotowebinar_campaignmonitor_default_list'];
    } else {
        $campaignMonitorDefaultList = "";    
    }
    
    if(isset($options['gotowebinar_aweber_default_list'])){
        $aweberDefaultList = $options['gotowebinar_aweber_default_list'];
    } else {
        $aweberDefaultList = "";    
    }
    
    //if there's a webinar key in the query string set the key and hide to the query string
    if(isset($_GET['webinarKey'])) {
    $a = shortcode_atts( array(
            'key' => $_GET['webinarKey'],
            'hide' => $_GET['hide'],
            'mailchimp' => $mailChimpDefaultList,
            'constantcontact' => $constantContactDefaultList,
            'activecampaign' => $activeCampaignDefaultList,
            'campaignmonitor' => $campaignMonitorDefaultList,
            'aweber' => $aweberDefaultList,
            'thankyou' => '',
        ), $atts );
        
    //else get the values from the shortcode 
    } else {  
       $a = shortcode_atts( array(
            'key' => '',
            'hide' => '',
            'timezone' => '',
            'include' => '',
            'exclude' => '',
            'mailchimp' => $mailChimpDefaultList,
            'constantcontact' => $constantContactDefaultList,
            'activecampaign' => $activeCampaignDefaultList,
            'campaignmonitor' => $campaignMonitorDefaultList,
            'aweber' => $aweberDefaultList,
            'thankyou' => '',
        ), $atts ); 

        //if the webinar key is upcoming get the webinar key of the most upcoming webinar    
        if($a['key'] == "upcoming") { 
            
            //call upcoming webinars function and store responses as variables    
            $transientName = 'gtw_upc_'.current_time( 'd', $gmt = 0 );
            list($jsondata,$json_response) = wp_gotowebinar_upcoming_webinars($transientName, 86400);    

            foreach ($jsondata as $data) {
                foreach($data['times'] as $mytimes) {

                    if(wp_gotowebinar_timezone_check($a['timezone'],$data['timeZone']) && wp_gotowebinar_include_exclude_check($a['include'],$data['subject'],'include') && wp_gotowebinar_include_exclude_check($a['exclude'],$data['subject'],'exclude') ){
                        
                        //get start time of webinar
                        $startTime = $mytimes['startTime'];
                        //convert to timestamp
                        $startTime = strtotime($startTime); 
                        //get current time
                        $currentTime = current_time( 'timestamp' );

                        if($startTime > $currentTime){
                            $a['key'] = $data['webinarKey'];
                            break 2;
                        }                    
                    }
                }
            }    
        } //end upcoming webinar check  
        
    } //end else
    
    //establishing of transients and ajax request start here
    //here we are getting information for the webinar to display the header information
    //if the transient exists get this data, otherwise fetch the data
    $transientName = 'gtw_upc_'.current_time( 'd', $gmt = 0 ).'_'.$a['key']; 
    $getTransient = get_transient($transientName);
    if ($getTransient != false){
        $jsondata = $getTransient;
        $json_response = 200;
    } else {
        
        list($access_token,$organizer_key) = wp_gotowebinar_get_access_and_refresh_token();
        
        $json_feed = wp_remote_get( wpgotowebinar_api_base().'/organizers/'.$organizer_key.'/webinars/'.$a['key'], array(
        'headers' => array(
        'Authorization' => $access_token,
	    ),));
   
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $json_feed )), true);
        $json_response = wp_remote_retrieve_response_code($json_feed);    
        
        //if the response is successful store the transient data
        if($json_response == 200){     
            set_transient($transientName,$jsondata, 86400);  
        }       
    }
        
        
    //check if there's a webinar key to display registration form otherwise show a message    
    if(strlen($a['key'])>0){ 
        //if the response is successful display registration form     
        if($json_response == 200){     


            //start of display of webinar details
            $html = '<div class="webinar-registration-header">'; 
            //title
            $html .= '<h3 style="margin-bottom: 10px;">'.wp_gotowebinar_hide_from_title($a['hide'],$jsondata['subject']).'</h3>'; 




            foreach($jsondata['times'] as $mytimes) {   
                $html .= '<div id="date-time-duration-details">';   


                //date  
                $date = new DateTime($mytimes['startTime']);  
                $date->setTimeZone(new DateTimeZone($jsondata['timeZone']));     
                $html .= '<span';
                if(!isset($options['gotowebinar_disable_tooltip'])){
                $html .= ' class="masterTooltip" title="'.   date_i18n( 'l', strtotime($mytimes['startTime']) )    .'"';    
                }  

                $html .= '><i class="far fa-calendar-alt" aria-hidden="true"></i><span class="webinar-date">'.$date->format(wp_gotowebinar_date_format()).'</span><span style="display:none;" class="webinar-date-format">'.wp_gotowebinar_date_format().'</span></span>';
                $formdate = $date->format(wp_gotowebinar_date_format());


                //time
                $startingtime = new DateTime($mytimes['startTime']);
                $startingtime->setTimeZone(new DateTimeZone($jsondata['timeZone']));    
                $html .= '<span ';
                if(!isset($options['gotowebinar_disable_tooltip'])){
                 $html .= 'class="masterTooltip" title="GMT '.$time_zone_list[$jsondata['timeZone']] .'"';         
                } 

                $html .= '><i class="far fa-clock" aria-hidden="true"></i><span class="webinar-time">'.$startingtime->format(wp_gotowebinar_time_format()).'</span><span id="webinars-moment" style="display:none;">'.$mytimes['startTime'].'</span><span style="display:none;" id="webinar-time-format">'.wp_gotowebinar_time_format().'</span></span>';
                $formtime = $startingtime->format(wp_gotowebinar_time_format());  


                //duration
                $html .= '<span><i class="fas fa-hourglass-half" aria-hidden="true"></i>';
                $time_diff = strtotime($mytimes['endTime']) - strtotime($mytimes['startTime']);
                if($time_diff/60/60 < 1) {
                $html .= $time_diff/60 . ' '.__( 'minutes', 'wp-gotowebinar' ).'<br>';  
                } else if ($time_diff/60/60 == 1) {
                     $html .= $time_diff/60/60 . ' '.__( 'hour', 'wp-gotowebinar' ).'<br>';
                }
                else {
                $html .= $time_diff/60/60 . ' '.__( 'hours', 'wp-gotowebinar' ).'<br>';
                }   
                $html .= '</span>';    
                $html .= '</div>';     
            }
            //if timezone conversion is enabled show the conversion link
            if(array_key_exists('gotowebinar_enable_timezone_conversion',$options)){
                if($options['gotowebinar_enable_timezone_conversion'] == 1){
                    $html .= '<p><a class="timezone-convert-link-registration">'.__( 'Convert to my timezone', 'wp-gotowebinar' ).'</a></p>';
                    $html .= '<span id="timezone_error_message" style="display:none;">';
                    
                    if(isset($options['gotowebinar_timezone_error_message']) && strlen($options['gotowebinar_timezone_error_message'])>0){
                        $html .= $options['gotowebinar_timezone_error_message'];     
                    } else {   
                        $html .= 'Sorry, your location could not be determined.';
                    }
                    $html .= '</span>';     
                }
            }
            //description

            if(array_key_exists('description',$jsondata)){
                $html .= '<em>'.nl2br($jsondata['description']).'</em><br>';
            }
            

            $html .= '</div>'; 






            if(strtotime($mytimes['startTime']) > time()){  




                //establishing of transients and ajax request for form fields
                $transientNameForm = 'gtw_for_'.current_time( 'd', $gmt = 0 ).'_'.$a['key']; 
                $getTransientForm = get_transient($transientNameForm);
                if ($getTransientForm != false){
                    $jsondataform = $getTransientForm; 
                } else {


                    list($access_token,$organizer_key) = wp_gotowebinar_get_access_and_refresh_token();

                    $json_feed_form = wp_remote_get( wpgotowebinar_api_base().'/organizers/'.$organizer_key.'/webinars/'.$a['key'].'/registrants/fields', array(
                    'headers' => array(
                    'Authorization' => $access_token,
                ),));

                $jsondataform = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $json_feed_form )), true);


                set_transient($transientNameForm,$jsondataform, 86400);  
                }




                //start form table
                $html .= '<form id="webinar-registration-form" class="webinar-registration-form">';
                $html .= '<table class="webinar-registration">';
                $html .= '<colgroup>
                    <col class="small-column">
                    <col class="large-column">
                </colgroup>';


                //set a variable which checks the required field text
                if(strlen($options['gotowebinar_translate_required'])>0){
                     $errorMessage = $options['gotowebinar_translate_required'];
                } else {
                     $errorMessage = 'Please fill in this field.';
                }    



                //start fields inputs
                foreach($jsondataform['fields'] as $field){
                    $html .= '<tr><td><label';
                    if($field['required'] == true) {
                        $html .= ' class="gotowebinar-required"';     
                    }  


                    $html .= ' for="'.$field['field'].'">';


                    if($field['field'] == "firstName" && strlen($options['gotowebinar_translate_firstName'])>0) {
                        $html .= $options['gotowebinar_translate_firstName'];
                    } elseif ($field['field'] == "lastName" && strlen($options['gotowebinar_translate_lastName'])>0) { 
                       $html .= $options['gotowebinar_translate_lastName']; 
                    } elseif ($field['field'] == "email" && strlen($options['gotowebinar_translate_email'])>0) { 
                       $html .= $options['gotowebinar_translate_email']; 
                    } elseif ($field['field'] == "address" && strlen($options['gotowebinar_translate_address'])>0) { 
                       $html .= $options['gotowebinar_translate_address']; 
                    } elseif ($field['field'] == "city" && strlen($options['gotowebinar_translate_city'])>0) { 
                       $html .= $options['gotowebinar_translate_city']; 
                    } elseif ($field['field'] == "state" && strlen($options['gotowebinar_translate_state'])>0) { 
                       $html .= $options['gotowebinar_translate_state']; 
                    } elseif ($field['field'] == "zipCode" && strlen($options['gotowebinar_translate_zipCode'])>0) { 
                       $html .= $options['gotowebinar_translate_zipCode']; 
                    } elseif ($field['field'] == "country" && strlen($options['gotowebinar_translate_country'])>0) { 
                       $html .= $options['gotowebinar_translate_country']; 
                    } elseif ($field['field'] == "phone" && strlen($options['gotowebinar_translate_phone'])>0) { 
                       $html .= $options['gotowebinar_translate_phone']; 
                    } elseif ($field['field'] == "organization" && strlen($options['gotowebinar_translate_organization'])>0) { 
                       $html .= $options['gotowebinar_translate_organization']; 
                    } elseif ($field['field'] == "jobTitle" && strlen($options['gotowebinar_translate_jobTitle'])>0) { 
                       $html .= $options['gotowebinar_translate_jobTitle']; 
                    } elseif ($field['field'] == "questionsAndComments" && strlen($options['gotowebinar_translate_questionsAndComments'])>0) { 
                       $html .= $options['gotowebinar_translate_questionsAndComments']; 
                    } elseif ($field['field'] == "industry" && strlen($options['gotowebinar_translate_industry'])>0) { 
                       $html .= $options['gotowebinar_translate_industry']; 
                    } elseif ($field['field'] == "numberOfEmployees" && strlen($options['gotowebinar_translate_numberOfEmployees'])>0) { 
                       $html .= $options['gotowebinar_translate_numberOfEmployees']; 
                    } elseif ($field['field'] == "purchasingTimeFrame" && strlen($options['gotowebinar_translate_purchasingTimeFrame'])>0) { 
                       $html .= $options['gotowebinar_translate_purchasingTimeFrame']; 
                    } elseif ($field['field'] == "purchasingRole" && strlen($options['gotowebinar_translate_purchasingRole'])>0) { 
                       $html .= $options['gotowebinar_translate_purchasingRole'];
                    }
                    else {
                        $html .= ucwords(preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]|[0-9]{1,}/', ' $0', $field['field']));   
                    }


                    $html .= '</label></td>';

                    $html .= '<td>';
                    if(isset($field['answers'])) {
                    $html .= '<select class="gotowebinar-field" name="'.$field['field'].'" id="'.$field['field'].'" ';
                     if ($field['maxSize']){
                         $html .= 'maxlength="'.$field['maxSize'].'" ';   
                        }
                        if ($field['required'] == true){
                         $html .= 'oninput="setCustomValidity(\'\')" required';  
                        }    
                    $html .= '>';
                    $html .= '<option value="">'.__('--Select--','wp-gotowebinar').'</option>';    
                    foreach($field['answers'] as $answer){    
                    $html .= '<option value="'.$answer.'">'.$answer.'</option>';
                    } //end select options foreach
                    $html .= '</select>';    
                    } else { //end select inputs
                    $html .= '<input class="gotowebinar-field" id="'.$field['field'].'" name="'.$field['field'].'" type="text" ';
                        if ($field['maxSize']){
                         $html .= 'maxlength="'.$field['maxSize'].'" ';   
                        }
                        if ($field['required'] == true){
                         $html .= 'oninvalid="this.setCustomValidity(\''.$errorMessage.'\')" oninput="setCustomValidity(\'\')" required';  
                        }
                    $html .= '>';   
                    } //end normal text field input      
                    $html .= '</td></tr>';    
                } //end for each fields


                //start questions inputs    
                foreach($jsondataform['questions'] as $question){ 
                $html .= '<tr><td><label';
                  if($question['required'] == true) {
                          $html .= ' class="gotowebinar-required"';     
                  }             
                $html .= ' for="'.$question['questionKey'].'">'.$question['question'].'</label></td>';    
                    $html .= '<td>';   
                    if($question['type'] == "shortAnswer"){
                    $html .= '<input class="gotowebinar-question" id="'.$question['questionKey'].'" name="'.$question['questionKey'].'" type="text" ';
                    if ($question['maxSize']){
                     $html .= 'maxlength="'.$question['maxSize'].'" ';   
                    }
                    if ($question['required'] == true){
                     $html .= 'oninvalid="this.setCustomValidity(\''.$errorMessage.'\')" oninput="setCustomValidity(\'\')" required';  
                    }
                $html .= '>';  
                    } else { //end input
                        $html .= '<select class="gotowebinar-question gotowebinar-select" name="'.$question['questionKey'].'" id="'.$question['questionKey'].'" ';
                 if ($question['maxSize']){
                     $html .= 'maxlength="'.$question['maxSize'].'" ';   
                    }
                    if ($question['required'] == true){
                     $html .= 'oninvalid="this.setCustomValidity(\''.$errorMessage.'\')" oninput="setCustomValidity(\'\')" required';  
                    }    
                $html .= '>';
                $html .= '<option value="">'.__('--Select--','wp-gotowebinar').'</option>';
                foreach($question['answers'] as $answer){    
                $html .= '<option value="'.$answer['answerKey'].'">'.$answer['answer'].'</option>';
                } //end select options foreach
                $html .= '</select>';
                    } //end select
                    $html .= '</td></tr>';  
                } //end for each questions


                //check if user is logged in
                if ( is_user_logged_in() ) {
                    //get current user
                    $current_user = wp_get_current_user();
                    //current user email
                    $html .= '<tr style="display:none;">';
                    $html .= '<td><input name="gotowebinar_current_user_email" id="gotowebinar_current_user_email" type="text" value="'.$current_user->user_email.'"></td></tr>';     
                    //current user first name    
                    $html .= '<tr style="display:none;">';
                    $html .= '<td><input name="gotowebinar_current_user_first_name" id="gotowebinar_current_user_first_name" type="text" value="'.$current_user->user_firstname.'"></td></tr>';     
                    //current user last name    
                    $html .= '<tr style="display:none;">';
                    $html .= '<td><input name="gotowebinar_current_user_last_name" id="gotowebinar_current_user_last_name" type="text" value="'.$current_user->user_lastname.'"></td></tr>';     
                }  


                //start hidden fields
                //source
                //get source value
                if(isset($options['gotowebinar_registration_source']) && strlen($options['gotowebinar_registration_source'])>0){
                    $html .= '<tr style="display:none;">';

                    $source = apply_filters( 'gotowebinar_registration_source', $options['gotowebinar_registration_source'], $a['key'],$jsondata['subject'] );

                    $html .= '<td><input class="gotowebinar-field" name="source" id="gotowebinar_registration_source" type="text" value="'.$source.'"></td></tr>'; 
                }
                //webinarkey
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_registration_webinar_key" id="gotowebinar_registration_webinar_key" type="text" value="'.$a['key'].'"></td></tr>';
                //webinartitle
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_registration_webinar_title" id="gotowebinar_registration_webinar_title" type="text" value="'.str_replace($a['hide'],"",$jsondata['subject']).'"></td></tr>';
                //webinartime
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_registration_webinar_time" id="gotowebinar_registration_webinar_time" type="text" value="'.$formtime.'"></td></tr>';
                //webinardate
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_registration_webinar_date" id="gotowebinar_registration_webinar_date" type="text" value="'.$formdate.'"></td></tr>';  
                //webinarregistrationurl
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_registration_url" id="gotowebinar_registration_url" type="text" value="'.$jsondata['registrationUrl'].'"></td></tr>';
                //mailchimpdefaultlist
                $html .= '<tr style="display:none;"><td></td>';
                $html .= '<td><input name="gotowebinar_mailchimp_default_list" id="gotowebinar_mailchimp_default_list" type="text" value="'.$a['mailchimp'].'"></td></tr>';  
                //constantcontactdefaultlist
                $html .= '<tr style="display:none;"><td></td>';
                $html .= '<td><input name="gotowebinar_constantcontact_default_list" id="gotowebinar_constantcontact_default_list" type="text" value="'.$a['constantcontact'].'"></td></tr>';
                //activecampaigndefaultlist
                $html .= '<tr style="display:none;"><td></td>';
                $html .= '<td><input name="gotowebinar_activecampaign_default_list" id="gotowebinar_activecampaign_default_list" type="text" value="'.$a['activecampaign'].'"></td></tr>'; 
                //campaignmonitordefaultlist
                $html .= '<tr style="display:none;"><td></td>';
                $html .= '<td><input name="gotowebinar_campaignmonitor_default_list" id="gotowebinar_campaignmonitor_default_list" type="text" value="'.$a['campaignmonitor'].'"></td></tr>'; 
                //aweberdefaultlist
                $html .= '<tr style="display:none;"><td></td>';
                $html .= '<td><input name="gotowebinar_aweber_default_list" id="gotowebinar_aweber_default_list" type="text" value="'.$a['aweber'].'"></td></tr>';     
                //MailChimp SubscribeIf
                if($gotowebinar_is_pro == "YES"){    
                    $html .= '<tr style="display:none;">';
                    $html .= '<td><input name="gotowebinar_mailchimp_subscribe_if" id="gotowebinar_mailchimp_subscribe_if" type="text" value="'.$options['gotowebinar_mailchimp_subscribe_if'].'"></td></tr>';
                }
                //successMessage
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_translate_successMessage" id="gotowebinar_translate_successMessage" type="text" value="'.$options['gotowebinar_translate_successMessage'].'"></td></tr>';
                //alreadyRegisteredMessage
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_translate_alreadyRegisteredMessage" id="gotowebinar_translate_alreadyRegisteredMessage" type="text" value="'.$options['gotowebinar_translate_alreadyRegisteredMessage'].'"></td></tr>';
                //attendeeLimitMessage
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_translate_attendeeLimitMessage" id="gotowebinar_translate_attendeeLimitMessage" type="text" value="'.$options['gotowebinar_translate_attendeeLimit'].'"></td></tr>';    
                //errorMessage
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_translate_errorMessage" id="gotowebinar_translate_errorMessage" type="text" value="'.$options['gotowebinar_translate_errorMessage'].'"></td></tr>';
                //customThankYouPage
                //we are also going to provide a way to specify this with a shortcode


                if(isset($atts['thankyou'])){
                    $thank_you_page_link = $atts['thankyou'];
                } else {
                    $thank_you_page_link = apply_filters( 'gotowebinar_custom_thankyou_page', get_permalink($options['gotowebinar_custom_thankyou_page']), $a['key'],$jsondata['subject'] );
                }
                $html .= '<tr style="display:none;">';
                $html .= '<td><input name="gotowebinar_custom_thankyou_page" id="gotowebinar_custom_thankyou_page" type="text" value="'.$thank_you_page_link.'"></td></tr>';
                //require checked
                if($gotowebinar_is_pro == "YES" && isset($options['gotowebinar_emailservice_require_checked'])){
                    $html .= '<tr style="display:none;">';
                    $html .= '<td><input name="gotowebinar_require_checked" id="gotowebinar_require_checked" type="text" value="YES"></td></tr>';
                }
                //require checked
                if($gotowebinar_is_pro == "YES" && isset($options['gotowebinar_dont_send_query_strings'])){
                    $html .= '<tr style="display:none;">';
                    $html .= '<td><input name="gotowebinar_dont_send_query_strings" id="gotowebinar_dont_send_query_strings" type="text" value="YES"></td></tr>';
                }

                //shows opt in condition
                if(!isset($options['gotowebinar_emailservice_opt_in']) && $gotowebinar_is_pro == "YES"){

                    if(strlen($options['gotowebinar_translate_subscribe_condition_title']) >0){
                        $customSubscribeConditionMessage = $options['gotowebinar_translate_subscribe_condition_title'];    
                    } else {
                        $customSubscribeConditionMessage = 'Sign me up to the mailing list';     
                    }        

                    $html .= '<tr><td><label class="email-service-opt-in" for="gotowebinar_opt_in">'.$customSubscribeConditionMessage.'</label></td>';

                    
                    $html .= '<td>';

                        //check if the input is checked

                        if(isset($options['gotowebinar_emailservice_opt_in_default'])){
                            $html .= '<input class="email-service-opt-in" name="gotowebinar_opt_in" id="gotowebinar_opt_in" type="checkbox">';
                        } else {
                            $html .= '<input class="email-service-opt-in" name="gotowebinar_opt_in" id="gotowebinar_opt_in" type="checkbox" checked>';
                        }
                    
                    $html .= '</td></tr>'; 


                }

                //shows 2nd opt in condition
                if(isset($options['gotowebinar_registration_confirmation'])){

                    if(strlen($options['gotowebinar_translate_registration_confirmation_message']) >0){
                        $customRegistrationConfirmationMessage = $options['gotowebinar_translate_registration_confirmation_message'];    
                    } else {
                        $customRegistrationConfirmationMessage = 'Are you sure you want to register for this webinar?';     
                    }    

                    $html .= '<tr><td><label class="second-opt-in" for="gotowebinar_opt_in">'.__($customRegistrationConfirmationMessage,'wp-gotowebinar').'</label></td>';

                    //set the default option appropriately 

                    if(isset($options['gotowebinar_registration_confirmation_default']) && $options['gotowebinar_registration_confirmation_default'] == 'checked'){
                        $defaultValue = 'checked';
                    } else {
                        $defaultValue = '';    
                    }

                    $html .= '<td><input class="second-opt-in" name="gotowebinar_opt_in_second" id="gotowebinar_opt_in_second" type="checkbox" '.$defaultValue.'></td></tr>'; 


                }     

                //google recaptcha    
                if(isset($options['gotowebinar_recaptcha_site_key']) && strlen($options['gotowebinar_recaptcha_site_key']) > 0){    
                $html .= '<tr><td></td><td>';    
                $html .= '<div class="g-recaptcha" data-sitekey="'.$options['gotowebinar_recaptcha_site_key'].'"></div>';
                $html .= '</td></tr>';
                }

                //submit button and closing tags
                $html .= '<tr><td></td>';
                $html .= '<td><input id="gotowebinar_registration_submit" class="gotowebinar_registration_submit" value="';
                if(strlen($options['gotowebinar_translate_submitButton'])>0) {
                    $html .= $options['gotowebinar_translate_submitButton'];
                } 
                else {
                    $html .= "Submit";   
                }
                $html .= '" type="submit">';
                $html .= '<i class="fas fa-spinner" aria-hidden="true"></i>';
                $html .= '</td></tr>';
                $html .= '</table>';
                $html .= '</form>';

            }

            $html .= apply_filters('gotowebinar_after_registration_form','');

            return $html; //end form

        //this is the error thrown if there's a 400 status    
        } else {
            if(isset($options['gotowebinar_translate_cancelledWebinar']) && strlen($options['gotowebinar_translate_cancelledWebinar'])>0) {
                echo html_entity_decode(stripslashes($options['gotowebinar_translate_cancelledWebinar']));    
            } else {
                echo "The webinar either no longer exists or an error has occured.";    
            }
        }
        
    //this is the error if a person goes to a blank registration page with no webinar id
    } else {
        
        if(current_user_can('administrator')) { 
          echo "Thanks for using WP GoToWebinar. The shortcode has been implemented correctly. This page is required if you wish to display GoToWebinar registration forms on your own website. However this page requires a parameter at the end of the URL when accessed so the page knows what registration form to display for a given webinar. So on your upcoming webinars display when you click on a register link it will go to this page and send a parameter to it so that page knows what registration form to display. So if you were expecting a form here don't worry everything is working fine.";
        }
    } 
    
    
}
add_shortcode('gotowebinar-reg', 'go_to_webinar_registration');
add_shortcode('gotowebinar-reg-gen', 'go_to_webinar_registration');
//creates shortcode for any page and also visual composer - the visual composer one is required because otherwise it would share a namespace

?>