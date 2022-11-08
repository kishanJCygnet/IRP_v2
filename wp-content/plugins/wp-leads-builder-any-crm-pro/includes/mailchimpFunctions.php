<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2016 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
        include_once(SM_LB_PRO_DIR.'lib/SmackMailchimp.php');
        class PROFunctions{
                
                public $accesskey;
                public $authtoken;
                public $url;
                public $result_emails;
                public $result_ids;
                public $result_products;
                public $domain;
                public function __construct(){
                        $this->activated_plugin = get_option("WpLeadBuilderProActivatedPlugin");
                        $Mailchimpconfig=get_option("wp_{$this->activated_plugin}_settings");
                        $this->dc=$Mailchimpconfig['dc'];
                        $this->token=$Mailchimpconfig['access_token'];
                        $this->client_id=$Mailchimpconfig['key'];
                        $this->client_secret=$Mailchimpconfig['secret'];
                }
                public function getCrmFields( $module ){
                        $client=new SmackMailchimp();
                        $WPCapture_includes_helper_Obj = new WPCapture_includes_helper_PRO();
                        $activateplugin = $WPCapture_includes_helper_Obj->ActivatedPlugin;
                        $SettingsConfig = get_option("wp_{$activateplugin}_settings");
                        $list=$client->getlist($module,$this->dc,$this->token);
                        $lists['id']=$list['id'];
                        $lists['name']=$list['name'];
                        $listid=$lists['id'];
                        $listname=$lists['name'];
                        global $wpdb;
                        $query=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}smackleadbuilder_mailchimp_lists");
                        foreach($query as $val){
                                $id=$val->id;  
                                
                        }
                        
                        if($id!=$listid){
                                $wpdb->insert("wp_smackleadbuilder_mailchimp_lists", array('id'=> $listid,'name'=>$listname));
                        }
                        $recordInfo=$client->getmemberfields($this->dc,$listid,$this->token);
                        $config_fields = array();
                        $config_fields['fields'][0]['name']="email_address";
                        $config_fields['fields'][0]['label']="Email Address";
                        $config_fields['fields'][0]['type']['name']="email";
                        $config_fields['fields'][0]['wp_mandatory'] = 1;
                        $config_fields['fields'][0]['mandatory'] = 2;
                        $config_fields['fields'][1]['name']="list";
                        $config_fields['fields'][1]['label']="List";
                        $config_fields['fields'][1]['type']['name']="text";
                        $config_fields['fields'][1]['wp_mandatory'] = 1;
                        $config_fields['fields'][1]['mandatory'] = 2;
                        $j=2;
                        
                        if(isset($recordInfo['merge_fields'])){
                                foreach($recordInfo['merge_fields'] as $key => $fields )
                                 {
                                        if($fields['tag']=='LNAME')
                                        {
                                                $fields['req']='true';
                                        }				
                                        if(isset($fields['req']) && $fields['req'] == 'true' )
                                        {
                                                $config_fields['fields'][$j]['wp_mandatory'] = 1;
                                                $config_fields['fields'][$j]['mandatory'] = 2;
                                        }
                                        else
                                        {
                                                $config_fields['fields'][$j]['wp_mandatory'] = 0;
                                        }
                                        $config_fields['fields'][$j]['name']=$fields['tag'];
                                        $config_fields['fields'][$j]['label']=$fields['name'];
                                        $config_fields['fields'][$j]['type']['name']=$fields['type'];
                                        $config_fields['fields'][$j]['publish'] = 1;
                                        $config_fields['fields'][$j]['order'] = $j;

                                        $j++;
                                }
                        
                                $config_fields['check_duplicate'] = 0;
                                $config_fields['isWidget'] = 0;
                                $config_fields['module'] = $module;
                                $users_list = $this->getUsersList();
                                $users  = isset($users_list) ? $users_list : '';
                                $usersid = isset($users['id']) ? $users['id'] : '';
                                $config_fields['assignedto'] = $usersid;
                                return $config_fields;
                                

                        }
                }
                public function getUsersList(){
                        $client=new SmackMailchimp();
                        $records = $client->Mailchimp_Getuser($this->dc,$this->token);  
                        $user=array();
                        $user['first_name']=$records['username'];
                        $user['id']=$records['login_id'];
                        $user['last_name']="";
                        $user['account_id']=$records['account_id'];
                        $user['user_name']=$records['username'];
             
                        return $user; 
                }
                public function getUsersListHtml( $shortcode = "" )
                  {
                        $HelperObj = new WPCapture_includes_helper_PRO();
                        $activatedplugin = $HelperObj->ActivatedPlugin;
                        $formObj = new CaptureData();
                        if(isset($shortcode) && ( $shortcode != "" ))
                        {
                                $config_fields = $formObj->getFormSettings( $shortcode );  // Get form settings 
                        }
                        $users_list = get_option('crm_users');
                        $users_list = $users_list[$activatedplugin];
                        $html = "";
                        $html = '<select class="form-control" name="assignedto" id="assignedto">';
                        $content_option = "";
                
                        
                        $content_option.="<option id='{$users_list['user_name']}' value='{$users_list['id']}'";
                        if($users_list['id'] == $config_fields->assigned_to)
                        {
                                $content_option.=" selected";
                        }
                        $content_option.=">{$users_list['user_name']}</option>";
                        $content_option .= "<option id='owner_rr' value='Round Robin'";
                        if( $config_fields->assigned_to == 'Round Robin' )
                        {
                                $content_option .= "selected";
                        }
                        $content_option .= "> Round Robin </option>";

                        $html .= $content_option;
                        $html .= "</select> <span style='padding-left:15px; color:red;' id='assignedto_status'></span>";
                        return $html;
                }
                public function mapUserCaptureFields( $user_firstname , $user_lastname , $user_email )
                {
                        $post = array();
                        $post['First_Name'] = $user_firstname;
                        $post['Last_Name'] = $user_lastname;
                        $post[$this->duplicateCheckEmailField()] = $user_email;
                        return $post;
                }
                public function duplicateCheckEmailField()
	        {
		return 'email_address';
                }
                public function assignedToFieldId()
	        {
                
                return "owner_id";
                }
                public function checkEmailPresent( $module , $email,$list )
                {
                   $result_emails = array();
                   $result_ids = array();    
                   $client = new SmackMailchimp();
                   $email_present = "no";
                   $records = $client->getRecords($module,$email,$this->dc,$this->token,$list);
                   if($records['id']!=""){
                        $result_ids[]=$records['id'];
                        $result_emails[]=$records['email_address'];
                        $email_present = "yes";
                   }
                   $this->result_emails = $result_emails;
                   $this->result_ids = $result_ids;
                   if($email_present == 'yes')
                           return true;
                   else
                           return false;
                   
                        
                }
                public function createRecord( $module , $module_fields )
                {
                        
                         $client=new SmackMailchimp();
                               
                        foreach($module_fields as $fieldname => $fieldvalue){
                                if($fieldname=='email_address'){
                                        $email[$fieldname]=array();
                                        $email[$fieldname]=$fieldvalue;
                                        $email['status']='subscribed';
                                        $email['merge_fields']=array();
                                
                                }
                                elseif($fieldname=='list'){
                                        $list[$fieldname]=array();
                                        $list[$fieldname]=$fieldvalue;
                                        $list=$list[$fieldname];
                                }
                                else{
                        
                                        $module_fields[$fieldname] = array();
                                        unset($module_fields['email_address']);
                                        unset($module_fields['list']);
                                        if($fieldname=='BIRTHDAY'){
                                                $value=strtotime($fieldvalue);
                                                $module_fields[$fieldname]=date('m/d',$value);     
                                        }
                                        elseif($fieldname=='ADDRESS'){
                                                $address=explode(",",$fieldvalue);
                                                $add=array();
                                                if(isset($address[0])){
                                                         $add['addr1']=$address[0];
                                                }
                                                else{
                                                        $add['addr1']="";      
                                                }
                                                if(isset($address[1])){
                                                        $add['addr2']=$address[1];
                                                 }
                                                 else{
                                                          $add['addr2']="";      
                                                 }
                                                 if(isset($address[2])){
                                                         $add['city']=$address[2];
                                                 }
                                                else{
                                                         $add['city']="";      
                                                }
                                                 if(isset($address[3])){
                                                 $add['state']=$address[3];
                                                  }
                                                  else{
                                                         $add['state']="";      
                                                 }
                                                 if(isset($address[4])){
                                                        $add['zip']=$address[4];
                                                 }
                                                 else{
                                                         $add['zip']="";      
                                                 } 
                                                 if(isset($address[5])){
                                                         $add['country']=$address[5];
                                                 }
                                                  else{
                                                   $add['country']="";      
                                                }
                                                // $add['addr2']=isset($address[1])?$address[1]:"";
                                                // $add['city']=isset($address[2])?$address[2]:"";
                                                // $add['state']=isset($address[3])?$address[3]:"";
                                                // $add['zip']=isset($address[4])?$address[4]:"";
                                                // $add['country']=isset($address[5])?$address[5]:"";
                                                $module_fields[$fieldname]=$add;
                                        }
                                        else{
                                                $module_fields[$fieldname]=$fieldvalue;
                                        }
                                }
                        }
                        array_push($email['merge_fields'],$module_fields); 
                        $body_json=str_replace(array('[', ']'), '', htmlspecialchars(json_encode($email), ENT_NOQUOTES));
                        $record = $client->Mailchimp_CreateRecord( $module,$body_json,$list,$this->dc,$this->token);
                        if($record['id']!=""){
                                $data['result'] = "success";
                                $data['failure'] = 0;
                        }
                        else
                        {
                                $data['result'] = "failure";
                                $data['failure'] = 1;
                                $data['reason'] = "failed adding entry";
                        }
                        return $data;
                }
                public function updateRecord( $module , $module_fields , $ids_present )
                {
                      
                        $client=new SmackMailchimp();
                               
                        foreach($module_fields as $fieldname => $fieldvalue){
                                if($fieldname=='email_address'){
                                        $email[$fieldname]=array();
                                        $email[$fieldname]=$fieldvalue;
                                        $email['email_type']='html';
                                        $email['status']='subscribed';
                                        $email['merge_fields']=array();
                                
                                }
                                elseif($fieldname=='list'){
                                        $list[$fieldname]=array();
                                        $list[$fieldname]=$fieldvalue;
                                        $list=$list[$fieldname];
                                }
                                else{
                        
                                        $module_fields[$fieldname] = array();
                                        unset($module_fields['email_address']);
                                        unset($module_fields['list']);
                                        if($fieldname=='BIRTHDAY'){
                                                $value=strtotime($fieldvalue);
                                                $module_fields[$fieldname]=date('m/d',$value);
                                        }
                                        elseif($fieldname=='ADDRESS'){
                                                $address=explode(",",$fieldvalue);
                                                $add=array();
                                                if(isset($address[0])){
                                                         $add['addr1']=$address[0];
                                                }
                                                else{
                                                        $add['addr1']="";      
                                                }
                                                if(isset($address[1])){
                                                        $add['addr2']=$address[1];
                                                 }
                                                 else{
                                                          $add['addr2']="";      
                                                 }
                                                 if(isset($address[2])){
                                                         $add['city']=$address[2];
                                                 }
                                                else{
                                                         $add['city']="";      
                                                }
                                                 if(isset($address[3])){
                                                 $add['state']=$address[3];
                                                  }
                                                  else{
                                                         $add['state']="";      
                                                 }
                                                 if(isset($address[4])){
                                                        $add['zip']=$address[4];
                                                 }
                                                 else{
                                                         $add['zip']="";      
                                                 } 
                                                 if(isset($address[5])){
                                                         $add['country']=$address[5];
                                                 }
                                                  else{
                                                   $add['country']="";      
                                                }
                                                // $add['addr2']=isset($address[1])?$address[1]:"";
                                                // $add['city']=isset($address[2])?$address[2]:"";
                                                // $add['state']=isset($address[3])?$address[3]:"";
                                                // $add['zip']=isset($address[4])?$address[4]:"";
                                                // $add['country']=isset($address[5])?$address[5]:"";
                                                $module_fields[$fieldname]=$add;
                                        }
                                        else{
                                                $module_fields[$fieldname]=$fieldvalue;
                                        }
                                }
                        }
                        array_push($email['merge_fields'],$module_fields); 
                        $body_json=str_replace(array('[', ']'), '', htmlspecialchars(json_encode($email), ENT_NOQUOTES));
                        $record = $client->Mailchimp_UpdateRecord( $module,$body_json,$ids_present,$list,$this->dc,$this->token);
                        if($record['id']!=""){
                                $data['result'] = "success";
                                $data['failure'] = 0;
                        }
                        else
                        {
                                $data['result'] = "failure";
                                $data['failure'] = 1;
                                $data['reason'] = "failed adding entry";
                        }
                        return $data;  
                }


                
        }