/*
function addToCart_QuickShop(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
			
				parent.location = json['redirect'];
				
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
				var image=$("#tab-related .image a#"+ product_id+" img").attr('src');
				var temp='<div class="addcart_success">\
								<h2 class="sft_icon_success"><span><?php echo $text_title_wishlist; ?></span></h2>\
								<div class="content">\
								<img src="'+image+'" width="80" height="80">\
									<h3>'+json['success']+'</h3>\
								</div>\
							</div>';					
				lightbox1(temp);
			}	
		}
	});
}
*/

function lightbox(insertContent){

	// jQuery wrapper (optional, for compatibility only)
	(function($) {
	
		// add lightbox/shadow <div/>'s if not previously added
		if($('#lightbox').size() == 0){
			var theLightbox = $('<div id="lightbox"/>');
			var theShadow = $('<div id="lightbox-shadow"/>');
			$(theShadow).click(function(e){
				closeLightbox();
				parent.$.fancybox.close();
			});
			$('body').append(theShadow);
			$('body').append(theLightbox);
		}
		
		// remove any previously added content
		$('#lightbox').empty();
		
		// insert HTML content
		if(insertContent != null){
			$('#lightbox').append(insertContent);
		}
		
		
		// move the lightbox to the current window top + 100px
		$('#lightbox').css('top', $(window).scrollTop() + 100 + 'px');
		
		// display the lightbox
		$('#lightbox').show();
		$('#lightbox-shadow').show();
	
	
	
	
	
	})(jQuery); // end jQuery wrapper
	
}

function lightbox1(insertContent){

	// jQuery wrapper (optional, for compatibility only)
	(function($) {
	
		// add lightbox/shadow <div/>'s if not previously added
		if($('#lightbox').size() == 0){
			var theLightbox = $('<div id="lightbox"/>');
			var theShadow = $('<div id="lightbox-shadow"/>');
			$(theShadow).click(function(e){
				closeLightbox();				
			});
			$('body').append(theShadow);
			$('body').append(theLightbox);
		}
		
		// remove any previously added content
		$('#lightbox').empty();
		
		// insert HTML content
		if(insertContent != null){
			$('#lightbox').append(insertContent);
		}
		
		
		// move the lightbox to the current window top + 100px
		$('#lightbox').css('top', '100px');
		
		// display the lightbox
		$('#lightbox').show();
		$('#lightbox-shadow').show();
	
	
	
	
	
	})(jQuery); // end jQuery wrapper
	
}
// close the lightbox
function closeLightbox(){
	
	// jQuery wrapper (optional, for compatibility only)
	(function($) {
		
		// hide lightbox/shadow <div/>'s
		$('#lightbox').hide();
		$('#lightbox-shadow').hide();		
		// remove contents of lightbox in case a video or other content is actively playing
		$('#lightbox').empty();
	
	})(jQuery); // end jQuery wrapper
	
}

