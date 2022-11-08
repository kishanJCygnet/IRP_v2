<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2016 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
global $wpdb;
$active_plugin = get_option('WpLeadBuilderProActivatedPlugin');

$check_shortcode = $wpdb->get_results( $wpdb->prepare("select shortcode_name from wp_smackleadbulider_shortcode_manager where crm_type=%s", $active_plugin));
$check_field_manager = $wpdb->get_results( $wpdb->prepare("select field_name from wp_smackleadbulider_field_manager where crm_type=%s", $active_plugin));
$count_shortcode=0;
$count_shortcode = count($check_shortcode);
   if( !empty( $check_field_manager)){
         if( $count_shortcode>1 ){
                $shortcode_available = 'yes';
        }else{
                $shortcode_available = 'no';
        }
}else{
        $shortcode_available = 'yes';
}
echo "<input type='hidden' id='check_shortcode_availability' value='$shortcode_available'>";
echo "<input type='hidden' id='count_shortcode' value='$count_shortcode'>";
//END
$config = get_option("wp_{$active_plugin}_settings");

if( $config == "" )
{
        $config_data = 'no';
}
else
{
        $config_data = 'yes';
}

$site_url = site_url();
$page_scheme = parse_url($site_url,PHP_URL_SCHEME);
$sales = $page_scheme."://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$sales_url = trim( strtok( $sales , '?' ));
$sales_query_string = $_SERVER['QUERY_STRING'] ;
$remove_code = remove_query_arg( 'code' , $sales_query_string );
$sales_callback_url = site_url().'/wp-admin/admin.php?page=lb-crmconfig';

if(isset( $_REQUEST['code'] ) && (sanitize_text_field($_REQUEST['code']) != '') && !isset($config['id_token']) )
{
  //http://wordpress.playground.com:8888/wordpress5.2/leadsbuilderpro/wp-admin/admin.php?page=lb-crmconfig&code=1000.e057bd55449a2ad9dd0cd87396727ed9.fd28b2d4be25a5be73c85ce78b4e9e39&location=us&accounts-server=https%3A%2F%2Faccounts.zoho.com
  // $config['access_token'] = '';
  // $config['refresh_token'] = '';
  // $config['key'] = $
  // $config['callback'] = 
  // $config['secret'] = 
  //update_option('wp_wpzohopro_settings', $config);  
  include_once(SM_LB_PRO_DIR."lib/SmackZohoApi.php");
  $code = sanitize_text_field( $_REQUEST['code'] );
 
  if(empty($config['refresh_token'])){

    $test=new SmackZohoApi();
    $response =$test->ZohoGet_Getaccess( $config , $code);
    $access_token = $response['access_token'];
    $refresh_token = $response['refresh_token'];

    if (!isset($access_token) || $access_token == "") {
    }
    $url = isset($instance_url) ? $instance_url : ''; 
    $_SESSION['access_token'] = $access_token;
    $_SESSION['instance_url'] = $url;
    $config['access_token'] = $access_token;
    $config['refresh_token'] = $refresh_token;
    $config['api_domain'] = $response['api_domain'];
    update_option("wp_{$active_plugin}_settings" , $config );
  }
}

$siteurl = site_url(); 
$help_img = SM_LB_PRO_DIR."assets/images/help.png";
$callout_img = SM_LB_PRO_DIR."assets/images/callout.gif";
$help="<img src='$help_img'>";
$call="<img src='$callout_img'>";
?>
<div class="mt20">
 <div class="form-group col-md-5 col-md-offset-7">    
        <div class="col-md-6">
            <label id="inneroptions" class="leads-builder-crm" style="margin-left:18%"><?php echo esc_html__('Select the CRM you use', 'wp-leads-builder-any-crm' ); ?></label>
        </div>
        <div class="col-md-5">          
            <?php $ContactFormPluginsObj = new ContactFormPROPlugins();
        echo $ContactFormPluginsObj->getPluginActivationHtml();
          ?>
        </div>
</div><!-- form group close -->
</div>  
<div class="clearfix"></div>      
<div>
  <div class="panel" style="width:98%;">
    <div class="panel-body">
  <img src="<?php echo esc_url($siteurl); ?>/wp-content/plugins/wp-leads-builder-any-crm-pro/assets/images/zoho-crm.png" width=100 height=42>
         <input type="hidden" id="get_config" value="<?php echo $config_data ?>" >
         <span id="save_config" style="font:14px;width:200px;">
         </span>

<script>
  jQuery( document ).ready( function( ) {
    //save_zoho_settings('callback', "<?php echo $sales_callback_url ;?>");
  });
</script>
         <input type="hidden" id="revert_old_crm_pro" value="wpsalesforcepro">
        <form id="smack-salesforce-settings-form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
            <input type="hidden" name="smack-salesforce-settings-form" value="smack-salesforce-settings-form" />
           <input type="hidden" id="plug_URL" value="<?php echo esc_url(SM_LB_URL);?>" />
           <!-- <div class="wp-common-crm-content" style="width: 1000px;float: left;"> -->
<div class="clearfix"></div>
<hr> 
    <div class="mt30">
        <div class="form-group col-md-12">              
            <label id="inneroptions" class="leads-builder-heading" style="margin-left:0">Zoho CRM Settings</label>
        </div>
    </div>

