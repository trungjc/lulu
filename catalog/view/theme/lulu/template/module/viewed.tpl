<?php if (count($products) > 0) { ?>
<div id="recently-viewed" class="tab-content">
<div class="box-product">
<?php foreach ($products as $product) {
// add locById if required
if(!strpos("locByLocId", $product['href']) && isset($_REQUEST['locByLocId'])) { // by amit
$product['href'] .= "&locByLocId=" . $_REQUEST['locByLocId'];
}

?>
<div>
<?php if ($product['thumb']) { ?>
<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
<?php } ?>
<div class="name" ><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
<?php if ($product['price']) { ?>
<div class="price" style="clear: both">
<?php if (!$product['special']) { ?>
<?php echo $product['price']; ?>
<?php } else { ?>
<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
<?php } ?>
</div>
<?php } ?>
<?php if ($product['rating']) { ?>
<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
<?php } else { ?>
              <div class="rating">  <img src="catalog/view/theme/lulu/image/stars-0.png" alt="0 review" /></div>
               <?php }  ?>
<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button button-cart">add</a></div>
<?php } ?>
</div>
</div>
<?php } ?>