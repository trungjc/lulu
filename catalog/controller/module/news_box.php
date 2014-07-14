<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerModuleNewsbox extends Controller {
	protected function index($setting) {
		
		$this->load->model('catalog/news');
		$this->language->load('news/news');
		$this->load->model('tool/image');
		
		$this->data['news'] = array();
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_news_not_found'] = $this->language->get('text_news_not_found');
		$this->data['text_updated_on'] = $this->language->get('text_updated_on');
		$this->data['text_posted_on'] = $this->language->get('text_posted_on');
		$this->data['text_read'] = $this->language->get('text_read');
		$this->data['text_times'] = $this->language->get('text_times');
		$this->data['text_read_more'] = $this->language->get('text_read_more');
		$this->data['text_comments'] = $this->language->get('text_comments');
		
		$data = array(
			'sort'  => 'n.sort_order, nd.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit'],
		);
		
		if ($setting['news_category_id'] == -1)
		{
			$this->data['heading_title'] = $this->language->get('title_latest');			
		} else {
			$data['filter_news_category_id'] = $setting['news_category_id'];
			$category = $this->model_catalog_news->getNewsCategory($setting['news_category_id']);
			$this->data['heading_title'] = $category['name'];
		}
		
		$results = $this->model_catalog_news->getArticles($data);
		
		$this->data['min_height'] = $setting['image_height'];
		$this->data['articles'] = array();
		foreach ($results as $result) {
			$this->data['articles'][] = array(
        		'title' => $result['title'],
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
        		'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
        		'description' => html_entity_decode($result['description']),
        		'short_description' => html_entity_decode($result['short_description']),
        		'count_read' => $result['count_read'],
        		'image' => $this->model_tool_image->resize(($result['image']) ? ($result['image']) : 'news_logo.png', $setting['image_width'], $setting['image_height']),
	    		'href'  => $this->url->link('news/news', (($setting['news_category_id'] != -1) ? 'npath=' . $setting['news_category_id'] : '') . '&news_id=' . $result['news_id']),
				'href_comment'  => $this->url->link('news/news', (($setting['news_category_id'] != -1) ? 'npath=' . $setting['news_category_id'] : '')  . '&news_id=' . $result['news_id'] . '#comment_area'),
				'news_comment_count' =>$this->model_catalog_news->getTotalCommentsByNewsId($result['news_id'])
      		);
		}
		
		$this->data['show_create_date'] = $this->config->get('news_setting_show_create_date');
		$this->data['show_modify_date'] = $this->config->get('news_setting_show_modify_date');
		
		if($setting['position']=='content_top'||$setting['position']=='content_bottom'){
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newsbox.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/newsbox.tpl';
			} else {
					$this->template = 'default/template/module/newsbox.tpl';
			}
		}  else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newsbox_side.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/newsbox_side.tpl';
			} else {
					$this->template = 'default/template/module/newsbox_side.tpl';
			}
		}	
		
		$this->render();
	}
}
?>