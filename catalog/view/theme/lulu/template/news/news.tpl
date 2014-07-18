<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php echo $header; ?><?php echo $content_top; ?>
<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<h1><?php echo $heading_title; ?></h1>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
	
	<div class="news-info">
	
                <div class="news-intro" style="display: none"><?php echo $short_description; ?></div>
		<?php if($image){ ?><div class="news-image"><img src="<?php echo $image; ?>" border="0"/></div><br /><?php } ?>
		<div class="news-content"><?php echo $description; ?></div> 		
  		<?php if ($related_newss) { ?>
		<div class="news-related">
  		<h2><?php echo $text_related_news; ?></h2>
  		<ul>
  			<?php foreach ($related_newss as $related_news) { ?>
  			<li><a href="<?php echo $related_news['href']; ?>"><?php echo $related_news['title']; ?></a></li>
  			<?php } ?>
  		</ul>
		</div>
  		<?php } ?>
		
	</div>
  	
	<div class="tags_share" style="display: none;">	
		  <?php if ($tags) { ?>
		  <div class="tags"><b><?php echo $text_tags; ?></b>
			<?php foreach ($tags as $tag) { ?>
			<a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>,
			<?php } ?>
		  </div>
		  <?php } ?>	  
    </div>

 </div>
<div style="clear: both"></div>
<?php echo $content_bottom; ?>
<script type="text/javascript"><!--
$('#comments .pagination a').live('click', function() {
	$('#comments').slideUp('slow');
		
	$('#comments').load(this.href);
	
	$('#comments').slideDown('slow');
	
	return false;
});	
  
$('#comments').load('index.php?route=news/news/comment&news_id=<?php echo $news_id; ?>');

$('#button-comment').bind('click', function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=news/news/write&news_id=<?php echo $news_id; ?>',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&email=' + $('input[name=\'email\']').val() + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-comment').attr('disabled', true);
			$('#comment-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-comment').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data.error) {
				$('#comment-title').after('<div class="warning">' + data.error + '</div>');
			}
			
			if (data.success) {
				$('#comments').load('index.php?route=news/news/comment&news_id=<?php echo $news_id; ?>');
				$('#comment-title').after('<div class="success">' + data.success + '</div>');
				$('input[name=\'email\']').val('<?php echo $email; ?>');
				$('input[name=\'name\']').val('<?php echo $name; ?>');
				$('textarea[name=\'comment\']').val('');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.5
});
//--></script>
<?php echo $footer; ?>