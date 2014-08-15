<?php
class Tools {

	const isLive                        = true;
	public static $SYNC_IMG_DIR         = "data/sync/";
	public static $TABLE_NAME_S2S       = "sync_site_2_site";
	public static $TABLE_NAME_SYNC_DATA = "sync_data_src";
	public static $KEY_4_CATEGORY_NAME  = "Category";
	public static $KEY_4_CATEGORY_ID    = "Category";
	public static $CATEGORY_NAME_VALUE_SELECTED = "";
	public static $CATEGORY_ID_VALUE_SELECTED = "";
	
	public static $KEY_4_PRODUCT_ID               = "ItemNumber";
	public static $KEY_4_PRODUCT_NAME             = "Product Name";
	public static $KEY_4_PRODUCT_DESCRIPTION      = "Product Description";
	public static $KEY_4_PRODUCT_META_DESCRIPTION = "";
	public static $KEY_4_PRODUCT_IMAGE            = "image link";
	public static $KEY_4_PRODUCT_PRICE            = "Cost (in AUD)";
	public static $KEY_4_PRODUCT_MODEL            = "ItemNumber";

	public static $KEY_4_MANUFACT_ID          = "Brand";
	public static $KEY_4_MANUFACT_NAME        = "Brand";
	public static $KEY_4_MANUFACT_DESCRIPTION = "Brand Description";
	public static $KEY_4_MANUFACT_IMAGE       = "";

	public static $KEY_4_PRODUCT_OPTION_TYPE_NAME  = "select";// need to get OpI from O by type
	public static $KEY_4_PRODUCT_OPTION_VALUE_NAME = "size";// check in OVD => insert new to OV & OVD with OpI above

	public static $KEY_4_PRODUCT_ATTR_TYPE   = "type";
	public static $KEY_4_PRODUCT_ATTR_SIZE   = "size";
	public static $KEY_4_PRODUCT_ATTR_GENDER = "gender";

	public static $KEY_4_PRODUCT_ATTR_TYPE_ID   = 0;
	public static $KEY_4_PRODUCT_ATTR_SIZE_ID   = 0;
	public static $KEY_4_PRODUCT_ATTR_GENDER_ID = 0;

	public static $KEY_4_PRODUCT_FILTER_GROUP_TYPE   = "type";
	public static $KEY_4_PRODUCT_FILTER_GROUP_SIZE   = "size";
	public static $KEY_4_PRODUCT_FILTER_GROUP_GENDER = "gender";

	public static $KEY_4_PRODUCT_FILTER_GROUP_TYPE_ID   = 0;
	public static $KEY_4_PRODUCT_FILTER_GROUP_SIZE_ID   = 0;
	public static $KEY_4_PRODUCT_FILTER_GROUP_GENDER_ID = 0;

	public static $ATTRIBUTES_LIST    = array();
	public static $FILTER_GROUPS_LIST = array();
	public static $CATEGORIES_IMPORTED = array('Skincare','Fragrances');
	

