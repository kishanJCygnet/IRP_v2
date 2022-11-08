<?php
/*
*		Plugin Name: WP GoToWebinar
*		Plugin URI: https://www.northernbeacheswebsites.com.au
*		Description: Show upcoming GoToWebinars on any post or page or in a widget and register users on your website. 
*		Version: 14.36
*		Author: Martin Gibson
*		Author URI:  https://www.northernbeacheswebsites.com.au
*		Text Domain: wp-gotowebinar   
*		Support: https://www.northernbeacheswebsites.com.au/contact
*		Licence: GPL2
*/

// Assign global variables
global $gotowebinar_is_pro;

if(file_exists(dirname( __FILE__ ).'/inc/pro')){
    $gotowebinar_is_pro = "YES";    
} else {
    $gotowebinar_is_pro = "NO";    
}


//the first YES/NO in the array is if the feature is pro, the second YES/NO in the array is if a save settings button is necessary
global $gotowebinar_pro_features;
$gotowebinar_pro_features = array('General Options' => array('NO','YES'), 'Translation' => array('NO','YES'), 'Clear Cache' => array('NO','NO'), 'FAQ' => array('NO','NO'), 'Support' => array('NO','NO'), 'Log' => array('NO','NO'), 'Webinar Product Manager' => array('YES','NO'), 'Create a Webinar' => array('YES','NO'), 'Integration' => array('YES','YES'), 'Pro Options' => array('YES','YES'), 'Performance' => array('YES','NO'), 'Toolbar Countdown' => array('YES','YES'), 'Licence Activation' => array('YES','YES'));

global $time_zone_list;
$time_zone_list = array("Pacific/Tongatapu"=>13, "Pacific/Fiji"=>12, "Pacific/Auckland"=>12, "Asia/Magadan"=>11, "Asia/Vladivostok"=>10, "Australia/Hobart"=>10, "Pacific/Guam"=>10, "Australia/Sydney"=>10, "Australia/Brisbane"=>10, "Australia/Darwin"=>9.5, "Australia/Adelaide"=>9.5, "Asia/Yakutsk"=>9, "Asia/Seoul"=>9, "Asia/Tokyo"=>9, "Asia/Taipei"=>8, "Australia/Perth"=>8, "Asia/Singapore"=>8, "Asia/Irkutsk"=>8, "Asia/Shanghai"=>8, "Asia/Krasnoyarsk"=>7, "Asia/Bangkok"=>7, "Asia/Jakarta"=>7, "Asia/Rangoon"=>6.5, "Asia/Colombo"=>6, "Asia/Dhaka"=>6, "Asia/Novosibirsk"=>6, "Asia/Katmandu"=>5.75, "Asia/Calcutta"=>5.5, "Asia/Karachi"=>5, "Asia/Yekaterinburg"=>5, "Asia/Kabul"=>4.5, "Asia/Tbilisi"=>4, "Asia/Muscat"=>4, "Asia/Tehran"=>3.5, "Africa/Nairobi"=>3, "Europe/Moscow"=>3, "Asia/Kuwait"=>3, "Asia/Baghdad"=>3, "Asia/Jerusalem"=>2, "Europe/Helsinki"=>2, "Africa/Harare"=>2, "Africa/Cairo"=>2, "Europe/Bucharest"=>2, "Europe/Athens"=>2, "Africa/Malabo"=>1, "Europe/Warsaw"=>1, "Europe/Brussels"=>1, "Europe/Prague"=>1, "Europe/Amsterdam"=>1, "GMT"=>0, "Europe/London"=>0, "Africa/Casablanca"=>0, "Atlantic/Cape_Verde"=>-1, "Atlantic/Azores"=>-1, "America/Buenos_Aires"=>-3, "America/Sao_Paulo"=>-3, "America/St_Johns"=>-3, "America/Santiago"=>-4, "America/Caracas"=>-4, "America/Halifax"=>-4, "America/Indianapolis"=>-5, "America/New_York"=>-5, "America/Bogota"=>-5, "America/Mexico_City"=>-6, "America/Chicago"=>-6, "America/Denver"=>-7, "America/Phoenix"=>-7, "America/Los_Angeles"=>-8, "America/Anchorage"=>-9, "Pacific/Honolulu"=>-10, "MIT"=>-11);

//get plugin version number
function wpgotowebinar_plugin_get_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}

//gotowebinar api base
function wpgotowebinar_api_base() {
    return 'https://api.getgo.com/G2W/rest/v2';
}


// Add a link to our plugin in the admin menu under Settings > GoToWebinar
function wp_gotowebinar_wp_menu() {
    global $gotowebinar_wp_settings_page;
    $gotowebinar_wp_settings_page = add_options_page(
        'WP GoToWebinar Options',
        'WP GoToWebinar',
        'manage_options',
        'wp-gotowebinar',
        'wp_gotowebinar_options_page'    
    );
}
add_action('admin_menu','wp_gotowebinar_wp_menu');
add_action( 'admin_init', 'wp_gotowebinar_settings_init' );


//add a settings link on the plugin page
function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=wp-gotowebinar">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

//add custom links to plugin on plugins page
function wp_gotowebinar_custom_plugin_row_meta( $links, $file ) {
   if ( strpos( $file, 'wp-gotowebinar.php' ) !== false ) {
      $new_links = array(
               '<a href="https://northernbeacheswebsites.com.au/product/donate-to-northern-beaches-websites/" target="_blank">' . __('Donate') . '</a>',
               '<a href="https://northernbeacheswebsites.com.au/wp-gotowebinar-pro/" target="_blank">' . __('Pro Version') . '</a>',
               '<a href="http://wordpress.org/support/plugin/wp-gotowebinar" target="_blank">' . __('Support Forum') . '</a>',
            );
      $links = array_merge( $links, $new_links );
   }
   return $links;
}
add_filter( 'plugin_row_meta', 'wp_gotowebinar_custom_plugin_row_meta', 10, 2 );

//Gets, sets and renders options
require('inc/options-output.php');

// Create our main options page
function wp_gotowebinar_options_page(){
    require('inc/options-page-wrapper.php');
}


//get translations from plugin folder
add_action('plugins_loaded', 'wp_gotowebinar_translations');
function wp_gotowebinar_translations() {
	load_plugin_textdomain( 'wp-gotowebinar', false, dirname( plugin_basename(__FILE__) ) . '/inc/lang/' );
}


