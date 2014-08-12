<?php
include 'dbx.php';
require_once 'tools.php';
if (isset($_GET['file'])) {
	Tools::initFieldFromCSV($_GET['file']);
}
?>
<h3>Products To Be Imported</h3>
<?php
$sql    = "select count(*) as total from ".Tools::TABLE_NAME_SYNC_DATA;
$result = getDBResult($sql);
if ($result) {
	echo $result->row['total']." Products To Be Imported<br/>";
}

?>
<h3>Manufacturers Imported</h3>
<?php

$sql     = "select * from sync_imported_manufacturers";
$results = getDBResult($sql);
foreach ($results->rows as $result)
echo $result['name']."<br/>";

?>
<h3>Categories Imported</h3>
<?php

$sql     = "select * from sync_imported_categories";
$results = getDBResult($sql);
foreach ($results->rows as $result)
echo $result['name']."<br/>";
?>
<h3>Filter Groups Imported</h3>
<?php

$sql     = "select * from sync_imported_filter_groups";
$results = getDBResult($sql);
foreach ($results->rows as $result)
echo $result['filter_group_name']."<br/>";

?>
<h3>Filters Imported</h3>
<?php

$sql     = "select * from ".DB_PREFIX."sync_imported_filters";
$results = getDBResult($sql);
foreach ($results->rows as $result)
echo $result['filter_name']."<br/>";

?>
<h3>Products Inactivated</h3>
<?php

$sql     = "select pd.name from ".DB_PREFIX."product p JOIN ".DB_PREFIX."product_description pd ON (p.product_id = pd.product_id) where p.status = 0 limit 500";
$results = getDBResult($sql);
foreach ($results->rows as $result)
echo $result['name']."<br/>";
?>
<h3>Products Imported</h3>
<?php

$sql    = "select count(*) as total from sync_imported_products";
$result = getDBResult($sql);
if ($result) {
	echo $result->row['total']." Products Have Been Imported<br/>";
}

Tools::cleanDraftData();
?>