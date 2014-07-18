<?php  
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerModuleNewsCategories extends Controller {
	protected function index() {
		$this->language->load('module/news_categories');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['npath'])) {
			$parts = explode('_', (string)$this->request->get['npath']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['news_category_id'] = $parts[0];
		} else {
			$this->data['news_category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		if (isset($parts[2])) {
			$this->data['grand_id'] = $parts[2];
		} else {
			$this->data['grand_id'] = 0;
		}
							
		$this->load->model('catalog/news');	
		
		$this->data['categories'] = array();
					
		$categories = $this->model_catalog_news->getCategories(0);
		
		foreach ($categories as $category) {
			$children_data = array();
			
			$children = $this->model_catalog_news->getCategories($category['news_category_id']);
						
			foreach ($children as $child) {
				$grandchild_data = array();
				
				$grandchild = $this->model_catalog_news->getCategories($child['news_category_id']);
				
				foreach ($grandchild as $grand) {
					if ($this->config->get('news_setting_article_count')) {
						$data = array(
							'filter_news_category_id'  => $grand['news_category_id'],
							'filter_sub_category' => true
						);		
							
						$article_total = $this->model_catalog_news->getTotalArticles($data);
					}			
					$grandchild_data[] = array(
						'news_category_id' => $grand['news_category_id'],
						'name'        => ($this->config->get('news_setting_article_count')) ? $grand['name'] . ' (' . $article_total . ')' : $grand['name'],
						'href'        => $this->url->link('news/category', 'npath=' . $child['news_category_id'] . '_' . $grand['news_category_id'])	
					);					
				}
				//echo "<pre>";var_dump($grandchild_data);
				if ($this->config->get('news_setting_article_count')) {
					$data = array(
						'filter_news_category_id'  => $child['news_category_id'],
						'filter_sub_category' => true
					);		
						
					$article_total = $this->model_catalog_news->getTotalArticles($data);
				}			
				$children_data[] = array(
					'news_category_id' => $child['news_category_id'],
					'name'        => ($this->config->get('news_setting_article_count')) ? $child['name'] . ' (' . $article_total . ')' : $child['name'],
					'children'    => $grandchild_data,
					'href'        => $this->url->link('news/category', 'npath=' . $category['news_category_id'] . '_' . $child['news_category_id'])	
				);	
				
			}
			
			if ($this->config->get('news_setting_article_count')) {
				$data = array(
					'filter_news_category_id'  => $category['news_category_id'],
					'filter_sub_category' => true	
				);		
					
				$product_total = $this->model_catalog_news->getTotalArticles($data);
			}
			
			$this->data['categories'][] = array(
				'category_id' => $category['news_category_id'],
				'name'        => ($this->config->get('news_setting_article_count')) ? $category['name'] . ' (' . $product_total . ')' : $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('news/category', 'npath=' . $category['news_category_id'])
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news_categories.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/news_categories.tpl';
		} else {
			$this->template = 'default/template/module/news_categories.tpl';
		}
		
		$this->render();
  	}
}
?>