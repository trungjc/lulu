<?php
class Tools {

	const isLive                        = true;
	public static $SYNC_IMG_DIR         = "data/sync/";
	public static $TABLE_NAME_S2S       = "sync_site_2_site";
	public static $TABLE_NAME_SYNC_DATA = "sync_data_src";
	public static $KEY_4_CATEGORY_NAME  = "Product Category";
	public static $KEY_4_CATEGORY_ID    = "Product Category";
	public static $KEY_4_PRODUCT_NAME   = "Product Name";
	//"Name";
	public static $KEY_4_PRODUCT_ID = "ItemNumber";
	//"Item Number";
	public static $KEY_4_PRODUCT_DESCRIPTION = "Product Description";
	//"Description";
	public static $KEY_4_PRODUCT_META_DESCRIPTION = "";
	//short description";
	public static $KEY_4_PRODUCT_IMAGE = "image link";
	public static $KEY_4_PRODUCT_PRICE = "Cost (in AUD)";
	public static $KEY_4_PRODUCT_MODEL = "ItemNumber";
	//"Name";
	// need to change to model

	public static $KEY_4_MANUFACT_ID          = "Brand";
	public static $KEY_4_MANUFACT_MAME        = "Brand";
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

	public static $KEY_4_PRODUCT_FILTER_TYPE_ID   = 0;
	public static $KEY_4_PRODUCT_FILTER_SIZE_ID   = 0;
	public static $KEY_4_PRODUCT_FILTER_GENDER_ID = 0;

	public static $ATTRIBUTES_LIST    = array();
	public static $FILTER_GROUPS_LIST = array();

	const SYNC_IMG_DIR         = "data/sync/";
	const TABLE_NAME_S2S       = "sync_site_2_site";
	const TABLE_NAME_SYNC_DATA = "sync_data_src";
	const KEY_4_CATEGORY_NAME  = "Product Category";
	const KEY_4_CATEGORY_ID    = "Product Category";
	const KEY_4_PRODUCT_NAME   = "Product Name";
	//"Name";
	const KEY_4_PRODUCT_ID          = "ItemNumber";
	const KEY_4_PRODUCT_DESCRIPTION = "Product Description";
	//"Description";
	const KEY_4_PRODUCT_META_DESCRIPTION = "";
	const KEY_4_PRODUCT_IMAGE            = "image link";
	const KEY_4_PRODUCT_PRICE            = "Cost (in AUD)";
	const KEY_4_PRODUCT_MODEL            = "ItemNumber";// need to change to model

	public static function cleanDraftData() {

		$sql = "DROP TABLE IF EXISTS sync_imported_filter_groups";
		getDBResult($sql);

		$sql = "DROP TABLE IF EXISTS ".DB_PREFIX."sync_imported_filters";
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS sync_imported_attribute_groups";
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS sync_imported_manufacturers";
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS sync_imported_categories";
		getDBResult($sql);
		$sql = "DROP TABLE IF EXISTS sync_imported_products";
		getDBResult($sql);

	}
	public static function initFieldFromCSV($filename) {

		self::$ATTRIBUTES_LIST    = array(self::$KEY_4_PRODUCT_ATTR_SIZE, self::$KEY_4_PRODUCT_ATTR_TYPE, self::$KEY_4_PRODUCT_ATTR_GENDER);
		self::$FILTER_GROUPS_LIST = array(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE, self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE, self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);

		$filename = 'upload/'.$filename;
		$chk_ext  = explode(".", $filename);
		if (strtolower($chk_ext[1]) == "csv") {
			$headerArray = array();
			$valuesArray = array();
			self::init_create_table(self::TABLE_NAME_SYNC_DATA);
			if ($handle = fopen($filename, "r")) {
				$i = 0;
				while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
					if ($i == 0) {
						$headerArray = $data;
						self::alter_table(self::TABLE_NAME_SYNC_DATA, $data);

					} else {
						$valuesArray[] = $data;
					}
					$i++;

				}
				fclose($handle);

				self::import_csv_2_table_src(self::TABLE_NAME_SYNC_DATA, $headerArray, $valuesArray);

				self::importFilterGroups();

				self::sync_filter_groups();

				self::importFilters();

				self::sync_filters();

				self::importAttributeGroups();

				self::sync_attributes_group();

				self::importManufacturers();

				self::sync_manufacturers();
				self::importCategories();
				self::sync_categories();
				self::importProducts();
				self::sync_products();
				self::sync_cat_prod();
				//self::sync_prod_attributes();
				self::sync_prod_filters();
				self::sync_product_images();

				echo "<h1>PROCESS SUCESSFUL</h1>";

			} else {
				echo "CANNOT IMPORT THIS FILE";
			}
		} else {
			echo "Invalid File to init importation <br>";
		}
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
			if (strtolower($label) == strtolower(self::KEY_4_PRODUCT_IMAGE)) {
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
					$val = 'no name';
				}

