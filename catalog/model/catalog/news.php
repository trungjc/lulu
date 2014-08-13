<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php
class ModelCatalogNews extends Model {
	public function getArticle($news_id) {
		if  ($this->config->get('news_setting_category_permission')) {
			$categories = $this->getNewsCategories($news_id);
			$allowed = $this->getPermissionCategories();
			$checked = array_intersect($categories, $allowed);
		
			if (empty($checked)) { 
				return array(); 
			}
		}	
		
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1'");
	
		return $query->row;
	}
	
	public function getNewsCategories($news_id) {
		$news_category_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_to_category WHERE news_id = '" . (int)$news_id . "'");
		
		foreach ($query->rows as $result) {
			$news_category_data[$result['news_category_id']] = $result['news_category_id'];
		}

		return $news_category_data;
	}
	
	
	public function updateNewsReadCounter($news_id, $new_read_counter_value) {
		$this->db->query("UPDATE " . DB_PREFIX . "news SET count_read = '" . (int)$new_read_counter_value . "' WHERE news_id = '" . (int)$news_id . "'");
	}
   
   public function addComment($news_id, $name, $email, $comment, $comment_status) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "news_comment SET news_id = '" . (int)$news_id . "', name = '" . $this->db->escape($name) . "', email = '" . $this->db->escape($email) . "', comment = '" . $this->db->escape(strip_tags($comment)) . "', status = '" . (int)$comment_status . "',  date_added = NOW()");
	}
	
	public function getCommentsByNewsId($news_id, $start = 0, $limit = 40) {
		$query = $this->db->query("SELECT nc.news_id, nc.name, nc.email, nc.comment, n.news_id, nd.title, n.image, nc.date_added FROM " . DB_PREFIX . "news_comment nc LEFT JOIN " . DB_PREFIX . "news n ON (nc.news_id = n.news_id) LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND n.status = '1' AND nc.status = '1' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY nc.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
		
		return $query->rows;
	}
	
	public function getTotalArticles($data = array()) {
		$sql = "SELECT COUNT(DISTINCT n.news_id) AS total " . $this->Articles($data);
		$query = $this->db->query($sql);		
		return $query->row['total'];
	}
	
	public function getArticles($data = array()) {
		$sql = "SELECT DISTINCT n.* , nd.* " . $this->Articles($data);
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	private function Articles($data = array()) {
		$sql = "FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id)";
		
		if (!empty($data['filter_tag'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_tag nt ON (n.news_id = nt.news_id)";			
		}
			
		if (!empty($data['filter_news_category_id']) || $this->config->get('news_setting_category_permission')) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "news_to_category n2c ON (n.news_id = n2c.news_id)";			
		}
			
		$sql .= " WHERE n.sort_order != -999 AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_title']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";
										
			if (!empty($data['filter_title'])) {
				$implode = array();
				
				$words = explode(' ', $data['filter_title']);
				
				foreach ($words as $word) {
					if (!empty($data['filter_content'])) {
						if (!empty($data['filter_intro'])) {
							$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(nd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(nd.short_description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						} else {
							$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%' OR LCASE(nd.description) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
						}
					} else {
						$implode[] = "LCASE(nd.title) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
					}				
				}
				
				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . "";
				}
			}
			
			if (!empty($data['filter_title']) && !empty($data['filter_tag'])) {
				$sql .= " OR (";
			}
			
			if (!empty($data['filter_tag'])) {
				$implode = array();
				
				$words = explode(' ', $data['filter_tag']);
				
				foreach ($words as $word) {
					$implode[] = "LCASE(nt.tag) LIKE '%" . $this->db->escape(utf8_strtolower($word)) . "%'";
				}
				
				if ($implode) {
					$sql .= " " . implode(" OR ", $implode) . " ";
				}	
				$sql .= " AND nt.language_id = '" . (int)$this->config->get('config_language_id') . "'";				
			}
			
			if (!empty($data['filter_title']) && !empty($data['filter_tag'])) {
				$sql .= ")";
			}
		
			$sql .= ")";
		}

		if (!empty($data['filter_news_category_id'])) {
			if (!empty($data['filter_sub_news_category'])) {
				$categories = $this->getCategoriesByParentId($data['filter_news_category_id']);			
				$categories[] = (int)$data['filter_news_category_id'];
				$sql .= " AND n2c.news_category_id IN (" . implode(' , ', $categories) . ")";			
			} else {
				$sql .= " AND n2c.news_category_id = '" . (int)$data['filter_news_category_id'] . "'";
			}
		}
		
		if  ($this->config->get('news_setting_category_permission')) {
			$categories = $this->getPermissionCategories();
			$sql .= " AND n2c.news_category_id IN (" . implode(' , ', $categories) . ")";
		}
		
		$sort_data = array(
			'title-A' => 'nd.title ASC',
			'title-D' => 'nd.title DESC',
			'order-A-date-D' => 'n.sort_order ASC, nd.date_added DESC',
			'order-A-date-A' => 'n.sort_order ASC, nd.date_added ASC',
		);		
		
		if (isset($data['sort']) && array_key_exists($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $sort_data[$data['sort']];	
		} else {
			$sql .= " ORDER BY n.sort_order ASC, nd.date_added DESC";	
		}
			
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}		

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		return $sql;
	}	
	
	public function getArticleTags($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_tag WHERE news_id = '" . (int)$news_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->rows;
	}
	
	public function getTotalCommentsByNewsId($news_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_comment nc LEFT JOIN " . DB_PREFIX . "news n ON (nc.news_id = n.news_id) LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) WHERE n.news_id = '" . (int)$news_id . "' AND n.status = '1' AND nc.status = '1' AND nd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row['total'];
	}
	
	public function getRelatedNews($news_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_description nd ON (n.news_id = nd.news_id) LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) LEFT JOIN " . DB_PREFIX . "news_related nr ON (n.news_id = nr.child_news_id) WHERE nd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND n.status = '1' AND n.sort_order <> '-1' AND nr.parent_news_id = '" . (int)$news_id. "' ORDER BY n.sort_order, nd.date_modified DESC");
		
		return $query->rows;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
            //echo "<pre>";
              //  var_dump($query);
		if  ($this->config->get('news_setting_category_permission')) {
			$allowed = $this->getPermissionCategories();
		
			$results = array();
			foreach ($query->rows as $result) {
				if (array_key_exists($result['news_category_id'], $allowed)) {
					$results[] = $result;
				} 
			}
		
			return $results;
		} else {
			return $query->rows;
		}
	}
	
	public function getNewsCategory($news_category_id) {
		if  ($this->config->get('news_setting_category_permission')) {
			$allowed = $this->getPermissionCategories();
			
			if (!in_array($news_category_id, $allowed)) {
				return array();
			}
		}

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.news_category_id = '" . (int)$news_category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row;
	}
	
	public function getCategoriesByParentId($news_category_id, $permission = 1) {
		$news_category_data = array();
		
		if  ($this->config->get('news_setting_category_permission')) {
			if ($this->customer->isLogged()) {
				$customer_group_id = $this->customer->getCustomerGroupId();
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}
		
			$news_category_query = $this->db->query("SELECT c.news_category_id FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_permission cp ON (c.news_category_id = cp.news_category_id) WHERE c.parent_id = '" . (int)$news_category_id . "' AND cp.customer_group_id = '" . (int)$customer_group_id . "' AND cp.permission = '" . $permission . "'" );
		} else {
			$news_category_query = $this->db->query("SELECT news_category_id FROM " . DB_PREFIX . "news_category WHERE parent_id = '" . (int)$news_category_id . "'");
		}
		
		foreach ($news_category_query->rows as $news_category) {
			$news_category_data[$news_category['news_category_id']] = $news_category['news_category_id'];
			
			$children = $this->getCategoriesByParentId($news_category['news_category_id']);
			
			if ($children) {
				$news_category_data = array_merge($children, $news_category_data);
			}			
		}
		
		return $news_category_data;
	}
		
	public function getNewsCategoryLayoutId($news_category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_to_layout WHERE news_category_id = '" . (int)$news_category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return $this->config->get('config_layout_news_category');
		}
	}
					
	public function getTotalCategoriesBynews_categoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_to_store c2s ON (c.news_category_id = c2s.news_category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
		
		return $query->row['total'];
	}	
	
	public function getFullPath($news_category_id) {
		$query = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . "news_category c LEFT JOIN " . DB_PREFIX . "news_category_description cd ON (c.news_category_id = cd.news_category_id) WHERE c.news_category_id = '" . (int)$news_category_id . "'");
		
		if ($query->row['parent_id']) {
			return $this->getFullPath($query->row['parent_id']) . "_" . $news_category_id;
		} else {
			return $news_category_id;
		}
	}
	
	public function getPermissionCategories($permission = 1) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "news_category_permission WHERE customer_group_id = '" . (int)$customer_group_id . "' AND permission = '" . $permission . "'");		
		
		$results = array();
		foreach ($query->rows as $result) {
			$results[$result['news_category_id']] = $result['news_category_id'];
		}
		return $results;
	}
	
	public function getArchive($group) {
		$sql = "SELECT";
      
		if ($group == 'year') {
			$sql .= " YEAR(created) as value";
		} else {
			$sql .= " MONTH(created) as value";
		}
      
		$sql .= " FROM " . DB_PREFIX . "news n LEFT JOIN " . DB_PREFIX . "news_to_store n2s ON (n.news_id = n2s.news_id) WHERE n.status = '1' AND n2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
      
		if ($group != 'year') {
			$sql .= " AND YEAR(created) = " . $group . "";
		}
      
		if ($group == 'year') {
			$sql .= " GROUP BY YEAR(created)";
		} else {
			$sql .= " GROUP BY MONTH(created)";
		}
      
		$sql .= " ORDER BY created DESC";
      
		$query = $this->db->query($sql);
      
		return $query->rows;
	}  
}
?>
