<?php
class ControllerSaleNewssubscribers extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('sale/newssubscribers');
 
		$this->document->setTitle($this->language->get('heading_title'));
 		
		$this->load->model('sale/newssubscribers');
		
		$this->getList();
	}

	public function copycustomer() {
		
		$this->load->language('sale/newssubscribers');
		 
	$imported_localemails=0;
		$importedfailed_localemails=0;
		
		$this->load->model('sale/customer');
		$this->session->data['total_imported_emails'] = 0;
		// $customer_total = $this->model_sale_customer->getTotalCustomers($data = array());
	
		$results = $this->model_sale_customer->getCustomers($data = array());
 	$this->load->model('sale/newssubscribers');
    	foreach ($results as $result) {
			
				
		
		if ($result['newsletter']==1) {
	
	
		
		$stores = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY name");
		
		$stores = $stores->rows;
		
		

		 array_unshift($stores, array('store_id' => 0, 'name' => $this->config->get('config_name')));

foreach ($stores as $store){

$mailchimpapi = $this->config->get('newslettersubscribe_'.$store['store_id'].'_mailchimpapi');

		
$mailchimplistid= $this->config->get('newslettersubscribe_'.$store['store_id'].'_mailchimplistid');
$mailchimpenable= $this->config->get('newslettersubscribe_mailchimp_msync');

		$data = array(
					'email_id' => $result['email'],
					'email_name' => $result['name'],
					
					'firstname' => $result['firstname'],
					'lastname' => $result['lastname'],
					'store_id' => $store['store_id'],
					'mailchimpapi' => $mailchimpapi,
					'mailchimplistid' => $mailchimplistid,
					'mailchimpenable' => $mailchimpenable,
					
				);
		$email_total = $this->model_sale_newssubscribers->copycustomer($data);
				
		
		if ($email_total['imported_localemails']==1)
		{
		$imported_localemails++;
		}
		
		if ($email_total['importedfailed_localemails']==1)
		{
		$importedfailed_localemails++;
		}
		
		}	
		}
		
			
}
$url = '';
$this->session->data['total_imported_emails'] = $imported_localemails;
				$this->session->data['total_existing_emails'] = $importedfailed_localemails;
	$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));

}
	public function pushlist() {
		
		$this->load->language('sale/newssubscribers');
		$this->load->model('sale/newssubscribers');
	
		$email_total = $this->model_sale_newssubscribers->getTotalEmails($data = array());
		$imported_localemails=$email_total;
		
		$results = $this->model_sale_newssubscribers->getallemails();
 	
    	foreach ($results as $result) {
			
					$data = array(
					'email_id' => $result['email_id'],
					'email_name' => $result['name'],
			
					'store_id' => $result['store_id'],
					'store_id' => $result['store_id'],
					'option1' => $result['option1'],
					'option2' => $result['option2'],
					'option3' => $result['option3'],
					'option4' => $result['option4'],
					'option5' => $result['option5'],
					'option6' => $result['option6'],
					
				
					
				);
		$email_push = $this->model_sale_newssubscribers->pushlist($data);
			

		
		}
		//echo "<pre>";
		//print_r ($results);
	//	die();
		

$this->session->data['total_imported_emails'] = $imported_localemails;
		$url = '';		
	$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));

}
	
	public function insert() {
		$this->load->language('sale/newssubscribers');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/newssubscribers');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_newssubscribers->addEmail($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('sale/newssubscribers');

		$this->document->setTitle($this->language->get('heading_title'));		
		
		$this->load->model('sale/newssubscribers');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_newssubscribers->editEmail($this->request->get['id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function import() { 
	$url = '';
	    
		$this->load->model('sale/newssubscribers');	
		
	    if($_SERVER['REQUEST_METHOD']=="POST" and isset($_FILES["excel_subscribers"]["name"]) and $_FILES["excel_subscribers"]["name"]!="" ) {
			
			$file_info = pathinfo($_FILES["excel_subscribers"]["name"]);
			
			if($file_info['extension']=="xls"){
				
				require_once DIR_SYSTEM.'library/excelreader.php';
				$data = new Spreadsheet_Excel_Reader($_FILES['excel_subscribers']['tmp_name']);
				$datas = $data->dumptoarray(0);
				
				$this->session->data['total_imported_emails'] = 0;
				
				if($datas){ 
				   foreach($datas as $email_info){ 
				     if($email_info[1]!="" and filter_var($email_info[1],FILTER_VALIDATE_EMAIL)){ 
					 
					 
					if(!isset($email_info[4])){
						$email_info[4] = $this->config->get('config_language_id');}
					
							if(!isset($email_info[5])){
						$email_info[5] = "";}
							if(!isset($email_info[6])){
						$email_info[6] = "";}
							if(!isset($email_info[7])){
						$email_info[7] = "";}
							if(!isset($email_info[8])){
						$email_info[8] = "";}
							if(!isset($email_info[9])){
						$email_info[9] = "";}
							if(!isset($email_info[10])){
						$email_info[10] = "";}
						
						$imp_info = array(
						 			'email_id'=>$email_info[1],
									'email_name'=>$email_info[2],
									'store_id'=>$email_info[3],
									'language_id'=>$email_info[4],
									'option1'=>$email_info[5],
									'option2'=>$email_info[6],
									'option3'=>$email_info[7],
									'option4'=>$email_info[8],
									'option5'=>$email_info[9],
									'option6'=>$email_info[10],
								);
					 	if($this->model_sale_newssubscribers->addEmail($imp_info)){ 
							$imported_emails++;						
						}else{ 
							$existing_emails++;
						}	  
					 }
				   }	
				}
				$this->session->data['total_imported_emails'] = $imported_emails;
				$this->session->data['total_existing_emails'] = $existing_emails;
			   	$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));
			} else { 
				$this->error['warning'] = $this->laguage->get('error_invalid_file');
			}
			
		} else { 
		   	$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}
	}
	
	public function export() {
		$url = '';
	 $this->load->model('sale/newssubscribers');
		
	 $field_option1 = $this->config->get('newslettersubscribe_option_field1')?$this->config->get('newslettersubscribe_option_field1'):'Option1';
	 $field_option2 = $this->config->get('newslettersubscribe_option_field2')?$this->config->get('newslettersubscribe_option_field2'):'Option2';
	 $field_option3 = $this->config->get('newslettersubscribe_option_field3')?$this->config->get('newslettersubscribe_option_field3'):'Option3';
	 $field_option4 = $this->config->get('newslettersubscribe_option_field4')?$this->config->get('newslettersubscribe_option_field4'):'Option4';
	 $field_option5 = $this->config->get('newslettersubscribe_option_field5')?$this->config->get('newslettersubscribe_option_field5'):'Option5';
	 $field_option6 = $this->config->get('newslettersubscribe_option_field6')?$this->config->get('newslettersubscribe_option_field6'):'Option6';
		
		$contents="Email \t Name \t Store Name \t \t language_id ".$field_option1." \t ".$field_option2." \t ".$field_option3." \t ".$field_option4." \t ".$field_option5." \t ".$field_option6." \n ";
		
		$results = $this->model_sale_newssubscribers->exportEmails();
		
		$filename ="Newsletter_subscribers_".date("Y-m-d").".xls";
		if($results) {
			foreach($results as $result){

				if($result['store_name']=="")
				$result['store_name'] = strip_tags($this->language->get('text_default'));
				
				$contents .= implode("\t",$result)."\n";	
			}
		}else{
			$contents = $this->language->get('text_no_results');
		}

		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $contents;	
	}
	
	public function delete() { 
		$this->load->language('sale/newssubscribers');

		$this->document->setTitle($this->language->get('heading_title'));		
		
		$this->load->model('sale/newssubscribers');
		
		if (isset($this->request->post['selected'])) {
      		foreach ($this->request->post['selected'] as $id) {
				$this->model_sale_newssubscribers->deleteEmail($id);	
			}
						
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
	
  		$this->data['breadcrumbs'] = array();
$url = '';
  		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

  		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
							
		
		$this->data['insert'] 		= $this->url->link('sale/newssubscribers/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] 		= $this->url->link('sale/newssubscribers/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['export'] 		= $this->url->link('sale/newssubscribers/export', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['import'] 		= $this->url->link('sale/newssubscribers/import', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['synchcustomer'] 		= $this->url->link('sale/newssubscribers/copycustomer', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['pushlist'] 		= $this->url->link('sale/newssubscribers/pushlist', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['text_export']  = $this->language->get('text_export');
		$this->data['text_import']  = $this->language->get('text_import');
		$this->data['text_pushlist']  = $this->language->get('text_pushlist');
		
		$this->data['text_synchcustomer']  = $this->language->get('text_synchcustomer');
		$this->data['upload_excel'] = $this->language->get('text_import');
		$this->data['text_sample']  = $this->language->get('text_sample');
		$this->data['button_filter']  = $this->language->get('button_filter');
		$this->data['token']  = $this->session->data['token'];
		$this->data['help_import'] = $this->language->get('help_import');
		
		if(isset($this->request->get['page'])) {
	            $page = $this->request->get['page'];
		}else{
		        $page = 1;
		}
	
		if (isset($this->request->get['filter_email'])) {
			$this->data['filter_email'] = $this->request->get['filter_email'];
		} else {
			$this->data['filter_email'] = null;
		}
	if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
	
		$this->data['emails'] = array();
		
		$data = "";
		
		$email_total = $this->model_sale_newssubscribers->getTotalEmails($data);
		
		$results = $this->model_sale_newssubscribers->getEmails($data,($page - 1) * $this->config->get('config_admin_limit'),$this->config->get('config_admin_limit'),$filter_email);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/newssubscribers/update', 'token=' . $this->session->data['token'] . '&id=' . $result['id'], 'SSL')
			);		
		
			$this->data['emails'][] = array(
				'id' 		 => $result['id'],
				'name' 		 => $result['name'],
				'store_name' => $result['store_name']?$result['store_name']:$this->language->get('text_default'),
				'email' 	 => $result['email_id'],
				'action'     => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_store'] = $this->language->get('column_store');
		
		$this->data['column_action'] = $this->language->get('column_action');
        $this->data['opmbutton'] = '<img src="view/javascript/kodecube/arrow.gif" /> <span style="color:#449DD0; font-weight:bold">Kodecube NewsLetter <a target="_blank" href="http://kodecube.com/" >Kodecube.com</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Check  awesome Opencart Mobile App at <a target="_blank" href="http://opencartmobileapp.com">Opencartmobileapp.com</span></a>';
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];	
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		
		
		if (isset($this->session->data['total_imported_emails'])) {
			$this->data['success'] = sprintf($this->language->get('message_imported'),$this->session->data['total_imported_emails']); 
			unset($this->session->data['total_imported_emails']);
		}
		
 		if (isset($this->session->data['total_existing_emails'])) {
			$this->data['error_warning'] = sprintf($this->language->get('message_already_imported'),$this->session->data['total_existing_emails']);
			unset($this->session->data['total_existing_emails']);
		}
		
		$url = "";
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $email_total;
		$pagination->page  = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text  = $this->language->get('text_pagination');
		$pagination->url   = $this->url->link('sale/newssubscribers/', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort_name'] = $this->url->link('sale/newssubscribers/', 'token=' . $this->session->data['token']);
		
		$this->template = 'sale/newsletter_subscriberslist.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
 	}

	private function getForm() {
	$url = '';
	 $language_id=$this->config->get('config_language_id');
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_mail'] = $this->language->get('entry_mail');
		
		
		$this->data['text_default'] = $this->language->get('text_default');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['error_email_name'])) {
			$this->data['error_email_name'] = $this->error['error_email_name'];
		} else {
			$this->data['error_email_name'] = '';
		}
		
 		if (isset($this->error['error_email_exist'])) {
			$this->data['error_email_exist'] = $this->error['error_email_exist'];
		} else {
			$this->data['error_email_exist'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

  		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

  		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'], 'SSL'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
			
		if (!isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('sale/newssubscribers/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/newssubscribers/update', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'], 'SSL');
		}
		
		$this->data['token'] = $this->session->data['token'];
		  
    	$this->data['cancel'] = $this->url->link('sale/newssubscribers', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$email_info = $this->model_sale_newssubscribers->getEmail($this->request->get['id']);
		}
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		
		if (isset($this->request->post['store_id'])) {
			$this->data['store_id'] = $this->request->post['store_id'];
		} elseif (isset($email_info)) {
			$this->data['store_id'] = $email_info['store_id'];
		} else {
			$this->data['store_id'] = '';
		}

		if (isset($this->request->post['email_name'])) {
			$this->data['email_name'] = $this->request->post['email_name'];
		} elseif (isset($email_info)) {
			$this->data['email_name'] = $email_info['name'];
		} else {
			$this->data['email_name'] = '';
		}
		
		if (isset($this->request->post['email_id'])) {
			$this->data['email_id'] = $this->request->post['email_id'];
		} elseif (isset($email_info)) {
			$this->data['email_id'] = $email_info['email_id'];
		} else {
			$this->data['email_id'] = '';
		}
			
		$this->template = 'sale/newsletter_subscriber_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression')); 
	}

	private function validateForm() {
		
	$this->load->model('sale/newssubscribers');
		
		if (!$this->user->hasPermission('modify', 'sale/newssubscribers')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

	 if(!filter_var($this->request->post['email_id'],FILTER_VALIDATE_EMAIL)){
			$this->error['error_email_name'] = $this->language->get('error_email');
		}
		
	 	if(isset($this->request->get['id']) and $this->request->get['id']!=""){
		    
			if($this->model_sale_newssubscribers->checkmail($this->request->post['email_id'],$this->request->post['store_id'],$this->request->get['id']))
			 $this->error['error_email_exist'] = $this->language->get('error_email_exist');
			 
		}else{
			
		   if($this->model_sale_newssubscribers->checkmail($this->request->post['email_id'],$this->request->post['store_id']))
		   $this->error['error_email_exist'] = $this->language->get('error_email_exist');
		 
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}
?>