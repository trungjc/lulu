<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerModuleNewsTagProduct extends Controller {
	protected function index($setting) {
		$this->language->load('module/news_tag_product');
		
      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_cart'] = $this->language->get('button_cart');

		$tags = array();

		if (isset($this->request->get['news_id'])) {
			$this->load->model('catalog/news');
			$results = $this->model_catalog_news->getArticleTags($this->request->get['news_id']);
			foreach ($results as $result) {
				$tags[] = $result['tag'];
			}
		}
				
		if (isset($this->request->get['filter_tag'])) {
			$tags = array_unique(array_merge( array( $this->request->get['filter_tag']) ,  $tags));
		}		
				
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();
		
		$limit = $setting['limit'];
		$count = 0;
		$posted_id = array();
		
	foreach ($tags as $tag) {	
		$data = array(
			'filter_tag' => $tag,
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $limit,
		);	
		
		$results = $this->model_catalog_product->getProducts($data);

		foreach ($results as $result) {
			if (key_exists($result['product_id'], $posted_id)) {
				continue;
			} else {
				$posted_id[$result['product_id']] = true;
			}
			
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			
			$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
			$count ++;
			if ($count >= $limit) break;
		}
		if ($count >= $limit) break;
	}
		if ($count == 0) {$this->data['hidebox'] = true;}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/news_tag_product.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/news_tag_product.tpl';
		} else {
			$this->template = 'default/template/module/news_tag_product.tpl';
		}

		$this->render();
	}
}
?>