	public static function cleanDraftData() {

		$sql = "DROP TABLE IF EXISTS ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS ".DB_PREFIX."sync_imported_filter_groups";
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS ".DB_PREFIX."sync_imported_filters";
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS ".DB_PREFIX."sync_imported_manufacturers";
		getDBResult($sql);

	}
	public static function initFieldFromCSV($category,$filename) {

		self::getOrCreateCategoryIdByName($category);
		self::$CATEGORY_NAME_VALUE_SELECTED = $category;
		
		
		self::$ATTRIBUTES_LIST    = array(self::$KEY_4_PRODUCT_ATTR_SIZE, self::$KEY_4_PRODUCT_ATTR_TYPE, self::$KEY_4_PRODUCT_ATTR_GENDER);
		self::$FILTER_GROUPS_LIST = array(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE, self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE, self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);

		$filename = 'upload/'.$filename;
		$chk_ext  = explode(".", $filename);
		if (strtolower($chk_ext[1]) == "csv") {
			$headerArray = array();
			$valuesArray = array();
			self::init_create_table(DB_PREFIX.self::$TABLE_NAME_SYNC_DATA);
			if ($handle = fopen($filename, "r")) {
				$i = 0;
				while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
					if ($i == 0) {
						$headerArray = $data;
						self::alter_table(DB_PREFIX.self::$TABLE_NAME_SYNC_DATA, $data);

					} else {
						$valuesArray[] = $data;
					}
					$i++;

				}
				fclose($handle);
				self::import_csv_2_table_src(DB_PREFIX.self::$TABLE_NAME_SYNC_DATA, $headerArray, $valuesArray);
				self::init_process();
				echo "<h1>PROCESS SUCESSFUL</h1>";

			} else {
				echo "CANNOT IMPORT THIS FILE";
			}
		} else {
			echo "Invalid File to init importation <br>";
		}
	}

	public static function init_process() {
	
		self::updateCategory4ProductsImported();
		
		self::importFilterGroups();
		self::sync_filter_groups();
		// separate 2 steps to be easier inscrease id		
		self::importFilters();
		self::sync_filters();

		self::importManufacturers();

		self::sync_manufacturers();
		
		self::sync_products();
		self::sync_cat_prod();

		self::sync_prod_filters();
		self::sync_product_images();
	}
	public static function init_create_table($tableName) {
		getDBResult('DROP TABLE IF EXISTS '.$tableName);
		$sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.' (id int(11) primary key auto_increment)  ENGINE = MYISAM CHARACTER SET utf8 COLLATE  utf8_general_ci';
		getDBResult($sql);
	}
	public static function import_csv_2_table_src($tableName, $headerArray, $fields) {
		$imageIndex = false;
		$sql        = 'INSERT INTO '.$tableName;
		$sql .= '(';
		for ($i = 0; $i < count($headerArray); $i++) {
			$label = $headerArray[$i];
			if (strtolower($label) == strtolower(self::$KEY_4_PRODUCT_IMAGE)) {
				$imageIndex = $i;
			}

			$sql .= self::strSQL4Field($label);
			$sql .= ' , ';
		}
		$sql .= 'img_name';
		$sql .= ')';
		$sql .= ' VALUES ';
		for ($i = 0; $i < count($fields); $i++) {
			if ($i != 0) {
				$sql .= ',';
			}

			$sql .= ' ( ';
			$line = $fields[$i];
			for ($l = 0; $l < count($line); $l++) {

				$val = $line[$l];
				if ($imageIndex !== false && $l == $imageIndex) {

					$path_parts = pathinfo($val);
				}
				if (empty($val)) {
					$val = '';
				}

				$sql .= self::strSQL4Value($val);
				$sql .= ',';
			}
			$sql .= $path_parts['filename'] != ""?self::strSQL4Value(self::$SYNC_IMG_DIR.$path_parts['filename'].'.'.$path_parts['extension']):'""';
			$sql .= ') ';
		}
		getDBResult($sql);
	}

	public static function alter_table($tableName, $fields) {
		$sql = 'ALTER TABLE '.$tableName;

		for ($i = 0; $i < count($fields); $i++) {
			$sql .= ' ADD COLUMN `'.$fields[$i].'`';
			if (strpos(strtolower($fields[$i]), 'description') >= 0) {
				$sql .= ' TEXT';
			} else {

				$sql .= ' VARCHAR(15) ';
			}
			$sql .= ' NULL , ';
		}

		$sql .= ' ADD COLUMN  `img_name` TEXT NULL';
		$sql .= ' ,ADD COLUMN  `category_id` VARCHAR(15) NULL';
		$sql .= ' ,ADD COLUMN  `manufacturer_id` VARCHAR(15) NULL';
		$sql .= ' ,ADD COLUMN  `filter_size_id` VARCHAR(15) NULL';
		$sql .= ' ,ADD COLUMN  `filter_type_id` VARCHAR(15) NULL';
		$sql .= ' ,ADD COLUMN  `filter_gender_id` VARCHAR(15) NULL';
		
		getDBResult($sql);

	}

	public static function strSQL4Field($field) {
		if (empty($field)) {
			return strSQLValue('null');
		}

		return strSQLValue('`'.$field.'`');
	}
	public static function strSQL4Value($value) {
		return "'".strSQLValue($value)."'";
	}

	public static function updateCategory4ProductsImported(){
		$sql = "update ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		$sql .=" set category_id = ".self::strSQL4Value(self::$CATEGORY_ID_VALUE_SELECTED);
		getDBResult($sql);
	}
	public static function getOrCreateCategoryIdByName($cat_name){

		if(empty($cat_name) || is_null($cat_name) || $cat_name == "")
			die("category is empty, cannot process importation");
		$cat_id = null;
		$sql = "SELECT c.category_id from ".DB_PREFIX."category c JOIN ".DB_PREFIX."category_description cd ON (c.category_id = cd.category_id) ";
		$sql .=" WHERE LOWER(cd.name) = ".strtolower(self::strSQL4Value($cat_name))." and language_id = 1";
	
		$result = getDBResult($sql);
		if($result->num_rows == 0){
			$sql        = "SELECT MAX(category_id) as number from ".DB_PREFIX."category Where status = 1";
			$result     = getDBResult($sql);
			echo "number ";$numberCats = $result->row['number']+10;
	
			$sql = "INSERT INTO ".DB_PREFIX."category_description(category_id,name,language_id) values(".$numberCats.",".self::strSQL4Value($cat_name).",1)";
			getDBResult($sql);
			$sql = "INSERT INTO ".DB_PREFIX."category(category_id,parent_id,top,status) values(".$numberCats.",0,1,1)";
			getDBResult($sql);
			$sql = "INSERT INTO ".DB_PREFIX."category_path (category_id,path_id,level) VALUES ('".$numberCats."','".$numberCats."',0)";
			getDBResult($sql);
			$sql = "INSERT INTO ".DB_PREFIX."category_to_store (category_id,store_id) VALUES ('".$numberCats."',0)";
			getDBResult($sql);
			$cat_id = $numberCats;
		}else{
			$cat_id = $result->row['category_id'];
		}
	
		if(empty($cat_id) || is_null($cat_id) || $cat_id == 0 || $cat_id == "")
			die("category is empty, cannot process importation");
		self::$CATEGORY_ID_VALUE_SELECTED = $cat_id;
	}
	
	
	public static function importFilterGroups() {

		$sql = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."sync_imported_filter_groups (
		id int primary key auto_increment,
		filter_group_name text,
		lang_id int
		)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filter_groups(filter_group_name,lang_id) VALUES";
		for ($i = 0; $i < count(self::$FILTER_GROUPS_LIST); $i++) {
			if ($i != 0) {
				$sql .= ",";
			}

			$sql .= "(".self::strSQL4Value(self::$FILTER_GROUPS_LIST[$i]).",1)";
		}
		if (count(self::$FILTER_GROUPS_LIST) > 0) {
			getDBResult($sql);

		}
	}

	public static function sync_filter_groups() {

		$sql    = "SELECT MAX(filter_group_id) as number from ".DB_PREFIX."filter_group_description";
		$result = getDBResult($sql);
		$number = $result->row['number']+50;

		$sql = "INSERT INTO ".DB_PREFIX."filter_group_description(filter_group_id,language_id,name) ";
		$sql .= " SELECT (id+".$number."),1,filter_group_name from ".DB_PREFIX."sync_imported_filter_groups ";
		$sql .= " WHERE filter_group_name NOT IN (SELECT name FROM ".DB_PREFIX."filter_group_description)";
		getDBResult($sql);

		$sql = " INSERT INTO ".DB_PREFIX."filter_group(filter_group_id,sort_order)";
		$sql .= " SELECT filter_group_id,1 from ".DB_PREFIX."filter_group_description ";
		$sql .= " WHERE filter_group_id NOT IN (SELECT filter_group_id FROM ".DB_PREFIX."filter_group )";
		getDBResult($sql);

	}
	public static function importFilters() {

		$sql = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."sync_imported_filters (
		id int primary key auto_increment,
		filter_group_id int,
		filter_name text,
		lang_id int
		)";
		getDBResult($sql);

		$sql = "SELECT filter_group_id FROM ".DB_PREFIX."filter_group_description WHERE name =".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND FILTER GROUP SIZE");
		} else {
			self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE_ID = $row->row['filter_group_id'];
			
		}

		$sql = "SELECT filter_group_id FROM ".DB_PREFIX."filter_group_description WHERE name = ".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND FILTER GROUP TYPE");
		} else {

			self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE_ID = $row->row['filter_group_id'];
		}

		$sql = "SELECT filter_group_id FROM ".DB_PREFIX."filter_group_description WHERE name = ".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND FILTER GROUP GENDER");
		} else {

			self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER_ID = $row->row['filter_group_id'];
		}

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filters(filter_name,filter_group_id,lang_id) ";
		$sql .= " SELECT DISTINCT ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE).",".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE_ID).",1 FROM ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE)." <> '' AND ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE)." NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE);
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filters(filter_name,filter_group_id,lang_id) ";
		$sql .= "SELECT DISTINCT ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE).",".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE_ID).",1 FROM ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE)." <> '' AND ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE)." NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE);
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filters(filter_name,filter_group_id,lang_id) ";
		$sql .= "SELECT DISTINCT ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER).",".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER_ID).",1 FROM ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER)." <> '' AND ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER)." NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);
		getDBResult($sql);

	}

	public static function sync_filters() {
		$sql = "SELECT count(*) FROM ".DB_PREFIX."sync_imported_filters";
		$resutlt = getDBResult($sql);
		if($resutlt->num_rows > 0){
			$sql          = "SELECT MAX(filter_id) as number from ".DB_PREFIX."filter_description";
			$result       = getDBResult($sql);
			$numberFilter = $result->row['number']+50;
			
			$sql = "INSERT INTO ".DB_PREFIX."filter_description(name,filter_id,filter_group_id,language_id) ";
			$sql .= " SELECT filter_name,(id+".$numberFilter."),filter_group_id,1 FROM ".DB_PREFIX."sync_imported_filters ";
			$sql .= " WHERE filter_name NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
			getDBResult($sql);
			
			$sql = "INSERT INTO ".DB_PREFIX."filter(filter_id,filter_group_id,sort_order) ";
			$sql .= " SELECT filter_id,filter_group_id,1 FROM ".DB_PREFIX."filter_description fd ";
			$sql .= " WHERE fd.filter_id NOT IN ( SELECT filter_id FROM ".DB_PREFIX."filter f WHERE f.filter_group_id = fd.filter_group_id)";
			getDBResult($sql);
				
		}
		$sql = "update ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA ." sip join ".DB_PREFIX."filter_description fd ON (sip.".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE)." = fd.name) set sip.filter_size_id = fd.filter_id ";
		getDBResult($sql);
		$sql = "update ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA ." sip join ".DB_PREFIX."filter_description fd ON (sip.".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE)." = fd.name) set sip.filter_type_id = fd.filter_id ";
		getDBResult($sql);
		$sql = "update ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA ." sip join ".DB_PREFIX."filter_description fd ON (sip.".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER)." = fd.name) set sip.filter_gender_id = fd.filter_id ";
		getDBResult($sql);
		
		
		

	}

	public static function importManufacturers() {

		$sql = "SELECT MAX(manufacturer_id) as number from ".DB_PREFIX."manufacturer";

		$result = getDBResult($sql);

		$number = $result->row['number']+50;

		$sql = "CREATE TABLE IF NOT EXISTS ".DB_PREFIX."sync_imported_manufacturers (
		id int primary key auto_increment,
		sync_id int,
		name text,
		description text,
		image text
		)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_manufacturers (sync_id,name,description,image) ";
		$sql .= " SELECT DISTINCT id + ".$number.",".self::strSQL4Field(self::$KEY_4_MANUFACT_NAME).",".self::strSQL4Field(self::$KEY_4_MANUFACT_DESCRIPTION).",".self::strSQL4Field(self::$KEY_4_MANUFACT_IMAGE)."
		FROM ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." WHERE ".self::strSQL4Field(self::$KEY_4_MANUFACT_NAME)." NOT IN (SELECT name FROM ".DB_PREFIX."manufacturer) ";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_MANUFACT_NAME);
		getDBResult($sql);

	}
	public static function sync_manufacturers() {
		
		$sql = "SELECT count(*) FROM ".DB_PREFIX."sync_imported_manufacturers";
		$resutlt = getDBResult($sql);
		if($resutlt->num_rows > 0){
			$sql = "INSERT INTO ".DB_PREFIX."manufacturer SELECT sync_id,name,image,0
			FROM ".DB_PREFIX."sync_imported_manufacturers
			WHERE sync_id NOT IN (SELECT manufacturer_id from ".DB_PREFIX."manufacturer)";
			getDBResult($sql);
			
			$sql = "INSERT INTO ".DB_PREFIX."manufacturer_to_store SELECT manufacturer_id, 0 FROM ".DB_PREFIX."manufacturer WHERE manufacturer_id NOT IN (SELECT manufacturer_id FROM ".DB_PREFIX."manufacturer_to_store) ";
			getDBResult($sql);
			
			if (self::isLive) {
				$sql = "INSERT INTO ".DB_PREFIX."manufacturer_description(manufacturer_id,description,language_id) ";
				$sql .= " SELECT sync_id,description,1 FROM ".DB_PREFIX."sync_imported_manufacturers";
				$sql .= " WHERE sync_id NOT IN (SELECT manufacturer_id from ".DB_PREFIX."manufacturer_description)";
				getDBResult($sql);
			}			
		}
		$sql = "update ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA ." sip join ".DB_PREFIX."manufacturer m ON (sip.".self::strSQL4Field(self::$KEY_4_MANUFACT_NAME)." = m.name) set sip.manufacturer_id = m.manufacturer_id ";
		getDBResult($sql);
		

	}

	public static function sync_products() {
		
		

		$sql = "insert into ".DB_PREFIX."product(model,status,image,price,manufacturer_id,quantity,date_added,date_modified)
		select ".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL).",1,img_name,".self::strSQL4Field(self::$KEY_4_PRODUCT_PRICE).",manufacturer_id,100,now(),now() from ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		$sql .=" WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL)." NOT IN (SELECT model FROM ".DB_PREFIX."product) ";
		getDBResult($sql);

		$sql = "
		INSERT INTO ".DB_PREFIX."product_description( description,product_id, name, language_id )
		SELECT ".self::strSQL4Field(self::$KEY_4_PRODUCT_DESCRIPTION).",p.product_id,".self::strSQL4Field(self::$KEY_4_PRODUCT_NAME).",1
		FROM ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." src JOIN ".DB_PREFIX."product p ON (src.".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL)." = p.model) ";
		$sql .="  WHERE p.product_id NOT IN (select product_id from ".DB_PREFIX."product_description) ";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_image(product_id,image) ";
		$sql .= " SELECT p.product_id,image from ".DB_PREFIX."product p ";
		$sql .= " WHERE p.product_id NOT IN (SELECT product_id from ".DB_PREFIX."product_image) ";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_to_store(product_id) SELECT product_id from ".DB_PREFIX."product WHERE (product_id) NOT IN (SELECT product_id FROM ".DB_PREFIX."product_to_store)";
		getDBResult($sql);

		$sql = "update ".DB_PREFIX."product p JOIN ".DB_PREFIX."product_to_category ptc ON (p.product_id=ptc.product_id AND ptc.category_id = '".self::$CATEGORY_ID_VALUE_SELECTED."' ) set p.status = 0 WHERE p.model NOT IN (select ".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL)." from ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." ) ";
		getDBResult($sql);
		
	}

	public static function sync_cat_prod() {

		$sql = "INSERT INTO ".DB_PREFIX."product_to_category (product_id,category_id) ";
		$sql .="SELECT p.product_id,".self::strSQL4Value(self::$CATEGORY_ID_VALUE_SELECTED);
		$sql .=" FROM ".DB_PREFIX."product p JOIN ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." src ON (p.model = src.".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL).")  ";
		$sql .=" WHERE p.product_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_to_category WHERE ".DB_PREFIX."product_to_category.category_id = ".self::$CATEGORY_ID_VALUE_SELECTED.")"; 
		getDBResult($sql);

	}

	public static function sync_prod_filters() {

		$sql = "DELETE FROM ".DB_PREFIX."product_filter ";
		$sql .=" WHERE product_id IN ";
		$sql .= " ( ";
		$sql .= " SELECT p.product_id FROM ".DB_PREFIX."product p JOIN ".DB_PREFIX."product_to_category ptc ON (p.product_id = ptc.product_id and ptc.category_id = ".self::strSQL4Value(self::$CATEGORY_ID_VALUE_SELECTED).")";
		$sql .= " ) ";
		getDBResult($sql);
		
		$sql = "INSERT INTO ".DB_PREFIX."product_filter(product_id,filter_id)";
		$sql .= " SELECT p.product_id,src.filter_size_id FROM ".DB_PREFIX."product p JOIN ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." src ";
		$sql .= " ON (p.model = src.".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL)." ) ";
		$sql .= " WHERE p.product_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_filter WHERE filter_id = src.filter_size_id)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_filter(product_id,filter_id)";
		$sql .= " SELECT p.product_id,src.filter_type_id FROM ".DB_PREFIX."product p JOIN ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." src ";
		$sql .= " ON (p.model = src.".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL)." ) ";
		$sql .= " WHERE p.product_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_filter WHERE filter_id = src.filter_type_id)";
		getDBResult($sql);
		
		$sql = "INSERT INTO ".DB_PREFIX."product_filter(product_id,filter_id)";
		$sql .= " SELECT p.product_id,src.filter_gender_id FROM ".DB_PREFIX."product p JOIN ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA." src ";
		$sql .= " ON (p.model = src.".self::strSQL4Field(self::$KEY_4_PRODUCT_MODEL)." ) ";
		$sql .= " WHERE p.product_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_filter WHERE filter_id = src.filter_gender_id)";
		getDBResult($sql);
		
	}

	public static function remoteFileExists($url) {

		$curl = curl_init($url);
		//don't fetch the actual page, you only want to check the connection is ok
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_NOBODY, TRUE);
		//do request
		$result = curl_exec($curl);
		$ret    = false;
		//if request did not fail
		if ($result !== false) {
			//if request was ok, check response code
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if ($statusCode == 200) {
				$ret = true;
			}
		}

		curl_close($curl);
		return $ret;
	}
	public static function sync_product_images() {

		//img_local_downloaded

		$sql    = "select ".self::strSQL4Field(self::$KEY_4_PRODUCT_IMAGE).",img_name from ".DB_PREFIX.self::$TABLE_NAME_SYNC_DATA;
		$result = mysql_query($sql);
		if (!file_exists('../image/'.self::$SYNC_IMG_DIR)) {
			mkdir('../image/'.self::$SYNC_IMG_DIR, 0777, true);
		}
		while ($row = mysql_fetch_array($result)) {
			$urlImage = $row[self::$KEY_4_PRODUCT_IMAGE];
			$imgLocal = $row['img_name'];
			if ($urlImage != "" && $imgLocal != '') {
				if (!file_exists($imgLocal)) {
					if (self::remoteFileExists($urlImage)) {
						set_time_limit(17999);

						ob_end_clean();
						ob_start();

						readfile($urlImage);

						$imgFile = ob_get_contents();

						ob_end_clean();
						if (!$fp = fopen("../image/".$row['img_name'], 'wb')) {
							echo "ERROR WRITING FILE";
						}
						fwrite($fp, $imgFile);
						fclose($fp);

					} else {
						echo "file not found ".$urlImage;
					}

				}
			}

		}

	}

}
?>