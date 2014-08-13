<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php if(!isset($hidebox)){ ?>
<div class="box">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="box-content">
	<?php if($articles){ ?>
	<?php foreach ($articles as $article) { ?>
		<div class="box-article-small">
			<?php if($article['image']){ ?><div class="news-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>" title="<?php echo $article['title']; ?>" /></a></div><?php } ?>
			<div class="news-title"><a href="<?php echo $article['href']; ?>"><b><?php echo $article['title']; ?></b></a></div>
			<div class="clear"></div>
		</div>
	<?php } ?>
<?php } else { ?>
	<?php echo $text_news_not_found; ?>
<?php } ?> 
</div>
</div>
<?php } ?> 