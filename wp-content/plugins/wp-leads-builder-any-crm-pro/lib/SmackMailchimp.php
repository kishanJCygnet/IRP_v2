<?php
if( !class_exists( "SmackMailchimp" ) )
{
  class SmackMailchimp
  {
    public function __construct()
    {
      $activated_plugin = get_option("WpLeadBuilderProActivatedPlugin");
      $Mailchimpconfig=get_option("wp_{$activated_plugin}_settings");
      $accesstok = isset($Mailchimpconfig['access_token']) ? $Mailchimpconfig['access_token'] : '';	
      $this->access_token=$accesstok;
      $this->client_id=$Mailchimpconfig['key'];
      $this->callback=$Mailchimpconfig['callback'];
      $this->client_secret=$Mailchimpconfig['secret'];
    }
    public function MailchimpGet_Getaccess($config,$code)
    {
      
      $params = "code=" .$code
        . "&redirect_uri=" . $this->callback 
        . "&client_id=" . $this->client_id
        . "&client_secret=" . $this->client_secret
        . "&grant_type=authorization_code";
      $token_url='https://login.mailchimp.com/oauth2/token';
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://login.mailchimp.com/oauth2/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $params,
      ));
        
      $response = curl_exec($curl);
      $response = json_decode($response, true);
      curl_close($curl);

      return $response;

    }
    public function MailchimpGet_Getaccessdc($config,$token)
    {

      $url = "https://login.mailchimp.com/oauth2/metadata";
      $args = array(
          'headers' => array(
          'Authorization' => 'Bearer'.$token
        )
      );
      $response = wp_remote_retrieve_body( wp_remote_get($url, $args ) );
      $body = json_decode($response, true);
      return $body;
    }

    public function getlist($module,$dc,$token)
    {
      $url="https://".$dc.".api.mailchimp.com/3.0/lists";
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          
        ),
      ));
      
      $response = curl_exec($curl);
      $result=json_decode($response, true);
      curl_close($curl);
      $value=$result['lists'];
      foreach($value as $val){
        $list['name']=$val['name'];
        $list['id']=$val['id'];
      }
      return $list;
    }
    public function Mailchimp_Getuser($dc,$token)
    {

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://'.$dc.'.api.mailchimp.com/3.0',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          
        ),
      ));

        $response = curl_exec($curl);
        $result=json_decode($response, true);
        curl_close($curl);
        return $result;
    }
    public function getmemberfields($dc,$listid,$token)
    {
        $curl = curl_init();
        $url="https://".$dc.".api.mailchimp.com/3.0/lists/".$listid."/merge-fields";
        curl_setopt_array($curl, array(
        CURLOPT_URL =>$url ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          
        ),
      ));

      $response = curl_exec($curl);
      $result=json_decode($response, true);
      curl_close($curl);
      return $result;
    }
    public function Mailchimp_CreateRecord($module,$data_array,$list,$dc,$token) 
    {
      try
      {
        global $wpdb;
        $query=$wpdb->get_results($wpdb->prepare("SELECT id FROM {$wpdb->prefix}smackleadbuilder_mailchimp_lists where name=%s",$list));
        foreach($query as $val){
          $id=$val->id;
        }
        $url= "https://".$dc.".api.mailchimp.com/3.0/lists/".$id."/members/";
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$data_array,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token,
            'Content-Type: text/plain',
            
          ),
        ));
        
        $response = curl_exec($curl);
        $result = json_decode($response,true);
        curl_close($curl);
      }catch(\Exception $exception)
      {
          // TODO - handle the error in log
      }
      return $result;
    }
    public function getRecords($module,$email,$dc,$token,$list)
    {
  
      global $wpdb;
      $query=$wpdb->get_results($wpdb->prepare("SELECT id FROM {$wpdb->prefix}smackleadbuilder_mailchimp_lists where name=%s",$list));
      foreach($query as $val){
          $id=$val->id;
      }
      $email_address=md5($email);
      $url='https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$id.'/members/'.$email_address;
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          
        ),
      ));
      
      $response = curl_exec($curl);
      $result = json_decode($response,true);
      curl_close($curl); 
      return $result;
    }
    public function Mailchimp_UpdateRecord($module,$body_json,$ids_present,$list,$dc,$token)
    {
      global $wpdb;
      $query=$wpdb->get_results($wpdb->prepare("SELECT id FROM {$wpdb->prefix}smackleadbuilder_mailchimp_lists where name=%s",$list));
      foreach($query as $val){
          $id=$val->id;
      }
      $url='https://'.$dc.'.api.mailchimp.com/3.0/lists/'.$id.'/members/'.$ids_present.'?skip_merge_validation=true';
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS =>$body_json,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer '.$token,
          'Content-Type: text/plain',
        ),  
      ));

      $response = curl_exec($curl);
      $result = json_decode($response,true);
      curl_close($curl);
        
      return $result;
    }
  }
}
?>