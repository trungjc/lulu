<head>
<meta charset="UTF-8" />
<base href="<?php echo $base; ?>" />
<?php echo $supermenu_settings; ?>
</head>
<?php if($menu_type == "header"){  echo $supermenu; } ?>
<?php if($menu_type == "footer"){ echo $footer; } ?>