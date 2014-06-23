<?php
/*
Author 		: Thanh Tien
Version 				: 1.0
Original Release Date 	: January 30 2013
Opencart Compatibility	: v1.5.4.x, v1.5.5.x

*/
class ControllerModuleSFTQuickShop extends Controller {
	private $error = array(); 
	
	
	public function index() {   
		$this->load->language('module/sft_quickshop');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			$this->model_setting_setting->editSetting('sft_quickshop', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_header'] = $this->language->get('text_header');
		$this->data['text_footer'] = $this->language->get('text_footer');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');			
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		

		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
				
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/sft_quickshop', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/sft_quickshop', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
			
		$sft_quickshop = array();
	
		if (isset($this->request->post['sft_quickshop'])) {
			 $sft_quickshop = $this->request->post['sft_quickshop'];			
		} elseif ($this->config->get('sft_quickshop')) {		
			$sft_quickshop = $this->config->get('sft_quickshop');
		}	
		
		
		
		//module		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['sft_quickshop_module'])) {
			$this->data['modules'] = $this->request->post['sft_quickshop_module'];
		} elseif ($this->config->get('sft_quickshop_module')) { 
			$this->data['modules'] = $this->config->get('sft_quickshop_module');
		}		                      

		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/sft_quickshop.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);		
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/sft_quickshop')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
	
			return true;
		} else {
		
			return false;
		}	
	}
	private function getIdLayout($layout_name) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE LOWER(name) = LOWER('".$layout_name."')");
		return (int)$query->row['layout_id'];
	}
	
		public function install() 
	{
		$this->load->model('setting/setting');
			
		$sft_quickshop = array(
		'sft_quickshop_module' => array ( 
			0 => array ('width' => 650, 'height' => 500, 'layout_id' => $this->getIdLayout("home"), 'position' => 'content_top', 'status' => 1, 'sort_order' => 1),
			1 => array ('width' => 650, 'height' => 500, 'layout_id' => $this->getIdLayout("category"), 'position' => 'content_top', 'status' => 1, 'sort_order' => 1),
			)
		);
		$this->model_setting_setting->editSetting('sft_quickshop', $sft_quickshop);		
	}
}
?>