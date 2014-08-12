<?php 
set_time_limit(0);
include_once('util.php');
global $db;

function getstats(){
	global $db;
	$res = $db->fetch("SELECT  
					(select count(*) from `temp_csv_upload` where iscrawled='yes') as completed, 
					count(*) as total 
				FROM `temp_csv_upload`",true);
	$completed = number_format(($res['completed']/$res['total'])*100,2);
	?>
	<div class="panel panel-info" style="width:50%;">
	  <div class="panel-heading">
	    <h3 class="panel-title">Scrapping Status (<?php echo $res['completed'].'/'.$res['total']; ?> Completed)</h3>
	  </div>
	  <div class="panel-body">
				<div class="progress">
				  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $completed; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $completed; ?>%;">
				    <span class="sr-only"><?php echo $completed; ?>% Complete</span>
				  </div>
				</div>
		</div>
	</div>
	<?php
}


switch($_GET['action']){
	case "stats":
		getstats();
	break;
	case "import":

			   //if($_GET['markup']==""){ exit(0); }

		       $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR."temp_csv.csv";
		       if(!file_exists($filename)){ exit(0); }

	          //truncate table
	      	  $db->query("TRUNCATE TABLE `temp_csv_upload`");

	          
	         	//$handle = fopen($filename, "r");
	     	  	
	     	  	$row = 0;
	     	  	$datas = array();
				if (($handle = fopen($filename, "r")) !== FALSE) {
				    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				        $num = count($data);
				        if($row>0){
					        for ($c=0; $c < $num; $c++) {
					            $datas[$row][$c] = $data[$c];
					        }
				    	}
				        $row++;
				    }
				    fclose($handle);
				}

	      	foreach($datas as $data){
	      			
	      			/*$m = number_format($db->clean($data[6]),2) * (number_format($_GET['markup'],2)/100);
	      			$price = number_format(number_format($db->clean($data[6]),2) + $m,2);

	      			$sql="insert into temp_csv_upload
					set 
					itemno ='".$db->clean($data[0])."', 
					brandname ='".$db->clean($data[1])."', 
					productname ='".$db->clean($data[2])."', 
					shortdescription ='".$db->clean($data[4])."',
					productdescription ='".$db->clean($data[9])."',
					gender ='".$db->clean($data[5])."',
					imagelink ='".$db->clean($data[2])."',
					retailprice_aud ='".$db->clean($data[6])."',
					cost_aud ='".$db->clean($data[7])."',
					price ='".$price."',
					iscrawled ='no'
					";*/
					$m = number_format($db->clean($data[5]),2) * (number_format($_GET['markup'],2)/100);
	      			$price = number_format(number_format($db->clean($data[5]),2) + $m,2);

	      			//determine type here
	      			$size = "";
	      			if($data[2]<>""){

	      				if(strpos(strtolower($data[2]),"gift") != FALSE){
	      					$type = $data[2];	
		      			}else{
		      				if(strpos($data[2]," ml ") != FALSE){
		      					$type = explode(" ml ",$data[2]);
		      					$size = $type[0].' ml';
		      					$type = $type[1];
		      				}else{
		      					if(strpos($data[2]," oz ") != FALSE){
			      					$type = explode(" oz ",$data[2]);
			      					$size = $type[0].' oz';
			      					$type = $type[1];
			      				}else{
			      					$type = $data[2];
			      				}
		      				}
		      			}
	      			}

	      			$sql="insert into temp_csv_upload
					set 
					itemno ='".$db->clean($data[0])."', 
					productname ='".$db->clean($data[1])."', 
					gender ='".$db->clean($data[3])."',
					retailprice_aud ='".$db->clean($data[4])."',
					cost_aud ='".$db->clean($data[5])."',
					type='".$db->clean($type)."',
					size='".$size."',
					price = '".$price."',
					iscrawled ='no'
					";

					$db->connect();
					mysql_query($sql) or die(mysql_error());

	      	}

	      getstats();

	break;

	case "scrape":
		include_once('simple_html_dom.php');
		$items = $db->fetch("select * from temp_csv_upload where iscrawled = 'no'");

		$ctr=1;
		foreach($items as $item){
			//echo '<hr>Checking itemno: '.$item['itemno'].'<br>';
			$data =  get_item_data($item['itemno']);
			if($data==false){
				sleep(15);
				$data =  get_item_data($item['itemno']);
				$ctr=1;
			}
			$html = str_get_html($data);

			$desc =  $html->find('div[class=product-hero-desc]',0);
			if(!empty($desc)){
				$desc = $desc->find('p[class=mtn]',0);
			}
			$desc =str_replace(
						array(
							"All products are original, authentic name brands. We do not sell knockoffs or imitations",
							"Read More",
							"...",
							" ."
							),
						array(
							"",
							"",
							"",
							""),
						$desc->plaintext);
			 $img = $html->find('ul[class=product-list]',0);
			 if(!empty($img)){
			 	$img = $img->find('div[class=blink]',0);
			 	 if(!empty($img)){
			 	 	$img = $img->find('img',0);
			 	 	 if(!empty($img)){
			 	 	 	$img = 'http://www.fragrancex.com'.$img->src;
			 	 	 }
			 	 }
			 }
			 $brand = $html->find('div[class=product-hero-desc]',0);
			 if(!empty($brand)){
			 	$brand = $brand->find('p[class=blink]',0);
			 	if(!empty($brand)){
			 		$brand = $brand->find('a',0);
			 		if(!empty($brand)){
			 			 $link = $brand->attr['href'];
			 			$brand = $brand->plaintext;
			 			if($brand<>""){
			 				//check database
			 				$sql="select count(*) as r from temp_csv_brand where brandname='".trim($brand)."'";
			 				$row = $db->fetch($sql,true);
			 				if($row['r']=='0'){
			 					 $brand_data = get_item_brand('http://www.fragrancex.com'.$link);
			 					$brand_data = str_get_html($brand_data);
			 					if(!empty($brand_data)){
			 						$nl = $brand_data->find('div[class=brand-descrip]',0);
			 						if(!empty($nl)){
			 							$nl = $nl->find('a[class=cta-no-arrow]',0);
			 							if(!empty($nl)){
			 								//get the brand description in another page
			 								 $link = $nl->attr['href'];
			 								 $brand_data = get_item_brand('http://www.fragrancex.com'.$link);
			 								 $brand_data = str_get_html($brand_data);
			 								 $desc = $brand_data->find('div[class=body-1]',0);
			 								 if(!empty($desc)){
			 								 	$desc = str_replace("See All products by ".$brand, "", $desc->plaintext);

			 								 	$db->query("insert into temp_csv_brand set 
			 								 				brandname='".$brand."',
			 								 				branddescription ='".trim($desc)."'
			 								 				");
			 								 }
			 							}
			 						}
			 					}
			 					
			 				}
			 			}
			 		}
			 	}
			 }

			 $productname = $html->find('div[class=product-hero-scale]',0);
			 if(!empty($productname)){
			 	$productname = $productname->find('h1[class=h2]',0);
			 	if(!empty($productname)){
			 		$productname = $productname->plaintext;
			 	}
			 }
			// $type = $html->find('ul[class=product-list]',0)->find('div[class=product-info]',0)->find('div[class=h5]',0)->plaintext;
			// $type = explode("oz",$type);
			//echo $data;
			/*$db->query("update temp_csv_upload 
							set 
							iscrawled='yes',
							productdescription='".$db->clean($desc)."',
							imagelink='".$db->clean($img)."',
							brandname ='".$db->clean($brand)."',
							size ='".$db->clean($type[0])."',
							type ='".$db->clean($type[1])."',
							productname  ='".$db->clean($productname)."'
							where itemno='".$item['itemno']."'
						");*/

			$db->query("update temp_csv_upload 
							set 
							iscrawled='yes',
							productdescription='".$db->clean($desc)."',
							imagelink='".$db->clean($img)."',
							brandname ='".$db->clean($brand)."',
							productname  ='".$db->clean($productname)."'
							where itemno='".$item['itemno']."'
						");

			if($ctr==15){
				//sleep to prevent us from being blocked
				sleep(15);
				$ctr =0;
			}
		 $ctr++;

		}
	break;

	case "export":

			$data = $db->fetch("SELECT *, 
						(select branddescription from temp_csv_brand where brandname=a.brandname) as branddescription 
						FROM `temp_csv_upload` a");
			$c[0] = array(
						"ItemNumber",
						"Brand",
						"Brand Description",
						"Product Name",
						"Product Description",
						"Size",
						"Type",
						"Gender",
						"Image Link",
						"Retail Price",
						"Cost (in AUD)"
					);
			$a=1;
			foreach($data as $d){
				$c[$a] = array(
						$d['itemno'],
						$d['brandname'],
						$d['branddescription'],
						$d['productname'],
						$d['productdescription'],
						$d['size'],
						$d['type'],
						$d['gender'],
						$d['imagelink'],
						$d['retailprice_aud'],
						$d['price']
					);
			$a++;
			}
			download_send_headers("data_export_" . date("Y-m-d") . ".csv");
			echo array2csv($c);
			die();
	break;


}


?>