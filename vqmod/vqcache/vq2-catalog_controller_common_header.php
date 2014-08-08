<?php   
class ControllerCommonHeader extends Controller {

	private function getposts($news_category_id, $limit, $father = "") {
		$children_data = array();
		
		// get the post
		$postdata = array(
			'filter_news_category_id' => $news_category_id,
			'start' => 0,
			'limit' => $limit, 
		);
		
		$posts = $this->model_catalog_news->getArticles($postdata);
		
		foreach ($posts as $post) {								
			$children_data[] = array(
				'name'  => $post['title'] ,
				'href'  => $this->url->link('news/news', 'npath=' . $father . $news_category_id . '&news_id=' . $post['news_id']),
			);					
		}						
		return $children_data;
	}
	
	private function sortByOneKey(array $array, $key, $asc = true) {
		$result = array();
		   
		$values = array();
		foreach ($array as $id => $value) {
			$values[$id] = isset($value[$key]) ? $value[$key] : '';
		}
		   
		if ($asc) {
			asort($values);
		}
		else {
			arsort($values);
		}
		   
		foreach ($values as $key => $value) {
			$result[$key] = $array[$key];
		}
		   
		return $result;
	}
			
private static function sortCatCmenu($a, $b)
                {
                    $val = $a['sort_order'] - $b['sort_order'];
                    if($val == 0)
                    {
                        return strcmp(strtolower($a['name']), strtolower($b['name']));
                    }
                    return $val;
                }

                private function seoUrl($link)
                {
                    $parsed_url = @parse_url($link);
                    $http_server = parse_url(HTTP_SERVER);
                    $route = $path = '';
                    if ($this->config->get('config_seo_url') && isset($parsed_url['host']) && $parsed_url['host'] == $http_server['host'] && isset($parsed_url['query']) && substr($parsed_url['query'], 0, 5) == 'route') {
                        $url_query = strstr($parsed_url['query'], '=');
                        if(strpos($url_query, '&')) {
                            $route = substr($url_query, 1, strpos($url_query, '&') - 1);
                        } else {
                            $route = substr($url_query, 1);
                        }
                        $path = substr(html_entity_decode(strstr($url_query, '&')), 1);
                        return $this->url->link($route, $path);
                    } else {
                        return ($link == '#' ? '#" onclick="return false;' : $link);
                    }
                }
	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		$this->data['base'] = $server;
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	 
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['name'] = $this->config->get('config_name');

		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}		

		$this->language->load('common/header');

		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
		$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_checkout'] = $this->language->get('text_checkout');

		$this->data['home'] = $this->url->link('common/home');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['shopping_cart'] = $this->url->link('checkout/cart');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

		// Daniel's robot detector
		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", trim($this->config->get('config_robots')));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// A dirty hack to try to set a cookie for the multi-store feature
		$this->load->model('setting/store');

		$this->data['stores'] = array();

		if ($this->config->get('config_shared') && $status) {
			$this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();

			$stores = $this->model_setting_store->getStores();

			foreach ($stores as $store) {
				$this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
			}
		}

		// Search		
		if (isset($this->request->get['search'])) {
			$this->data['search'] = $this->request->get['search'];
		} else {
			$this->data['search'] = '';
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->data['categories'] = array();

		$categories = array();

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$product_total = $this->model_catalog_product->getTotalProducts($data);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);						
				}

				// Level 1
				$this->data['categories'][] = array(

				'sort_order'     => $category['sort_order'],
			
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$this->children = array(
			'module/language',
'module/supermenu',
			'module/supermenu_settings',
			'module/currency',
			'module/cart'
		);


				$this->load->model('catalog/news');
		
				$categories = $this->model_catalog_news->getCategories(0);				
				foreach ($categories as $category) {
					if ($category['top']) {
						$children_data = array();		
						$children_articles = array();
						if ($category['top_article']) { $children_articles = $this->getposts($category['news_category_id'], $category['top_article'], ""); }
						
						// get subCategories						
						$children = $this->model_catalog_news->getCategories($category['news_category_id']);				
						foreach ($children as $child) {
							// for the sub of sub
							$grand_data = array();
							$grand_articles = array();
							if ($child['top_article']) { $grand_articles = $this->getposts($child['news_category_id'], $child['top_article'], $category['news_category_id'] . "_"); }
							
							if ($this->config->get('news_setting_article_count')) {									
								$data = array(
									'filter_news_category_id'  => $child['news_category_id'],
									'filter_sub_category' => true	
								);		
							
								$total = $this->model_catalog_news->getTotalArticles($data);
							}
									
							$children_data[] = array(
								'name'  => ($this->config->get('news_setting_article_count')) ? $child['name'] . ' (' . $total . ')' : $child['name'],
								'href'  => $this->url->link('news/category', 'npath=' . $category['news_category_id'] . '_' . $child['news_category_id']),
								'children' => $grand_data,
								'column'   => $category['column'] ? $category['column'] : 1,
								'article' => $grand_articles,
							);					
						}
						
						// Level 1
						$this->data['categories'][] = array(
							'name'     => $category['name'],
							'sort_order'     => $category['sort_order'],
							'children' => $children_data,
							'column'   => $category['column'] ? $category['column'] : 1,
							'href'     => $this->url->link('news/category', 'npath=' . $category['news_category_id']),
							'is_news'  => true,
							'article' => $children_articles,
						);
					}
				}
				
				// for the all category page
				if ($this->config->get('news_setting_all_articles_to_top_menu')) {
					$titles = $this->config->get('news_setting_all_articles_top_title');
					$this->data['categories'][] = array(
						'sort_order'     => $this->config->get('news_setting_all_articles_top_order'),
						'name'     => $titles[$this->config->get('config_language_id')],
						'children' => array(),
						'href'     => $this->url->link('news/all', ''),
						'is_news'  => true,
						'article' => null,
					);
				}
									
				$this->data['categories'] = $this->sortByOneKey($this->data['categories'], 'sort_order');
			
$this->data['categories'] = array();
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}

