<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php if(!isset($hidebox)){ ?>
<div class="box last-new">
	<div class="box-heading heading-new">Feature how to's</div>
	<div class="box-content">
	<?php if($articles){ 
		$i = 0; 
		$col = 1; 
	?>
		<div class="article-list <?php if ($col > 1) echo 'article-' . $col . 'col' ?>">
		<?php foreach ($articles as $article) { ?>
			<?php if (($col > 1) && ($i % $col === 0)) echo '<div class="box-row">'; ?>
			<div class="box-article">
				<?php if($article['image']){ ?><div class="news-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['title']; ?>" title="<?php echo $article['title']; ?>" /></a></div><?php } ?>
				<div class="news-title"><a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a></div>
				
				<div class="news-intro"><?php echo $article['short_description']; ?></div>
				
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
<?php } else { ?>
	<?php echo $text_news_not_found; ?>
<?php } ?> 
</div>
</div>
<?php } ?> 