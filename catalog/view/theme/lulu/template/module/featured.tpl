<div class="box">
  <div class="box-heading withLine "><?php echo $heading_title; ?></div>
  <hr/>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
         <a   class="manufacturer-name" href="<?php echo $product['href_manufacter']; ?>"><?php echo $product['manufacturers']; ?></a>
       
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
       
		<?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/lulu/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
       <?php } else {?>
        <div class="rating"> <img src="catalog/view/theme/lulu/image/stars-0.png" alt="Based on 0 reviews." /></div>
        <?php } ?>
        <div class="cart">
		<input type="button" value="ADD " onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /><div class="wishlist "><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo "add to whishlist"; ?></a></div>
    
	</div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