//common function to get upcoming webinars
function wp_gotowebinar_upcoming_webinars($transientName, $transientDuration){
    //get options
    $options = get_option('gotowebinar_settings');
    //get transient
    $getTransient = get_transient($transientName);
    //if transient doesn't exist or caching disabled do this
    if ($getTransient != false){
        
        $jsondata = $getTransient; 
        $json_response = 200;
        return array($jsondata,$json_response);
        
    } else { 
        
        //otherwise do this
        list($access_token,$organizer_key) = wp_gotowebinar_get_access_and_refresh_token();

        $currentTime = current_time('Y-m-d\TH:i:s\Z');
        $currentTimePlusYear = date('Y-m-d\TH:i:s\Z', strtotime('+1 year', strtotime($currentTime)));

        $json_feed = wp_remote_get( wpgotowebinar_api_base().'/organizers/'.$organizer_key.'/webinars?fromTime='.$currentTime.'&toTime='.$currentTimePlusYear.'&page=0&size=200', array(
            'headers' => array(
                'Authorization' => $access_token,
            ),
        ));

        $json_response = wp_remote_retrieve_response_code($json_feed);




        //if response is successful set the transient    
        if($json_response == 200){    

            //store the data and response in a variable
            $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $json_feed )), true);
            $jsondata = $jsondata['_embedded']['webinars']; 


            if(is_array($jsondata) && is_countable($jsondata) &&count($jsondata)>0){
                $webinarsToSort = array();

                //cycle through the webinars
                foreach($jsondata as $key1 => $webinar){

                    //get the key
                    $webinarKey = $webinar['webinarKey'];

                    //cycle through the times
                    foreach($webinar['times'] as $key2 => $time){

                        $startTime = $time['startTime'];
                        $endTime = $time['endTime'];

                        //we only want to put stuff in the array which is in the future
                        if($startTime > $currentTime ){
                            $webinarsToSort[$webinarKey.'-'.$key1.'-'.$key2] = $startTime;
                        }
                    }
                }

                //sort the array by value i.e. time
                asort($webinarsToSort);

                //create holding array
                $jsondatareturn = array();

                //loop through sorted array
                foreach($webinarsToSort as $key => $value){

                    $explodeTheKey = explode('-',$key);

                    $webinarPosition = $explodeTheKey[1];
                    $timePosition = $explodeTheKey[2];

                    $webinarInstance = $jsondata[$webinarPosition];
                    $timeInstance = $webinarInstance['times'][$timePosition];

                    //now we want to remove the times from the array and then plug in the actual time of this part in the sequence
                    unset($webinarInstance['times']);

                    //now add the time back in with just the key
                    $webinarInstance['times'] = array($timeInstance);

                    //now add the webinar instance to the array
                    array_push($jsondatareturn,$webinarInstance);

                }


                // //create holding array
                // $webinarsToSorted = array();


                // //cycle through each webinar
                // foreach ($jsondata as $key => $webinar) {

                //     //we also need to loop through the individual times to make sure they aren't in the past

                //     $webinarStartDate = strtotime($webinar['times'][0]['startTime']);

                //     //we are going to add the key that way webinars which havethe same start time can be differentiated
                //     //add the webinar to the array to be sorted
                //     $webinarsToSorted[$webinarStartDate+$key] = $webinar;
            
                // }   


                // //lets sort by array key
                // ksort($webinarsToSorted);

                // //now lets remove the keys
                // $jsondata = array_values($webinarsToSorted);
                
                set_transient($transientName,$jsondatareturn, $transientDuration);  
                

                //return the data and response
                return array($jsondatareturn,$json_response);
            } else {
                return false;    
            }
        } else {
            return false;
        }


    } //end else  
} //end function


//function to check authentication status
function wp_gotowebinar_authentication_check(){
    
    //get options
    $options = get_option('gotowebinar_settings');
    
    list($access_token,$organizer_key) = wp_gotowebinar_get_access_and_refresh_token();

    $currentTime = current_time('Y-m-d\TH:i:s\Z');
    $currentTimePlusYear = date('Y-m-d\TH:i:s\Z', strtotime('+1 year', strtotime($currentTime)));

    $json_feed = wp_remote_get( wpgotowebinar_api_base().'/organizers/'.$organizer_key.'/webinars?fromTime='.$currentTime.'&toTime='.$currentTimePlusYear.'&page=0&size=200', array(
        'headers' => array(
            'Authorization' => $access_token,
        ),
    ));

    $json_response = wp_remote_retrieve_response_code($json_feed);

    //return the data and response
    return $json_response;
    
    
} //end function


// Add shortcode
if(file_exists(get_stylesheet_directory().'/wp-gotowebinar/shortcode.php')) {
require(get_stylesheet_directory().'/wp-gotowebinar/shortcode.php');      
} else {
require('inc/shortcode.php');    
}

// Add registration shortcode
if(file_exists(get_stylesheet_directory().'/wp-gotowebinar/shortcode-registration.php')) {
require(get_stylesheet_directory().'/wp-gotowebinar/shortcode-registration.php');      
} else {
require('inc/shortcode-registration.php');   
}

// Add calendar shortcode
if(file_exists(get_stylesheet_directory().'/wp-gotowebinar/shortcode-calendar.php')) {
require(get_stylesheet_directory().'/wp-gotowebinar/shortcode-calendar.php');      
} else {
require('inc/shortcode-calendar.php');   
}

// Add widget
require('inc/widget.php');


