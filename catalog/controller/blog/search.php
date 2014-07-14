<?php 
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php 
class ControllerBlogSearch extends Controller {
	public function index() { 
		$this->language->load('news/news');
		
		$this->load->model('catalog/news');
				
		$this->load->model('tool/image'); 

		$f_url = '';
		$l_url = '';
		$s_url = '';
		
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
			$f_url .= '&filter_title=' . $this->request->get['filter_title'];
		} else {
			$filter_title = '';
		} 
		
		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
			$f_url .= '&filter_tag=' . $this->request->get['filter_tag'];
		} elseif (isset($this->request->get['filter_title'])) {
			$filter_tag = $this->request->get['filter_title'];
		} else {
			$filter_tag = '';
		} 
				
		if (isset($this->request->get['filter_content'])) {
			$filter_content = $this->request->get['filter_content'];
			$f_url .= '&filter_content=' . $this->request->get['filter_content'];
		} else {
			$filter_content = '';
		} 
				
		if (isset($this->request->get['filter_intro'])) {
			$filter_intro = $this->request->get['filter_intro'];
			$f_url .= '&filter_intro=' . $this->request->get['filter_intro'];
		} else {
			$filter_intro = '';
		} 
				
		if (isset($this->request->get['filter_news_category_id'])) {
			$filter_news_category_id = $this->request->get['filter_news_category_id'];
			$f_url .= '&filter_news_category_id=' . $this->request->get['filter_news_category_id'];
		} else {
			$filter_news_category_id = 0;
		} 
		
		if (isset($this->request->get['filter_sub_news_category'])) {
			$filter_sub_news_category = $this->request->get['filter_sub_news_category'];
			$f_url .= '&filter_sub_news_category=' . $this->request->get['filter_sub_news_category'];
		} else {
			$filter_sub_news_category = '';
		} 

		// if (isset($this->request->get['page'])) {
			// $url .= '&page=' . $this->request->get['page'];
		// }	
									
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
		
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->language->get('heading_title') .  ' - ' . $this->request->get['keyword']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array( 
	   		'text'	  => $this->language->get('text_home'),
			'href'	  => $this->url->link('common/home'),
	  		'separator' => false
   		);
										
   		$this->data['breadcrumbs'][] = array(
	   		'text'	  => $this->language->get('heading_search_article'),
			'href'	  => $this->url->link('blog/search', $f_url),
	  		'separator' => $this->language->get('text_separator')
   		);
		
		$url1 = '';
		
		if (isset($this->request->get['filter_title'])) {
			$url1 .= '&search=' . $this->request->get['filter_title'];
		}
		
		if (isset($this->request->get['filter_tag'])) {
			$url1 .= '&filter_tag=' . $this->request->get['filter_tag'];
		}
		
		$search_product = '<a href="' . $this->url->link('product/search', $url1) . '">' . $this->language->get('heading_search_product') . '</a> | ';
		
		$this->data['heading_title'] = $search_product . $this->language->get('heading_search_article');
		$this->document->addLink(str_replace('&amp;', '&', $this->url->link('blog/search', $f_url)), 'canonical');
		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
		
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_critea'] = $this->language->get('text_critea');
		$this->data['text_search'] = $this->language->get('text_search');
		$this->data['text_keyword'] = $this->language->get('text_keyword');
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_search_sub_category'] = $this->language->get('text_search_sub_category');
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
		
		$this->data['entry_search'] = $this->language->get('entry_search');
		$this->data['entry_intro'] = $this->language->get('entry_intro');
		$this->data['entry_content'] = $this->language->get('entry_content');
		  
		$this->data['button_search'] = $this->language->get('button_search');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_wishlist'] = $this->language->get('button_wishlist');
		$this->data['button_compare'] = $this->language->get('button_compare');
	
		$this->load->model('catalog/category');
		
		// 3 Level Category Search
		$this->data['categories'] = array();
					
		$categories_1 = $this->model_catalog_news->getCategories(0);
		
		foreach ($categories_1 as $category_1) {
			$level_2_data = array();
			
			$categories_2 = $this->model_catalog_news->getCategories($category_1['news_category_id']);
			
			foreach ($categories_2 as $category_2) {
				$level_3_data = array();
				
				$categories_3 = $this->model_catalog_news->getCategories($category_2['news_category_id']);
				
				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
						'news_category_id' => $category_3['news_category_id'],
						'name'		=> $category_3['name'],
					);
				}
				
				$level_2_data[] = array(
					'news_category_id' => $category_2['news_category_id'],	
					'name'		=> $category_2['name'],
					'children'	=> $level_3_data
				);					
			}
			
			$this->data['categories'][] = array(
				'news_category_id' => $category_1['news_category_id'],
				'name'		=> $category_1['name'],
				'children'	=> $level_2_data
			);
		}
		
		$this->data['articles'] = array();
		
		if (isset($this->request->get['filter_title']) || isset($this->request->get['filter_tag'])) {
			$data = array(
				'filter_title'		 => $filter_title, 
				'filter_tag'		  => $filter_tag, 
				'filter_content'	  => $filter_content,
				'filter_intro'		=> $filter_intro,
				'filter_news_category_id'  => $filter_news_category_id, 
				'filter_sub_news_category' => $filter_sub_news_category, 
				'sort'				=> $sort,
				'start'			   => ($page - 1) * $limit,
				'limit'			   => $limit
			);

			$article_total = $this->model_catalog_news->getTotalArticles($data);

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
					'href'	=> $this->url->link('blog/article', $f_url . '&news_id=' . $result['news_id']),
					'href_comment'  => $this->url->link('blog/article', $f_url . '&news_id=' . $result['news_id'] . '#comment_area'),
					'news_comment_count' => $news_comment_count,
				);
			}
					
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_latest_first'),
				'value' => 'order-A-date-D',
				'href'  => $this->url->link('blog/search', 'sort=order-A-date-D' . $f_url . $l_url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_oldest_first'),
				'value' => 'order-A-date-A',
				'href'  => $this->url->link('blog/search', 'sort=order-A-date-A' . $f_url . $l_url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'title-A',
				'href'  => $this->url->link('blog/search', 'sort=title-A' . $f_url . $l_url)
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'title-D',
				'href'  => $this->url->link('blog/search', 'sort=title-D' . $f_url . $l_url)
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
					'href'  => $this->url->link('blog/search', $f_url . $s_url . '&limit=' . $plimit)
				);
			}
					
			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('blog/search', $f_url . $s_url . $l_url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();
		}	
		
		$this->data['filter_title'] = $filter_title;
		$this->data['filter_content'] = $filter_content;
		$this->data['filter_intro'] = $filter_intro;
		$this->data['filter_news_category_id'] = $filter_news_category_id;
		$this->data['filter_sub_news_category'] = $filter_sub_news_category;
				
		$this->data['sort'] = $sort;
		$this->data['limit'] = $limit;
		
		$this->data['show_create_date'] = $this->config->get('news_setting_show_create_date');
		$this->data['show_modify_date'] = $this->config->get('news_setting_show_modify_date');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/search.tpl';
		} else {
			$this->template = 'default/template/news/search.tpl';
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
?>