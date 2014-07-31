<?php
class ModelAccountnewslettersubscribe extends Model {
	public function checkmailid($data) {
  	   
	  $query=$this->db->query("SELECT * FROM " . DB_PREFIX . "subscribe where email_id='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");
	   return $query->num_rows;
	}
	

	public function subscribe($data) {
	  	   $lccode=$this->config->get('config_language_id');
		      $this->db->query("INSERT INTO " . DB_PREFIX . "subscribe SET store_id='".$this->config->get('config_store_id')."',email_id='".$data['subscribe_email']."',name='".$data['subscribe_name']."',language_id='".$lccode."',option1='".$this->db->escape(isset($data['option1'])?$data['option1']:'')."',option2='".$this->db->escape(isset($data['option2'])?$data['option2']:'')."',option3='".$this->db->escape(isset($data['option3'])?$data['option3']:'')."',option4='".$this->db->escape(isset($data['option4'])?$data['option4']:'')."',option5='".$this->db->escape(isset($data['option5'])?$data['option5']:'')."',option6='".$this->db->escape(isset($data['option6'])?$data['option6']:'')."'");
		

			    $this->loadmailchimp($data);
				  $this->customersubscribeemail($data);
			  $this->adminemailsub($data);
	}
	
	public function unsubscribe($data) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "subscribe WHERE email_id='".$data['subscribe_email']."' AND store_id='".$this->config->get('config_store_id')."'");
			    $this->loadmailchimpun($data);
				  $this->customerunsubscribeemail($data);
			  $this->adminemailunsub($data);

	}
   public function check_db(){
	   
	 $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "subscribe` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `email_id` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `language_id` int(11) NOT NULL,
  `option1` varchar(225) NOT NULL,
  `option2` varchar(225) NOT NULL,
  `option3` varchar(225) NOT NULL,
  `option4` varchar(225) NOT NULL,
  `option5` varchar(225) NOT NULL,
  `option6` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;");
   }
   
   
   public function loadmailchimp($data){
   

	
	
	if($this->config->get('newslettersubscribe_mailchimp_msync')){
	   if(!isset($data['option1']))
		$data['option1'] = "";
		if(!isset($data['option2']))
		$data['option2'] = "";
		if(!isset($data['option3']))
		$data['option3'] = "";
		if(!isset($data['option4']))
		$data['option4'] = "";
		if(!isset($data['option5']))
		$data['option5'] = "";
		if(!isset($data['option6']))
		$data['option6'] = "";
	
        $store_id=$this->config->get('config_store_id');
		
			$api = $this->config->get('newslettersubscribe_'.$store_id.'_mailchimpapi');
		$fid  = $this->config->get('newslettersubscribe_'.$store_id.'_mailchimplistid');
		
if($this->config->get('newslettersubscribe_mailchimp_mwelcome')){
$mwelcome="true";
}
else {
$mwelcome="false";
}
if($this->config->get('newslettersubscribe_mailchimp_optin')){

$double_optin="true";
}
else {
$double_optin="false";
}
$name= $data['subscribe_name'];
$email_address= $data['subscribe_email'];
$apikey= $api;

$id= $fid;

if (version_compare(PHP_VERSION, '6.0.0') >= 0) {

  $fname=strstr($name, ' ', true);
$lname2=strstr($name, ' ');
$lname = substr($lname2, 1); 
}
	  
	
  else
  { 
  $fname = substr($name, 0, strpos($name, ' '));
$lname = substr($name,  strpos($name, ' '));
     }


$dc2 = strstr($apikey, '-');
$dc = substr($dc2, 1); 

if ($fname == null){

$fname = $name;

 }

$url = 'http://'.$dc.'.api.mailchimp.com/1.3/?method=listSubscribe&apikey='.$apikey.'&id='.$id.'&email_address='.$email_address.'&double_optin='.$double_optin.'&send_welcome='.$mwelcome.'&merge_vars[FNAME]='.$fname.'&merge_vars[LNAME]='.$lname.'&merge_vars[OPTION1]='.$data['option1'].',&merge_vars[OPTION2]='.$data['option2'].'&merge_vars[OPTION3]='.$data['option3'].'&merge_vars[OPTION4]='.$data['option4'].'&merge_vars[OPTION5]='.$data['option5'].'&merge_vars[OPTION6]='.$data['option6'].'';




$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_ENCODING, "");
					curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: MCAPI/1.3');
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);
					curl_setopt($ch, CURLOPT_FAILONERROR, 1);
					curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, null);
					$data  = curl_exec( $ch );
					curl_close( $ch );
}
}

