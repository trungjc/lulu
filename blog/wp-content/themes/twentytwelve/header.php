<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="container">
	<header id="header" class="site-header" role="banner">
                    <div class="notice">Complimentary shipping on orders over $75</div>
                    <div style="display: none" class="livechat">
                        <a href="#">live chat</a>
                    </div>
                    <div id="logo"><a href="http://localhost/lulu/index.php?route=common/home"><img alt="Your Store" title="Your Store" src="http://localhost/lulu/image/data/logo.png"></a></div>
                    <div id="search">
                    <div class="button-search"></div>
                    <input type="text" value="" placeholder="Search" name="search">
                  </div>
                  <div id="welcome">
                        <a href="http://localhost/lulu/index.php?route=account/login">Sign In</a> / <a href="http://localhost/lulu/index.php?route=account/register">Register</a>.      </div>
                  <div class="links"><!--a href="http://localhost/lulu/index.php?route=common/home">Home</a!-->
                      <a id="wishlist-total" href="http://localhost/lulu/index.php?route=account/wishlist">Wish List (0)</a>
                      <!--a href="http://localhost/lulu/index.php?route=account/account">My Account</a-->
                      <!--a href="http://localhost/lulu/index.php?route=checkout/cart">Shopping Cart</a-->
                      <a href="http://localhost/lulu/index.php?route=checkout/checkout">Checkout</a>
                  </div>
                  <div class="social">
                      <a class="facebook" href="#">facebook</a>
                      <a class="tiwtter" href="#">tiwtter</a>
                      <a class="diagram" href="#">diagram</a>
                      <a class="printest" href="#">printest</a>
                       <a class="youtube" href="#">youtube</a>
                  </div>
	</header><!-- #masthead -->
        <div id="menu">
            <div id="menu">
<script type="text/javascript"> 
$(document).ready(function(){ 
	var setari = {   
				over: function() { $(this).find('.bigdiv').fadeIn('fast'); }, 
		out: function() { $(this).find('.bigdiv').fadeOut('fast'); },
				timeout: 150
	};
	$("#supermenu ul li.tlli").hoverIntent(setari);
	var setariflyout = {   
		over: function() { $(this).find('.flyouttoright').fadeIn('fast'); }, 
		out: function() { $(this).find('.flyouttoright').fadeOut('fast'); },
		timeout: 200
	};
	$("#supermenu ul li div.bigdiv.withflyout &gt; .withchildfo").hoverIntent(setariflyout);
});
</script>
<div class="default" id="supermenu">
		<ul>
										<li class="tlli">
				<a href="http://dev.dusted.com.au/lulu/" class="tll">Home</a>
				
											</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli">
				<a href="http://localhost/lulu/index.php?route=product/category&amp;path=25" class="tll">fragrances</a>
				
											</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli mkids">
				<a href="http://localhost/lulu/index.php?route=product/category&amp;path=20" class="tll">make up</a>
				
													<div class="bigdiv" style="margin-left: 0px; position: absolute; visibility: visible; display: none; width: 583px;">
											
													<div class="menu-add">
																	<a><img alt="make up" src="image/data/LipAnimation_MegaNav_071714_image.jpg"></a>
															</div>
																								<div style="margin-right: 210px" class="supermenu-left">
								  
														
								  
																																		<div class="withchild haskids">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=20_67" class="theparent">eyes makeup</a>
																							<span class="mainexpand"></span>
												<ul class="child-level">
																											<li><a href="http://localhost/lulu/index.php?route=product/category&amp;path=20_67_69">mascara</a></li>
																									</ul>
																					</div>
																			<div class="withchild haskids">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=20_66" class="theparent">Face makeup</a>
																							<span class="mainexpand"></span>
												<ul class="child-level">
																											<li><a href="http://localhost/lulu/index.php?route=product/category&amp;path=20_66_68">Foundation Sets</a></li>
																									</ul>
																					</div>
																														</div>
													<div class="addingaspace"></div>
											</div>
							</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli">
				<a href="http://localhost/lulu/index.php?route=product/category&amp;path=33" class="tll">Skincare</a>
				
											</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli mkids">
				<a href="http://localhost/lulu/index.php?route=product/category&amp;path=18" class="tll">hair care</a>
				
													<div class="bigdiv" style="margin-left: -66.5px; position: absolute; visibility: visible; display: none; width: 605px;">
											
													<div class="menu-add">
																	<a><img alt="hair care" src="image/data/meganav_hair_9.24.13_v2.jpg"></a>
															</div>
																								<div style="margin-right: 210px" class="supermenu-left">
								  
														
								  
																																		<div class="withchild">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=18_64" class="theparent">shampoo and conditioner</a>
																					</div>
																			<div class="withchild">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=18_63" class="theparent">styling products</a>
																					</div>
																			<div class="withchild">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=18_65" class="theparent">treatment</a>
																					</div>
																														</div>
													<div class="addingaspace"></div>
											</div>
							</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli mkids">
				<a href="http://localhost/lulu/index.php?route=product/category&amp;path=59" class="tll">Tools</a>
				
													<div class="bigdiv" style="margin-left: -171.5px; position: absolute; visibility: visible; display: none; width: 605px;">
											
													<div class="menu-add">
																	<a><img alt="Tools" src="image/data/toolsguide_meganav_073114_image.jpg"></a>
															</div>
																								<div style="margin-right: 210px" class="supermenu-left">
								  
														
								  
																																		<div class="withchild">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=59_62" class="theparent">accessories</a>
																					</div>
																			<div class="withchild">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=59_61" class="theparent">bags</a>
																					</div>
																			<div class="withchild">
											<a href="http://localhost/lulu/index.php?route=product/category&amp;path=59_60" class="theparent">brushes</a>
																					</div>
																														</div>
													<div class="addingaspace"></div>
											</div>
							</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli">
				<a href="http://dev.dusted.com.au/lulu/index.php?route=product/manufacturer" class="tll">Brands</a>
				
											</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli">
				<a href="http://localhost/lulu/index.php?route=information/information&amp;information_id=8" class="tll">sale</a>
				
											</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli">
				<a href="http://localhost/lulu/index.php?route=product/category&amp;path=70" class="tll">Gifts</a>
				
											</li>
					<li class="tlli sep"><span class="item-sep">&nbsp;</span></li>			<li class="tlli">
				<a href="http://localhost/lulu/index.php?route=information/information&amp;information_id=4" class="tll">who is lulu</a>
				
											</li>
			</ul>
</div>

    </div>

        </div>
        <div class="banners" id="">
        <div style="display: block;"><a href="#"><img title="who is lulu " alt="who is lulu " src="http://localhost/lulu/image/cache/data/banner/whoislulu-980x188.png"></a></div>
      </div>
	<div id="content" class="wrapper">