<div class="clearfix"></div>  
<div class="mt20">
    <div class="form-group col-md-12">
        <div class="col-md-2">
            <label id="innertext" class="leads-builder-label"> <?php echo esc_attr__('Client ID', 'wp-leads-builder-any-crm' ); ?>  </label>
        </div>
        <div class="col-md-3">
            <input type='text' class='smack-vtiger-settings form-control' name='key' id='smack_host_address' value="<?php echo isset($config['key']) ? $config['key'] : '' ?>" />
                 <div style="position:relative;top:-20px;margin-left:197px;">
           <div class="tooltip">
        <?php echo $help ?> <span class="tooltipPostStatus"><h5>Consumer Key</h5>Get the Consumer Key from your Salesforce account and specify here.
                 <a target="_blank" href="https://help.salesforce.com/apex/HTViewSolution?id=000205876&language=en_US">Refer Salesforce help</a></span> 
                 </div>
         </div>
        </div>
        <div class="col-md-2">
            <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('Client Secret', 'wp-leads-builder-any-crm' ); ?> </label>
        </div>
        <div class="col-md-3">
           <input type='password' class='smack-vtiger-settings form-control' name='secret' id='smack_host_username' value="<?php echo isset($config['secret']) ? $config['secret'] : '' ?>" />
          <div style="position:relative;top:-20px;margin-left:197px;">
            <div class="tooltip">
            <?php echo $help ?>
                                <span class="tooltipPostStatus" style="width:330px;">
                                <h5>Consumer Secret</h5>Get the Consumer Secret from your Salesforce account and specify here. 
                 <a target="_blank" href="https://help.salesforce.com/apex/HTViewSolution?id=000205876&language=en_US">Refer Salesforce Help</a></span> 
                 </div>
          </div>
        </div>
    </div> 
   <div class="clearfix"></div> 
    <div class="form-group col-md-12">
        <div class="col-md-2">
            <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('Authorized redirect URIs' , 'wp-leads-builder-any-crm' ); ?> </label>
        </div>
        <div class="col-md-8">
            <input type='text' class='smack-vtiger-settings form-control' name='callback'  id='copy_smack_host_access_key' value="<?php echo esc_url($sales_callback_url); ?>"  disabled="disabled"/>
        </div>    
<!-- 

<?php echo esc_url($sales_callback_url); ?>
-->     
        <div>
      <img src="<?php echo esc_url($siteurl); ?>/wp-content/plugins/wp-leads-builder-any-crm-pro/assets/images/copy.png" id="copy_to_clipboard" value="Copy"  data-clipboard-action="copy" data-clipboard-target="#copy_smack_host_access_key">
    </div>  
      
    </div>


    <div class="clearfix"></div> 
    <div class="form-group col-md-12">
    <div class="col-md-2">
    <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('Available Domains' , 'wp-leads-builder-any-crm' ); ?> </label>
    </div>
    <div class="col-md-8">
    <?php $config = get_option("wp_{$active_plugin}_settings"); ?>

    <select name='domainselect' id ='domainselect' class='smack-vtiger-settings form-control'/>
      
    <optgroup label='Available Domains'>
      <option value='.com'<?php  if($config['domain'] == '.com'): ?> selected=selected<?php endif; ?>> zoho.com </option>	
      <option value='.in'<?php if($config['domain'] == '.in'): ?> selected=selected<?php endif; ?>> zoho.in </option>
      <option value='.eu'<?php if($config['domain'] == '.eu'): ?> selected=selected<?php endif; ?>> zoho.eu </option>
      <option value='.au'<?php if($config['domain'] == '.au'): ?> selected=selected<?php endif; ?>> zoho.au </option>		
    </optgroup>	
    </select>
    </div> 
    </div>


</div> <!--label hole div mt close --> 
 
    <div class="clearfix"></div>
  
    <input type="hidden" id="posted" name="posted" value="<?php echo 'posted';?>">
    <input type="hidden" id="site_url" name="site_url" value="<?php echo esc_attr($siteurl) ;?>">
    <input type="hidden" id="active_plugin" name="active_plugin" value="<?php echo esc_attr($active_plugin); ?>">
    <input type="hidden" id="leads_fields_tmp" name="leads_fields_tmp" value="smack_wpsalesforcepro_leads_fields-tmp">
    <input type="hidden" id="contact_fields_tmp" name="contact_fields_tmp" value="smack_wpsalesforcepro_contacts_fields-tmp">
    <div class="col-md-12">
    <?php if(empty($config['refresh_token'])) {?>
        <div class="col-md-offset-8"><span>
    <!-- <a class="call-back-btn-authentication" href="<?php //echo "$auth_url"?>" > -->
      <input name="button" type="button" value="<?php echo esc_attr__('Save and Authenticate' , 'wp-leads-builder-any-crm' ); ?>" class="smack-btn smack-btn-primary btn-radius" onclick="saveZOHOCRMAPICredentials()"  /> <!-- </a> -->
       </span></div>
       <?php } else { ?>
       <div class="col-md-offset-9">
             <span><input type="button" id="Save_crm_config" value="<?php echo esc_attr__('Save CRM Configuration' , 'wp-leads-builder-any-crm' );?>" id="save"  class="smack-btn smack-btn-primary btn-radius"  onclick="saveCRMConfiguration(this.id);" />
         </span></div>
       <?php } ?>
  </div>
  <!--<div class="mt30">
     <label class="sf-crm-note"><?php echo esc_html__('Note : The included API add-on supports only Enterprise edition, Unlimited edition and Developer edition of sales force.' , 'wp-leads-builder-any-crm'  ); ?></label>
     </div> --> 


     
     </form>


     <div id="loading-sync" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm/assets/images/ajax-loaders.gif) no-repeat center"><?php echo esc_html__('' , 'wp-leads-builder-any-crm' ); ?></div>
<div id="loading-image" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm/assets/images/ajax-loaders.gif) no-repeat center"><?php echo esc_html__('' , 'wp-leads-builder-any-crm' ); ?></div>



    </div>
  </div>
</div>  