public function adminemailsub($data){
	
	 if($this->config->get('newslettersubscribe_mail_status')){
			 $language_id=$this->config->get('config_language_id');   
			   
			   
			   
				
	$store_name=$this->config->get('config_name');
 $language_id=$this->config->get('config_language_id');
  		$storeurl=$this->config->get('config_url');
	$storeemail=$this->config->get('config_email'); 

	$username = $data['subscribe_name'];
	$email_id = $data['subscribe_email'];
	  
			

		$link = $storeurl;
		 	$mail_subject = $this->config->get('newslettersubscribe_subject_'.$language_id.'_admin');
$mail_message = html_entity_decode($this->config->get('newslettersubscribe_mail_'.$language_id.'_admin'), ENT_QUOTES, 'UTF-8');

		


$mail_subject =str_replace('{store_name}', $store_name, $mail_subject);
$mail_subject =str_replace('{user_name}', $username, $mail_subject);
$mail_subject =str_replace('{user_email}', $email_id, $mail_subject);


$mail_message =str_replace('{store_name}', $store_name, $mail_message);
$mail_message =str_replace('{user_name}', $username, $mail_message);
$mail_message =str_replace('{user_email}', $email_id, $mail_message);


if(isset($data['option1'])) {
for($l=1;$l<=6;$l++){
      			
	
	$option_fields[$l] = $this->config->get('newslettersubscribe_optionfield_'.$language_id.$l.'');


}

$mail_message =str_replace('{optiondata}', '{optionname1}: {optionvalue1}<br/>{optionname}{optionvalue}', $mail_message);

$mail_message =str_replace('{optionname1}', $option_fields[1], $mail_message);
$mail_message =str_replace('{optionvalue1}', $data['option1'], $mail_message);
			 
				}
				
if(isset($data['option2'])) {
$mail_message =str_replace('{optionname}{optionvalue}', '{optionname2}: {optionvalue2}<br/>{optionname}{optionvalue}', $mail_message);

$mail_message =str_replace('{optionname2}', $option_fields[2], $mail_message);
$mail_message =str_replace('{optionvalue2}', $data['option2'], $mail_message);
			 
				}
				if(isset($data['option3'])) {
$mail_message =str_replace('{optionname}{optionvalue}', '{optionname3}: {optionvalue3}<br/>{optionname}{optionvalue}', $mail_message);

$mail_message =str_replace('{optionname3}', $option_fields[3], $mail_message);
$mail_message =str_replace('{optionvalue3}', $data['option3'], $mail_message);
			 
				}
				if(isset($data['option4'])) {
$mail_message =str_replace('{optionname}{optionvalue}', '{optionname4}: {optionvalue4}<br/>{optionname}{optionvalue}', $mail_message);

$mail_message =str_replace('{optionname4}', $option_fields[4], $mail_message);
$mail_message =str_replace('{optionvalue4}', $data['option4'], $mail_message);
			 
				}
				if(isset($data['option5'])) {
$mail_message =str_replace('{optionname}{optionvalue}', '{optionname5}: {optionvalue5}<br/>{optionname}{optionvalue}', $mail_message);

$mail_message =str_replace('{optionname5}', $option_fields[5], $mail_message);
$mail_message =str_replace('{optionvalue5}', $data['option5'], $mail_message);
			 
				}
				if(isset($data['option6'])) {
$mail_message =str_replace('{optionname}{optionvalue}', '{optionname6}: {optionvalue6}', $mail_message);
$mail_message =str_replace('{optionname6}', $option_fields[6], $mail_message);
$mail_message =str_replace('{optionvalue6}', $data['option6'], $mail_message);
			 
				}
$mail_message =str_replace('{optionname}', '', $mail_message);
$mail_message =str_replace('{optionvalue}', '', $mail_message);
$mail_message =str_replace('{optiondata}', '', $mail_message);

	    $mail = new Mail();
	    $mail->protocol = $this->config->get('config_mail_protocol');
	    $mail->parameter = $this->config->get('config_mail_parameter');
	    $mail->hostname = $this->config->get('config_smtp_host');
	    $mail->username = $this->config->get('config_smtp_username');
	    $mail->password = $this->config->get('config_smtp_password');
	    $mail->port = $this->config->get('config_smtp_port');
	    $mail->timeout = $this->config->get('config_smtp_timeout');


		$mail->setFrom($storeemail);
			$mail->setSender($storeemail);

	$mail->setTo($this->config->get('config_email'));
	$mail->setSubject($mail_subject);
	$mail->setHtml($mail_message);

	$mail->send();   
 	
			}
			}
			
			
			public function customersubscribeemail($data){
			 if($this->config->get('newslettersubscribe_localemail')){
			 
	 $customersubscribeemail=1;			
 if($this->config->get('newslettersubscribe_mailchimp_optin') ){
 $customersubscribeemail=0;
 }
 if($this->config->get('newslettersubscribe_mailchimp_mwelcome') ){
 $customersubscribeemail=0;
 }
  if(!$this->config->get('newslettersubscribe_mailchimp_msync') ){
 $customersubscribeemail=1;
 }
			   

			
			
			   
			   if($customersubscribeemail==1) {
			   
    $language_id=$this->config->get('config_language_id');
			   
			   
				
	$store_name=$this->config->get('config_name');
   $language_id=$this->config->get('config_language_id');
   $storeurl=$this->config->get('config_url');
	$storeemail=$this->config->get('config_email'); 

	$username = $data['subscribe_name'];
	$email_id = $data['subscribe_email'];
	  
			

		$link = $storeurl;
		 	$mail_subject = $this->config->get('newslettersubscribe_subject_'.$language_id.'_custumer');
$mail_message = html_entity_decode($this->config->get('newslettersubscribe_mail_'.$language_id.'_custumer'), ENT_QUOTES, 'UTF-8');

		


$mail_subject =str_replace('{store_name}', $store_name, $mail_subject);
$mail_subject =str_replace('{user_name}', $username, $mail_subject);
$mail_subject =str_replace('{user_email}', $email_id, $mail_subject);


$mail_message =str_replace('{store_name}', $store_name, $mail_message);
$mail_message =str_replace('{user_name}', $username, $mail_message);
$mail_message =str_replace('{user_email}', $email_id, $mail_message);







	    $mail = new Mail();
	    $mail->protocol = $this->config->get('config_mail_protocol');
	    $mail->parameter = $this->config->get('config_mail_parameter');
	    $mail->hostname = $this->config->get('config_smtp_host');
	    $mail->username = $this->config->get('config_smtp_username');
	    $mail->password = $this->config->get('config_smtp_password');
	    $mail->port = $this->config->get('config_smtp_port');
	    $mail->timeout = $this->config->get('config_smtp_timeout');


		$mail->setFrom($storeemail);
			$mail->setSender($storeemail);

	$mail->setTo($email_id);
	$mail->setSubject($mail_subject);
	$mail->setHtml($mail_message);

	$mail->send();   
 	
			}
		
			}
			}
			public function customerunsubscribeemail($data){
			 
			 if($this->config->get('newslettersubscribe_localemail')){
			 
			 	 $customerunsubscribeemail=1;			
 if($this->config->get('newslettersubscribe_mailchimp_optin') ){
 $customerunsubscribeemail=0;
 }
 if($this->config->get('newslettersubscribe_mailchimp_mwelcome') ){
 $customerunsubscribeemail=0;
 }
  if(!$this->config->get('newslettersubscribe_mailchimp_msync') ){
 $customerunsubscribeemail=1;
 }
			   

			
			
			   
			   if($customerunsubscribeemail==1) {
			   
			   $language_id=$this->config->get('config_language_id');
			   
			   
				
	$store_name=$this->config->get('config_name');
 $language_id=$this->config->get('config_language_id');
  		$storeurl=$this->config->get('config_url');
	$storeemail=$this->config->get('config_email'); 

	$username = $data['subscribe_name'];
	$email_id = $data['subscribe_email'];
	  
			

		$link = $storeurl;
		 	$mail_subject = $this->config->get('newslettersubscribe_unsubject_'.$language_id.'_custumer');
$mail_message = html_entity_decode($this->config->get('newslettersubscribe_unmail_'.$language_id.'_custumer'), ENT_QUOTES, 'UTF-8');

		


$mail_subject =str_replace('{store_name}', $store_name, $mail_subject);
$mail_subject =str_replace('{user_name}', $username, $mail_subject);
$mail_subject =str_replace('{user_email}', $email_id, $mail_subject);


$mail_message =str_replace('{store_name}', $store_name, $mail_message);
$mail_message =str_replace('{user_name}', $username, $mail_message);
$mail_message =str_replace('{user_email}', $email_id, $mail_message);


	    $mail = new Mail();
	    $mail->protocol = $this->config->get('config_mail_protocol');
	    $mail->parameter = $this->config->get('config_mail_parameter');
	    $mail->hostname = $this->config->get('config_smtp_host');
	    $mail->username = $this->config->get('config_smtp_username');
	    $mail->password = $this->config->get('config_smtp_password');
	    $mail->port = $this->config->get('config_smtp_port');
	    $mail->timeout = $this->config->get('config_smtp_timeout');


		$mail->setFrom($storeemail);
			$mail->setSender($storeemail);

	$mail->setTo($email_id);
	$mail->setSubject($mail_subject);
	$mail->setHtml($mail_message);

	$mail->send();   
 	
			}
		
			}
			}
	public function adminemailunsub($data){
	 
	 if($this->config->get('newslettersubscribe_mail_status')){
			   
			   
			$language_id=$this->config->get('config_language_id');   
			   
				
	$store_name=$this->config->get('config_name');
 $language_id=$this->config->get('config_language_id');
  		$storeurl=$this->config->get('config_url');
	$storeemail=$this->config->get('config_email'); 

	$username = $data['subscribe_name'];
	$email_id = $data['subscribe_email'];
	  
			

		$link = $storeurl;
		 	$mail_subject = $this->config->get('newslettersubscribe_unsubject_'.$language_id.'_admin');
$mail_message = html_entity_decode($this->config->get('newslettersubscribe_unmail_'.$language_id.'_admin'), ENT_QUOTES, 'UTF-8');

		


$mail_subject =str_replace('{store_name}', $store_name, $mail_subject);
$mail_subject =str_replace('{user_name}', $username, $mail_subject);
$mail_subject =str_replace('{user_email}', $email_id, $mail_subject);


$mail_message =str_replace('{store_name}', $store_name, $mail_message);
$mail_message =str_replace('{user_name}', $username, $mail_message);
$mail_message =str_replace('{user_email}', $email_id, $mail_message);


	    $mail = new Mail();
	    $mail->protocol = $this->config->get('config_mail_protocol');
	    $mail->parameter = $this->config->get('config_mail_parameter');
	    $mail->hostname = $this->config->get('config_smtp_host');
	    $mail->username = $this->config->get('config_smtp_username');
	    $mail->password = $this->config->get('config_smtp_password');
	    $mail->port = $this->config->get('config_smtp_port');
	    $mail->timeout = $this->config->get('config_smtp_timeout');


		$mail->setFrom($storeemail);
			$mail->setSender($storeemail);

	$mail->setTo($this->config->get('config_email'));
	$mail->setSubject($mail_subject);
	$mail->setHtml($mail_message);

	$mail->send();   
 	
			}
			}
	
		public function loadmailchimpun($data){
	
	 
	if($this->config->get('newslettersubscribe_mailchimp_msync')){
	
        $store_id=$this->config->get('config_store_id');
			
		$api = $this->config->get('newslettersubscribe_'.$store_id.'_mailchimpapi');
		$fid  = $this->config->get('newslettersubscribe_'.$store_id.'_mailchimplistid');

		
if($this->config->get('newslettersubscribe_mailchimp_mwelcome')){
$send_goodbye="true";
}
else {
$send_goodbye="false";
}
if($this->config->get('newslettersubscribe_mailchimp_optin')){

$send_notify="true";
}
else {
$send_notify="false";
}

$email_address= $data['subscribe_email'];
$apikey= $api;

$id= $fid;


	  
	



$dc2 = strstr($apikey, '-');
$dc = substr($dc2, 1); 



$url = 'http://'.$dc.'.api.mailchimp.com/1.3/?method=listUnsubscribe&apikey='.$apikey.'&id='.$id.'&email_address='.$email_address.'&delete_member=true&send_goodbye='.$send_goodbye.'&send_notify='.$send_notify.'';




$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_ENCODING, "");
					curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: MCAPI/1.3');
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);
					curl_setopt($ch, CURLOPT_FAILONERROR, 1);
					curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, null);
					$data  = curl_exec( $ch );
					curl_close( $ch );
}
	}
	
}
?>
