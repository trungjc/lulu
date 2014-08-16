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
                    <div class="notice">Complimentary shipping on orders over $100</div>
                    <div style="display: none" class="livechat">
                        <a href="#">live chat</a>
                    </div>
                    <div id="logo"><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu/index.php?route=common/home"><img alt="Your Store" title="Your Store" src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu/image/data/logo.png"></a></div>
                    <div id="search">
                    <div class="button-search"></div>
                    <input type="text" value="" placeholder="Search" name="search">
                  </div>
                  <div id="welcome">
                        <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu/index.php?route=account/login">Sign In</a> / <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu/index.php?route=account/register">Register</a>.      </div>
                  <div class="links"><!--a href="http://localhost/lulu/index.php?route=common/home">Home</a!-->
                      <a id="wishlist-total" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu/index.php?route=account/wishlist">Wish List</a>
                      <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/lulu/index.php?route=checkout/checkout">Checkout</a>
                  </div>
                  <div class="social">
                      <a class="facebook" href="https://www.facebook.com/LuluandLipstick">facebook</a>
                      <a class="tiwtter" href="https://twitter.com/LuluandLipstick">tiwtter</a>
                      <a class="diagram" href="http://instagram.com/luluandlipstick">diagram</a>
                      <a class="printest" href="https://www.pinterest.com/luluandlipstick">printest</a>
                       <a class="youtube" href="#">youtube</a>
                  </div>
	</header><!-- #masthead -->
        <div id="menu">
<?php 
$menu = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/lulu/index.php?route=common/menu');
echo $menu;
?>	
        </div>
        <?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</a>
	</div>
	<?php endif; ?>
       
	<div id="content" class="wrapper">