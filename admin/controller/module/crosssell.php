<?php
class ControllerModuleCrossSell extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/crosssell');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('catalog/product');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//echo "<xmp>";print_r($this->request->post['crosssell_module']);die();			
			$this->model_setting_setting->editSetting('crosssell', array( 'crosssell_module' => $this->request->post['crosssell_module']));		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_unselect'] = $this->language->get('text_unselect');
		$this->data['text_view_grid'] = $this->language->get('text_view_grid');
		$this->data['text_view_list'] = $this->language->get('text_view_list');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_alsobought'] = $this->language->get('entry_alsobought');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$this->data['entry_attribs'] = $this->language->get('entry_attribs');
		$this->data['entry_options'] = $this->language->get('entry_options');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_selection'] = $this->language->get('entry_selection');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_relation_criteria'] = $this->language->get('entry_relation_criteria');
		$this->data['entry_relation_options'] = $this->language->get('entry_relation_options');
		$this->data['entry_relation_attribs'] = $this->language->get('entry_relation_attribs');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['dimension'])) {
			$this->data['error_dimension'] = $this->error['dimension'];
		} else {
			$this->data['error_dimension'] = array();
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
			'href'      => $this->url->link('module/crosssell', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/crosssell', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		$this->data['modules'] = array();
		
		if (isset($this->request->post['crosssell_module'])) {
			$this->data['modules'] = $this->request->post['crosssell_module'];
		} elseif ($this->config->get('crosssell_module')) { 
			$this->data['modules'] = $this->config->get('crosssell_module');
		}	

		$this->load->model('catalog/attribute');
		$results = $this->model_catalog_attribute->getAttributes();
		
		$this->data['attributes'] = array();
		foreach ($results as $result) {
			$this->data['attributes'][] = array(
				'attribute_id'  => $result['attribute_id'],
				'name'          => $result['name']
			);
		}	

		$this->load->model('catalog/option');
		$results = $this->model_catalog_option->getOptions();
		
		$this->data['options'] = array();
		foreach ($results as $result) {
			$this->data['options'][] = array(
				'option_id'  => $result['option_id'],
				'name'       => $result['name']
			);
		}	
				

		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);

		$this->load->model('catalog/manufacturer');
		$this->data['manufacturers'] = $results = $this->model_catalog_manufacturer->getManufacturers();

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();



		$this->template = 'module/crosssell.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/crosssell')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['crosssell_module'])) {
			foreach ($this->request->post['crosssell_module'] as $key => $value) {
				//if (!$value['width'] || !$value['height']) {
				//	$this->error['dimension'][$key] = $this->language->get('error_dimension');
				//}			
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>