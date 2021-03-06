<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/lulu/stylesheet/stylesheet.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<?php echo $supermenu_settings; ?>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/lulu/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/lulu/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php echo $google_analytics; ?>

			<?php
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/news.css')) {
				$news_css = $this->config->get('config_template') . '/stylesheet/news.css';
			} else {
				$news_css = 'default/stylesheet/news.css';
			}
			?>
          <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $news_css;?>" />
			
</head>
<body<?php 
					
					//Preset ID && Class
					$class 	 = 'home common-home';
					$id 	 = 'phome';

					//If Route Exists
					if(isset($this->request->get['route'])){

						//Get Route
						$class 	 = explode('/',$this->request->get['route']);
						$id 	 = 'p'.$class[1];
						$class 	 = 'p'.implode(' ',array_splice($class,1));
						$class 	.= ' class-'.str_replace('/','-',$this->request->get['route']);

						//Load Models
						$this->load->model('catalog/category');
						$this->load->model('catalog/information');
						$this->load->model('catalog/product');

						//Category
						if(isset($this->request->get['path'])){
							$cats  	= explode('_',$this->request->get['path']);
							$cats 	= !is_array($cats)? array($cats) : $cats;
							foreach($cats as $cat){
								$model 	= $this->model_catalog_category->getCategory($cat);
								$class .= ' category-'.$cat;
								$class .= ' category-'.str_replace(' ','-',preg_replace('/[^a-z0-9\s]/','',strtolower($model['name'])));
							}
						}

						//Information
						if(isset($this->request->get['information_id'])){
							$info 	= $this->request->get['information_id'];
							$model	= $this->model_catalog_information->getInformation($info);
							$class .= ' information-'.$info;
							$class .= ' information-'.str_replace(' ','-',preg_replace('/[^a-z0-9\s]/','',strtolower($model['title'])));
						}


						//Product
						if(isset($this->request->get['product_id'])){
							$prod   = $this->request->get['product_id'];
							$model  = $this->model_catalog_product->getProduct($prod);
							$class .= ' product-'.$prod;
							$class .= ' product-'.str_replace(' ','-',preg_replace('/[^a-z0-9\s]/','',strtolower($model['name'])));

						}

					}
					echo ' id="'.$id.'" class="'.$class.'" ';
			?>>
<div id="container">
<div id="header">
    <div class="notice">Complimentary shipping on orders over $75</div>
    <div class="livechat" style="display: none">
        <a href="#">live chat</a>
    </div>
  <?php if ($logo) { ?>
  <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  <div id="search">
    <div class="button-search"></div>
    <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
  </div>
  <div id="welcome">
    <?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
  </div>
  <div class="links"><!--a href="<?php echo $home; ?>"><?php echo $text_home; ?></a!-->
      <a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a>
      <!--a href="<?php echo $account; ?>"><?php echo $text_account; ?></a-->
      <!--a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a-->
      <a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
  </div>
  <div class="social">
      <a href="#" class="facebook">facebook</a>
      <a href="#" class="tiwtter">tiwtter</a>
      <a href="#" class="diagram">diagram</a>
      <a href="#" class="printest">printest</a>
       <a href="#" class="youtube">youtube</a>
  </div>
</div>
    <div id="menu">
<?php echo $supermenu; ?>
<?php if ($categories) { ?>

<?php } ?>
    </div>
<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/lulu/image/close.png" alt="" class="close" /></div>
    
<?php } ?>
<div id="notification"></div>