// Load front end style and scripts
function wp_gotowebinar_register_frontend() { 

    //register styles
    wp_register_style( 'full-calendar-style', plugins_url('/inc/external/fullcalendar.min.css', __FILE__ ) );
    wp_register_style( 'font-awesome-icons', plugins_url('/inc/external/all.min.css', __FILE__ ) );
    wp_register_style( 'custom-style', plugins_url( '/inc/style.css', __FILE__ ),array(),wpgotowebinar_plugin_get_version());
    
    //register scripts
    wp_register_script( 'moment-gotowebinar', plugins_url('/inc/external/moment.js', __FILE__ ), array( 'jquery' )); 
    wp_register_script( 'moment-timezone', plugins_url('/inc/external/moment-timezone-with-data.js', __FILE__ ), array( 'jquery' ));
    wp_register_script( 'full-calendar', plugins_url('/inc/external/fullcalendar.min.js', __FILE__ ), array( 'jquery' ));
    wp_register_script( 'full-calendar-locale', plugins_url('/inc/external/locale-all.js', __FILE__ ), array( 'jquery' ));
    wp_register_script( 'jquery-ui', plugins_url('/inc/external/jquery-ui.min.js', __FILE__ ), array( 'jquery'), '1.12.1');
    wp_register_script( 'custom-script', plugins_url( '/inc/script.js', __FILE__ ), array( 'jquery' ),wpgotowebinar_plugin_get_version(),true);
    wp_localize_script( 'custom-script', 'registration_form_submit', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    wp_localize_script( 'custom-script', 'integration_post', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
    wp_register_script( 'timezone-detection', plugins_url('/inc/external/jstz.min.js', __FILE__ ), array( 'jquery' ));
    wp_register_script( 'google-recaptcha-gotowebinar', 'https://www.google.com/recaptcha/api.js');


    //need to load flipclock stuff on every page if enabled
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_toolbar_activate'])){
        wp_enqueue_style( 'gotowebinar-flipclockstyle', plugins_url( '/inc/external/flipclock.css', __FILE__ ));
        wp_enqueue_style( 'custom-style-everywhere', plugins_url( '/inc/style-everywhere.css', __FILE__ ),array(),wpgotowebinar_plugin_get_version());
        wp_enqueue_script( 'gotowebinar-flipclock', plugins_url( '/inc/external/flipclock.min.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( 'gotowebinar-jquerycookie', plugins_url( '/inc/external/jquery.cookie.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( 'custom-script-everywhere', plugins_url( '/inc/script-everywhere.js', __FILE__ ), array( 'jquery' ),wpgotowebinar_plugin_get_version(),true);
    }

    //only output on checkout page
    //check if woocommerce is active
    if(class_exists('woocommerce')){
        if(is_checkout()){
            wp_enqueue_script( 'custom-script-woocommerce-checkout', plugins_url( '/inc/woocommerce-checkout.js', __FILE__ ), array( 'jquery' ),wpgotowebinar_plugin_get_version(),true);   
        }
    }
  
}
add_action( 'wp_enqueue_scripts', 'wp_gotowebinar_register_frontend' );



// Load admin style and scripts
function wp_gotowebinar_register_admin($hook)
{
    wp_enqueue_style( 'visual-composer-style', plugins_url( '/inc/vc-adminstyle.css', __FILE__ ));
    global $gotowebinar_wp_settings_page;
    
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'product' === $post->post_type ) {     
            wp_enqueue_script( 'custom-admin-script-pro', plugins_url( '/inc/pro/adminscriptpro.js', __FILE__ ), array( 'jquery'),wpgotowebinar_plugin_get_version());
        }
    }
    
    if($hook != $gotowebinar_wp_settings_page)
        return;
    
    
    wp_enqueue_script('time-picker', plugins_url('/inc/external/jquery.timepicker.min.js', __FILE__ ), array('jquery'));
    
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'custom-admin-script', plugins_url( '/inc/adminscript.js', __FILE__ ), array( 'jquery','wp-color-picker' ),wpgotowebinar_plugin_get_version());
    wp_enqueue_script('jquery-ui', plugins_url('/inc/external/jquery-ui.min.js', __FILE__ ), array( 'jquery'), '1.12.1');
    wp_enqueue_script('jquery-form');
    wp_enqueue_script('jquery-effects-shake');
    wp_enqueue_script('chart','https://www.gstatic.com/charts/loader.js');
    wp_enqueue_style( 'custom-admin-style', plugins_url( '/inc/adminstyle.css', __FILE__ ),array(),wpgotowebinar_plugin_get_version());
    wp_register_style( 'font-awesome-icons', plugins_url('/inc/external/all.min.css', __FILE__ ) );
    wp_register_style( 'time-picker-style', plugins_url('/inc/external/jquery.timepicker.min.css', __FILE__ ) );
    wp_enqueue_style( array('font-awesome-icons','time-picker-style') );
    
    wp_enqueue_script( 'moment-gotowebinar', plugins_url('/inc/external/moment.js', __FILE__ ), array( 'jquery' )); 
    wp_enqueue_script( 'moment-timezone', plugins_url('/inc/external/moment-timezone-with-data.js', __FILE__ ), array( 'jquery' ));
    
}
add_action( 'admin_enqueue_scripts', 'wp_gotowebinar_register_admin' );


// Include pro functions
if ($gotowebinar_is_pro == "YES"){ 
    include('inc/pro/pro.php');
    include('inc/pro/options-output-pro.php');
} 
//clear cache and deactivation tasks
require('inc/clear-cache.php');
// add visual composer functionality
require('inc/visual-composer.php');
// add registration function
require('inc/registration.php');

//function to save dismiss welcome notice

function wp_gotowebinar_disable_welcome_message_callback() {

$gotowebinar_options = get_option('gotowebinar_settings');
$gotowebinar_options['gotowebinar_welcome_message'] = 1;   
     
update_option('gotowebinar_settings', $gotowebinar_options);        
wp_die(); 
    
}
add_action( 'wp_ajax_disable_welcome_message', 'wp_gotowebinar_disable_welcome_message_callback' );





//functions to register tinymce features
function wp_gotowebinar_register_plugin( $plugin_array ) {
    $plugin_array['wpgotowebinar_button'] = plugins_url('/inc/tinymce.js', __FILE__ );
    return $plugin_array;
}

function wp_gotowebinar_register_buttons($button) {
    array_push($button, 'wpgotowebinar_button'); 
    return $button;
}

function wp_gotowebinar_mce() {
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    
    if ('true' == get_user_option( 'rich_editing')){
        add_filter( "mce_external_plugins", "wp_gotowebinar_register_plugin" );
        add_filter( 'mce_buttons', 'wp_gotowebinar_register_buttons' );
    }   
}
add_action('init','wp_gotowebinar_mce');






//get timezones
function wp_gotowebinar_get_timezones() {
    global $time_zone_list;    
    
    $list = array();
    
    $list[] = array(
            'text' =>	'',
			'value'	=>	''
        );
    
    foreach($time_zone_list as $key => $value) {
        $list[] = array(
            'text' =>	$key,
			'value'	=>	$key
        );
    } 
    
    wp_send_json($list);
    wp_die();
}

function wp_gotowebinar_get_timezones_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_timezones();
}
add_action( 'wp_ajax_get_timezones_list', 'wp_gotowebinar_get_timezones_ajax' );



//get upcoming webinars
function wp_gotowebinar_get_webinars() {
    
    $options = get_option('gotowebinar_settings');
    
    list($jsondata,$json_response) = wp_gotowebinar_upcoming_webinars('gtw_key', 86400);
    
    $list = array();
    
    $list[] = array(
            'text' =>	'Use most upcoming webinar',
			'value'	=>	'upcoming'
        );
    
    if($json_response == 200){  
        foreach ($jsondata as $data) {
            
            foreach($data['times'] as $mytimes) {
                $date = new DateTime($mytimes['startTime']); 
                $startTime = $date->format(wp_gotowebinar_date_format());    
            }
            
            $list[] = array(
            'text' =>	$data['subject'].' ('.$startTime.')',
			'value'	=>	$data['webinarKey']
            );    
        } 
    }
    
    wp_send_json($list);
    wp_die();
 
}

