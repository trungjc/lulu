<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php 
class ControllerNewsNews extends Controller {
	private $error = array(); 
	
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
		
		$npath_url = '';		
		if (isset($this->request->get['npath'])) {
			$npath = '';
				
			foreach (explode('_', $this->request->get['npath']) as $npath_id) {
				if (!$npath) {
					$npath = $npath_id;
				} else {
					$npath .= '_' . $npath_id;
				}
									
				$category_info = $this->model_catalog_news->getNewsCategory($npath_id);
				
				if ($category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('news/category', 'npath=' . $npath),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
			$npath_url = 'npath=' . $npath . '&';
		}

		// Related News start
		if (isset($this->request->get['news_id'])) {
			$this->data['related_newss'] = array();
		
			foreach ($this->model_catalog_news->getRelatedNews($this->request->get['news_id']) as $result) {
			$this->data['related_newss'][] = array(
				'title' => $result['title'],      
				// 'image' => $this->model_tool_image->resize($result['image'], 100, 100),
				'href'  => $this->url->link('news/news', 'news_id=' . $result['news_id'])								
			);
			}
		}
		// Related News end
		
		if (isset($this->request->get['news_id'])) {
			$news_id = $this->request->get['news_id'];
		} else {
			$news_id = 0;
		}
		
		$news_info = $this->model_catalog_news->getArticle($news_id);
		
		if ($news_info) {
			
			// Count Read start
			$this->data['new_read_counter_value'] = $news_info['count_read']+1;
			$this->model_catalog_news->updateNewsReadCounter($this->request->get['news_id'], $this->data['new_read_counter_value']);
			// Count Read end
			
			$this->data['news_id'] = $news_id;
			
			$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($news_info['date_added']));
			$this->data['date_modified'] = date($this->language->get('date_format_short'), strtotime($news_info['date_modified']));
			$this->data['count_read'] = $news_info['count_read']+1;
			$this->data['short_description'] = html_entity_decode($news_info['short_description']);  
			$this->data['description'] = html_entity_decode($news_info['description']);  
			$this->data['allow_comment'] = $news_info['allow_comment']; 
			$this->data['comment_permission'] = $news_info['comment_permission']; 
			$this->data['comment_need_approval'] = $news_info['comment_need_approval'];
			if ($this->config->get('news_setting_image_show')) {
				$this->data['image'] = $this->model_tool_image->resize($news_info['image'], $this->config->get('news_setting_image_width'), $this->config->get('news_setting_image_height'));
			} else {
				$this->data['image'] = false;
			}
				
			$this->data['tags'] = array();
					
			$results = $this->model_catalog_news->getArticleTags($this->request->get['news_id']);
			
			foreach ($results as $result) {
				$this->data['tags'][] = array(
					'tag'  => $result['tag'],
					'href' => $this->url->link('news/search', 'filter_tag=' . $result['tag'])
				);
			}
			
			$this->data['comment_total'] = $this->model_catalog_news->getTotalCommentsByNewsId($this->request->get['news_id']);
			
			$this->document->setTitle($news_info['title']); 
			$this->document->setDescription($news_info['meta_description']);
			$this->document->setKeywords($news_info['meta_keyword']);
			$this->document->addLink($this->url->link('news/news', 'news_id=' . $this->request->get['news_id']), 'canonical');
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $news_info['title'],
				'href'      => $this->url->link('news/news', $npath_url . 'news_id=' . $this->request->get['news_id']),
				'separator' => $this->language->get('text_separator')
			);		
						
			$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');		
			$this->data['heading_title'] = $news_info['title'];
			
			$this->data['text_updated_on'] = $this->language->get('text_updated_on');
			$this->data['text_posted_on'] = $this->language->get('text_posted_on');
			$this->data['text_read'] = $this->language->get('text_read');
			$this->data['text_times'] = $this->language->get('text_times');
			$this->data['text_comment'] = $this->language->get('text_comment');
			$this->data['text_write_comment'] = $this->language->get('text_write_comment');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['button_comment'] = $this->language->get('button_comment');
			$this->data['text_comments'] = $this->language->get('text_comments');
			$this->data['text_comment_must_logged'] = $this->language->get('text_comment_must_logged');
			$this->data['text_related_news'] = $this->language->get('text_related_news');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_share'] = $this->language->get('text_share');
			$this->data['text_tags'] = $this->language->get('text_tags');
			
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_email'] = $this->language->get('entry_email');
			$this->data['entry_comment'] = $this->language->get('entry_comment');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');
							
			$this->data['button_continue'] = $this->language->get('button_continue');
																			
			$this->data['logged'] = $this->customer->isLogged();
      		$this->data['continue'] = $this->url->link('common/home');
			
			$this->data['show_create_date'] = $this->config->get('news_setting_show_create_date');
			$this->data['show_modify_date'] = $this->config->get('news_setting_show_modify_date');
			$this->data['show_read_times'] = $this->config->get('news_setting_show_read_times');
			$this->data['show_comment_count'] = $this->config->get('news_setting_show_comment_count');
			
			// Get Comment end
			
			if (isset($this->request->post['name'])) {
				$this->data['name'] = $this->request->post['name'];
			} else {
				$this->data['name'] = $this->customer->getFirstName();
			}

			if (isset($this->request->post['email'])) {
				$this->data['email'] = $this->request->post['email'];
			} else {
				$this->data['email'] = $this->customer->getEmail();
			}
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/news/news.tpl';
			} else {
				$this->template = 'default/template/news/news.tpl';
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
												
			if (isset($this->request->get['news_id'])) {
				$url .= '&news_id=' . $this->request->get['news_id'];
			}
											
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error_article'),
				'href'      => $this->url->link('news/news', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error_article'));

			$this->data['heading_title'] = $this->language->get('text_error_article');

			$this->data['text_error'] = $this->language->get('text_error_article');

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
	
	public function write() {
		$this->language->load('news/news');
		
		$this->load->model('catalog/news');
		
		$json = array();
		
		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 25)) {
			$json['error'] = $this->language->get('error_name');
		}
		
		if ((strlen(utf8_decode($this->request->post['comment'])) < 25) || (strlen(utf8_decode($this->request->post['comment'])) > 1000)) {
			$json['error'] = $this->language->get('error_comment');
		}
		
    	if ((strlen(utf8_decode($this->request->post['email'])) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$json['error'] = $this->language->get('error_email') . $this->request->post['email'];
    	}

		if (!isset($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
			$json['error'] = $this->language->get('error_captcha');
		}
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !isset($json['error'])) {
			$result = $this->model_catalog_news->getArticle($this->request->get['news_id']);
			
			if ($result['comment_need_approval']){
				$this->model_catalog_news->addComment($this->request->get['news_id'], $this->request->post['name'], $this->request->post['email'], $this->request->post['comment'], 0);	
				$json['success'] = $this->language->get('success_messages_approval');
			} else {
				$this->model_catalog_news->addComment($this->request->get['news_id'], $this->request->post['name'], $this->request->post['email'], $this->request->post['comment'], 1);
				$json['success'] = $this->language->get('success_messages');
			}
			
			// Admin Alert Mail
			if ($this->config->get('news_setting_comment_alert')) {
				$subject = $this->language->get('text_new_comment');
				
				// Text 
				$text  = $this->language->get('text_new_comment_hi') . "\n\n";
				$text .= sprintf($this->language->get('text_new_comment_text'), $this->request->post['name'] . ' [' . $this->request->post['email']. ']') . "\n\n";
				$text .= $this->request->post['comment'];
						
				$mail = new Mail(); 
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
				$mail->send();
				
				// Send to additional alert emails
				$emails = explode(',', $this->config->get('config_alert_emails'));
				
				foreach ($emails as $email) {
					if ($email && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
						$mail->setTo($email);
						$mail->send();
					}
				}				
			}					
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function comment()
	{
		$this->language->load('news/news');
		
		$this->load->model('catalog/news');
		$this->load->model('tool/image');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$news_id = $this->request->get['news_id'];
		
		$this->data['comments'] = array();
		
		$results = $this->model_catalog_news->getCommentsByNewsId($news_id, ($page - 1) * $this->config->get('news_setting_comments_per_page'), $this->config->get('news_setting_comments_per_page'));
		
		foreach ($results as $result) {
			$this->data['comments'][] = array(
				'name'     => $result['name'],
				'email'     => $result['email'],
				'comment'       => strip_tags($result['comment']),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
			);
		}			

		$comment_total = $this->model_catalog_news->getTotalCommentsByNewsId($news_id);
		
		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('news_setting_comments_per_page'); 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/news/comment', 'news_id=' . $news_id . '&page={page}#comment_area');
		
		$this->data['pagination'] = $pagination->render();
		$this->data['text_no_comment'] = $this->language->get('text_no_comment');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/comment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/comment.tpl';
		} else {
			$this->template = 'default/template/news/comment.tpl';
		}
		$this->response->setOutput($this->render());
	}
	
	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
		
}
?>
