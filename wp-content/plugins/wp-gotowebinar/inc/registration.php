<?php
//function to register registrant for webinar



function wp_gotowebinar_webinar_registration($body,$webinarId,$webinarTitle,$name){
    $options = get_option('gotowebinar_settings');
    
    list($access_token,$organizer_key) = wp_gotowebinar_get_access_and_refresh_token();
    
    $url = wpgotowebinar_api_base().'/organizers/'.$organizer_key.'/webinars/'.$webinarId.'/registrants';

    $response = wp_remote_post($url , array(
	'headers' => array(
		'Authorization' => $access_token,
		'Content-Type' => 'application/json; charset=utf-8',
	),
	'body' => $body,
    ));

    if (! is_wp_error($response)) {

        if ( 201 == wp_remote_retrieve_response_code( $response ) ) {

            wp_gotowebinar_add_log_item('success','Webinar Registration Successful - '.$webinarTitle.' - '.$name,false); 

            $jsondata = json_decode($response['body'],true); 
            echo $jsondata['joinUrl'];

            //do action so other people can hook in
            do_action( 'gotowebinar_add_registrant_success', $webinarId, $webinarTitle, $body, $response );


        } elseif ( 409 == wp_remote_retrieve_response_code( $response ) ) {
            wp_gotowebinar_add_log_item('warning','Webinar Registration Unsuccessful (already registered) - '.$webinarTitle.' - '.$name,false);
            echo "409";

            //do action so other people can hook in
            do_action( 'gotowebinar_add_registrant_already_registered', $webinarId, $webinarTitle, $body );

        } elseif ( 403 == wp_remote_retrieve_response_code( $response ) ) {
            wp_gotowebinar_add_log_item('warning','Webinar Registration Unsuccessful (attendee limit reached) - '.$webinarTitle.' - '.$name,false);
            echo "403";

            //do action so other people can hook in
            do_action( 'gotowebinar_add_registrant_limit_reached', $webinarId, $webinarTitle, $body );

        } else { 
            wp_gotowebinar_add_log_item('error','Webinar Registration Unsuccessful - '.$webinarTitle.' - '.$name,false);
            echo "ERROR";  
            
            //do action so other people can hook in
            do_action( 'gotowebinar_add_registrant_failure', $webinarId, $webinarTitle, $body );
        }

    } else {
        // There was an error making the request
        wp_gotowebinar_add_log_item('error','Webinar Registration Unsuccessful - '.$webinarTitle.' - '.$name,false);
        echo "ERROR"; 
        //do action so other people can hook in
        do_action( 'gotowebinar_add_registrant_failure', $webinarId, $webinarTitle, $body );
    }  
}



function wpgotowebinar_registration_form_submit(){
    $options = get_option('gotowebinar_settings');

    $webinarId = $_POST['webinarId'];
    $name = $_POST['name']; //used for logging only
    $webinarTitle = $_POST['webinarTitle']; //used for logging only
    $body = json_encode($_POST['data']);      

    wp_gotowebinar_webinar_registration($body,$webinarId,$webinarTitle,$name);    

    wp_die(); 

} //end function
add_action( 'wp_ajax_registration_form_submit', 'wpgotowebinar_registration_form_submit' );
add_action( 'wp_ajax_nopriv_registration_form_submit', 'wpgotowebinar_registration_form_submit' );

?>