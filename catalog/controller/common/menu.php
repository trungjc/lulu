<?php   
class ControllerCommonMenu extends Controller {
	public function index() {

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['base'] = $server;
		$type = "header";
		if (isset($this->request->get['type'])) {
			$type = $this->request->get['type'];
		}
		$this->data['menu_type'] = $type;
		$this->children = array(
			'module/supermenu',
			'module/supermenu_settings',
			'common/footer'			
		);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/menu.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/menu.tpl';
		} else {
			$this->template = 'default/template/common/menu.tpl';
		}

		$this->response->setOutput($this->render());
	} 	
}
?>
