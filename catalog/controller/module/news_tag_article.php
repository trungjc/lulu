<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerModuleNewsTagArticle extends Controller {
	protected function index($setting) {
		
		$this->load->model('catalog/news');
		$tags = array();

		if (isset($this->request->get['product_id'])) {
			$this->load->model('catalog/product');
			if (method_exists($this->model_catalog_product, 'getProductTags')) {
				$results = $this->model_catalog_product->getProductTags($this->request->get['product_id']);
				foreach ($results as $result) {
					$tags[] = $result['tag'];
				}
			} else {
				$results = $this->model_catalog_product->getProductTags2($this->request->get['product_id']);
				foreach ($results as $result) {
					$tags = explode(',', $result['tag']);
				}
			}
		}
				
		if (isset($this->request->get['filter_tag'])) {
			$tags = array_unique(array_merge( array( $this->request->get['filter_tag']) ,  $tags));
		}
		
		$this->language->load('news/news');
		$this->data['heading_title'] = $this->language->get('title_tag_article');	
		$this->load->model('tool/image');
		
		
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_news_not_found'] = $this->language->get('text_news_not_found');
		$this->data['text_updated_on'] = $this->language->get('text_updated_on');
		$this->data['text_posted_on'] = $this->language->get('text_posted_on');
		$this->data['text_read'] = $this->language->get('text_read');
		$this->data['text_times'] = $this->language->get('text_times');
		$this->data['text_read_more'] = $this->language->get('text_read_more');
		$this->data['text_comments'] = $this->language->get('text_comments');
		
		$this->data['min_height'] = $setting['image_height'];

		$this->data['articles'] = array();
		
		$limit = $setting['limit'];
		$count = 0;
		$posted_id = array();
		
		foreach ($tags as $tag) {
			$data = array(
				'filter_tag' => trim($tag),
				'start' => 0,
				'limit' => $limit,
			);
					
			$results = $this->model_catalog_news->getArticles($data);
			
			foreach ($results as $result) {
				if (key_exists($result['news_id'], $posted_id)) {
					continue;
				} else {
					$posted_id[$result['news_id']] = true;
				}
				$this->data['articles'][] = array(
					'title' => $result['title'],
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
					'description' => html_entity_decode($result['description']),
					'short_description' => html_entity_decode($result['short_description']),
					'count_read' => $result['count_read'],
					'image' => $this->model_tool_image->resize(($result['image']) ? ($result['image']) : 'news_logo.png', $setting['image_width'], $setting['image_height']),
					'href'  => $this->url->link('news/news', 'news_id=' . $result['news_id']),
					'href_comment'  => $this->url->link('news/news', 'news_id=' . $result['news_id'] . '#comment_area'),
					'news_comment_count' =>$this->model_catalog_news->getTotalCommentsByNewsId($result['news_id'])
				);
				$count ++;
				if ($count >= $limit) break;
			}
			if ($count >= $limit) break;
		}
	
		if ($count == 0) {$this->data['hidebox'] = true;}
		
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