function wp_gotowebinar_get_webinars_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_webinars();
}
add_action( 'wp_ajax_get_webinars_list', 'wp_gotowebinar_get_webinars_ajax' );





//get mailchimp lists
function wp_gotowebinar_get_mailchimp() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_mailchimp_api']) && strlen($options['gotowebinar_mailchimp_api'])>0){

        list($jsondata,$json_response) = wp_gotowebinar_mailchimp_list_hint(); 

        if (200 == $json_response) {
            
            $lists = array();
            
            foreach($jsondata['lists'] as $list){
                
                $lists[] = array(
                    'text' =>	$list['name'],
                    'value'	=>	$list['id']
                );
            }
            
            wp_send_json($lists);
            wp_die();

        }
    }
}

function wp_gotowebinar_get_mailchimp_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_mailchimp();
}
add_action( 'wp_ajax_get_mailchimp_list', 'wp_gotowebinar_get_mailchimp_ajax');





//get constantcontact lists
function wp_gotowebinar_get_constantcontact() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_constantcontact_token']) && strlen($options['gotowebinar_constantcontact_token'])>0){

        list($jsondata,$json_response) = wp_gotowebinar_constantcontact_list_hint(); 

        if (200 == $json_response) {
            
            $lists = array();
            
            foreach($jsondata as $list){
                
                $lists[] = array(
                    'text' =>	$list['name'],
                    'value'	=>	$list['id']
                );
            }
            
            wp_send_json($lists);
            wp_die();

        }
    }
}

function wp_gotowebinar_get_constantcontact_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_constantcontact();
}
add_action( 'wp_ajax_get_constantcontact_list', 'wp_gotowebinar_get_constantcontact_ajax');





//get activecampaign lists
function wp_gotowebinar_get_activecampaign() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_activecampaign_account']) && strlen($options['gotowebinar_activecampaign_account'])>0){

        list($jsondata,$json_response) = wp_gotowebinar_activecampaign_list_hint(); 

        if (200 == $json_response) {
            
            $lists = array();
            
            foreach($jsondata as $list){
                if (is_array($list) && isset($list['name'])) {
                    $lists[] = array(
                        'text' =>	$list['name'],
                        'value'	=>	$list['id']
                    );
                }
            }
            
            wp_send_json($lists);
            wp_die();

        }
    }
}

function wp_gotowebinar_get_activecampaign_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_activecampaign();
}
add_action( 'wp_ajax_get_activecampaign_list', 'wp_gotowebinar_get_activecampaign_ajax');







//get campaignmonitor lists
function wp_gotowebinar_get_campaignmonitor() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_campaignmonitor_client_id']) && strlen($options['gotowebinar_campaignmonitor_client_id'])>0){

        list($jsondata,$json_response) = wp_gotowebinar_campaignmonitor_list_hint(); 

        if (200 == $json_response) {
            
            $lists = array();
            
            foreach($jsondata as $list){
                if (is_array($list) && isset($list['Name'])) {
                    $lists[] = array(
                        'text' =>	$list['Name'],
                        'value'	=>	$list['ListID']
                    );
                }
            }
            
            wp_send_json($lists);
            wp_die();

        }
    }
}

function wp_gotowebinar_get_campaignmonitor_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_campaignmonitor();
}
add_action( 'wp_ajax_get_campaignmonitor_list', 'wp_gotowebinar_get_campaignmonitor_ajax');









//get aweber lists
function wp_gotowebinar_get_aweber() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_aweber_token']) && strlen($options['gotowebinar_aweber_token'])>0){

        list($jsondata,$json_response) = wp_gotowebinar_aweber_list_hint(); 

        if (200 == $json_response) {
            
            $lists = array();
            
            foreach($jsondata['entries'] as $key => $list){

                $lists[] = array(
                    'text' =>	$list['name'],
                    'value'	=>	$list['id']
                );

            }
            
            wp_send_json($lists);
            wp_die();

        }
    }
}

function wp_gotowebinar_get_aweber_ajax() {
	// check for nonce
	check_ajax_referer( 'wpgotowebinar-nonce', 'security' );
	return wp_gotowebinar_get_aweber();
}
add_action( 'wp_ajax_get_aweber_list', 'wp_gotowebinar_get_aweber_ajax');







function wp_gotowebinar_send_tinymce_data() {
	// create nonce
	global $pagenow;
	if( $pagenow != 'admin.php' ){
		$nonce = wp_create_nonce( 'wpgotowebinar-nonce' );
		?><script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				var data = {
					'action'	: 'get_timezones_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.timezoneList = response;
							}
						}
			  		}
			  	});
                var data = {
					'action'	: 'get_webinars_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.webinarList = response;
							}
						}
			  		}
			  	});
                var data = {
					'action'	: 'get_mailchimp_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.mailchimpList = response;
							}
						}
			  		}
			  	});
                var data = {
					'action'	: 'get_constantcontact_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.constantcontactList = response;
							}
						}
			  		}
			  	});
                var data = {
					'action'	: 'get_activecampaign_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.activecampaignList = response;
							}
						}
			  		}
			  	});
                var data = {
					'action'	: 'get_campaignmonitor_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.campaignmonitorList = response;
							}
						}
			  		}
			  	});
                var data = {
					'action'	: 'get_aweber_list', // wp ajax action
					'security'	: '<?php echo $nonce; ?>' // nonce value created earlier
				};
				// fire ajax
			  	jQuery.post(ajaxurl, data, function(response) {
			  		// if nonce fails then not authorized else settings saved
			  		if( response === '-1' ){
			  		} else {
			  			if (typeof(tinyMCE) != 'undefined') {
			  				if (tinyMCE.activeEditor != null) {
								tinyMCE.activeEditor.settings.aweberList = response;
							}
						}
			  		}
			  	});
                
			});
		</script>
<?php 
	}
}
add_action('admin_footer','wp_gotowebinar_send_tinymce_data');











//get email service list hints for use in tinymce and visual composer shortcode builder and also in pro settings
function wp_gotowebinar_mailchimp_list_hint() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_mailchimp_api']) && strlen($options['gotowebinar_mailchimp_api'])>0){
    
        $serverCenter = substr($options['gotowebinar_mailchimp_api'], strpos($options['gotowebinar_mailchimp_api'],'-')+1);
    
        $response = wp_remote_get( 'https://'.$serverCenter.'.api.mailchimp.com/3.0/lists', array(
            'headers' => array(
                'Authorization' => 'Basic '. base64_encode('anystring:'.$options['gotowebinar_mailchimp_api']),
            ),
        ));
        
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $response )), true);
        $json_response = wp_remote_retrieve_response_code($response);
        
        return array($jsondata,$json_response);
        
    }
}

