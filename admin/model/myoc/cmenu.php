<?php
class ModelMyocCmenu extends Model {
	public function addCmenu($data)
	{
		if(!isset($data['customer_group']))
		{
			$data['customer_group'] = array();
		}
		if(!isset($data['store']))
		{
			$data['store'] = array();
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "myoc_cmenu SET
			link = '" .  $this->db->escape($data['link']) . "',
			popup = '" .  (int)$data['popup'] . "',
			parent_cmenu_id = '" . (int)$data['parent_cmenu_id'] . "',
			parent_category_id = '" . (int)$data['parent_category_id'] . "',
			top = '" . (int)$data['top'] . "',
			in_module = '" . (int)$data['in_module'] . "',
			`column` = '" . (int)$data['column'] . "',
			login = '" . (int)$data['login'] . "',
			customer_group = '" . $this->db->escape(serialize($data['customer_group'])) . "',
			store = '" . $this->db->escape(serialize($data['store'])) . "',
			sort_order = '" . (int)$data['sort_order'] . "',
			status = '" . (int)$data['status'] . "',
			date_added = NOW(),
			date_modified = NOW()");
		
		$cmenu_id = $this->db->getLastId();
		
		foreach ($data['cmenu_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "myoc_cmenu_description SET cmenu_id = '" . (int)$cmenu_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		return $cmenu_id;
	}

	public function editCmenu($cmenu_id, $data)
	{
		if(!isset($data['customer_group']))
		{
			$data['customer_group'] = array();
		}
		if(!isset($data['store']))
		{
			$data['store'] = array();
		}
		$this->db->query("UPDATE " . DB_PREFIX . "myoc_cmenu SET
			link = '" .  $this->db->escape($data['link']) . "',
			popup = '" .  (int)$data['popup'] . "',
			parent_cmenu_id = '" . (int)$data['parent_cmenu_id'] . "',
			parent_category_id = '" . (int)$data['parent_category_id'] . "',
			top = '" . (int)$data['top'] . "',
			in_module = '" . (int)$data['in_module'] . "',
			`column` = '" . (int)$data['column'] . "',
			login = '" . (int)$data['login'] . "',
			customer_group = '" . $this->db->escape(serialize($data['customer_group'])) . "',
			store = '" . $this->db->escape(serialize($data['store'])) . "',
			sort_order = '" . (int)$data['sort_order'] . "',
			status = '" . (int)$data['status'] . "',
			date_modified = NOW() WHERE cmenu_id = '" . (int)$cmenu_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "myoc_cmenu_description WHERE cmenu_id = '" . (int)$cmenu_id . "'");
		
		foreach ($data['cmenu_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "myoc_cmenu_description SET cmenu_id = '" . (int)$cmenu_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
	}

	public function deleteCmenu($cmenu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "myoc_cmenu WHERE cmenu_id = '" . (int)$cmenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "myoc_cmenu_description WHERE cmenu_id = '" . (int)$cmenu_id . "'");
	}

	public function getCmenu($cmenu_id)
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "myoc_cmenu WHERE cmenu_id = '" . (int)$cmenu_id . "'");
		
		$cmenu_data = array(
			'cmenu_id'			=> $query->row['cmenu_id'],
			'link'				=> $query->row['link'],
			'popup'				=> $query->row['popup'],
			'parent_cmenu_id'	=> $query->row['parent_cmenu_id'],
			'parent_category_id'=> $query->row['parent_category_id'],
			'top'				=> $query->row['top'],
			'in_module'			=> $query->row['in_module'],
			'column'			=> $query->row['column'],
			'login'				=> $query->row['login'],
			'customer_group'	=> unserialize($query->row['customer_group']),
			'store'				=> unserialize($query->row['store']),
			'sort_order'		=> $query->row['sort_order'],
			'status'			=> $query->row['status'],
		);

		return $cmenu_data;
	}

	public function getCmenus($data = array())
	{
		$sql = "SELECT * FROM " . DB_PREFIX . "myoc_cmenu c LEFT JOIN " . DB_PREFIX . "myoc_cmenu_description cd ON (c.cmenu_id = cd.cmenu_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND LCASE(cd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
								
		$sort_data = array(
			'cd.name',
			'c.sort_order'
		);	
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cd.name";	
		}	
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getTotalCmenus() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "myoc_cmenu");
		
		return $query->row['total'];
	}	

	public function getCmenuDescriptions($cmenu_id) {
		$cmenu_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "myoc_cmenu_description WHERE cmenu_id = '" . (int)$cmenu_id . "'");
		
		foreach ($query->rows as $result) {
			$cmenu_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $cmenu_data;
	}
	
	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}

	public function installTable()
	{
		$this->uninstallTable();
  		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "myoc_cmenu` (
			  `cmenu_id` int(11) NOT NULL AUTO_INCREMENT,
			  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
			  `popup` tinyint(1) NOT NULL DEFAULT '0',
			  `parent_cmenu_id` int(11) NOT NULL DEFAULT '0',
			  `parent_category_id` int(11) NOT NULL DEFAULT '0',
			  `top` tinyint(1) NOT NULL,
			  `in_module` tinyint(1) NOT NULL,
			  `column` int(3) NOT NULL,
			  `login` tinyint(1) NOT NULL,
			  `customer_group` text CHARACTER SET utf8 COLLATE utf8_bin,
			  `store` text CHARACTER SET utf8 COLLATE utf8_bin,
			  `sort_order` int(3) NOT NULL DEFAULT '0',
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY (`cmenu_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
  		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "myoc_cmenu_description` (
			  `cmenu_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  PRIMARY KEY (`cmenu_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	}

	public function uninstallTable()
	{
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "myoc_cmenu`, `" . DB_PREFIX . "myoc_cmenu_description`;");
	}

	public function fixTable()
	{
		//Version 1.1
		$status = true;
		$query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "myoc_cmenu`;");
		foreach ($query->rows as $column_data) {
			if($column_data['Field'] == 'popup')
			{
				$status = false;
				break;
			}
		}
		if($status) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_cmenu` ADD `popup` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `link`;");
		}

		//Version 1.5
		$status = true;
		foreach ($query->rows as $column_data) {
			if($column_data['Field'] == 'in_module')
			{
				$status = false;
				break;
			}
		}
		if($status) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_cmenu` ADD `in_module` TINYINT( 1 ) NOT NULL AFTER `parent_category_id`;");
		}

		//Version 1.6
		$status = true;
		foreach ($query->rows as $column_data) {
			if($column_data['Field'] == 'top')
			{
				$status = false;
				break;
			}
		}
		if($status) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "myoc_cmenu` ADD `top` TINYINT( 1 ) NOT NULL AFTER `parent_category_id`;");
		}
	}
}