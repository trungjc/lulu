<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ControllerNewsArticle extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		 
		$this->load->model('news/news');

		$this->getList();
	}

	public function insert() {
		$this->language->load('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		
			$this->model_news_news->addNews($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			if(isset($this->request->post['ignore_date_modified'])){
			$ignore_date_modified = $this->request->post['ignore_date_modified'];
			}else{
			$ignore_date_modified = '';
			}
			
			$this->model_news_news->editNews($this->request->get['news_id'], $this->request->post, $ignore_date_modified);
					
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	
	public function copy() {
		$this->language->load('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->copyNews($news_id);
	  		}
					
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() {
		$this->language->load('news/article');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->deleteNews($news_id);
				$this->model_news_news->deleteNewsComments($news_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect($this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['filter_category_id'])) {
			$filter_category_id = $this->request->get['filter_category_id'];
		} else {
			$filter_category_id = null;
		}
		
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = '';
		}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nd.title';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href'	  => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text'	  => $this->language->get('text_home'),
	  		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'	  => $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'text'	  => $this->language->get('heading_title'),
	  		'separator' => ' :: '
		);
		$this->data['insert'] = $this->url->link('news/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('news/article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['copy'] = $this->url->link('news/article/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['newss'] = array();

		$data = array(
			'filter_category_id'  => $filter_category_id,
			'filter_title'  => $filter_title,
			'filter_status'=> $filter_status,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$news_total = $this->model_news_news->getTotalNewss($data);
	
		$results = $this->model_news_news->getNewss($data);
 
		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/article/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL'),
				'text_view' => $this->language->get('text_view'),
				'href_view' => HTTP_CATALOG . 'index.php?route=news/news&news_id=' . $result['news_id'],
			);
						
			$this->data['newss'][] = array(
				'news_id' => $result['news_id'],
				'title'	  => $result['title'],
				'date_added'	  => $result['date_added'],
				'date_modified'	  => $result['date_modified'],
				'comment_total' => $this->model_news_news->getTotalCommentsByNewsId($result['news_id']),
				'comment_link' => $this->url->link('news/comment', 'token=' . $this->session->data['token'] . '&filter_title=' . $result['title'], 'SSL'),
				'approved_comment' => $this->model_news_news->getTotalApprovedCommentsByNewsId($result['news_id']),
				'unapproved_comment' => $this->model_news_news->getTotalUnapprovedCommentsByNewsId($result['news_id']),
				'sort_order' => $result['sort_order'],
				'status'	 => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'category'   => $this->model_news_news->getNewsCategories($result['news_id']),
				'action'	 => $action
			);
		}	
		
		$this->data['categories'] = $this->model_news_news->getCategories(0);	
			
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_category'] = $this->language->get('column_category');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_comment'] = $this->language->get('column_comment');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_filter'] = $this->language->get('button_filter');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';
		
		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}
		
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_title'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
		$this->data['sort_category'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nc.news_category_id' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nd.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=nd.date_modified' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . '&sort=n.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_category_id'])) {
			$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
		}

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL') . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_category_id'] = $filter_category_id;
		$this->data['filter_title'] = $filter_title;
		$this->data['filter_status'] = $filter_status;

 		$this->data['token'] = $this->session->data['token'];

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'news/article_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_related_news'] = $this->language->get('tab_related_news');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_all_user'] = $this->language->get('text_all_user');
		$this->data['text_member_only'] = $this->language->get('text_member_only');
		$this->data['text_approved'] = $this->language->get('text_approved');
		$this->data['text_unapproved'] = $this->language->get('text_unapproved');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_no_comments'] = $this->language->get('text_no_comments');
		$this->data['text_ignore_date_modified'] = $this->language->get('text_ignore_date_modified');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_short_description'] = $this->language->get('entry_short_description');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_tag'] = $this->language->get('entry_tag');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_allow_comment'] = $this->language->get('entry_allow_comment');
		$this->data['entry_comment_permission'] = $this->language->get('entry_comment_permission');
		$this->data['entry_comment_need_approval'] = $this->language->get('entry_comment_need_approval');
		$this->data['entry_category'] = $this->language->get('entry_category');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];
		
		if(isset($this->request->get['news_id'])){
			$this->data['check_news_id'] = $this->request->get['news_id'];
		}else{
			$this->data['check_news_id'] = '';
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}
		
	 	if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}
		
		if (isset($this->error['short_description'])) {
			$this->data['error_short_description'] = $this->error['short_description'];
		} else {
			$this->data['error_short_description'] = '';
		}
		$this->load->model('news/news');
				
		$this->data['categories'] = $this->model_news_news->getCategories(0);
		
		if (isset($this->request->post['news_category'])) {
			$this->data['news_category'] = $this->request->post['news_category'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_category'] = $this->model_news_news->getnewsCategories($this->request->get['news_id']);
		} else {
			$this->data['news_category'] = array();
		}
		$url = '';
			
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
  		$this->document->breadcrumbs = array();

		$this->document->breadcrumbs[] = array(
			'href'	  => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text'	  => $this->language->get('text_home'),
	  		'separator' => false
		);

		$this->document->breadcrumbs[] = array(
			'href'	  => $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'text'	  => $this->language->get('heading_title'),
	  		'separator' => ' :: '
		);
		$this->data['breadcrumbs'] = $this->document->breadcrumbs;						
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('news/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/article/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/article', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_news_news->getNews($this->request->get['news_id']);
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_description'] = $this->model_news_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}
		
		if (isset($this->request->post['news_tag'])) {
			$this->data['news_tag'] = $this->request->post['news_tag'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_tag'] = $this->model_news_news->getNewsTags($this->request->get['news_id']);
		} else {
			$this->data['news_tag'] = array();
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (isset($news_info)) {
			$this->data['image'] = $news_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($news_info) && $news_info['image'] && file_exists(DIR_IMAGE . $news_info['image'])) {
			$this->data['preview'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} else {
			$this->data['preview'] = $this->model_tool_image->resize('news_logo.png', 100, 100);
		}
				
		$this->data['no_image'] = $this->model_tool_image->resize('news_logo.png', 100, 100);
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (isset($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
			$this->data['status'] = 1;
		}
		
		if (isset($this->request->post['allow_comment'])) {
			$this->data['allow_comment'] = $this->request->post['allow_comment'];
		} elseif (isset($news_info)) {
			$this->data['allow_comment'] = $news_info['allow_comment'];
		} else {
			$this->data['allow_comment'] = 1;
		}
		
		if (isset($this->request->post['comment_permission'])) {
			$this->data['comment_permission'] = $this->request->post['comment_permission'];
		} elseif (isset($news_info)) {
			$this->data['comment_permission'] = $news_info['comment_permission'];
		} else {
			$this->data['comment_permission'] = 0;
		}
		
		if (isset($this->request->post['comment_need_approval'])) {
			$this->data['comment_need_approval'] = $this->request->post['comment_need_approval'];
		} elseif (isset($news_info)) {
			$this->data['comment_need_approval'] = $news_info['comment_need_approval'];
		} else {
			$this->data['comment_need_approval'] = 0;
		}
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['news_store'])) {
			$this->data['news_store'] = $this->request->post['news_store'];
		} elseif (isset($news_info)) {
			$this->data['news_store'] = $this->model_news_news->getNewsStores($this->request->get['news_id']);
		} else {
			$this->data['news_store'] = array(0);
		}		
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($news_info)) {
			$this->data['keyword'] = $news_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($news_info)) {
			$this->data['sort_order'] = $news_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		if (isset($this->request->post['ignore_date_modified'])) {
			$this->data['ignore_date_modified'] = $this->request->post['ignore_date_modified'];
		}else{
			$this->data['ignore_date_modified'] = '';
		}
		
		// Related News start
		$this->data['newss'] = $this->model_news_news->getNewss(0);
		
		if (isset($this->request->post['related_news'])) {
			$this->data['related_news'] = $this->request->post['related_news'];
		} elseif (isset($news_info)) {
			$this->data['related_news'] = $this->model_news_news->getRelatedNews($this->request->get['news_id']);
		} else {
			$this->data['related_news'] = array();
		}
		// Related News end
		
		$this->template = 'news/article_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_description'] as $language_id => $value) {
			if ((strlen(utf8_decode($value['title'])) < 3) || (strlen(utf8_decode($value['title'])) > 255)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}
		
			if (strlen(utf8_decode($value['description'])) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
			
			if (strlen(utf8_decode($value['short_description'])) > 1000) {
				$this->error['short_description'][$language_id] = $this->language->get('error_short_description');
			}
		}

		if (!$this->error) {
			return true;
		} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

  	private function validateCopy() {
		if (!$this->user->hasPermission('modify', 'news/article')) {
	  		$this->error['warning'] = $this->language->get('error_permission');  
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_title'])) {
			$this->load->model('news/news');
			
			if (isset($this->request->get['filter_title'])) {
				$filter_title = $this->request->get['filter_title'];
			} else {
				$filter_title = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_title'		 => $filter_title,
				'start'			=> 0,
				'limit'			=> $limit
			);
			
			$results = $this->model_news_news->getNewss($data);
			
			foreach ($results as $result) {			
				$json[] = array(
					'news_id' => $result['news_id'],
					'title'	=> html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),	
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>