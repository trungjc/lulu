<?php 
	include_once('util.php'); 
	
?>
<html>
<head>
	<title>Import</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
	<style type="text/css">
		.red{ color:red;}
		.green{color: green;}
		body{
			padding: 20px;
			margin: 0;
		}
		.bs-callout-warning {
   			border-left-color: #f0ad4e;
		}
		.bs-callout {
		    -moz-border-bottom-colors: none;
		    -moz-border-left-colors: none;
		    -moz-border-right-colors: none;
		    -moz-border-top-colors: none;
		    border-image: none;
		    border-radius: 3px;
		    border-style: solid;
		    border-width: 1px 1px 1px 5px;
		    margin: 20px 0;
		    padding: 20px;
		}
		.bs-callout-warning h4 {
		    color: #f0ad4e;
		}
		.bs-callout h4 {
		    margin-bottom: 5px;
		    margin-top: 0;
		}
		p {
		    margin: 0 0 10px;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<?php
		if(!empty($_FILES)){
			$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
			//pr($_FILES);
			$csv = $_FILES['file'];
			if($csv['error']==0){
				//begin copy 
				$filename = $path.'temp_csv.csv';
				if(file_exists($filename)){
					if(unlink($filename)){
						if(copy($csv['tmp_name'],$filename)){
							$str = '<span class="label label-success">CSV UPLOADED.</span>';
						}	
					}
				}else{
					if(copy($csv['tmp_name'],$filename)){
						$str = '<span class="label label-success">CSV UPLOADED.</span>';
					}
				}
			}
		}
			

		?>
		<div class="panel panel-default">
  			<div class="panel-body">
  				<div class="col-md-3">
					<form method="post" id="form" enctype="multipart/form-data">
						<p>
							<input type="file" name="file" id="file" value="Browse" style="display:none">
							<input type="button" class="btn btn-primary btn-xs" id="button" value="Browse CSV to Upload" onclick="jQuery('#file').trigger('click')">
							<?php echo $str;  ?>
						</p>
					</form>
				</div>
				<div class="col-md-9">
					<div>
				  		<div>Enter markup % amount <input type="text" id="priceup"></div>
					</div>
					<input type="button" class="btn btn-info btn-xs" id="buttonimport" value="RUN Import">
					<span class="label label-warning">WARNING: THIS WILL DELETE THE PREVIOUSLY IMPORTED CSV DATA</span>
				</div>
			</div>
		</div>
		<div id="stats"></div>
		<div id="actions">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title"></h3>
			  </div>
			  <div class="panel-body">
			  	 <div id="callout-navbar-overflow" class="bs-callout bs-callout-warning">
				    <h4>Notes</h4>
				    <p>If you think the scrapping status didn't move, you can click the run scrapper button many times.</p>
				    <ol type="a">
				      <li>Do not close the browser when running.</li>
				    </ol>
				  </div>
				 <div>
			    	<input type="button" class="btn btn-primary btn-xs" id="buttonscrapp" value="Run Scrapper">
			   		<a type="button" href="ajax.php?action=export" class="btn btn-warning btn-xs" id="buttonimport">Export CSV</a>
			   		<img src="ajax-loader.gif" id="loader" style="display:none"/>
			   	</div>
			  </div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">Logs</h3>
			  </div>
			  <div class="panel-body">
			  		<div id="logs" style="max-height:500px;overflow:auto;"></div>
			  	</div>
			</div>

		</div>
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		var running = false;
	    function checkrunbtn(){
	    	setTimeout(checkrunbtn,5000);
	    	if(running==true){
		    	if($('#buttonscrapp').val() != 'Please wait...'){ 
		    		console.log('Force Start Running');   		
		    		$('#buttonscrapp').trigger('click');
		    	}
	    	}
	    }
		function startstats(){
			setTimeout(startstats,5000);
			$.get('ajax.php?action=stats',function(data){
					$('#stats').html(data);
				});
		}
		$ = jQuery.noConflict();
		jQuery(document).ready(function($){
			startstats();
			checkrunbtn();
			$('#file').change(function(){
				$('#button').val('Please wait...');
				$("#form").submit();
			});
			$('#buttonimport').click(function(){
				$(this).val('Please wait...');
				$.get('ajax.php?action=import&markup=' + $('#priceup').val(),function(data){
					$('#stats').html(data);
					$('#buttonimport').val('RUN Import');
				});
			});
			$('#buttonscrapp').click(function(){
				running = true;
				$(this).val('Please wait...');
				$("#loader").show();
				$.get('ajax.php?action=scrape',function(data){
					$('#logs').prepend(data);
					$('#buttonscrapp').val('Run Scrapper');
					$("#loader").hide();
					running = false;
					console.log('Stop Running Status');
				});
			});
		});
	</script>
</body>
</html>