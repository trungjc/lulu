<?php
class ModelCatalogCrossSell extends Model {
	public function getLayoutRoutes($layout_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$layout_id . "'");
		
		return $query->rows;
	}

	public function getRelated($s,$p) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		$data = array();
		$where = array();
		$join = array();
		
		if ($p) {
			if (isset($s['related']) and $s['related']) {
				$where[] = "exists(select * from `".DB_PREFIX."product_related` r WHERE p.product_id=r.related_id and r.product_id in (".implode(",",$p)."))";
			}
	
			if (isset($s['alsobought']) and $s['alsobought'])
				$where[] = "exists(select oo.product_id from `".DB_PREFIX."order_product` o inner join `".DB_PREFIX."order_product` oo on oo.order_id=o.order_id where o.product_id in (".implode(",",$p).") and oo.product_id not in (".implode(",",$p).") and oo.product_id=p.product_id)";
	
			if (isset($s['category']) and $s['category']) {
				$where[] = "exists(select * from `".DB_PREFIX."product_to_category` c WHERE p.product_id=c.product_id and c.category_id in (select cc.category_id from `".DB_PREFIX."product_to_category` cc where cc.product_id in (".implode(",",$p).") ) )";
			}
	
			if (isset($s['manufacturer']) and $s['manufacturer']) {
				$where[] = "p.manufacturer_id in (select pp.manufacturer_id from `".DB_PREFIX."product` pp where pp.manufacturer_id>0 and pp.product_id in (".implode(",",$p)."))";
			}
	
			if (isset($s['attribute_id']) and is_array($s['attribute_id']))
				$where[] = "exists(select * from `".DB_PREFIX."product_attribute` a inner join `".DB_PREFIX."product_attribute` aa on aa.language_id=a.language_id and a.text<>'' and a.text is not null and aa.text=a.text and aa.attribute_id=a.attribute_id WHERE p.product_id=a.product_id and a.attribute_id in (".implode(",",$s['attribute_id']).") and a.attribute_id=aa.attribute_id and aa.product_id in (".implode(",",$p).") ) ";

			if (isset($s['option_id']) and is_array($s['option_id'])) {
				$where[] = "exists(";
				$where[count($where)-1].= "select * \n"; 
				$where[count($where)-1].= "from `".DB_PREFIX."product_option` o  \n";
				$where[count($where)-1].= "	left join `".DB_PREFIX."product_option_value` ov on o.option_id=ov.option_id and o.product_id=ov.product_id \n"; 
				$where[count($where)-1].= "	left join `".DB_PREFIX."option_value_description` ovd on o.option_id=ovd.option_id and ov.option_value_id=ovd.option_value_id \n"; 
				$where[count($where)-1].= "	inner join `".DB_PREFIX."product_option` oo on oo.option_value=o.option_value and oo.option_id=o.option_id  \n";
				$where[count($where)-1].= "	left join `".DB_PREFIX."product_option_value` oov on oo.option_id=oov.option_id and oo.product_id=oov.product_id  \n";
				$where[count($where)-1].= "WHERE ";
				$where[count($where)-1].= "		p.product_id=o.product_id and o.option_id in (".implode(",",$s['option_id']).") and oo.product_id in (".implode(",",$p).") and p.product_id not in (".implode(",",$p).") and \n";
				$where[count($where)-1].= " (\n";
				//									non-empty plain text option_values
				$where[count($where)-1].= " 	(ov.option_id is null and o.option_value is not null and o.option_value<>'' and o.option_value=oo.option_value)\n";
				$where[count($where)-1].= "  	OR \n";
				// 									non-empty list type option values
				$where[count($where)-1].= "  	(ov.option_id is null and oov.option_id is null and ovd.name is not null and ovd.name<>'' and ov.option_value_id=oov.option_value_id)";
				$where[count($where)-1].= " )\n";
				$where[count($where)-1].= ") ";
			}	
	
 			
			if ($where) {
				$sql = "SELECT DISTINCT p.product_id from `".DB_PREFIX."product` p ";
				$sql.= "LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) ";
				$sql.= "WHERE " . implode(" OR ",$where) . " AND (p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "')";

			 	$cache = md5($sql);
				//if (!($data = $this->cache->get('crosssell_product_related.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache))) {
					$products = $this->db->query($sql);
					if ($products->rows) {
						foreach($products->rows as $r)
							if (array_search((int)$r['product_id'],$p)===false)
								$data[] = (int)$r['product_id'];
					}
					$this->cache->set('crosssell_product_related.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $data);
				//}
			}
		}
		return $data;
	}

	public function getProductsByMan($m) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$data = array();
		if ($m) {
			$sql = "SELECT DISTINCT p.product_id FROM `".DB_PREFIX."product` p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
			$sql.= "WHERE p.manufacturer_id = $m AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
 
		 	$cache = md5($sql);
			if (!($data = $this->cache->get('crosssell_product_manufacturer.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache))) {
				$products = $this->db->query($sql);
				if ($products->rows) {
					foreach($products->rows as $r)
						$data[] = $r['product_id'];
				}
				$this->cache->set('crosssell_product_manufacturer.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $data);
			}
		}
		return $data;
	}

	public function getProductsByCats($c) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}	
		
		$data = array();
		if ($c) {
			$sql = "SELECT DISTINCT p.product_id FROM `".DB_PREFIX."product` p ";
			$sql.= "LEFT JOIN `".DB_PREFIX."product_to_category` c on c.product_id=p.product_id ";
			$sql.= "LEFT JOIN `".DB_PREFIX."product_to_store` p2s ON (p.product_id = p2s.product_id) ";
			$sql.= "WHERE c.category_id in (".implode(",",$c).") AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
				 
		 	$cache = md5($sql);
			if (!($data = $this->cache->get('crosssell_product_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache))) {
				$products = $this->db->query($sql);
				if ($products->rows) {
					foreach($products->rows as $r)
						$data[] = $r['product_id'];
				}
				$this->cache->set('crosssell_product_category.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . (int)$customer_group_id . '.' . $cache, $data);
			}
		}
		return $data;
	}

}
?>