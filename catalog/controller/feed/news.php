<?php 
class ControllerFeedNews extends Controller {
	public function index() {
		if ($this->config->get('feed_news_status')) { 
			$this->load->model('catalog/news');
					
			$this->load->model('tool/image');
			
			if (isset($this->request->get['npath'])) {		
				$parts = explode('_', (string)$this->request->get['npath']);
			
				$category_id = array_pop($parts);
				$data = array(
					'filter_news_category_id' => $category_id,
				);							
			} else {
				$category_id = 0;
				$data = array();
			}
			
			$category_info = $this->model_catalog_news->getNewsCategory($category_id);
			
			$output  = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
            $output .= '<channel>';
			if ($category_info) {
				$output .= '<title>' . $this->config->get('config_name') . ' - ' . $category_info['name'] . '</title>'; 
				$output .= '<description>' . $category_info['meta_description'] . '</description>';
			} else {
				$titles = $this->config->get('news_setting_all_articles_top_title');
				$title = $titles[$this->config->get('config_language_id')];
				$descriptions = $this->config->get('news_setting_all_articles_meta_description');
				$description = $descriptions[$this->config->get('config_language_id')];
				$output .= '<title>' . $this->config->get('config_name') . ' - ' . $title . '</title>'; 
				$output .= '<description>' . $description . '</description>';
			}
			$output .= '<link>' . HTTP_SERVER . '</link>';
			
			$articles = $this->model_catalog_news->getArticles($data);
						
			foreach ($articles as $article) {
				if ($article['description']) {
					$output .= '<item>';
					$output .= '<title>' . html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8') . '</title>';
					$output .= '<link>' . $this->url->link('news/news', 'news_id=' . $article['news_id']) . '</link>';
					$output .= '<pubDate>' . $article['date_added'] . '</pubDate>';
					$output .= '<description>' . $article['short_description'] . '</description>';
					$output .= '<g:id>' . $article['news_id'] . '</g:id>';
					
					if ($article['image']) {
						$output .= '<g:image_link>' . $this->model_tool_image->resize($article['image'], 500, 500) . '</g:image_link>';
					} else {
						$output .= '<g:image_link>' . $this->model_tool_image->resize('news_logo.jpg', 500, 500) . '</g:image_link>';
					}
							   
					//$categories = $this->model_catalog_news->getCategories($article['news_id']);
					
					// foreach ($categories as $category) {
						// $path = $this->getPath($category['news_category_id']);
						
						// if ($path) {
							// $string = '';
							
							// foreach (explode('_', $path) as $path_id) {
								// $category_info = $this->model_catalog_news->getNewsCategory($path_id);
								
								// if ($category_info) {
									// if (!$string) {
										// $string = $category_info['name'];
									// } else {
										// $string .= ' &gt; ' . $category_info['name'];
									// }
								// }
							// }						 
						// }
					// }
					
					$output .= '</item>';
				}
			}
			
			$output .= '</channel>'; 
			$output .= '</rss>';	
			
			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
	}
	
	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_news->getNewsCategory($parent_id);
	
		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}	
		
			$path = $this->getPath($category_info['parent_id'], $new_path);
					
			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}		
}
?>