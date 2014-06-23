
<script type="text/javascript">

$(document).ready(function() {
var _qsHref = "<a id=\"sft_quickshop_icon\" href=\"#\" style=\"visibility:hidden;position:absolute;top:0;left:0\"><img  alt=\"quickshop\" src=\"<?php echo $baseurl;?>catalog/view/theme/default/image/sft_quickshop/quickshop_preview.png\" /></a>";
		//$(document.body).append(_qsHref);
			
		var quickshop_icon = $('#sft_quickshop_icon img');
		
		var selecter =new Array(".product-list>div",".product-grid>div",".box-product>div");
			
		for(i=0;i<selecter.length;i++)
		{		
				$(selecter[i]).each(function(index, value)
				{     
					var id_product="";
					 var reloadurl="";
					 var href_pro=$(".image a",this).attr('href'); // lay link href cua product
					 if	(href_pro)					 
					 var check=href_pro.match("index.php"); // neu tim thay index.php thi tra ve index.php					 
					 if(check=="index.php")
					 {	
					   
						 var last_index=href_pro.lastIndexOf("/");
						 var parameter=href_pro.substr(last_index+8,href_pro.length);
						 reloadurl="<?php echo $baseurl;?>index.php?route=module/sft_quickshop_product"+parameter;
										
					 }
					 else
					 {							
						 var str=$(".cart input",this).attr('onclick');
						 str=str.substr(11,str.length);
						 var id=str.substr(0,str.length-3);
						 var parameter="&product_id="+id;
                        reloadurl="<?php echo $baseurl;?>index.php?route=module/sft_quickshop_product"+parameter;						
					 }
					$(".cart",this).prepend('<a class="quickview">quickview</a>');
					$(".quickview ",this).attr('href',reloadurl);
						
					/* $("img", this).hover(function () {				
						  var o = $(this).offset();
						$('#sft_quickshop_icon').attr('href',reloadurl).show()
							.css({
								'top': o.top +($(this).height() - quickshop_icon.height())/2+'px',
								'left': o.left + ($(this).width() - quickshop_icon.width())/2+4+'px',
								'visibility': 'visible'
								
							});
						 }, 
						 function () {
						 $('#sft_quickshop_icon').hide();
						 }
					 );*/
					 
					 //fix bug image disapper when hover
				//$('#sft_quickshop_icon')
					//.bind('mouseover', function() {
					//	$(this).show();
					//})
					//.bind('click', function() {
					//	$(this).hide();
					//});
					
			});
	    }
		
	 
	   
	   
	   	$('.quickview').fancybox({
				'width'				: <?php echo $width;?>,
				'height'			: <?php echo $height;?>,
				'autoScale'			: false,
				'padding'			: 0,
				'margin'			: 0,
				//'transitionIn'		: 'none',
				//'transitionOut'		: 'none',
				'type'				: 'iframe',
				onComplete: function() { 
					$.fancybox.showActivity();
					$('#fancybox-frame').bind('load', function() {
						$.fancybox.hideActivity();
					});
				}
			
				
		});
	
	   
	   
});

/*
function reload()
{
	var quickshop_icon = $('#sft_quickshop_icon img');
		
		var selecter =new Array(".product-list>div",".product-grid>div",".box-product>div");		
		for(i=0;i<selecter.length;i++)
		{
				$(selecter[i]).each(function(index, value)
				{     
					var id_product="";
					 var reloadurl="";
					 var href_pro=$(".image a",this).attr('href'); // lay link href cua product
					 if	(href_pro)								
					 var check=href_pro.match("index.php"); // neu tim thay index.php thi tra ve index.php
					
					 if(check=="index.php")
					 {	
					   
						 var last_index=href_pro.lastIndexOf("/");
						 var parameter=href_pro.substr(last_index+8,href_pro.length);
						 reloadurl="<?php echo $baseurl;?>index.php?route=module/sft_quickshop_product"+parameter;
										
					 }
					 else
					 {							
						 var str=$(".cart input",this).attr('onclick');
						 str=str.substr(11,str.length);
						 var id=str.substr(0,str.length-3);
						 var parameter="&product_id="+id;
                        reloadurl="<?php echo $baseurl;?>index.php?route=module/sft_quickshop_product"+parameter;						
					 }
					
					 $("img", this).hover(function () {				
						  var o = $(this).offset();
						$('#sft_quickshop_icon').attr('href',reloadurl).show()
							.css({
								'top': o.top +($(this).height() - quickshop_icon.height())/2+'px',
								'left': o.left + ($(this).width() - quickshop_icon.width())/2+4+'px',
								'visibility': 'visible'
								
							});
						 }, 
						 function () {
						 $('#sft_quickshop_icon').hide();
						 }
					 );
					 
					 //fix bug image disapper when hover
				$('#sft_quickshop_icon')
					.bind('mouseover', function() {
						$(this).show();
					})
					.bind('click', function() {
						$(this).hide();
					});
					
			   });
	    }
		
	 
	   
	   
	   	$('#sft_quickshop_icon').fancybox({
				'width'				: <?php echo $width;?>,
				'height'			: <?php echo $height;?>,
				'autoScale'			: false,
				'padding'			: 0,
				'margin'			: 0,
				//'transitionIn'		: 'none',
				//'transitionOut'		: 'none',
				'type'				: 'iframe',
				onComplete: function() { 
					$.fancybox.showActivity();
					$('#fancybox-frame').bind('load', function() {
						$.fancybox.hideActivity();
					});
				}
			
				
		});
}*/
</script>

