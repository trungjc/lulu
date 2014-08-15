<?php echo $header; ?>
 <?php if (isset($thumb_category)) { ?>
    <div class="category-image"><img src="<?php echo HTTP_SERVER ; ?>/image/<?php echo $thumb_category; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if (isset($thumb_manufacturer)) { ?>
    <div class="category-image"><img src="<?php echo HTTP_SERVER ; ?>/image/<?php echo $thumb_manufacturer; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>

  
  <div class="product-info">
    <?php  if ($thumb || $images) { ?>
    <div class="left">
      <?php if ($thumb) { ?>
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
      <?php } ?>
      <?php if ($images) { ?>
        <div class="viewlarge"> view large</div>
      <div class="image-additional clearfix">
        
        <?php foreach ($images as $image) { ?>
        <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if ($manufacturer) { ?>
      <div class='brand-name'>
          <h3><?php echo $manufacturer; ?></h3>
      </div>
      <?php echo $manufacturer_description; ?>
        <?php } ?>
       
    <?php if ($manufacturer) { ?>
      <div class='brand-name-all'>
          <a  href="<?php echo $manufacturers; ?>">show all <?php echo $manufacturer; ?></a>
      </div>
        <?php } ?>
    </div>
    <?php } ?>
    <div class="right">
        <div class="clearfix">
        <div class="right-content">
            <div class="share"><!-- AddThis Button BEGIN -->
              <div class="addthis_default_style">
                  <a class="addthis_button_compact">Share this product</a> 
                  
                  <a class="addthis_button_facebook"></a>
                  <a class="addthis_button_twitter"></a>
                  <a class="addthis_button_instagram"></a>
                 
				  <a class="addthis_button_printest"> </a>
				  <a href="http://www.pinterest.com/pin/create/button/
					?url=http%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F
					&media=http%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg
					&description=Next%20stop%3A%20Pinterest"
					data-pin-do="buttonPin"
					data-pin-config="above">
				 
					</a>
              </div>
              <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
              <!-- AddThis Button END --> 
            </div>
            <div class="cart">
                <table >
                  <tr>
                      <td width="25%" class="quantity-container">
                          <?php echo $text_qty; ?>
                          <input type="text" name="quantity" size="2" value="<?php echo $minimum; ?>" />
                          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                      </td> 
                    <?php if ($price) { ?>
                      <td class="price">
                        <?php if (!$special) { ?>
                        <?php echo $price; ?>
                        <?php } else { ?>
                        <span class="price-old"><?php echo $price; ?></span> <span class="price-new"><?php echo $special; ?></span>
                        <?php } ?>
                        <br />
                        <?php if ($tax) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
                        <?php } ?>
                        <?php if ($points) { ?>
                        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
                        <?php } ?>
                        <?php if ($discounts) { ?>
                        <br />
                        <div class="discount">
                          <?php foreach ($discounts as $discount) { ?>
                          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
                          <?php } ?>
                        </div>
                        <?php } ?>
                         <?php if ($minimum > 1) { ?>
                          <div class="minimum"><?php echo $text_minimum; ?></div>
                          <?php } ?>
                      </td>
                      <?php } ?>
                      <td width="30%" class="button-container">
                           <input type="button" value="Add to basket" id="button-cart" class="button" />

                           <span class="links"><a onclick="addToWishList('<?php echo $product_id; ?>');">Add to wish list</a>

                      </td>
                   </tr>

            </table>
          </div><!--end cart-->            
        </div>        
        <!--right-content-->            
    
    
        <div class="left-content">
		  
            <h1><?php echo $heading_title;   ?></h1>
             <div class="description">
               
                <?php if ($filter_groups) { ?>
	           	<div class="filter-container">
	              <table class="filter">
	                <?php foreach ($filter_groups as $filter_group) { ?>
	                  <tr>
	                    <td><?php echo $filter_group['name']; ?></td>
	                    <?php foreach ($filter_group['filter'] as $filter) { ?>
		                    <td><?php echo $filter['name']; ?></td>
	                  <?php } ?>                    
	                  </tr>
	                <?php } ?>
	              </table>
	            </div>                             
                <?php } ?>        
                <span><?php echo $text_model; ?></span> <?php echo $model; ?><br />
                <?php if ($reward) { ?>
                <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
                <?php } ?>
                <span><?php echo $text_stock; ?></span> <?php echo $stock; ?>             
             </div>
            <!--end descritpion-->
            
            <?php if ($review_status) { ?>
            <div class="review">
              <div><img src="catalog/view/theme/lulu/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />
                 &nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $reviews; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('a[href=\'#tab-review\']').trigger('click');"><?php echo $text_write; ?></a></div>

            </div>
            <!--end review-->
            
            <?php } ?>
            <?php if ($profiles): ?>
            <div class="option">
                <h2><span class="required">*</span><?php echo $text_payment_profile ?></h2>
                <br />
                <select name="profile_id">
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($profiles as $profile): ?>
                    <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br />
                <br />
                <span id="profile-description"></span>
                <br />
                <br />
            </div>
            <?php endif; ?>
            <!--profiles-->
            
            
            
            <?php if ($options) { ?>
            <div class="options">
              <?php foreach ($options as $option) { ?>
              <?php if ($option['type'] == 'select') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <select name="option[<?php echo $option['product_option_id']; ?>]">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                  <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                  </option>
                  <?php } ?>
                </select>
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'radio') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <?php foreach ($option['option_value'] as $option_value) { ?>
                <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label>
                <br />
                <?php } ?>
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'checkbox') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <?php foreach ($option['option_value'] as $option_value) { ?>
                <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label>
                <br />
                <?php } ?>
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'image') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <ul class="option-image" style="padding:0;margin:0;overflow: hidden">
                  <?php foreach ($option['option_value'] as $option_value) { ?>
                  <li style="display: block;float: left;">
                      <input style="display:none" type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                      <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label>
                   <label style="display:none" for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                        <?php if ($option_value['price']) { ?>
                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                        <?php } ?>
                      </label>
                  </li>
                  <?php } ?>
                </ul>
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'text') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'textarea') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'file') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
                <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'date') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'datetime') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
              </div>
              <br />
              <?php } ?>
              <?php if ($option['type'] == 'time') { ?>
              <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
                <?php if ($option['required']) { ?>
                <span class="required">*</span>
                <?php } ?>
                <b><?php echo $option['name']; ?>:</b><br />
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
              </div>
              <br />
              <?php } ?>
              <?php } ?>
            </div>
            <?php } ?>
            <!--end options-->      
        </div>
        <!--left-content-->
     
        </div><!--end clearfix-->
        <div class="tabs1">
            <div id="tabs1" class="htabs">
                <a href="#tab-description"><?php echo $tab_description; ?></a>
              <?php if ($attribute_groups) { ?>
              <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
              <?php } echo "<span style='display:none'>shipping info</span>"; ?>    
            </div>
            <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
            <?php if ($attribute_groups) { ?>
            <div id="tab-attribute" class="tab-content">
              <table class="attribute">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                <thead>
                  <tr>
                    <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                  <tr>
                    <td><?php echo $attribute['name']; ?></td>
                    <td><?php echo $attribute['text']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <?php } ?>
              </table>
            </div>
            <?php } ?>
            <?php echo "<span style='display:none'>shipping info content</span>"; ?>
            <?php if ($tags) { ?>
            <div class="tags"><b><?php echo $text_tags; ?></b>
              <?php for ($i = 0; $i < count($tags); $i++) { ?>
              <?php if ($i < (count($tags) - 1)) { ?>
              <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
              <?php } else { ?>
              <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
              <?php } ?>
              <?php } ?>
            </div>
            <?php } ?>
    </div>
        <div class="tab2">
       <div id="tabs2" class="htabs">
           <a href="#recently-viewed">recently viewd</a>
           <a href="#tab-also-bought">others also bought </a>
            <?php if ($products) { ?>
            <a href="#tab-related"><?php echo $tab_related; ?> </a>
            <?php } ?>
      </div>
      <?php echo $content_bottom; ?>      
        <?php if ($products) { ?>
        <div id="tab-related" class="tab-content">
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
              <div class="rating"><img src="catalog/view/theme/lulu/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
              <?php } else { ?>
              <div class="rating">  <img src="catalog/view/theme/lulu/image/stars-0.png" alt="0 review" /></div>
               <?php }  ?>
              <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button">Add</a>
            </div>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
  </div>  
        <div class="tabs3">
      <div id="tabs3" class="htabs">
        <?php if ($review_status) { ?>
        <a href="#tab-review"><?php echo $tab_review; ?></a>
        <?php } ?>
        <?php echo "<span style='display:none'>tab faq</span>"; ?>
      </div>
      <?php if ($review_status) { ?>
        <div id="tab-review" class="tab-content">
          <div id="review"></div>
          <a class="write-review" >Write a review</a>
          <div class="review-form" style="margin-top: 20px">
          <b><?php echo $entry_name; ?></b><br />
          <input type="text" name="name" value="" />
          <br />
          <br />
          <b><?php echo $entry_review; ?></b>
          <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
          <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
          <br />
          <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
          <input type="radio" name="rating" value="1" />
          &nbsp;
          <input type="radio" name="rating" value="2" />
          &nbsp;
          <input type="radio" name="rating" value="3" />
          &nbsp;
          <input type="radio" name="rating" value="4" />
          &nbsp;
          <input type="radio" name="rating" value="5" />
          &nbsp;<span><?php echo $entry_good; ?></span><br />
          <br />
          <b><?php echo $entry_captcha; ?></b><br />
          <input type="text" name="captcha" value="" />
          <br />
          <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
          <br />
          <div class="buttons">
            <div class="right"><a id="button-review" class="button"><?php echo $button_continue; ?></a></div>
          </div>
          </div>
        
        </div>
        <?php }  ?>
        <?php echo "<span style='display:none'>faq content</span>"; ?>
  </div>
        
       </div> 
  </div><script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
        $('.write-review').click(function(){
            $(this).next().show();
        })
});
//--></script> 
<script type="text/javascript"><!--

$('select[name="profile_id"], input[name="quantity"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('#profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('#profile-description').html(json['success']);
			}	
		}
	});
});
    
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
                
                if (json['error']['profile']) {
                    $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                }
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/lulu/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/lulu/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/lulu/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs1 a').tabs();
$('#tabs2 a').tabs();
$('#tabs3 a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}
        $('.option-image li').click(function(){
            $('.option-image li').removeClass('selected');
            $(this).addClass('selected');
        });
        

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//--></script> 
<?php echo $footer; ?>