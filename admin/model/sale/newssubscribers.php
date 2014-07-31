<?php
class ModelSalenewssubscribers extends Model {
	
   private function check_db(){


	   
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
   
	public function addEmail($data) {
		if(!isset($data['language_id']))
		$data['language_id'] = $this->config->get('config_language_id');
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
	    
		$chk_email = $this->db->query("SELECT * FROM " . DB_PREFIX . "subscribe WHERE store_id='".(int)$data['store_id']."' AND email_id='".$this->db->escape($data['email_id'])."'");
		
		if(!$chk_email->num_rows){
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "subscribe SET store_id='".(int)$data['store_id']."',email_id='".$this->db->escape($data['email_id'])."',name='".$this->db->escape($data['email_name'])."',language_id='".$this->db->escape($data['language_id'])."',option1='".$this->db->escape($data['option1'])."',option2='".$this->db->escape($data['option2'])."',option3='".$this->db->escape($data['option3'])."',option4='".$this->db->escape($data['option4'])."',option5='".$this->db->escape($data['option5'])."',option6='".$this->db->escape($data['option6'])."'");
			$menable=$this->config->get('newslettersubscribe_mailchimp_msync');
			
			if($menable==1){
			$api = $this->config->get('newslettersubscribe_'.$data['store_id'].'_mailchimpapi');
            $fid= $this->config->get('newslettersubscribe_'.$data['store_id'].'_mailchimplistid');	
			$name=$this->db->escape($data['email_name']);
			
			
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
			if ($fname == null){

			$fname = $name;

			 }
			 $mwelcome="false";
				$double_optin="false";
				$dc2 = strstr($api, '-');
				$dc = substr($dc2, 1); 
				
				
$url = 'http://'.$dc.'.api.mailchimp.com/1.3/?method=listSubscribe&apikey='.$api.'&id='.$fid.'&email_address='.$data['email_id'].'&double_optin='.$double_optin.'&send_welcome='.$mwelcome.'&merge_vars[FNAME]='.$fname.'&merge_vars[LNAME]='.$lname.'&merge_vars[OPTION1]='.$data['option1'].',&merge_vars[OPTION2]='.$data['option2'].'&merge_vars[OPTION3]='.$data['option3'].'&merge_vars[OPTION4]='.$data['option4'].'&merge_vars[OPTION5]='.$data['option5'].'&merge_vars[OPTION6]='.$data['option6'].'';

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
			
			return true;
		}
		else{ 
			return false;
		}
	}
	
		public function pushlist($data) {
		
		$menable=$this->config->get('newslettersubscribe_mailchimp_msync');
		if($menable==1){
		
		
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
		
			$api = $this->config->get('newslettersubscribe_'.$data['store_id'].'_mailchimpapi');
            $fid= $this->config->get('newslettersubscribe_'.$data['store_id'].'_mailchimplistid');	
	       
			$name=$this->db->escape($data['email_name']);
		
				
			
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
			if ($fname == null){

			$fname = $name;

			 }
			 $mwelcome="false";
				$double_optin="false";
				$dc2 = strstr($api, '-');
				$dc = substr($dc2, 1); 
				
				
$url = 'http://'.$dc.'.api.mailchimp.com/1.3/?method=listSubscribe&apikey='.$api.'&id='.$fid.'&email_address='.$data['email_id'].'&double_optin='.$double_optin.'&send_welcome='.$mwelcome.'&merge_vars[FNAME]='.$fname.'&merge_vars[LNAME]='.$lname.'&merge_vars[OPTION1]='.$data['option1'].',&merge_vars[OPTION2]='.$data['option2'].'&merge_vars[OPTION3]='.$data['option3'].'&merge_vars[OPTION4]='.$data['option4'].'&merge_vars[OPTION5]='.$data['option5'].'&merge_vars[OPTION6]='.$data['option6'].'';

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
	
	
	public function copycustomer($data) {
		
		
		$imported_localemails=0;
		$importedfailed_localemails=0;
	    
		$chk_email = $this->db->query("SELECT * FROM " . DB_PREFIX . "subscribe WHERE store_id='".(int)$data['store_id']."' AND email_id='".$this->db->escape($data['email_id'])."'");
		
		if(!$chk_email->num_rows){
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "subscribe SET store_id='".(int)$data['store_id']."',email_id='".$this->db->escape($data['email_id'])."',name='".$this->db->escape($data['email_name'])."'");
			
			
			 $imported_localemails++;
			}
			else
			{
		   $importedfailed_localemails++;		
			}
			
			if($data['mailchimpenable']==1){
			
				$api=$data['mailchimpapi'];
				$fid=$data['mailchimplistid'];
				$mwelcome="false";
				$double_optin="false";
				$dc2 = strstr($api, '-');
				$dc = substr($dc2, 1); 
			
			
			
$url = 'http://'.$dc.'.api.mailchimp.com/1.3/?method=listSubscribe&apikey='.$api.'&id='.$fid.'&email_address='.$data['email_id'].'&double_optin='.$double_optin.'&send_welcome='.$mwelcome.'&merge_vars[FNAME]='.$data['firstname'].'&merge_vars[LNAME]='.$data['lastname'].'';


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
		 return array(
		 'imported_localemails'                => $imported_localemails,
		  'importedfailed_localemails'                => $importedfailed_localemails,
					);
		 
		
	}
	
	public function loadmailchimpun($email_id,$store_id){
			$menable=$this->config->get('newslettersubscribe_mailchimp_msync');
			
			if($menable==1){
			$apikey = $this->config->get('newslettersubscribe_'.$store_id.'_mailchimpapi');
            $id= $this->config->get('newslettersubscribe_'.$store_id.'_mailchimplistid');	
	        $email_address= $email_id;
		

$send_goodbye="false";


$send_notify="false";



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
	
	
	
	public function editEmail($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "subscribe SET store_id='".$data['store_id']."',email_id='".$this->db->escape($data['email_id'])."',name='".$this->db->escape($data['email_name'])."' WHERE id = '" . (int)$id . "'");
	}
	
	public function deleteEmail($id) {
	
	$email = $this->db->query("SELECT  email_id,store_id FROM " . DB_PREFIX . "subscribe WHERE id = '" . (int)$id . "'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "subscribe WHERE id = '" . (int)$id . "'");
		
					    $this->loadmailchimpun($email->row['email_id'],$email->row['store_id']);
	}
	
	public function getEmail($id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "subscribe WHERE id = '" . (int)$id . "'");

		
		return $query->row;
	}
		public function getallemails() {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "subscribe");
		
		return $query->rows;
	}
	public function getEmails($data,$start,$limit,$filter_email) {
		
		$condition = array();
		
		if(isset($data['store_id']) and $data['store_id']!=""){ 
		  $condition[] = "store_id='".$data['store_id']."'";
		}
		if(isset($filter_email) and $filter_email!=""){ 
				
			$condition[] = "LCASE(email_id) LIKE '" . $this->db->escape(utf8_strtolower($filter_email)) . "%'";
		}
		
		$condition = implode(" AND ",$condition);
		
		if($condition!=""){ 
			$condition = " WHERE ".$condition;
		}
		
			$sql = "SELECT SU.*,ST.name store_name FROM " . DB_PREFIX . "subscribe SU LEFT JOIN(" . DB_PREFIX . "store ST) ON (ST.store_id=SU.store_id) ".$condition." LIMIT $start,$limit";
			
			
		
			
		
			
			
			
			
			
			
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function exportEmails() {
		
		$this->check_db();
		
		$sql = "SELECT SU.email_id,SU.name,ST.name store_name,SU.language_id,SU.option1,SU.option2,SU.option3,SU.option4,SU.option5,SU.option6 FROM " . DB_PREFIX . "subscribe SU LEFT JOIN(" . DB_PREFIX . "store ST) ON(ST.store_id=SU.store_id)";
			
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	

	
	public function getTotalEmails($data) {
		
		$this->check_db();
		
		$sql = "SELECT * FROM " . DB_PREFIX . "subscribe";
			
		$query = $this->db->query($sql);
		
		return $query->num_rows;
	}
	public function checkmail($data,$store_id=0,$id=FALSE) {
	  
	   if($id)
		$sql = "SELECT * FROM " . DB_PREFIX . "subscribe WHERE email_id='".$data."' AND id!='".$id."' AND store_id='".$store_id."'";
	   else	
		$sql = "SELECT * FROM " . DB_PREFIX . "subscribe WHERE email_id='".$data."' AND store_id='".$store_id."'";
		
		$query = $this->db->query($sql);
		
		return $query->num_rows;
	}
	
	

}
?>
