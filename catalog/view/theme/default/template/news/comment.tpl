  		<?php if ($comments) { ?>
			<?php foreach ($comments as $comment) { ?>
			<div id="comment-1" class="content">
				<div class="avatar"></div>
				<div class="comment-head">
					<span id="comment-author-1" class="comment-author"><?php echo $comment['name']; ?></span>
					<span id="comment-date-1" class="comment-date"><?php echo $comment['date_added']; ?></span>
				</div>
				<div class="comment-body"><?php echo $comment['comment']; ?></div>
			</div>
			<?php } ?>
			<div class="pagination"><?php echo $pagination; ?></div>
		<?php } else { ?>
			<div class="comment"><?php echo $text_no_comment; ?></div>
		<?php } ?>
