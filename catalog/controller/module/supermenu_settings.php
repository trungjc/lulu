<?php  
class ControllerModuleSupermenusettings extends Controller {
	protected function index($setting) {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['base'] = $server;
		
		$this->data['supermenu_settings_status'] = $this->config->get('supermenu_settings_status');
		$this->data['skin'] = $this->config->get('supermenu_skin');
		$this->data['supermenu_settings'] = $this->config->get('supermenu_settings');
		$this->data['supermenuisresponsive'] = ($this->config->get('supermenu_supermenuisresponsive') ? true : false);
		$this->data['usehoverintent'] = ($this->config->get('supermenu_usehoverintent') ? false : true);
		$this->data['direction'] = $this->language->get('direction');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/supermenu_settings.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/supermenu_settings.tpl';
		} else {
			$this->template = 'default/template/module/supermenu_settings.tpl';
		}
		
		$this->render();
  	}
}
?>