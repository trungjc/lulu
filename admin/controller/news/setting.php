<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerNewsSetting extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('news/setting');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('news_setting', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title') . ' ' . $this->getVersion();
		
		$this->data['text_for_category'] = $this->language->get('text_for_category');
		$this->data['text_for_article'] = $this->language->get('text_for_article');
		$this->data['text_for_other'] = $this->language->get('text_for_other');
		$this->data['text_for_all_article'] = $this->language->get('text_for_all_article');
		
		$this->data['entry_category_image'] = $this->language->get('entry_category_image');
		$this->data['entry_news_per_page'] = $this->language->get('entry_news_per_page');
		$this->data['entry_comments_per_page'] = $this->language->get('entry_comments_per_page');
		$this->data['entry_category_1col_thumbnail'] = $this->language->get('entry_category_1col_thumbnail');
		$this->data['entry_category_2col_thumbnail'] = $this->language->get('entry_category_2col_thumbnail');
		$this->data['entry_article_image'] = $this->language->get('entry_article_image');
		$this->data['entry_width'] = $this->language->get('entry_width');
		$this->data['entry_height'] = $this->language->get('entry_height');
		$this->data['entry_show'] = $this->language->get('entry_show');
		$this->data['entry_article_count'] = $this->language->get('entry_article_count');
		$this->data['entry_category_permission'] = $this->language->get('entry_category_permission');
		$this->data['entry_show_create_date'] = $this->language->get('entry_show_create_date');
		$this->data['entry_show_modify_date'] = $this->language->get('entry_show_modify_date');
		$this->data['entry_show_read_times'] = $this->language->get('entry_show_read_times');
		$this->data['entry_show_comment_count'] = $this->language->get('entry_show_comment_count');
		$this->data['entry_comment_alert'] = $this->language->get('entry_comment_alert');
		
		$this->data['entry_stick_to_top_menu'] = $this->language->get('entry_stick_to_top_menu');		
		$this->data['entry_top_menu_order'] = $this->language->get('entry_top_menu_order');		
		$this->data['entry_top_menu_title'] = $this->language->get('entry_top_menu_title');		
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
       		'href'      => $this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		$this->data['action'] = $this->url->link('news/setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['news_setting_category_width'])) {
			$this->data['news_setting_category_width'] = $this->request->post['news_setting_category_width'];
		} else {
			$this->data['news_setting_category_width'] = $this->config->get('news_setting_category_width');
		}
		
		if (isset($this->request->post['news_setting_category_height'])) {
			$this->data['news_setting_category_height'] = $this->request->post['news_setting_category_height'];
		} else {
			$this->data['news_setting_category_height'] = $this->config->get('news_setting_category_height');
		}

		if (isset($this->request->post['news_setting_category_show'])) {
			$this->data['news_setting_category_show'] = $this->request->post['news_setting_category_show'];
		} else {
			$this->data['news_setting_category_show'] = $this->config->get('news_setting_category_show');
		}

		if (isset($this->request->post['news_setting_news_per_page'])) {
			$this->data['news_setting_news_per_page'] = $this->request->post['news_setting_news_per_page'];
		} else {
			$this->data['news_setting_news_per_page'] = $this->config->get('news_setting_news_per_page');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_width'])) {
			$this->data['news_setting_thumbnail_width'] = $this->request->post['news_setting_thumbnail_width'];
		} else {
			$this->data['news_setting_thumbnail_width'] = $this->config->get('news_setting_thumbnail_width');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_height'])) {
			$this->data['news_setting_thumbnail_height'] = $this->request->post['news_setting_thumbnail_height'];
		} else {
			$this->data['news_setting_thumbnail_height'] = $this->config->get('news_setting_thumbnail_height');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_show'])) {
			$this->data['news_setting_thumbnail_show'] = $this->request->post['news_setting_thumbnail_show'];
		} else {
			$this->data['news_setting_thumbnail_show'] = $this->config->get('news_setting_thumbnail_show');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_2col_width'])) {
			$this->data['news_setting_thumbnail_2col_width'] = $this->request->post['news_setting_thumbnail_2col_width'];
		} else {
			$this->data['news_setting_thumbnail_2col_width'] = $this->config->get('news_setting_thumbnail_2col_width');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_2col_height'])) {
			$this->data['news_setting_thumbnail_2col_height'] = $this->request->post['news_setting_thumbnail_2col_height'];
		} else {
			$this->data['news_setting_thumbnail_2col_height'] = $this->config->get('news_setting_thumbnail_2col_height');
		}
		
		if (isset($this->request->post['news_setting_thumbnail_2col_show'])) {
			$this->data['news_setting_thumbnail_2col_show'] = $this->request->post['news_setting_thumbnail_2col_show'];
		} else {
			$this->data['news_setting_thumbnail_2col_show'] = $this->config->get('news_setting_thumbnail_2col_show');
		}
		
		if (isset($this->request->post['news_setting_comments_per_page'])) {
			$this->data['news_setting_comments_per_page'] = $this->request->post['news_setting_comments_per_page'];
		} else {
			$this->data['news_setting_comments_per_page'] = $this->config->get('news_setting_comments_per_page');
		}	
		
		if (isset($this->request->post['news_setting_image_width'])) {
			$this->data['news_setting_image_width'] = $this->request->post['news_setting_image_width'];
		} else {
			$this->data['news_setting_image_width'] = $this->config->get('news_setting_image_width');
		}
		
		if (isset($this->request->post['news_setting_image_height'])) {
			$this->data['news_setting_image_height'] = $this->request->post['news_setting_image_height'];
		} else {
			$this->data['news_setting_image_height'] = $this->config->get('news_setting_image_height');
		}
		
		if (isset($this->request->post['news_setting_image_show'])) {
			$this->data['news_setting_image_show'] = $this->request->post['news_setting_image_show'];
		} else {
			$this->data['news_setting_image_show'] = $this->config->get('news_setting_image_show');
		}
		
		if (isset($this->request->post['news_setting_article_count'])) {
			$this->data['news_setting_article_count'] = $this->request->post['news_setting_article_count'];
		} else {
			$this->data['news_setting_article_count'] = $this->config->get('news_setting_article_count');
		}
		
		if (isset($this->request->post['news_setting_show_create_date'])) {
			$this->data['news_setting_show_create_date'] = $this->request->post['news_setting_show_create_date'];
		} else {
			$this->data['news_setting_show_create_date'] = $this->config->get('news_setting_show_create_date');
		}
		
		if (isset($this->request->post['news_setting_category_permission'])) {
			$this->data['news_setting_category_permission'] = $this->request->post['news_setting_category_permission'];
		} else {
			$this->data['news_setting_category_permission'] = $this->config->get('news_setting_category_permission');
		}
		
		if (isset($this->request->post['news_setting_comment_alert'])) {
			$this->data['news_setting_comment_alert'] = $this->request->post['news_setting_comment_alert'];
		} else {
			$this->data['news_setting_comment_alert'] = $this->config->get('news_setting_comment_alert');
		}
		
		if (isset($this->request->post['news_setting_show_modify_date'])) {
			$this->data['news_setting_show_modify_date'] = $this->request->post['news_setting_show_modify_date'];
		} else {
			$this->data['news_setting_show_modify_date'] = $this->config->get('news_setting_show_modify_date');
		}
		
		if (isset($this->request->post['news_setting_show_read_times'])) {
			$this->data['news_setting_show_read_times'] = $this->request->post['news_setting_show_read_times'];
		} else {
			$this->data['news_setting_show_read_times'] = $this->config->get('news_setting_show_read_times');
		}
		
		if (isset($this->request->post['news_setting_show_comment_count'])) {
			$this->data['news_setting_show_comment_count'] = $this->request->post['news_setting_show_comment_count'];
		} else {
			$this->data['news_setting_show_comment_count'] = $this->config->get('news_setting_show_comment_count');
		}
		
		if (isset($this->request->post['news_setting_all_articles_to_top_menu'])) {
			$this->data['news_setting_all_articles_to_top_menu'] = $this->request->post['news_setting_all_articles_to_top_menu'];
		} else {
			$this->data['news_setting_all_articles_to_top_menu'] = $this->config->get('news_setting_all_articles_to_top_menu');
		}
		
		if (isset($this->request->post['news_setting_all_articles_top_order'])) {
			$this->data['news_setting_all_articles_top_order'] = $this->request->post['news_setting_all_articles_top_order'];
		} else {
			$this->data['news_setting_all_articles_top_order'] = $this->config->get('news_setting_all_articles_top_order');
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
				
		if (isset($this->request->post['news_setting_all_articles_top_title'])) {
			$this->data['news_setting_all_articles_top_title'] = $this->request->post['news_setting_all_articles_top_title'];
		} else {
			$this->data['news_setting_all_articles_top_title'] = $this->config->get('news_setting_all_articles_top_title');
		}
		
		if (isset($this->request->post['news_setting_all_articles_meta_keyword'])) {
			$this->data['news_setting_all_articles_meta_keyword'] = $this->request->post['news_setting_all_articles_meta_keyword'];
		} else {
			$this->data['news_setting_all_articles_meta_keyword'] = $this->config->get('news_setting_all_articles_meta_keyword');
		}
		
		if (isset($this->request->post['news_setting_all_articles_meta_description'])) {
			$this->data['news_setting_all_articles_meta_description'] = $this->request->post['news_setting_all_articles_meta_description'];
		} else {
			$this->data['news_setting_all_articles_meta_description'] = $this->config->get('news_setting_all_articles_meta_description');
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->template = 'news/setting.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'news/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function getVersion() {
		return 'v2.3.0';
	}	
}
?>