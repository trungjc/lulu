<?php if (count($products)>0) { ?>
			<div id="tab-also-bought" class="tab-content">
			  <div class="box-product">
				<?php foreach ($products as $product) { ?>
				<div>
				<?php if ($product['thumb']) { ?>
				<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
				<?php } ?>
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
				<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
				<?php } else { ?>
                                    <div class="rating">  <img src="catalog/view/theme/lulu/image/stars-0.png" alt="0 review" /></div>
                                     <?php }  ?>
				<div class="cart"><input type="button" value="Add" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
			  </div>
			  <?php } ?>
			</div>
		  </div>
<?php } ?>