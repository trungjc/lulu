<?php
/*
Author 		: Thanh Tien
Version 				: 1.0
Original Release Date 	: January 30 2013
Opencart Compatibility	: v1.5.4.x, v1.5.5.x

*/
class ControllerModuleSFTQuickShop extends Controller {

	protected function index($setting) {
		
		//$this->document->addScript('catalog/view/javascript/sft_quickshop/jquery.js');
		$this->document->addScript('catalog/view/javascript/sft_quickshop/jquery.fancybox-1.3.4.pack.js');
		$this->document->addScript('catalog/view/javascript/sft_quickshop/sft_cloudzoom.js');		
			
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/sft_quickshop/jquery.fancybox-1.3.4.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/sft_quickshop/jquery.fancybox-1.3.4.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/sft_quickshop/jquery.fancybox-1.3.4.css');
		}
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/sft_quickshop/sft_cloudzoom.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/sft_quickshop/sft_cloudzoom.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/sft_quickshop/sft_cloudzoom.css');
		}
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/sft_quickshop/sft_quickshop.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/sft_quickshop/sft_quickshop.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/sft_quickshop/sft_quickshop.css');
		}
		
		static $module = 0;
		$this->data['width'] = $setting['width'];
		$this->data['height'] = $setting['height'];
		

		$this->data['module'] = $module++;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/sft_quickshop.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/sft_quickshop.tpl';
		} else {
			$this->template = 'default/template/module/sft_quickshop.tpl';
		}

		$this->data['dir_template']=DIR_TEMPLATE;
		
		     if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
         $this->data['baseurl'] = $this->config->get('config_ssl');
		  } else {
			 $this->data['baseurl'] = $this->config->get('config_url');
		  }
		  
		$this->render();
	}
}
?>