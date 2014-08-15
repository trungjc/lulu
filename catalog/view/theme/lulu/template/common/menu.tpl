<script type="text/javascript" src="<?php echo $base; ?>catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $base; ?>catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="<?php echo $base; ?>catalog/view/javascript/common.js"></script>
<?php 
if($menu_type == "header"){  
	echo $supermenu_settings;
	echo $supermenu; 
}
if($menu_type == "footer"){ 
	echo $footer; 
} 
?>