<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
global $time_zone_list; 
global $gotowebinar_is_pro;
$options = get_option('gotowebinar_settings');

?>

    <!-- start wrap -->
    <div class="wrap">
    <div id="poststuff">
        
    <!-- pro ad -->
    <?php if ($gotowebinar_is_pro != "YES"){ ?> 

    <div id="wp-gotowebinar-pro-ad">
        <div>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/M3rty3sV9lU?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            <div>
                
                <p>UPGRADE TO WP GOTOWEBINAR PRO - THE EASIEST WAY TO SELL WEBINARS&trade; <em>VIA <a href="https://woocommerce.com/" target="_blank">WOOCOMMERCE</a></em></p>
                
                <p>PLUS ADD REGISTRANTS TO:</br></p><p><em>
                <a href="http://www.activecampaign.com/" target="_blank">ACTIVECAMPAIGN</a>,
                <a href="https://www.agilecrm.com" target="_blank">AGILE CRM</a>,
                <a href="https://www.aweber.com/welcome.htm" target="_blank">AWEBER</a>,
                <a href="https://www.campaignmonitor.com/" target="_blank">CAMPAIGN MONITOR</a>, </br> 
                <a href="https://www.constantcontact.com/" target="_blank">CONSTANT CONTACT</a>,
                <a href="https://highrisehq.com" target="_blank">HIGHRISE CRM</a>, 
                <a href="https://www.hubspot.com/" target="_blank">HUBSPOT CRM</a>, 
                <a href="https://www.insightly.com/" target="_blank">INSIGHTLY CRM</a>, </br> 
                <a href="https://mailchimp.com/" target="_blank">MAILCHIMP</a>,
                <a href="https://www.pipedrive.com" target="_blank">PIPEDRIVE CRM</a>,
                <a href="https://www.salesforce.com" target="_blank">SALESFORCE CRM</a> &amp; 
                <a href="https://www.zoho.com/crm/" target="_blank">ZOHO CRM</a></em></p>      
                
                <p>INCREASE WEBINAR PARTICIPATION AND CONVERSIONS WITH THE NEW WEBINAR COUNTDOWN TOOLBAR</p>

                <a href="https://northernbeacheswebsites.com.au/wp-gotowebinar-pro/" target="_blank">LEARN MORE</a>
            </div>
        </div>

    </div>
    <?php } ?> 



        
    <!-- heading -->
    <?php if ($gotowebinar_is_pro == "YES"){ ?>  
        <h1><i class="fas fa-video" aria-hidden="true"></i> <?php esc_attr_e( 'WP GoToWebinar Pro Options', 'wp_admin_style' ); ?></h1>
        <?php } else { ?>
        <h1><i class="fas fa-video" aria-hidden="true"></i> <?php esc_attr_e( 'WP GoToWebinar Options', 'wp_admin_style' ); ?><a target="_blank" class="donate-button" href="https://northernbeacheswebsites.com.au/product/donate-to-northern-beaches-websites/">Donate now</a></h1>    
    <?php } ?>

   
        
        
    <!-- welcome note -->         
    <?php    
    if(!isset($options['gotowebinar_welcome_message'])) {
    ?>
    <div class="notice notice-warning is-dismissible wpgotowebinar-welcome">
        <h3>Quickstart Guide</h3>
        <p>Thanks for using WP GoToWebinar! The first thing you need to do to get started is to get your Authorization and Organizer Key which can be found in the <a class="open-tab" href="#general_options">General Options</a> tab. Once this is done you can now utilise the various plugin features. This includes adding an upcoming webinar table to a post or page by adding the <code>[gotowebinar]</code> shortcode to your page/post content (or if you want to show this in a sidebar use the included widget). To make the register links in the upcoming webinar table go to a registration page on your website create a new page and add the <code>[gotowebinar-reg]</code> shortcode to it and select this page in the settings on the <a class="open-tab" href="#general_options">General Options</a> tab.</p>
        <p>To learn more about all the great stuff you can do with WP GoToWebinar check out the <a class="open-tab" href="#faq">FAQ</a> tab.</p>
        
    </div>
    <?php } ?>    
        
