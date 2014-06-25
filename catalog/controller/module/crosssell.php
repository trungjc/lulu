<?php  
class ControllerModuleCrossSell extends Controller {
	protected function index($setting) {
		$languageId = $this->config->get('config_language_id');

   		$this->data['heading_title'] = $setting['title'][$languageId];
		
		$this->data['button_cart'] = $this->language->get('button_cart');

		$this->load->model('catalog/crosssell');
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');
		
		$this->data['products'] = array();

        $routes = $this->model_catalog_crosssell->getLayoutRoutes($setting['layout_id']);

	    $filter = false;
		foreach($routes as $route)
	        if (stripos($route['route'],'product/category')!==false and stripos($this->request->get['route'],'product/category')!==false)
	            $filter = 'category'; 
	        elseif (stripos($route['route'],'product/manufacturer')!==false and stripos($this->request->get['route'],'product/manufacturer')!==false)
	            $filter = 'manufacturer'; 
	        elseif (stripos($route['route'],'product/product')!==false and stripos($this->request->get['route'],'product/product')!==false)
	            $filter = 'product'; 
	        else
	            $filter = false;
            
         $ok = true;

		$curr_cats = array();
		$current_products = array();
		if ($filter=='category' and isset($this->request->get['path'])) {
			$path = explode("_",$this->request->get['path']);
			$curr_cats[] = $path[count($path)-1];
			$current_products = array_merge( $current_products, $this->model_catalog_crosssell->getProductsByCats( $curr_cats ) );
		}		
		
		$curr_man = 0; 
		if ($filter=='manufacturer' and isset($this->request->get['manufacturer_id'])) {
			$curr_man = (int) $this->request->get['manufacturer_id'];
			$current_products = array_merge( $current_products, $this->model_catalog_crosssell->getProductsByMan( $curr_man ) );
		}		
		
		$curr_pro = 0; 
		if ($filter=='product' and isset($this->request->get['product_id'])) {
			$curr_pro = (int) $this->request->get['product_id'];
			$p = $this->model_catalog_product->getProduct($curr_pro);
			$rc = $this->model_catalog_product->getCategories($curr_pro);
			$curr_man = $p['manufacturer_id']; 
			foreach($rc as $c) $curr_cats[] = $c['category_id']; 

		}		
		 

		//echo "<xmp>Setting:"; var_dump($setting); echo "</xmp>";
		if ($curr_pro)
			$current_products[] = $curr_pro;

		foreach($this->cart->getProducts() as $p) {
			if (in_array($p['product_id'],$current_products)===false)
				$current_products[] = $p['product_id'];
		}

		//echo "<xmp>Current products:"; var_dump($current_products); echo "</xmp>";
		$products = $this->model_catalog_crosssell->getRelated($setting,array_unique($current_products));		
		$limit = ($setting['limit']>count($products)) ? count($products) : (int) $setting['limit']; 

		$results = array();		
		if ($products) {
	        if (count($products)<=$limit) {
	            $results = array_keys($products);
	        } else  {
	    		$results =  ($limit>1) ? array_rand($products,$limit) : array( rand(0,count($products)-1) );
	        }
       }

		foreach ($results as $pid) {
			$result = (isset($products[$pid]) and $products[$pid]) ? $this->model_catalog_product->getProduct($products[$pid]) : false;

			if ($result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
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
					'description'=> $result['description'],
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}
		}

		$this->data['title'] = $setting['title'];
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/crosssell.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/crosssell.tpl';
		} else {
			$this->template = 'default/template/module/crosssell.tpl';
		}
		
		$this->render();
	}
}
?>