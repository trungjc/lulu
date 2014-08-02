<?php  
class ControllerModuleCategory extends Controller {
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
	protected function index($setting) {
		$this->language->load('module/category');

		$this->data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$this->data['category_id'] = $parts[0];
		} else {
			$this->data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$total = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category['category_id']));

			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {
				$data = array(
					'filter_category_id'  => $child['category_id'],
					'filter_sub_category' => true
				);

				$product_total = $this->model_catalog_product->getTotalProducts($data);

				$total += $product_total;

				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name'        => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])	
				);		
			}

			$this->data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $total . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);	
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/category.tpl';
		} else {
			$this->template = 'default/template/module/category.tpl';
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
                            
                //$categories = $this->model_catalog_category->getCategories(0);

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