function wp_gotowebinar_constantcontact_list_hint() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_constantcontact_token']) && strlen($options['gotowebinar_constantcontact_token'])>0){
        
        $response = wp_remote_get('https://api.constantcontact.com/v2/lists?api_key=me68vunsy43cw654ydm2tucf', array(
            'headers' => array(
                'Authorization' => 'Bearer '.$options['gotowebinar_constantcontact_token'],
            ),
        ));
        
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $response )), true);
        $json_response = wp_remote_retrieve_response_code($response);
        
        return array($jsondata,$json_response);
        
    }
}

function wp_gotowebinar_activecampaign_list_hint() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_activecampaign_account']) && strlen($options['gotowebinar_activecampaign_account'])>0){
        
        $response = wp_remote_get($options['gotowebinar_activecampaign_account'].'/admin/api.php?api_action=list_list&api_key='.$options['gotowebinar_activecampaign_api'].'&ids=all&api_output=json', array(
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'Content-Type' => 'application/json; charset=utf-8',
                    )
                ));
        
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $response )), true);
        $json_response = wp_remote_retrieve_response_code($response);
        
        return array($jsondata,$json_response);
        
    }
}


function wp_gotowebinar_campaignmonitor_list_hint() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_campaignmonitor_client_id']) && strlen($options['gotowebinar_campaignmonitor_client_id'])>0){
        
        $response = wp_remote_get('https://api.createsend.com/api/v3.1/clients/'.$options['gotowebinar_campaignmonitor_client_id'].'/lists.json?pretty=true', array(
            'headers' => array(
                'Authorization' => 'Basic '. base64_encode($options['gotowebinar_campaignmonitor_api']),
            ),
        ));
        
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $response )), true);
        $json_response = wp_remote_retrieve_response_code($response);
        
        return array($jsondata,$json_response);
        
    }
}









function wp_gotowebinar_aweber_account_hint() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_aweber_token']) && strlen($options['gotowebinar_aweber_token'])>0){
        
        //lets first get the account id
        
        //get authorization code from settings
        $authorizationCode = $options['gotowebinar_aweber_authorization_code'];
        $separateData = explode("|",$authorizationCode);
        $applicationKey = $separateData[0];
        $applicationSecret = $separateData[1];
        $nonce = wp_create_nonce('aweber');
        $unixTimestamp = time();
        
        $url = 'https://api.aweber.com/1.0/accounts';
        
        //start building a string which will be encoded and turned into the oauth1 signature
        $signatureBaseString = 'oauth_consumer_key=';
        $signatureBaseString .= $applicationKey;
        $signatureBaseString .= '&oauth_nonce=';
        $signatureBaseString .= $nonce;
        $signatureBaseString .= '&oauth_signature_method=HMAC-SHA1&oauth_timestamp=';
        $signatureBaseString .= $unixTimestamp;
        $signatureBaseString .= '&oauth_token=';
        $signatureBaseString .= $options['gotowebinar_aweber_token'];
        $signatureBaseString .= '&oauth_version=1.0';

        //encode the signature
        $signatureBaseString = 'GET&'.urlencode($url).'&'.urlencode($signatureBaseString);
        
        //the key of the signature
        $sigKey = $applicationSecret.'&'.$options['gotowebinar_aweber_token_secret'];

        //the final signature woohoo!
        $signature = base64_encode(hash_hmac('sha1', $signatureBaseString, $sigKey, true));

        $response = wp_remote_get($url, array(
            'headers' => array(
                'Authorization' => 'OAuth oauth_consumer_key="'.$applicationKey.'", oauth_nonce="'.$nonce.'", oauth_signature="'.$signature.'", oauth_signature_method="HMAC-SHA1", oauth_timestamp="'.$unixTimestamp.'", oauth_token="'.$options['gotowebinar_aweber_token'].'", oauth_version="1.0"',
            ),
        ));
         
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $response )), true);
        $json_response = wp_remote_retrieve_response_code($response);
        
        return array($jsondata,$json_response);
        
    }
}




















function wp_gotowebinar_aweber_list_hint() {
    
    $options = get_option('gotowebinar_settings');
    
    if(isset($options['gotowebinar_aweber_accounts']) && strlen($options['gotowebinar_aweber_token'])>0){
        
        //get authorization code from settings
        $authorizationCode = $options['gotowebinar_aweber_authorization_code'];
        $separateData = explode("|",$authorizationCode);
        $applicationKey = $separateData[0];
        $applicationSecret = $separateData[1];
        $nonce = wp_create_nonce('aweber');
        $unixTimestamp = time();
        
        //start building a string which will be encoded and turned into the oauth1 signature
        $signatureBaseString = 'oauth_consumer_key=';
        $signatureBaseString .= $applicationKey;
        $signatureBaseString .= '&oauth_nonce=';
        $signatureBaseString .= $nonce;
        $signatureBaseString .= '&oauth_signature_method=HMAC-SHA1&oauth_timestamp=';
        $signatureBaseString .= $unixTimestamp;
        $signatureBaseString .= '&oauth_token=';
        $signatureBaseString .= $options['gotowebinar_aweber_token'];
        $signatureBaseString .= '&oauth_version=1.0';
        
        //get the new url for lists with the accountid placed inside
        $url = 'https://api.aweber.com/1.0/accounts/'.$options['gotowebinar_aweber_accounts'].'/lists';
        
        //encode the signature
        $signatureBaseString = 'GET&'.urlencode($url).'&'.urlencode($signatureBaseString);
        
        //the key of the signature
        $sigKey = $applicationSecret.'&'.$options['gotowebinar_aweber_token_secret'];

        //the final signature woohoo!
        $signature = base64_encode(hash_hmac('sha1', $signatureBaseString, $sigKey, true));

        $response = wp_remote_get($url, array(
            'headers' => array(
                'Authorization' => 'OAuth oauth_consumer_key="'.$applicationKey.'", oauth_nonce="'.$nonce.'", oauth_signature="'.$signature.'", oauth_signature_method="HMAC-SHA1", oauth_timestamp="'.$unixTimestamp.'", oauth_token="'.$options['gotowebinar_aweber_token'].'", oauth_version="1.0"',
            ),
        ));
         
        $jsondata = json_decode(preg_replace('/("\w+"):(\d+(\.\d+)?)/', '\\1:"\\2"', wp_remote_retrieve_body( $response )), true);
        $json_response = wp_remote_retrieve_response_code($response);
        
        return array($jsondata,$json_response);
        
    }
}