				$sql .= self::strSQL4Value($val);
				$sql .= ',';
			}
			$sql .= $path_parts['filename'] != ""?self::strSQL4Value(self::SYNC_IMG_DIR.$path_parts['filename'].'.'.$path_parts['extension']):'""';
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

		getDBResult($sql);

	}
	public static function displayOptions2Sync() {
		/*
	$sql        = 'SELECT * FROM '.self::TABLE_NAME_SYNC_DATA;
	$result     = mysql_query($sql) or die('ERROR:'.$sql.mysql_error());
	$fields_num = mysql_num_fields($result);
	$row        = mysql_fetch_array($result);
	?>
	<form action="" method="post">
	<table border="0">
	<tr>
	<?php
	for ($i = 0; $i < $fields_num; $i++) {
	while ($field = mysql_fetch_field($result)) {
	if ('id' != $field->name) {

	?>
	<td>
	<table>
	<thead>
	<?php echo $field->name;?>
	</thead>
	<tbody>
	<tr>
	<td>
	<select>
	<option value="0">Delete</option>
	<option value="1">Sync</option>
	</select>

	</td>
	</tr>
	</tbody>
	</table>
	</td>
	<?php
	}
	}
	}
	?>
	</tr>
	</table>
	</form>
	<?php
	 */
	}

	public static function strSQL4Field($field) {
		if (empty($field)) {
			return mysql_real_escape_string('null');
		}

		return mysql_real_escape_string('`'.$field.'`');
	}
	public static function strSQL4Value($value) {
		return "'".mysql_real_escape_string($value)."'";
	}

	public static function importFilterGroups() {

		$sql = 'CREATE TABLE IF NOT EXISTS sync_imported_filter_groups (
		id int primary key auto_increment,
		filter_group_name text,
		lang_id int
		)';
		getDBResult($sql);

		$sql = "INSERT INTO sync_imported_filter_groups(filter_group_name,lang_id) VALUES";
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
		$sql .= " SELECT (id+".$number."),1,filter_group_name from sync_imported_filter_groups ";
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

			$filter_group_size_id = $row->row['filter_group_id'];
		}

		$sql = "SELECT filter_group_id FROM ".DB_PREFIX."filter_group_description WHERE name = ".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND FILTER GROUP TYPE");
		} else {

			$filter_group_type_id = $row->row['filter_group_id'];
		}

		$sql = "SELECT filter_group_id FROM ".DB_PREFIX."filter_group_description WHERE name = ".self::strSQL4Value(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND FILTER GROUP GENDER");
		} else {

			$filter_group_gender_id = $row->row['filter_group_id'];
		}

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filters(filter_name,filter_group_id,lang_id) ";
		$sql .= " SELECT DISTINCT ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE).",".$filter_group_size_id.",1 FROM ".self::$TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE)." <> '' AND ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE)." NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE);
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filters(filter_name,filter_group_id,lang_id) ";
		$sql .= "SELECT DISTINCT ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE).",".$filter_group_type_id.",1 FROM ".self::$TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE)." <> '' AND ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE)." NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE);
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."sync_imported_filters(filter_name,filter_group_id,lang_id) ";
		$sql .= "SELECT DISTINCT ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER).",".$filter_group_gender_id.",1 FROM ".self::$TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER)." <> '' AND ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER)." NOT IN (SELECT name FROM ".DB_PREFIX."filter_description)";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);
		getDBResult($sql);

	}

	public static function sync_filters() {

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
	public static function importAttributeGroups() {

		$sql = 'CREATE TABLE IF NOT EXISTS sync_imported_attribute_groups (
		id int primary key auto_increment,
		attr_id int,
		attr_group_id int,
		name_attr text,
		name_attr_group text
		)';
		getDBResult($sql);

		$sql = "INSERT INTO sync_imported_attribute_groups(name_attr,name_attr_group) VALUES";
		for ($i = 0; $i < count(self::$ATTRIBUTES_LIST); $i++) {
			if ($i != 0) {
				$sql .= ",";
			}

			$sql .= "(".self::strSQL4Value(self::$ATTRIBUTES_LIST[$i]).",".self::strSQL4Value(self::$ATTRIBUTES_LIST[$i]).")";
		}
		if (count(self::$ATTRIBUTES_LIST) > 0) {
			getDBResult($sql);

		}
	}

	public static function sync_attributes_group() {

		$sql    = "SELECT MAX(attribute_group_id) as number from ".DB_PREFIX."attribute_group_description";
		$result = getDBResult($sql);
		$number = $result->row['number']+50;

		$sql        = "SELECT MAX(attribute_id) as number from ".DB_PREFIX."attribute";
		$result     = getDBResult($sql);
		$numberAttr = $result->row['number']+50;

		$sql = "INSERT INTO ".DB_PREFIX."attribute_group_description(attribute_group_id,language_id,name) ";
		$sql .= " SELECT (id+".$number."),1,name_attr_group from sync_imported_attribute_groups ";
		$sql .= " WHERE name_attr_group NOT IN (SELECT name FROM ".DB_PREFIX."attribute_group_description)";
		getDBResult($sql);

		$sql = " INSERT INTO ".DB_PREFIX."attribute_group(attribute_group_id,sort_order)";
		$sql .= " SELECT attribute_group_id,1 from ".DB_PREFIX."attribute_group_description ";
		$sql .= " WHERE attribute_group_id NOT IN (SELECT attribute_group_id FROM ".DB_PREFIX."attribute_group )";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."attribute_description(attribute_id,language_id,name) ";
		$sql .= " SELECT (id+".$numberAttr."),1,name_attr from sync_imported_attribute_groups ";
		$sql .= " WHERE name_attr NOT IN (SELECT name FROM ".DB_PREFIX."attribute_description)";
		getDBResult($sql);

		$sql = " update sync_imported_attribute_groups siag
		JOIN ".DB_PREFIX."attribute_group_description ag ON (siag.name_attr_group = ag.name) set  siag.attr_group_id = ag.attribute_group_id ";
		getDBResult($sql);

		$sql = " update sync_imported_attribute_groups siag
		JOIN ".DB_PREFIX."attribute_description ad ON (siag.name_attr = ad.name) set  siag.attr_id = ad.attribute_id ";
		getDBResult($sql);

		$sql = "SELECT attr_group_id,attr_id FROM sync_imported_attribute_groups siag ";
		$sql .= " WHERE  attr_id NOT IN (SELECT attribute_id FROM ".DB_PREFIX."attribute a WHERE a.attribute_group_id = siag.attr_group_id )";
		$rows = getDBResult($sql);
		foreach ($rows->rows as $row) {
			$sql = " INSERT INTO ".DB_PREFIX."attribute(attribute_id,attribute_group_id,sort_order)";
			$sql .= " VALUES (".$row['attr_id'].",".$row['attr_group_id'].",1)";
			mysql_query($sql) or die('sql: $sql. '.$sql.mysql_error());
		}

	}

	public static function importManufacturers() {

		$sql = "SELECT MAX(manufacturer_id) as number from ".DB_PREFIX."manufacturer";

		$result = getDBResult($sql);

		$number = $result->row['number']+50;

		$sql = 'CREATE TABLE IF NOT EXISTS sync_imported_manufacturers (
		id int primary key auto_increment,
		sync_id int,
		name text,
		description text,
		image text
		)';
		getDBResult($sql);

		$sql = "INSERT INTO sync_imported_manufacturers (sync_id,name,description,image) ";
		$sql .= " SELECT DISTINCT id + ".$number.",".self::strSQL4Field(self::$KEY_4_MANUFACT_MAME).",".self::strSQL4Field(self::$KEY_4_MANUFACT_DESCRIPTION).",".self::strSQL4Field(self::$KEY_4_MANUFACT_IMAGE)."
		FROM ".self::TABLE_NAME_SYNC_DATA." WHERE ".self::strSQL4Field(self::$KEY_4_MANUFACT_MAME)." NOT IN (SELECT name FROM ".DB_PREFIX."manufacturer) ";
		$sql .= " GROUP BY ".self::strSQL4Field(self::$KEY_4_MANUFACT_MAME);
		getDBResult($sql);

	}
	public static function sync_manufacturers() {

		$sql = "INSERT INTO ".DB_PREFIX."manufacturer SELECT sync_id,name,image,0
		FROM sync_imported_manufacturers
		WHERE sync_id NOT IN (SELECT manufacturer_id from ".DB_PREFIX."manufacturer)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."manufacturer_to_store SELECT manufacturer_id, 0 FROM ".DB_PREFIX."manufacturer WHERE manufacturer_id NOT IN (SELECT manufacturer_id FROM ".DB_PREFIX."manufacturer_to_store) ";
		getDBResult($sql);

		if (self::isLive) {
			$sql = "INSERT INTO ".DB_PREFIX."manufacturer_description(manufacturer_id,description,language_id) ";
			$sql .= " SELECT sync_id,description,1 FROM sync_imported_manufacturers";
			$sql .= " WHERE sync_id NOT IN (SELECT manufacturer_id from ".DB_PREFIX."manufacturer_description)";
			getDBResult($sql);
		}
	}

	public static function importCategories() {

		$sql        = "SELECT MAX(category_id) as number from ".DB_PREFIX."category Where status = 1";
		$result     = getDBResult($sql);
		$numberCats = $result->row['number']+100;

		$sql = 'CREATE TABLE IF NOT EXISTS sync_imported_categories (
			id int primary key auto_increment,
			sync_id int,
			category_id text,
			name text,
			image text,
			parent_id int,
			top int,
			level int,
			lang_id text
			)';
		getDBResult($sql);

		$sql = "INSERT INTO sync_imported_categories (sync_id,category_id,name,top,lang_id,parent_id) ";
		$sql .= " SELECT DISTINCT id + ".$numberCats.",".self::strSQL4Field(self::KEY_4_CATEGORY_ID).",".self::strSQL4Field(self::KEY_4_CATEGORY_NAME).",1,1,0
		FROM ".self::TABLE_NAME_SYNC_DATA." WHERE ".self::strSQL4Field(self::KEY_4_CATEGORY_NAME)." NOT IN (SELECT name FROM ".DB_PREFIX."category_description) ";
		$sql .= " GROUP BY ".self::strSQL4Field(self::KEY_4_CATEGORY_NAME);
		getDBResult($sql);

	}

	public static function sync_categories() {

		$sql = mysql_query("SELECT sync_name FROM ".DB_PREFIX."category_description");
		if (!$sql) {
			mysql_query("ALTER TABLE `".DB_PREFIX."category_description` ADD `sync_name` TEXT NULL AFTER `meta_keyword`") or die('ERROR: '.$sql.mysql_error());
		}

		$sql = "ALTER TABLE `".DB_PREFIX."category_description` CHANGE `name` `name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."category_description (category_id,name,language_id)
		SELECT sync_id,name,lang_id FROM sync_imported_categories
		WHERE name NOT IN (SELECT name FROM ".DB_PREFIX."category_description)";
		getDBResult($sql);

		$sql = "UPDATE ".DB_PREFIX."category_description SET sync_name=name WHERE sync_name IS NULL";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."category (category_id,status) SELECT category_id,1 FROM ".DB_PREFIX."category_description WHERE category_id NOT IN (SELECT category_id from ".DB_PREFIX."category)";
		getDBResult($sql);

		$sql = "UPDATE ".DB_PREFIX."category,sync_imported_categories
					SET ".DB_PREFIX."category.top=sync_imported_categories.top
					,".DB_PREFIX."category.parent_id=sync_imported_categories.parent_id
					WHERE ".DB_PREFIX."category.category_id=sync_imported_categories.sync_id ";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."category_to_store (category_id,store_id) SELECT category_id, 0 FROM ".DB_PREFIX."category WHERE category_id NOT IN (SELECT category_id FROM ".DB_PREFIX."category_to_store) ";
		getDBResult($sql);

	}

	/*
	key is model
	 */
	public static function importProducts() {

		$sql         = "SELECT MAX(product_id) as number from ".DB_PREFIX."product ";
		$result      = getDBResult($sql);
		$numberProds = $result->row['number']+100;

		$sql = "SELECT attribute_id from ".DB_PREFIX."attribute_description WHERE name =".self::strSQL4Value(self::$KEY_4_PRODUCT_ATTR_SIZE);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND ATTR SIZE");
		} else {

			$attr_size_id = $row->row['attribute_id'];
		}

		$sql = "SELECT attribute_id from ".DB_PREFIX."attribute_description WHERE name =".self::strSQL4Value(self::$KEY_4_PRODUCT_ATTR_TYPE);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND ATTR TYPE");
		} else {

			$attr_type_id = $row->row['attribute_id'];
		}

		$sql = "SELECT attribute_id from ".DB_PREFIX."attribute_description WHERE name =".self::strSQL4Value(self::$KEY_4_PRODUCT_ATTR_GENDER);
		$row = getDBResult($sql);
		if ($row->num_rows == 0) {
			die(" CANNOT FIND ATTR GENDER");
		} else {

			$attr_gender_id = $row->row['attribute_id'];
		}

		getDBResult('CREATE TABLE IF NOT EXISTS `sync_imported_products` (
		  `id` int(11) NOT NULL auto_increment,
		  `product_id` int(11) NOT NULL,
		  `sync_id` int(11) NOT NULL,
		  `model` varchar(50) default NULL,
		  `name` varchar(100) default NULL,
		  `meta_description` text,
		  `description` text,
		  `image` text,
  		  `price` varchar(9) default NULL,
		  `manufacturer_id` int default NULL,
  		  `manufacturer_name` text default NULL,
		  `manufacturer_description` text,
		  `attr_size_id` int default NULL,
		  `attr_type_id` int default NULL,
		  `attr_gender_id` text default NULL,
		  `attr_size_name` text default NULL,
		  `attr_type_name` text default NULL,
		  `attr_gender_name` text default NULL,
		  `filter_size_name` text default NULL,
		  `filter_type_name` text default NULL,
		  `filter_gender_name` text default NULL,
		  `date` varchar(30) NOT NULL,
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');

		$sql = "UPDATE ".DB_PREFIX."product, ".self::TABLE_NAME_SYNC_DATA." SET ".DB_PREFIX."product.model = ".self::TABLE_NAME_SYNC_DATA.".".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL).", ".DB_PREFIX."product.price = ".self::TABLE_NAME_SYNC_DATA.".".self::strSQL4Field(self::KEY_4_PRODUCT_PRICE)."
		WHERE ".DB_PREFIX."product.model = ".self::TABLE_NAME_SYNC_DATA.".".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL)." AND ".DB_PREFIX."product.price != ".self::TABLE_NAME_SYNC_DATA.".".self::strSQL4Field(self::KEY_4_PRODUCT_PRICE);
		getDBResult($sql);

		$sql = "INSERT INTO sync_imported_products
		(sync_id,product_id,model,name,meta_description,description,image,price,manufacturer_name,manufacturer_description,
		attr_size_id,attr_type_id,attr_gender_id,attr_size_name,attr_type_name,attr_gender_name,filter_size_name,filter_type_name,filter_gender_name,date) ";
		$sql .= " SELECT DISTINCT id + ".$numberProds.",".self::strSQL4Field(self::KEY_4_PRODUCT_ID).",".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL).",".self::strSQL4Field(self::KEY_4_PRODUCT_NAME).",".self::strSQL4Field(self::KEY_4_PRODUCT_META_DESCRIPTION);
		$sql .= ", ".self::strSQL4Field(self::KEY_4_PRODUCT_DESCRIPTION).",img_name,".self::strSQL4Field(self::KEY_4_PRODUCT_PRICE).",".self::strSQL4Field(self::$KEY_4_MANUFACT_MAME).",".self::strSQL4Field(self::$KEY_4_MANUFACT_DESCRIPTION);
		$sql .= ",".$attr_size_id.",".$attr_type_id.",".$attr_gender_id;
		$sql .= ",".self::strSQL4Field(self::$KEY_4_PRODUCT_ATTR_SIZE).",".self::strSQL4Field(self::$KEY_4_PRODUCT_ATTR_TYPE).",".self::strSQL4Field(self::$KEY_4_PRODUCT_ATTR_GENDER);
		$sql .= ",".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_SIZE).",".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_TYPE).",".self::strSQL4Field(self::$KEY_4_PRODUCT_FILTER_GROUP_GENDER);
		$sql .= " ,now()";
		$sql .= " FROM ".self::TABLE_NAME_SYNC_DATA;
		$sql .= " WHERE ".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL)." NOT IN (SELECT model FROM ".DB_PREFIX."product) ";
		$sql .= " GROUP BY ".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL);
		getDBResult($sql);

		$sql = "update sync_imported_products sip join ".DB_PREFIX."manufacturer m ON (sip.manufacturer_name = m.name) set sip.manufacturer_id = m.manufacturer_id ";
		getDBResult($sql);
	}
	public static function sync_products() {

		$sql = "insert into ".DB_PREFIX."product(product_id,model,status,image,price,manufacturer_id,quantity,date_added,date_modified)
		select sync_id,model,1,image,price,manufacturer_id,100,now(),now() from sync_imported_products
		WHERE model NOT IN (SELECT model FROM ".DB_PREFIX."product) ";
		getDBResult($sql);

		$sql = "
		INSERT INTO ".DB_PREFIX."product_description( description,meta_description,product_id, name, language_id )
		SELECT description,meta_description,sync_id,name,1
		FROM sync_imported_products	WHERE sync_id NOT IN (select product_id from ".DB_PREFIX."product_description) ";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_image(product_id,image) ";
		$sql .= " SELECT sync_id,image from sync_imported_products ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id from ".DB_PREFIX."product_image) ";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_to_store(product_id) SELECT product_id from ".DB_PREFIX."product WHERE (product_id) NOT IN (SELECT product_id FROM ".DB_PREFIX."product_to_store)";
		getDBResult($sql);

		$sql = "select count(*) as number from sync_imported_products";
		$row = getDBResult($sql);
		if ($row->row['number'] > 0) {

			$sql = "update ".DB_PREFIX."product p set p.status = 0 WHERE p.product_id NOT IN (select sync_id from sync_imported_products) ";
			getDBResult($sql);
		}

	}

	public static function sync_cat_prod() {

		$sql = "SELECT src1.".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL).",sync_imported_products.sync_id as pid, sync_imported_categories.sync_id as cat_id
		from ".self::TABLE_NAME_SYNC_DATA." src1 LEFT JOIN sync_imported_products ON (sync_imported_products.product_id = src1.".self::strSQL4Field(self::KEY_4_PRODUCT_ID).")
		LEFT JOIN sync_imported_categories ON (sync_imported_categories.category_id = src1.".self::strSQL4Field(self::KEY_4_CATEGORY_ID).")
		WHERE sync_imported_products.sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_to_category WHERE ".DB_PREFIX."product_to_category.category_id = sync_imported_categories.sync_id )
		group by src1.".self::strSQL4Field(self::KEY_4_PRODUCT_MODEL);
		$fieldsCatProd = getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_to_category (product_id,category_id) ";
		$sql .= " VALUES ";
		$i = 0;
		foreach ($fieldsCatProd->rows as $fieldCatProd) {
			if ($i != 0) {
				$sql .= ",";
			}
			$sql .= "(";
			$sql .= self::strSQL4Value($fieldCatProd['pid']).",".self::strSQL4Value($fieldCatProd['cat_id']);
			$sql .= ")";
			$i++;

		}

		if ($i != 0) {

			getDBResult($sql);
		}

	}

	public static function sync_prod_attributes() {

		$sql = "INSERT INTO ".DB_PREFIX."product_attribute(product_id,attribute_id,language_id,text)";
		$sql .= " SELECT sync_id,attr_size_id,1,attr_size_name FROM sync_imported_products ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_attribute WHERE attribute_id = attr_size_id)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_attribute(product_id,attribute_id,language_id,text)";
		$sql .= " SELECT sync_id,attr_type_id,1,attr_type_name FROM sync_imported_products ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_attribute WHERE attribute_id = attr_type_id)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_attribute(product_id,attribute_id,language_id,text)";
		$sql .= " SELECT sync_id,attr_gender_id,1,attr_gender_name FROM sync_imported_products ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_attribute WHERE attribute_id = attr_gender_id)";
		getDBResult($sql);

	}

	public static function sync_prod_filters() {

		$sql = "INSERT INTO ".DB_PREFIX."product_filter(product_id,filter_id)";
		$sql .= " SELECT sync_id,filter_id FROM sync_imported_products JOIN ".DB_PREFIX."filter_description f ON (sync_imported_products.filter_size_name = f.name ) ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_filter WHERE filter_id = f.filter_id)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_filter(product_id,filter_id)";
		$sql .= " SELECT sync_id,filter_id FROM sync_imported_products JOIN ".DB_PREFIX."filter_description f ON (sync_imported_products.filter_type_name = f.name ) ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_filter WHERE filter_id = f.filter_id)";
		getDBResult($sql);

		$sql = "INSERT INTO ".DB_PREFIX."product_filter(product_id,filter_id)";
		$sql .= " SELECT sync_id,filter_id FROM sync_imported_products JOIN ".DB_PREFIX."filter_description f ON (sync_imported_products.filter_gender_name = f.name ) ";
		$sql .= " WHERE sync_id NOT IN (SELECT product_id FROM ".DB_PREFIX."product_filter WHERE filter_id = f.filter_id)";
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

		$sql    = "select ".self::strSQL4Field(self::KEY_4_PRODUCT_IMAGE).",img_name from ".self::TABLE_NAME_SYNC_DATA;
		$result = mysql_query($sql);
		if (!file_exists('../image/'.self::SYNC_IMG_DIR)) {
			mkdir('../image/'.self::SYNC_IMG_DIR, 0777, true);
		}
		while ($row = mysql_fetch_array($result)) {
			$urlImage = $row[self::KEY_4_PRODUCT_IMAGE];
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