<?php foreach ($links as $link) { ?>
<link href="<?php echo $base; ?><?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>catalog/view/theme/lulu/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $base; ?><?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="<?php echo $base; ?>catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $base; ?>catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="<?php echo $base; ?>catalog/view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $base; ?><?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="<?php echo $base; ?>catalog/view/theme/lulu/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/lulu/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php 
if($wpmenu == "header"){  
	echo $supermenu_settings;
	echo $supermenu; 
}
if($wpmenu == "footer"){ 
	echo $footer; 
} 
?>