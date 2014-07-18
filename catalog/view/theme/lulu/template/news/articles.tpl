	<?php if ($articles) { ?>
	
        <div class="article-2col" style="text-align: center">
	<?php 
	$i = 0; 
	$col = 3;
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

	<div class="pagination"><?php echo $pagination; ?></div>
	<?php } else { ?>
	<div class="content"><?php echo $text_empty; ?></div>
	<?php }?>