$this->load->model('setting/extension');
        
                $extensions = $this->model_setting_extension->getExtensions('module');

                $cmenu_installed = false;
                foreach ($extensions as $extension) {
                    if($extension['code'] == 'myoccmenu')
                    {
                        $cmenu_installed = true;
                        break;
                    }
                }

                $current_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];

                $this->load->model('catalog/category');
                $this->load->model('catalog/product');
                $this->load->model('myoc/cmenu');

                $this->data['categories'] = array();
                            
                //$categories = array();

                $data = array(
                    'parent_cmenu_id' => 0,
                    'parent_category_id' => 0,
                );
                $cmenus = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($data) : array();
                $cmenus = array_merge($cmenus, $categories);
                
                usort($cmenus, array(get_class($this), 'sortCatCmenu'));

                foreach ($cmenus as $cmenu) {
                    if((!isset($setting) || !isset($cmenu['in_module']) || $cmenu['in_module']) && (isset($setting) || $cmenu['top']))
                    {
                        $children_data = array();
                        $parent_id = 0;

                        if(isset($cmenu['category_id']))
                        {
                            $category_children = $this->model_catalog_category->getCategories($cmenu['category_id']);
                        
                            $data = array(
                                'parent_category_id' => $cmenu['category_id'],
                            );
                            $cmenu_children = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($data) : array();
                        
                            $cmenu_children = array_merge($cmenu_children, $category_children);
                        } else {
                            $data = array(
                                'parent_cmenu_id' => $cmenu['cmenu_id'],
                            );
                            $cmenu_children = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($data) : array();
                        }
                        usort($cmenu_children, array(get_class($this), 'sortCatCmenu'));

                        foreach ($cmenu_children as $cmenu_child) {
                            //3rd level
                            $gchildren_data = array();

                            if(isset($cmenu_child['category_id']))
                            {
                                $category_gchildren = $this->model_catalog_category->getCategories($cmenu_child['category_id']);
                            
                                $data = array(
                                    'parent_category_id' => $cmenu_child['category_id'],
                                );
                                $cmenu_gchildren = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($data) : array();
                            
                                $cmenu_gchildren = array_merge($cmenu_gchildren, $category_gchildren);
                            } else {
                                $data = array(
                                    'parent_cmenu_id' => $cmenu_child['cmenu_id'],
                                );
                                $cmenu_gchildren = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($data) : array();
                            }

                            foreach ($cmenu_gchildren as $cmenu_gchild) {
                                if(isset($cmenu_gchild['category_id']))
                                {
                                    $data = array(
                                        'filter_category_id'  => $cmenu_gchild['category_id'],
                                        'filter_sub_category' => true   
                                    );      
                                        
                                    $product_total = $this->model_catalog_product->getTotalProducts($data);
                                    
                                    $href = $this->url->link('product/category', 'path=' . $cmenu['category_id'] . '_' . $cmenu_child['category_id'] . '_' . $cmenu_gchild['category_id']);

                                    $gchildren_data[] = array(
                                        'category_id' => $cmenu_gchild['category_id'],
                                        'name'    => $cmenu_gchild['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                                        'href'    => $href, 
                                        'popup'   => false,
                                        'current' => $current_url == $href,
                                    );
                                } elseif((!isset($setting) && $cmenu_gchild['top']) || (isset($setting) && $cmenu_gchild['in_module'])) {
                                    $href = $this->seoUrl($cmenu_gchild['link']);

                                    $gchildren_data[] = array(
                                        'category_id' => $cmenu_gchild['cmenu_id'],
                                        'name'    => $cmenu_gchild['name'],
                                        'href'    => $href . ($cmenu_gchild['popup'] ? '" target="_blank' : ''),
                                        'popup'   => $cmenu_gchild['popup'],
                                        'current' => $current_url == $href,
                                    );
                                }
                            }
                            //end 3rd level

                            if(isset($cmenu_child['category_id']))
                            {
                                $data = array(
                                    'filter_category_id'  => $cmenu_child['category_id'],
                                    'filter_sub_category' => true   
                                );      
                                    
                                $product_total = $this->model_catalog_product->getTotalProducts($data);

                                $href = $this->url->link('product/category', 'path=' . $cmenu['category_id'] . '_' . $cmenu_child['category_id']);
                                
                                $children_data[] = array(
                                    'category_id' => $cmenu_child['category_id'],
                                    'name'     => $cmenu_child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                                    'children' => $gchildren_data, //3rd level
                                    'column'   => $cmenu_child['column'] ? $cmenu_child['column'] : 1,
                                    'href'     => $href,    
                                    'popup'    => false,
                                    'current'  => $current_url == $href,
                                );
                            } elseif((!isset($setting) && $cmenu_child['top']) || (isset($setting) && $cmenu_child['in_module'])) {
                                $href = $this->seoUrl($cmenu_child['link']);

                                if(!isset($this->request->get['path']) && $href == ("http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")) {
                                    $this->data['child_id'] = $cmenu_child['cmenu_id'];
                                    $parent_id = $cmenu_child['parent_cmenu_id'] ? $cmenu_child['parent_cmenu_id'] : $cmenu_child['parent_category_id'];
                                }

                                $children_data[] = array(
                                    'category_id' => $cmenu_child['cmenu_id'],
                                    'name'     => $cmenu_child['name'],
                                    'children' => $gchildren_data, //3rd level
                                    'column'   => $cmenu_child['column'] ? $cmenu_child['column'] : 1,
                                    'href'     => $href . ($cmenu_child['popup'] ? '" target="_blank' : ''),
                                    'popup'    => $cmenu_child['popup'],
                                    'current'  => $current_url == $href,
                                );
                            }
                        }

                        $href = isset($cmenu['link']) ? $this->seoUrl($cmenu['link']) : $this->url->link('product/category', 'path=' . $cmenu['category_id']);

                        if(!isset($this->request->get['path'])) {
                            if($parent_id) {
                                $this->data['category_id'] = $parent_id;
                            } elseif ($href == ("http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")) {
                                $this->data['category_id'] = isset($cmenu['cmenu_id']) ? $cmenu['cmenu_id'] : $cmenu['category_id'];
                            }
                        }

                        $this->data['categories'][] = array(
                            'category_id' => isset($cmenu['cmenu_id']) ? $cmenu['cmenu_id'] : $cmenu['category_id'],
                            'name'     => $cmenu['name'],
                            'children' => $children_data,
                            'column'   => $cmenu['column'] ? $cmenu['column'] : 1,
                            'href'     => $href . ((isset($cmenu['popup']) && $cmenu['popup']) ? '" target="_blank' : ''),
                            'popup'    => isset($cmenu['popup']) ? $cmenu['popup'] : false,
                            'current'  => $current_url == $href,
                        );
                    }
                }
		$this->render();
	} 	
}
?>