//add item to log
function wp_gotowebinar_add_log_item($type,$message,$user) {
    
    include(ABSPATH . "wp-includes/pluggable.php"); 
    $options = get_option('gotowebinar_settings');
    
    
    if(get_option('gotowebinar_log')===false){
        add_option( 'gotowebinar_log',array(), '', 'yes' );
    }
    
    $currentOption = get_option('gotowebinar_log');
    
    //get the current user name
    $current_user = wp_get_current_user();
    $userFullName = $current_user->user_firstname.' '.$current_user->user_lastname;
        
    if(strlen($userFullName)<2) {
        $name = $current_user->user_login;  
    } else {
        $name = $userFullName;     
    }
    
    //get the time
    $currentDate = date_i18n(wp_gotowebinar_date_format(), current_time('timestamp'),true);
    $currentTime = date_i18n(str_replace(" T","",wp_gotowebinar_time_format()), current_time('timestamp'),true);
    $fullDateTime = $currentDate.' '.$currentTime;
    
    if($user == true){
        $newLogItem = array($type,$fullDateTime,$message,$name);    
    } else {
        $newLogItem = array($type,$fullDateTime,$message,'');    
    }
    
    
    
    //if there are more than 200 log entries lets start removing the earlier log entrie
    if(count($currentOption)>=200){
        array_shift($currentOption);
    }
    
    //add the new item to the array
    array_push($currentOption,$newLogItem);
    
    //update the option
    update_option('gotowebinar_log',$currentOption,'yes');

}


function wp_gotowebinar_add_create_webinar_log_item(){
    
    $type = $_POST['type'];
    $message = $_POST['message'];
    $user = true;
    
    wp_gotowebinar_add_log_item($type,$message,$user);
    wp_die();
}
add_action( 'wp_ajax_create_product_log', 'wp_gotowebinar_add_create_webinar_log_item' );


//Function to run upon ajax request to delete log
function wp_gotowebinar_delete_log_callback() {
    delete_option('gotowebinar_log');  
    wp_die();     
}
add_action( 'wp_ajax_delete_log', 'wp_gotowebinar_delete_log_callback' );




























if($gotowebinar_is_pro == "YES"){ 


    //initialise the update check
    require 'inc/pro/plugin-update-checker/plugin-update-checker.php';

    global $plugin_update_checker_wp_gotowebinar;

    $plugin_update_checker_wp_gotowebinar = Puc_v4_Factory::buildUpdateChecker(
        'https://northernbeacheswebsites.com.au/?update_action=get_metadata&update_slug=wp-gotowebinar', //Metadata URL.
        __FILE__, //Full path to the main plugin file.
        'wp-gotowebinar' //Plugin slug. Usually it's the same as the name of the directory.
    );


    //add queries to the update call
    $plugin_update_checker_wp_gotowebinar->addQueryArgFilter('filter_update_checks_wp_gotowebinar');
    function filter_update_checks_wp_gotowebinar($queryArgs) {
        
        
        $pluginSettings = get_option('gotowebinar_settings');
        

        if(isset($pluginSettings['gotowebinar_licence_activation_purchase_email']) && isset($pluginSettings['gotowebinar_licence_activation_order_id'])){

            $purchaseEmailAddress = $pluginSettings['gotowebinar_licence_activation_purchase_email'];
            $orderId = $pluginSettings['gotowebinar_licence_activation_order_id'];
            $siteUrl = get_site_url();
            $siteUrl = parse_url($siteUrl);
            $siteUrl = $siteUrl['host'];

            if (!empty($purchaseEmailAddress) &&  !empty($orderId)) {
                $queryArgs['purchaseEmailAddress'] = $purchaseEmailAddress;
                $queryArgs['orderId'] = $orderId;
                $queryArgs['siteUrl'] = $siteUrl;
                $queryArgs['productId'] = '8018';
            }

        }

        return $queryArgs;   
    }



    // define the puc_request_info_result-<slug> callback 
    $plugin_update_checker_wp_gotowebinar->addFilter(
        'request_info_result', 'filter_puc_request_info_result_slug_wp_gotowebinar', 10, 2
    );
    function filter_puc_request_info_result_slug_wp_gotowebinar( $plugininfo, $result ) { 
        //get the message from the server and set as transient
        set_transient('wp-gotowebinar-update',$plugininfo->{'message'},YEAR_IN_SECONDS * 1);

        return $plugininfo; 
    }; 






    $path = plugin_basename( __FILE__ );

    add_action("after_plugin_row_{$path}", function( $plugin_file, $plugin_data, $status ) {
        
        //get plugin settings
        $pluginSettings = get_option('gotowebinar_settings');
        
        
        if (!empty($pluginSettings['gotowebinar_licence_activation_purchase_email']) &&  !empty($pluginSettings['gotowebinar_licence_activation_order_id'])) {
            
            $order_id = $pluginSettings['gotowebinar_licence_activation_order_id'];
            
            //get transient
            $message = get_transient('wp-gotowebinar-update');
        
            if($message !== 'Yes' && $message !== false){

                $purchaseLink = 'https://northernbeacheswebsites.com.au/wp-gotowebinar-pro/';

                if($message == 'Incorrect Details'){
                    $displayMessage = 'The Order ID and Purchase ID you entered is not correct. Please double check the details you entered to receive product updates.';    
                } elseif ($message == 'Licence Expired'){
                    $displayMessage = 'Your licence has expired. Please <a href="'.$purchaseLink.'" target="_blank">purchase a new licence</a> to receive further updates for this plugin.';    
                } elseif ($message == 'Website Mismatch') {
                    $displayMessage = 'This plugin has already been registered on another website using your details. Under the licence terms this plugin can only be used on one website. Please <a href="'.$purchaseLink.'" target="_blank">click here</a> to purchase an additional licence. To change the website assigned to your licence, please click <a href="https://northernbeacheswebsites.com.au/my-account/view-order/'.$order_id.'/" target="_blank">here</a>.';    
                } else {
                    $displayMessage = '';    
                }
                
                echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-error notice-alt"><p class="installer-q-icon">'.$displayMessage.'</p></div></td></tr>';

            }
            
        } else {
            
            echo '<tr class="plugin-update-tr active"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-error notice-alt"><p class="installer-q-icon">Please enter your Order ID and Purchase ID in the plugin settings to receive automatics updates.</p></div></td></tr>';
            
        }
        

    }, 10, 3 );

    /**
    * 
    *
    *
    * Force check for updates
    */
    function wp_gotowebinar_force_check_for_updates(){
        global $plugin_update_checker_wp_gotowebinar;
        
        $plugin_update_checker_wp_gotowebinar->checkForUpdates();
    }

}


