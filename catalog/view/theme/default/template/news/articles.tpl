	<?php if ($articles) { ?>
	<div class="product-filter">
		<div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_1col; ?> <b>/</b> <a onclick="ndisplay('2col');"><?php echo $text_2col; ?></a></div>
		<div class="limit"><?php echo $text_limit; ?>
			<select onchange="location = this.value;">
				<?php foreach ($limits as $limits) { ?>
				<?php if ($limits['value'] == $limit) { ?>
				<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
		<div class="sort"><?php echo $text_sort; ?>
			<select onchange="location = this.value;">
				<?php foreach ($sorts as $sorts) { ?>
				<?php if ($sorts['value'] == $sort) { ?>
				<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>	
	<div class="article-list">
		<?php foreach ($articles as $article) { ?>
		<div class="box-article">
		<?php if ($article['image']){ ?><div class="news-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>" title="<?php echo $article['title']; ?>" /></a></div><?php } ?>
		<div class="news-title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></div>
		<?php if ($article['date_added'] != false || $article['date_modified'] != false){ ?>
		<div class="news-date">
		<?php if($article['date_added'] != false){ ?><span><b><?php echo $text_posted_on; ?></b> <?php echo $article['date_added']; ?></span><?php } ?>
		<?php if($article['date_modified'] != false){ ?><span><b><?php echo $text_updated_on; ?></b> <?php echo $article['date_modified']; ?></span><?php } ?>
		</div>	
		<?php } ?>
		<div class="news-intro"><?php echo $article['short_description']; ?></div>
		<?php if ($article['count_read'] || $article['news_comment_count']){ ?>		
		<div class="news-read-comment">
		<?php if ($article['count_read']) { ?><span><?php echo $text_read; ?> <b><?php echo $article['count_read']; ?> </b><?php echo $text_times; ?></span><?php } ?>
		<?php if ($article['news_comment_count']) { ?><span><a href="<?php echo $article['href_comment']; ?>"><?php echo $article['news_comment_count']; ?> <?php echo $text_comments; ?></a></span><?php } ?>
		</div>
		<?php } ?>
		</div>
	<?php } ?>
	</div>
	<div class="article-2col">
	<?php 
	$i = 0; 
	$col = 2;
	foreach ($articles as $article) { 
		if (($col > 1) && ($i % $col === 0)) echo '<div class="box-row">'; ?>
		<div class="box-article">
		<?php if($article['image2']){ ?><div class="news-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['image2']; ?>" alt="<?php echo $article['title']; ?>" title="<?php echo $article['title']; ?>" /></a></div><?php } ?>
		<div class="news-title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></div>
		<?php if ($article['date_added'] || $article['date_modified']){ ?>
		<div class="news-date">
		<?php if($article['date_added']){ ?><span><b><?php echo $text_posted_on; ?></b> <?php echo $article['date_added']; ?></span><?php } ?>
		<?php if($article['date_modified']){ ?><span><b><?php echo $text_updated_on; ?></b> <?php echo $article['date_modified']; ?></span><?php } ?>
		</div>	
		<?php } ?>
		<div class="news-intro"><?php echo $article['short_description']; ?></div>
		<?php if ($article['count_read'] || $article['news_comment_count']){ ?>		
		<div class="news-read-comment">
		<?php if ($article['count_read']) { ?><span><?php echo $text_read; ?> <b><?php echo $article['count_read']; ?> </b><?php echo $text_times; ?></span><?php } ?>
		<?php if ($article['news_comment_count']) { ?><span><a href="<?php echo $article['href_comment']; ?>"><?php echo $article['news_comment_count']; ?> <?php echo $text_comments; ?></a></span><?php } ?>
		</div>
		<?php } ?>
		</div>
		<?php if (($col > 1) && ($i % $col === $col - 1)) echo "</div>"; $i = ($i + 1) % $col; ?>
	<?php } 
		// truong hop so luong article ko chia het cho so cot 
		if ($i !== 0) {
			for (; $i !== 0; $i = ($i + 1) % $col) {
				echo '<div class="box-article">';
				echo '</div>';
			}
			echo "</div>";
		}
	?>
	</div>
<script type="text/javascript"><!--	
function ndisplay(view) {
	if (view == 'list') {
		$('.article-list').attr('style', 'display: block;');		
		$('.article-2col').attr('style', 'display: none;');		
		$('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_1col; ?> <b>/</b> <a onclick="ndisplay(\'2col\');"><?php echo $text_2col; ?></a>');		
		$.totalStorage('ndisplay', 'list'); 
	} else {
		$('.article-list').attr('style', 'display: none;');		
		$('.article-2col').attr('style', 'display: table;');				
		$('.display').html('<b><?php echo $text_display; ?></b> <a onclick="ndisplay(\'list\');"><?php echo $text_1col; ?></a> <b>/</b> <?php echo $text_2col; ?>');
		$.totalStorage('ndisplay', '2col'); 
	}
}
$(document).ready(function(){
view = $.totalStorage('ndisplay');

if (view) {
	ndisplay(view);
} else {
	ndisplay('list');
}
});
//--></script>	
	<div class="pagination"><?php echo $pagination; ?></div>
	<?php } else { ?>
	<div class="content"><?php echo $text_empty; ?></div>
	<?php }?>