<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php 
class ControllerBlogCategory extends Controller {
	public function index() {  
		$this->language->load('news/news');
		
		$this->load->model('catalog/news');
		$this->load->model('tool/image');
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
			
		if (isset($this->request->get['npath'])) {
			$npath = '';
		
			$parts = explode('_', (string)$this->request->get['npath']);
		
			foreach ($parts as $npath_id) {
				if (!$npath) {
					$npath = $npath_id;
				} else {
					$npath .= '_' . $npath_id;
				}
									
				$category_info = $this->model_catalog_news->getNewsCategory($npath_id);
				
				if ($category_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('blog/category', 'npath=' . $npath),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}
		
		$category_info = $this->model_catalog_news->getNewsCategory($category_id);

		if ($category_info) {
	  		$this->document->setTitle($category_info['name']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			$this->document->addLink($this->url->link('blog/category', 'npath=' . $this->model_catalog_news->getFullPath($category_id)), 'canonical');			
			$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
			
			$this->data['heading_title'] = $category_info['name'];
			if ($this->config->get('news_setting_category_show')) {
				$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('news_setting_category_width'), $this->config->get('news_setting_category_height'));
			} else {
				$this->data['thumb'] = false;
			}
			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			
			$this->data['text_empty'] = $this->language->get('text_news_not_found');			
			$this->data['text_updated_on'] = $this->language->get('text_updated_on');
			$this->data['text_posted_on'] = $this->language->get('text_posted_on');
			$this->data['text_read'] = $this->language->get('text_read');
			$this->data['text_times'] = $this->language->get('text_times');
			$this->data['text_read_more'] = $this->language->get('text_read_more');
			$this->data['text_comments'] = $this->language->get('text_comments');
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_1col'] = $this->language->get('text_1col');
			$this->data['text_2col'] = $this->language->get('text_2col');
			$this->data['text_sub_category'] = $this->language->get('text_sub_category');

			$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');
      		
			$this->data['min_height'] = $this->config->get('news_setting_thumbnail_height');
			
			$p_url = '';
			$l_url = '';
			$s_url = '';
			
      			// News All		
			
			if (isset($this->request->get['npath'])) {
				$p_url .= '&npath=' . $this->request->get['npath'];
			}

			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
				$s_url = '&sort=' . $this->request->get['sort'];
			} else {
				$sort = 'order-A-date-D';
			} 
			
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
					
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
				$l_url = '&limit=' . $this->request->get['limit'];
			} else {
				$limit = $this->config->get('news_setting_news_per_page');
			}
			
			$this->data['categories'] = array();
			
			$results = $this->model_catalog_news->getCategories($category_id);
			
			foreach ($results as $result) {
				if ($this->config->get('news_setting_article_count')) {
					$data = array(
						'filter_news_category_id'  => $result['news_category_id'],
						'filter_sub_news_category' => true	
					);
							
					$article_total = $this->model_catalog_news->getTotalArticles($data);
				}
				
				$this->data['categories'][] = array(
					'name'  => ($this->config->get('news_setting_article_count')) ? $result['name'] . ' (' . $article_total . ')' : $result['name'],
					'href'  => $this->url->link('blog/category', 'npath=' . $this->request->get['npath'] . '_' . $result['news_category_id'] . $s_url . $l_url),
				);
			}				
		
			$this->data['articles'] = array();
			
			$data = array(
				'sort'                => $sort,
				'start'               => ($page - 1) * $limit,
				'limit'               => $limit,
				'filter_news_category_id' => $category_id,
			);			
			
			$results = $this->model_catalog_news->getArticles($data);
			foreach ($results as $result) {
				if ($this->config->get('news_setting_thumbnail_show')) {
					$image = $this->model_tool_image->resize(($result['image']) ? ($result['image']) : 'news_logo.png', $this->config->get('news_setting_thumbnail_width'), $this->config->get('news_setting_thumbnail_height'));
				} else {
					$image = false;
				}				
				if ($this->config->get('news_setting_thumbnail_2col_show')) {
					$image2 = $this->model_tool_image->resize(($result['image']) ? ($result['image']) : 'news_logo.png', $this->config->get('news_setting_thumbnail_2col_width'), $this->config->get('news_setting_thumbnail_2col_height'));
				} else {
					$image2 = false;
				}				
				if ($this->config->get('news_setting_show_read_times')) {
					$count_read = $result['count_read'];
				} else {
					$count_read = false;
				}
				if ($this->config->get('news_setting_show_comment_count')) {
					$news_comment_count = $this->model_catalog_news->getTotalCommentsByNewsId($result['news_id']);
				} else {
					$news_comment_count = false;
				}
				$this->data['articles'][] = array(
					'title' => $result['title'],
					'date_added' => ($this->config->get('news_setting_show_create_date')) ? date($this->language->get('date_format_short'), strtotime($result['date_added'])): false,
					'date_modified' => ($this->config->get('news_setting_show_modify_date')) ? date($this->language->get('date_format_short'), strtotime($result['date_modified'])) : false,
					'description' => html_entity_decode($result['description']),
					'short_description' => html_entity_decode($result['short_description']),
					'count_read' => $count_read,
					'image' => $image,
					'image2' => $image2,
					'href'  => $this->url->link('blog/article', 'npath=' . $npath . '&news_id=' . $result['news_id']),
					'href_comment'  => $this->url->link('blog/article', 'npath=' . $npath . '&news_id=' . $result['news_id'] . '#comment_area'),
					'news_comment_count' => $news_comment_count,
				);
			}
						
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_latest_first'),
				'value' => 'order-A-date-D',
				'href'  => $this->url->link('blog/category', 'sort=order-A-date-D' . $p_url . $l_url),
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_oldest_first'),
				'value' => 'order-A-date-A',
				'href'  => $this->url->link('blog/category', 'sort=order-A-date-A' . $p_url . $l_url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'title-A',
				'href'  => $this->url->link('blog/category', 'sort=title-A' . $p_url . $l_url)
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'title-D',
				'href'  => $this->url->link('blog/category', 'sort=title-D' . $p_url . $l_url)
			);
			
			$this->data['limits'] = array();
			
			$plimits = array( 1 => 10, 2 => 20, 3 => 30);
			
			if (!in_array($this->config->get('news_setting_news_per_page'), $plimits)) {
				$plimits[0] = $this->config->get('news_setting_news_per_page');
			}
			
			foreach ($plimits as $plimit)
			{
				$this->data['limits'][] = array(
					'text'  => $plimit,
					'value' => $plimit,
					'href'  => $this->url->link('blog/category', $p_url . $s_url . '&limit=' . $plimit)
				);
			}
			
			// Pagination All News start      		
			$filter = array();
			$filter['filter_news_category_id'] = $category_id;
			$news_total = $this->model_catalog_news->getTotalArticles($filter);
		
			$pagination = new Pagination();
			$pagination->total = $news_total;
			$pagination->page = $page;
			$pagination->limit = $limit; 
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('blog/category', $p_url . $s_url . $l_url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
			// Pagination All News end
			
			$this->data['sort'] = $sort;
			$this->data['limit'] = $limit;
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/category.tpl';
			} else {
				$this->template = 'default/template/news/category.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
		
			$this->response->setOutput($this->render());
    	} else {
			$url = '';
			
			if (isset($this->request->get['npath'])) {
				$url .= '&npath=' . $this->request->get['npath'];
			}
												
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
											
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('blog/category', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

			$this->data['heading_title'] = $this->language->get('text_error');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
					
			$this->response->setOutput($this->render());
		}
	}
}
?>