//this common function checks whether to include or exclude the webinar in the shortcode and returns true or false
//its a pretty boring function with a whole bunch of if conditions
function wp_gotowebinar_include_exclude_check($shortcodeData,$webinarTitle,$includeExclude){


    
    //first if the short data is blank lets return true
    if($shortcodeData==''){
                
        return true;
    }
    
    //lets check if the shortcode data contains AND or OR statements
    if(strpos($shortcodeData, 'AND') !== false){
                
        $andArray = explode('AND',$shortcodeData);
        $countOfItemsInArray = count($andArray);
        $countOfConditionsMet = 0;
        
        foreach($andArray as $condition){
            if(strpos($webinarTitle,$condition) !== false){
                $countOfConditionsMet++;    
            } 
        }
        
        if($includeExclude == 'include'){
            //do include condition
            if($countOfItemsInArray == $countOfConditionsMet){
                return true;      
            } else {
                return false;    
            }
        } else {
            //do exclude condition
            if($countOfItemsInArray == $countOfConditionsMet){
                return false;      
            } else {
                return true;    
            }       
        }
  
    } elseif (strpos($shortcodeData, 'OR') !== false){
                
        $orArray = explode('OR',$shortcodeData);     
        
        $countOfConditionsMet = 0;
        
        foreach($orArray as $condition){
            if(strpos($webinarTitle,$condition) !== false){
                $countOfConditionsMet++;    
            } 
        }

        if($includeExclude == 'include'){
            //do include condition      
            if($countOfConditionsMet > 0){
                                
                return true;      
            } else {
                                
                return false;    
            }
        } else {
            //do exclude condition
            if($countOfConditionsMet > 0){
                return false;      
            } else {
                return true;    
            }       
        }  
    } else {
        
        
        
        if($includeExclude == 'include'){
            //include condition
            if(strpos($webinarTitle,$shortcodeData) !== false){
                return true;
            } else {
                return false;    
            }
            
        } else {
            //exclude condition    
            if(strpos($webinarTitle,$shortcodeData) !== false){
                return false;
            } else {
                
                
                return true; 
                
                
            }
        }
    }
    
}


//common function to check timezone
function wp_gotowebinar_timezone_check($shortcodeData,$webinarTimezone){
    
    //if the shortcode is blank return true
    if($shortcodeData == '' || $shortcodeData == 'Show All'){
        return true;
    }
    
    if(strpos($webinarTimezone,$shortcodeData) !== false){
        return true;    
    } else {
        return false;
    }
    
    
}


//common function hide parts of the title of a webinar
function wp_gotowebinar_hide_from_title($hideData,$webinarTitle){
    
    if($hideData == ''){
        return $webinarTitle;
    }
    
    if(strpos($hideData, 'AND') !== false) {
        $andArray = explode('AND',$hideData); 
        
        foreach($andArray as $condition){
            $webinarTitle = str_replace($condition,"",$webinarTitle);        
        }
        
        return $webinarTitle;
        
    } else {
        //theres no and so do a simple replace
        return str_replace($hideData,"",$webinarTitle);
    }
    
    
}




//common function to get access token and update the refresh token in the settings with the new refresh token
function wp_gotowebinar_get_access_and_refresh_token() {
    
    
    //first we need to get the transient, if the transient exists use that for the authorisation and organiser key
    $getTransient = get_transient('gotowebinar_auth_settings');
    
    //if the transient exists
    if ($getTransient != false){
        
        //if transient exists get the current transient
        
        //explode the transient
        $explodedTransient = explode("|", $getTransient);
        
        return array($explodedTransient[0],$explodedTransient[1]);

    } else {

        
        //the transient doesn't exist therefore do api call

        $pluginSettings = get_option('gotowebinar_auth_settings');

        //current refresh token
        $currentRefreshToken = $pluginSettings['refresh_token'];


        //do response
        $response = wp_remote_post( 'https://api.getgo.com/oauth/v2/token', array(
            'headers' => array(
                'Authorization' => 'Basic '.wp_gotowebinar_get_authorization(),
                'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
            ),
            'body' => array(
                'refresh_token' => $currentRefreshToken,
                'grant_type' => 'refresh_token',
            ),
        ));

        if ( ! is_wp_error( $response ) ) {
            // The request went through successfully, check the response code against
            // what we're expecting
            if ( 200 == wp_remote_retrieve_response_code( $response ) ) {


                //get new acess token and refresh token

                $jsondata = json_decode($response['body'],true); 

                $newAccessToken = $jsondata['access_token'];
                $newRefreshToken = $jsondata['refresh_token'];
                $organizerKey = $jsondata['organizer_key'];
                $accountKey = $jsondata['account_key'];

                //now we need to update the settings
                //set the new values from the existing array
                $pluginSettings['access_token'] = $newAccessToken;
                $pluginSettings['refresh_token'] = $newRefreshToken;
                $pluginSettings['organizer_key'] = $organizerKey;
                $pluginSettings['account_key'] = $accountKey;
                
                //update the option
                update_option('gotowebinar_auth_settings', $pluginSettings);
                
                //set the transient
                //we will make this transient expire just before 60 minutes
                set_transient( 'gotowebinar_auth_settings',$newAccessToken.'|'.$organizerKey,60*50);

                //add to connection log
                wp_gotowebinar_connection_log(wp_remote_retrieve_response_code($response).' Success');
                
                //return the array
                return array($newAccessToken,$organizerKey);


            } else {
                //we can put some diagnostic info here if we wanted to
                //add to connection log
                // $error_message = wp_remote_retrieve_response_message( $response );

                //the below code gives us a heaps better description as it's from the GoToWebinar server
                $jsondata = json_decode($response['body'],true); 
                $errorTitle = $jsondata['error'];
                $errorDescription = $jsondata['error_description'];

                wp_gotowebinar_connection_log(wp_remote_retrieve_response_code($response).' '.$errorTitle.' - '.$errorDescription);
            }
        } else {
            //we can put some diagnostic info here if we wanted to
            //add to connection log
            $error_message = $response->get_error_message();
            wp_gotowebinar_connection_log(wp_remote_retrieve_response_code($response).' '.$error_message);
        } 

        
     
    } //end else

} //end function



function wp_gotowebinar_connection_log($message){

    //add item to log
    $currentTime = current_time('timestamp');
    $currentTimeInNiceFormat = date('d/m/Y H:i',$currentTime);


    //get current log
    $existingLog = get_option('gotowebinar_connection_log');

    if($existingLog == false){
        $existingLog = array();    
    }

    //if the array length is greater than 200 then lets remove the first item
    if(count($existingLog) > 200){
        array_shift($existingLog);    
    }   

    //now lets add our new item to the log
    array_push($existingLog,array($currentTimeInNiceFormat,$message));

    //update the setting
    update_option('gotowebinar_connection_log',$existingLog);


}





