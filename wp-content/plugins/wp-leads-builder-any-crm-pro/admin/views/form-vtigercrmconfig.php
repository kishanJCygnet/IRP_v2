<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
 
global $wpdb;
$siteurl = site_url();
$siteurl = esc_url( $siteurl );
$active_plugin = get_option('WpLeadBuilderProActivatedPlugin');
$config = get_option("wp_{$active_plugin}_settings");
$app_url = isset($config['url']) ? esc_url($config['url']) : '';
$user = isset($config['username']) ? sanitize_text_field($config['username']) : '';
$pass = isset($config['accesskey']) ? sanitize_text_field($config['accesskey']) : '';
if( $config == "" )
{
        $config_data = 'no';
}
else
{
        $config_data = 'yes';
}

?>
<div class="mt20">
 <div class="form-group col-md-5 col-md-offset-7">    
        <div class="col-md-6">
            <label id="inneroptions" class="leads-builder-crm" style="margin-left:18%"><?php echo esc_html__("Select the CRM you use " , "wp-leads-builder-any-crm-pro" ); ?>
            </label>
        </div>
        <div class="col-md-5">          
            <?php $ContactFormPluginsObj = new ContactFormPROPlugins();echo $ContactFormPluginsObj->getPluginActivationHtml();?>
        </div>
</div><!-- form group close -->
</div>  
<div class="clearfix"></div>      
<div>
  <div class="panel" style="width:98%;">
    <div class="panel-body">
	<img src="<?php echo SM_LB_DIR?>assets/images/vtiger-logo.png" width=168 height=42>
      <!-- <div class="form-group">    
        <div class="col-md-3 col-md-offset-3">
            <label id="inneroptions" class="leads-builder-heading"><?php echo esc_html__("Select the CRM you use " , "wp-leads-builder-any-crm-pro" ); ?>
            </label>
        </div> -->
        <div>
            <!--<div id="loading-image" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm-pro/images/ajax-loaders.gif) no-repeat center #fff;"><?php echo esc_html__("Please Wait" , "wp-leads-builder-any-crm-pro" ); ?>...</div> -->
			<input type="hidden" id="plug_URL" value="<?php echo esc_url(SM_LB_URL);?>" />
        </div>
        <!-- <div class="col-md-3">			
            <?php $ContactFormPluginsObj = new ContactFormPROPlugins();echo $ContactFormPluginsObj->getPluginActivationHtml();?>
        </div>
      </div> --><!-- form group close -->
    <input type="hidden" id="get_config" value="<?php echo $config_data ?>" >
    <input type="hidden" id="revert_old_crm_pro" value="wptigerpro">
    <span id="save_config" style="font:14px;width:200px;">
    </span>
<div>
<!--  Start -->
         <form id="smack-vtiger-settings-form" action="" method="post">
                <input type="hidden" name="smack-vtiger-settings-form" value="smack-vtiger-settings-form" />
                <input type="hidden" id="plug_URL" value="<?php echo esc_url(SM_LB_URL);?>" />
                <!-- <div class="wp-common-crm-content" style="width: 900px;float: left;"> -->
<div class="clearfix"></div>
    <hr> 
  <div class="mt30">
    <div class="form-group col-md-12">              
        <label id="inneroptions" class="leads-builder-heading" style="margin-left:0">VTiger CRM Settings</label>
    </div>
  </div>
<div class="clearfix"></div>  
 <div class="mt20">   
    <div class="form-group col-md-12">
        <div class="col-md-2 label-space">
            <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('CRM Url' , "wp-leads-builder-any-crm-pro" ); ?> </label>
        </div>
        <div class="col-md-8">
            <input type='text' class='smack-vtiger-settings form-control' name='url' id='smack_tiger_host_address'  value="<?php echo $app_url ?>"/>
        </div>
    </div> 
<div class="form-group col-md-12">
        <div class="col-md-2 label-space">
            <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('Username' , "wp-leads-builder-any-crm-pro" ); ?> </label>
        </div>
        <div class="col-md-3">
            <input type='text' class='smack-vtiger-settings form-control' name='username' id='smack_host_username' value="<?php echo $user ?>"/>
        </div>
        <div class="col-md-2 label-space">
            <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('Access Key' , "wp-leads-builder-any-crm-pro" ); ?> </label>
        </div>
        <div class="col-md-3">
            <input type='text' class='smack-vtiger-settings form-control' name='accesskey' id='smack_host_access_key' value="<?php echo $pass ?>"/>  
        </div>
    </div> 
</div>
    
    <input type="hidden" name="posted" value="<?php echo 'posted';?>">
	<input type="hidden" id="site_url" name="site_url" value="<?php echo esc_attr($siteurl) ;?>">
	<input type="hidden" id="active_plugin" name="active_plugin" value="<?php echo esc_attr($active_plugin); ?>">
	<input type="hidden" id="leads_fields_tmp" name="leads_fields_tmp" value="smack_wptigerpro_leads_fields-tmp">
	<input type="hidden" id="contact_fields_tmp" name="contact_fields_tmp" value="smack_wptigerpro_contacts_fields-tmp">
<div class="col-md-offset-9">
	<span id="SaveCRMConfig">
            <input type="button" value="<?php echo esc_attr__('Save CRM Configuration' , "wp-leads-builder-any-crm-pro" );?>" id="save" class="smack-btn smack-btn-primary btn-radius" onclick="saveCRMConfiguration(this.id);" />
        </span>
</div>
<!-- </div> -->
</form>
</div>	   <!-- End-->
<div id="loading-sync" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm-pro/assets/images/ajax-loaders.gif) no-repeat center ;"><?php echo esc_html__('' , 'wp-leads-builder-any-crm-pro' ); ?></div>
<div id="loading-image" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm-pro/assets/images/ajax-loaders.gif) no-repeat center;"><?php echo esc_html__('' , "wp-leads-builder-any-crm-pro"  ); ?> </div>
</div>
</div>
</div>
