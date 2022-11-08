<?php

/******************************************************************************************
 * Copyright (C) Smackcoders 2016 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

$active_plugin = get_option('WpLeadBuilderProActivatedPlugin');
$config = get_option("wp_{$active_plugin}_settings");
$app_url = isset($config['domain_url']) ? sanitize_text_field($config['domain_url']) : '';
$user = isset($config['username']) ? sanitize_text_field($config['username']) : '';
$pass = isset($config['password']) ? sanitize_text_field($config['password']) : '';

if( $config == "" )
{
        $config_data = 'no';
}
else
{
        $config_data = 'yes';
}

$siteurl = site_url();
?>
<div class="mt20">
 <div class="form-group col-md-5 col-md-offset-7">    
        <div class="col-md-6">
            <label id="inneroptions" class="leads-builder-crm" style="margin-left:18%"><?php echo esc_html__('Select the CRM you use', 'wp-leads-builder-any-crm-pro' ); ?></label>
        </div>
        <div class="col-md-5">          
            <?php $ContactFormPluginsObj = new ContactFormPROPlugins();echo $ContactFormPluginsObj->getPluginActivationHtml();
          ?>
        </div>
</div><!-- form group close -->
</div>  
<div class="clearfix"></div>      
<div class="">
  <div class="panel" style="width:98%;">
    <div class="panel-body">
	<img src="<?php echo SM_LB_DIR?>assets/images/freshsales-logo.png" width=168 height=42>
    <input type="hidden" id="get_config" value="<?php echo $config_data ?>" >
    <span id="save_config" style="font:14px;width:200px;">
    </span>
    <input type="hidden" id="get_config" value="<?php echo $config_data ?>" >
    <input type="hidden" id="revert_old_crm_pro" value="wpsalesforcepro">
    <form id="smack-salesforce-settings-form" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
    <input type="hidden" name="smack-salesforce-settings-form" value="smack-salesforce-settings-form" />
	<input type="hidden" id="plug_URL" value="<?php echo esc_url(SM_LB_URL);?>" />
	<!-- <div class="wp-common-crm-content" style="width: 900px;float: left;"> -->
<!-- <div class="form-group">
   <div class="col-md-3 col-md-offset-3">
      <label id="inneroptions" class="leads-builder-heading" ><?php echo esc_html__('Select the CRM you use', 'wp-leads-builder-any-crm-pro' ); ?></label>
    </div>
     <div class="col-md-3">
        <?php $ContactFormPluginsObj = new ContactFormPROPlugins();echo $ContactFormPluginsObj->getPluginActivationHtml();
					?>
	</div>
</div> -->
<div class="clearfix"></div>
<hr>
<div class="mt30"> 
  <div class="form-group col-md-12">  
    <label id="inneroptions" class="leads-builder-heading" style="margin-left:0">Freshsales CRM Settings
    </label>
  </div>
</div>
<div class="clearfix"></div>
<div class="mt20">  
<div class="form-group col-md-12">
   <div class="col-md-2 label-space">
       <label id="innertext" class="leads-builder-label"> <?php echo esc_html__('Domain URL', 'wp-leads-builder-any-crm-pro' ); ?> </label>
    </div>
    <div class="col-md-8">   
        <input type='text' class='smack-vtiger-settings form-control'  name='domain_url' id='domain_url' value="<?php echo $app_url ?>" />
    </div>    
</div>
<div class="form-group col-md-12">
   <div class="col-md-2 label-space">
       <label id="innertext" class="leads-builder-label"> <?php echo esc_attr__('Username', 'wp-leads-builder-any-crm-pro' ); ?>  </label>
    </div>
    <div class="col-md-3">   
       <input type='text' class='smack-vtiger-settings form-control' name='username' id='username' value="<?php echo $user ?>" />
    </div> 
    <div class="col-md-2 label-space">
       <label id="innertext" class="leads-builder-label"> <?php echo esc_attr__('Password', 'wp-leads-builder-any-crm-pro' ); ?>  </label>
    </div>
    <div class="col-md-3">   
       <input type='password' class='smack-vtiger-settings form-control' name='password' id='password' value="<?php echo $pass ?>" />
    </div>      
</div>
</div>
    <input type="hidden" id="posted" name="posted" value="<?php echo 'posted';?>">
		<input type="hidden" id="site_url" name="site_url" value="<?php echo esc_attr($siteurl) ;?>">
    <input type="hidden" id="active_plugin" name="active_plugin" value="<?php echo esc_attr($active_plugin); ?>">
    <input type="hidden" id="leads_fields_tmp" name="leads_fields_tmp" value="smack_freshsales_leads_fields-tmp">
    <input type="hidden" id="contact_fields_tmp" name="contact_fields_tmp" value="smack_freshsales_contacts_fields-tmp">
<div class="col-md-offset-9">            		
	<span>
      <input type="button" id="Save_crm_config" value="<?php echo esc_attr__('Save CRM Configuration' , 'wp-leads-builder-any-crm-pro' );?>" id="save"  class="smack-btn smack-btn-primary btn-radius" onclick="saveCRMConfiguration(this.id);" />
		</span> 
</div>			
<!-- </div> wp-common-crm-content -->
</form>
<div id="loading-sync" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm-pro/assets/images/ajax-loaders.gif) no-repeat center"><?php echo esc_html__('' , 'wp-leads-builder-any-crm-pro' ); ?></div>
<div id="loading-image" style="display: none; background:url(<?php echo esc_url(WP_PLUGIN_URL);?>/wp-leads-builder-any-crm-pro/assets/images/ajax-loaders.gif) no-repeat center"><?php echo esc_html__('' , 'wp-leads-builder-any-crm-pro' ); ?></div>
    </div>
  </div>
</div>     