function wp_gotowebinar_get_access_and_refresh_token_call(){
    
    
    $implodeResult = implode('|',wp_gotowebinar_get_access_and_refresh_token());
    
    echo $implodeResult;

    wp_die();   
} 

add_action( 'wp_ajax_get_access_and_refresh_token', 'wp_gotowebinar_get_access_and_refresh_token_call' );



//function used to get different authentication depending on pro vs free
function wp_gotowebinar_get_authorization(){

    //first lets check if they have created a custom application, if they have let create that authrisation
    $options = get_option('gotowebinar_settings');   
    $consumerKey = trim($options['gotowebinar_consumer_key']);
    $consumerSecret = trim($options['gotowebinar_consumer_secret']);

    if( isset($consumerKey) && isset($consumerSecret) && strlen($consumerKey)> 0 &&  strlen($consumerSecret)> 0  ){

        return base64_encode($consumerKey.':'.$consumerSecret );

    } else {

        global $gotowebinar_is_pro;

        if($gotowebinar_is_pro == 'YES'){
            return 'V2lPUERtSXB0RFdudVRBZUtLbm9hUXpSQ2VxdHlwZjE6dmdYWEROb2RvQkJ6ZWNYUw==';
        } else {
            return 'bVhnZEFtelZzOWxHVmJFQ0dyVVQyaWVaZVBvVm1oNHo6VXVncUd5b1U0U3JBc3V5SA==';    
        }
    }
    
}




//Function to run upon ajax request to get the access token and store it in the plugin settings and to set a transient
function wp_gotowebinar_save_authentication_details() {
	
    //get the code field
    $code = $_POST['code'];
    

    // echo wp_gotowebinar_get_authorization();

    $response = wp_remote_post( 'https://api.getgo.com/oauth/v2/token', array(
        'headers' => array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
            'Authorization' => 'Basic '.wp_gotowebinar_get_authorization(),
            'Accept' => 'application/json',
        ),
        'body' => array(
            'code' => $code,
            'grant_type' => 'authorization_code',
        ),
    ) );

    if ( ! is_wp_error( $response ) ) {
        // The request went through successfully, check the response code against
        // what we're expecting
        if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
            
            //lets get the response and decode it
            $jsondata = json_decode($response['body'],true); 
            
            //lets pull our key variables from the response
            $access_token = $jsondata['access_token'];
            $refresh_token = $jsondata['refresh_token'];
            $organizer_key = $jsondata['organizer_key'];
            $accountKey = $jsondata['account_key'];
            
            //lets create an array which will store our updated settings
            $newPluginSettings = array();

            //lets add our fields to the array
            $newPluginSettings['organizer_key'] = $organizer_key;
            $newPluginSettings['access_token'] = $access_token;
            $newPluginSettings['refresh_token'] = $refresh_token;
            $newPluginSettings['account_key'] = $accountKey;
            
            
            //update the options
            update_option('gotowebinar_auth_settings', $newPluginSettings);

            //set the transient
            set_transient( 'gotowebinar_auth_settings',$access_token.'|'.$organizer_key,60*50);

            wp_gotowebinar_connection_log(wp_remote_retrieve_response_code($response).' Success');


            echo 'SUCCESS';
            wp_die(); 

        } else {
            // The response code was not what we were expecting, record the message

            $jsondata = json_decode($response['body'],true); 
            $errorTitle = $jsondata['error'];
            $errorDescription = $jsondata['error_description'];

            wp_gotowebinar_connection_log(wp_remote_retrieve_response_code($response).' '.$errorTitle.' - '.$errorDescription);

            $error_message = wp_remote_retrieve_response_message( $response );
            
            echo wp_remote_retrieve_response_code( $response ).' - '.$error_message.' - '.$errorTitle.' - '.$errorDescription;            


            wp_die();  
            
        }
    } else {
        // There was an error making the request
        $error_message = $response->get_error_message();

        wp_gotowebinar_connection_log(wp_remote_retrieve_response_code($response).' '.$error_message);
        
        echo wp_remote_retrieve_response_code($response).' '.$error_message;
        wp_die();
    }

   
}
add_action( 'wp_ajax_save_authentication_details_gotowebinar', 'wp_gotowebinar_save_authentication_details' );












//add notice about the update
function wp_gotowebinar_display_important_update_warning() {
   
    //check plugin options to see if it exists and keep displaying option until new option is saved
    if(get_option('gotowebinar_auth_settings') == false){
        $pluginSettingsPage = admin_url( 'options-general.php?page=wp-gotowebinar');
    
        ?>
        <div data-dismissible="wp-gotowebinar-notice-forever" class="notice notice-error is-dismissible">

            <h2><?php _e( 'IMPORTANT INFORMATION ABOUT THE WP GOTOWEBINAR PLUGIN UPDATE - PLEASE READ!', 'wp-gotowebinar' ); ?></h2>

            <p><?php _e( 'Thanks for updating WP GoToWebinar. Due to the GoToWebinar API upgrade the authentication process for this plugin has needed to be re-written. It is critical that you now reauthenticate the plugin immidiately by going to the <a href="'.$pluginSettingsPage.'">plugin settings</a> and clicking on the new "CLICK HERE TO CONNECT WITH GOTOWEBINAR" button, otherwise plugin features will be broken and potentially front end pages may not display correctly. If you should experience issues due to the uprade please try re-authenticating again and if this does not work please create a post on the <a target="_blank" href="https://wordpress.org/support/plugin/wp-gotowebinar">forum</a>.', 'wp-gotowebinar' ); ?></p>
        </div>
        <?php    
        
    }
    
}



//standard date and time display functions
function wp_gotowebinar_date_format() {

    $options = get_option('gotowebinar_settings');

    if(isset($options['gotowebinar_date_format'])){

        if($options['gotowebinar_date_format'] == 'wordpress'){
            $date_format = get_option('date_format');
        } else {
            $date_format = $options['gotowebinar_date_format']; 
        }

    } else {
        $date_format = "j/n/Y";    
    }

    return $date_format;

}

function wp_gotowebinar_time_format() {

    $options = get_option('gotowebinar_settings');

    if(isset($options['gotowebinar_time_format'])){

        if($options['gotowebinar_time_format'] == 'wordpress'){
            $time_format = get_option('time_format');
        } else {
            $time_format = $options['gotowebinar_time_format']; 
        }

    } else {
        $time_format = "g:ia T";    
    }

    return $time_format;

}






?>