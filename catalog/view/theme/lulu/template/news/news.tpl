<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<h1><?php echo $heading_title; ?></h1>
	<div class="news-info">
		<span class="news-properties">
		<?php if($show_create_date){ ?>
		<b><?php echo $text_posted_on; ?></b> <?php echo $date_added; ?>&nbsp;|&nbsp;
		<?php } ?>
		<?php if($show_modify_date){ ?>
		<b><?php echo $text_updated_on; ?></b> <?php echo $date_modified; ?>&nbsp;|&nbsp;
		<?php } ?>	
		<?php if($show_read_times){ ?>
		<?php echo $text_read; ?> <b><?php echo $count_read; ?></b> <?php echo $text_times; ?>&nbsp;|&nbsp;
		<?php } ?>	
		<?php if($show_comment_count){ ?>		
		<b><?php echo $comment_total; ?></b> <?php echo $text_comments; ?>
		<?php } ?>			
		</span><br /><br />
		<div class="news-intro"><?php echo $short_description; ?></div><br />
		<?php if($image){ ?><div class="news-image"><img src="<?php echo $image; ?>" border="0"/></div><br /><?php } ?>
		<div class="news-content"><?php echo $description; ?></div><br />  		
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
	<div class="tags_share">	
        <div class="share"><!-- AddThis Button BEGIN -->
          <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
          <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script> 
          <!-- AddThis Button END --> 
        </div>
	</div>
	
  	<?php if($allow_comment) { ?>
	<div id="tab-comment">
		<a name="comment_area"></a> 
		<h2 id="comments-text"><?php echo $text_comments; ?></h2>
		<div id="comments">
		</div>
				
  		<?php if ($comment_permission == 0 || ($comment_permission == 1 && $logged)) { ?>
		<br /><h2 id="comment-title"><?php echo $text_write_comment; ?></h2>
		<b><?php echo $entry_name; ?></b><br />
		<input type="text" name="name" value="<?php echo $name; ?>" />
	    <br /><br />

        <b><?php echo $entry_email; ?></b><br />
        <input type="text" name="email" value="<?php echo $email; ?>" />
        <br /><br />
		
		<b><?php echo $entry_comment; ?></b>
		<textarea name="comment" cols="40" rows="8" style="width: 98%;"></textarea>
		<span><?php echo $text_note; ?></span><br />

		<br />
		<b><?php echo $entry_captcha; ?></b><br />
        	<input type="text" name="captcha" value=""/>
		<br />
	        <img src="index.php?route=news/news/captcha" id="captcha" alt=""/>
		<br />
		<div class="buttons">
		  <div class="right"><a id="button-comment" class="button"><span><?php echo $button_comment; ?></span></a></div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	<div class="tags_share">	
		  <?php if ($tags) { ?>
		  <div class="tags"><b><?php echo $text_tags; ?></b>
			<?php foreach ($tags as $tag) { ?>
			<a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a>,
			<?php } ?>
		  </div>
		  <?php } ?>	  
    </div>

  <?php echo $content_bottom; ?></div>
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