<!--
    <div class="notice notice-error is-dismissible">

            <h2><?php //_e( 'CURRENT KNOWN ISSUE AROUND AUTHENTICATION', 'wp-gotowebinar' ); ?></h2>

            <p><?php //_e( 'We have recently ran into issues regarding hitting API limits with our GoToWebinar developer account. We have implemented a range of measures on the plugin to reduce the API burden caused by the plugin. We are currently monitoring the situation and in contact with GoToWebinar to ensure the plugin runs smoothly. If you should experience any issues around authentication please authenticate again. Alternatively you can downgrade the plugin by installing version 12.0 which uses the classic authentication method - but note you will need to eventually update the plugin because this authentication method will stop working on the 14/08/18. You can download this <a target="_blank" href="https://www.dropbox.com/s/mc2mnaspmen76cj/wp-gotowebinar.zip?dl=0">here</a>. Please use <a target="_blank" href="https://wordpress.org/support/topic/authentication-issue-400-bad-request/">this</a> support topic to see any updates regarding this issue - there\'s no need to create a new topic.', 'wp-gotowebinar' ); ?></p>
    </div>            
-->
        



    <?php
        
        //function to transform titles
        
        function wpgotowebinar_change_title($name){
            
            $nameToLowerCase = strtolower($name);
            $replaceSpaces = str_replace(' ', '_', $nameToLowerCase);    
            
            return $replaceSpaces;
            
        }
        
        
        //function to output tab titles
        function wpgotowebinar_output_tab_titles($name,$proFeature) {
            
            global $gotowebinar_is_pro;
            
            if ($gotowebinar_is_pro == "YES" && $proFeature == "YES"){ 
                $iconOutput = '<i class="fas fa-lock-open" aria-hidden="true"></i>';    
            } elseif ($proFeature == "YES") {
                $iconOutput = '<i class="fas fa-lock" aria-hidden="true"></i>'; 
            } else {
                $iconOutput = '';   
            }
         
            
            echo '<li><a class="nav-tab" href="#'.wpgotowebinar_change_title($name).'">'.$name.' '.$iconOutput.'</a></li>'; 
        }
        
        
        
        
        //function to output tab content
        function wpgotowebinar_tab_content ($tabName) {
            
            $transformedTitle = wpgotowebinar_change_title($tabName);
            
            ?>
            <div class="tab-content" id="<?php echo $transformedTitle; ?>">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <div class="inside">
                                <table class="form-table">
                                    <?php
                                    global $gotowebinar_is_pro;
                                    global $gotowebinar_pro_features;
            
                                    if($gotowebinar_is_pro != "YES" && $gotowebinar_pro_features[$tabName][0] == "YES") {
                                        
                                        settings_fields('locked');
                                        do_settings_sections('locked');     
                                        
                                    } else {
                                        
                                        if($transformedTitle == "support" && $gotowebinar_is_pro == "YES"){
                                            settings_fields('support_pro');
                                            do_settings_sections('support_pro');       
                                        } else {
                                            settings_fields($transformedTitle);
                                            do_settings_sections($transformedTitle);  
                                        }
                                            
                                        if($gotowebinar_pro_features[$tabName][1] == "YES"){
                                        ?>
                                        
                                        <table>
                                            <tr class="gotowebinar_settings_row">
                                                <td>
                                                    <button type="submit" name="submit" id="submit" class="button button-primary gotowebinar-save-all-settings-button"><?php _e('Save All Settings', 'wp-gotowebinar' ); ?></button>
                                                </td>
                                            </tr>    
                                        </table>    
                                        <?php    
                                        }
      
                                    }
                                    ?>
                                </table>
                             </div> <!-- .inside -->
                    </div> <!-- .postbox -->                      
                </div> <!-- .meta-box-sortables --> 
            </div> <!-- .tab-content -->  
            <?php
            
            
        }
    ?>    
    
 
        
        
        

    <!--start form-->    
    <form id="gotowebinar_settings_form" action="options.php" method="post">
       
        <div id="tabs" class="nav-tab-wrapper"> 
            <ul class="tab-titles">
                <?php 

                //declare pro and non pro options into an associative array
                global $gotowebinar_pro_features;

                foreach($gotowebinar_pro_features as $item => $value){

                    wpgotowebinar_output_tab_titles($item,$value[0]);
                }

                ?>

            </ul>

            <!--add tab content pages-->
            <?php

            global $gotowebinar_pro_features;

            foreach($gotowebinar_pro_features as $item => $value){
                wpgotowebinar_tab_content($item);     
            }
            ?>

        </div> <!--end tabs div-->         
    </form>
        
        


        
        
    
        
        <?php

        require('nbw.php');  

        echo northernbeacheswebsites_information();

        ?>
        
        
    </div> <!--end post stuff-->    
        
    </div> <!-- .wrap -->