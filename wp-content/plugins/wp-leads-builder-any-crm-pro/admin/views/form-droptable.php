<?php
/**
 * WP Leads Builder For Any CRM.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly
?>

<?php
    echo '<br>';   
    $droptable_config = get_option( "wp_droptablepro_settings" );
    // $captcha = SM_LB_URL ;
?>

<div class="panel" style="width: 98%;margin-top: 50px" id="all_addons_view" >
<div class="panel-body">
	<h4>Drop Table</h4>
    <small class="text-muted" style="margin-left:30px">If enabled plugin deactivation will remove plugin data, this cannot be restored.</small>
    <input value="<?php echo esc_attr__('Drop' , 'wp-leads-builder-any-crm-pro' );?>" onclick="drop_table_key();" id="droptable" type='checkbox' class="tgl tgl-skewed noicheck smack-vtiger-settings-text" name='droptable' <?php if(isset($droptable_config['droptable']) && sanitize_text_field($droptable_config['droptable']) == 'on') { echo "checked=checked"; } ?> onclick="droptable(this.id)" />
        <label  id="innertext" data-tg-off="OFF" data-tg-on="ON" for="droptable"  class="tgl-btn" style="font-size: 16px;margin-left:15px" >
        </label>        
</div>	

</div>

