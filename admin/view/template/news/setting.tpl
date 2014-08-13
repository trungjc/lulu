<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
  <?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
  <?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
  <div id="tabs" class="htabs">
	<a href="#tab-category"><?php echo $text_for_category; ?></a>
	<a href="#tab-article"><?php echo $text_for_article; ?></a>
	<a href="#tab-other"><?php echo $text_for_other; ?></a>
	<a href="#tab-allarticle"><?php echo $text_for_all_article; ?></a>
  </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	<div id="tab-category">
      <table class="form">
        <tr>
          <td><?php echo $entry_category_image; ?></td>
          <td>
			<?php echo $entry_width; ?><input type="text" name="news_setting_category_width" value="<?php echo $news_setting_category_width; ?>" size="3" /> x <?php echo $entry_height; ?><input type="text" name="news_setting_category_height" value="<?php echo $news_setting_category_height; ?>" size="3" />
			&nbsp;&nbsp;&nbsp;<?php echo $entry_show; ?><?php if ($news_setting_category_show) { ?><input type="checkbox" name="news_setting_category_show" value="1" checked="checked" /><?php } else { ?><input type="checkbox" name="news_setting_category_show" value="1" /><?php } ?>
		  </td>
        </tr>
        <tr>
          <td><?php echo $entry_news_per_page; ?></td>
          <td><input type="text" name="news_setting_news_per_page" value="<?php echo $news_setting_news_per_page; ?>" size="2" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_category_1col_thumbnail; ?></td>
          <td>
			<?php echo $entry_width; ?><input type="text" name="news_setting_thumbnail_width" value="<?php echo $news_setting_thumbnail_width; ?>" size="3" /> x <?php echo $entry_height; ?><input type="text" name="news_setting_thumbnail_height" value="<?php echo $news_setting_thumbnail_height; ?>" size="3" />
			&nbsp;&nbsp;&nbsp;<?php echo $entry_show; ?><?php if ($news_setting_thumbnail_show) { ?><input type="checkbox" name="news_setting_thumbnail_show" value="1" checked="checked" /><?php } else { ?><input type="checkbox" name="news_setting_thumbnail_show" value="1" /><?php } ?>
		  </td>
        </tr>
        <tr>
          <td><?php echo $entry_category_2col_thumbnail; ?></td>
          <td>
			<?php echo $entry_width; ?><input type="text" name="news_setting_thumbnail_2col_width" value="<?php echo $news_setting_thumbnail_2col_width; ?>" size="3" /> x <?php echo $entry_height; ?><input type="text" name="news_setting_thumbnail_2col_height" value="<?php echo $news_setting_thumbnail_2col_height; ?>" size="3" />
			&nbsp;&nbsp;&nbsp;<?php echo $entry_show; ?><?php if ($news_setting_thumbnail_2col_show) { ?><input type="checkbox" name="news_setting_thumbnail_2col_show" value="1" checked="checked" /><?php } else { ?><input type="checkbox" name="news_setting_thumbnail_2col_show" value="1" /><?php } ?>
		  </td>
        </tr>
      </table>
	</div>
	<div id="tab-article">
      <table class="form">
		<tr>
          <td><?php echo $entry_comments_per_page; ?></td>
          <td><input type="text" name="news_setting_comments_per_page" value="<?php echo $news_setting_comments_per_page; ?>" size="2" /></td>
        </tr>        
        <tr>
          <td><?php echo $entry_article_image; ?></td>
          <td>
			<?php echo $entry_width; ?><input type="text" name="news_setting_image_width" value="<?php echo $news_setting_image_width; ?>" size="3" /> x <?php echo $entry_height; ?><input type="text" name="news_setting_image_height" value="<?php echo $news_setting_image_height; ?>" size="3" />
			&nbsp;&nbsp;&nbsp;<?php echo $entry_show; ?><?php if ($news_setting_image_show) { ?><input type="checkbox" name="news_setting_image_show" value="1" checked="checked" /><?php } else { ?><input type="checkbox" name="news_setting_image_show" value="1" /><?php } ?>
		  </td>
        </tr>
      </table>
	</div>
	<div id="tab-other">
      <table class="form">
		<tr>
		  <td><?php echo $entry_article_count; ?></td>
		  <td><?php if ($news_setting_article_count) { ?>
			<input type="checkbox" name="news_setting_article_count" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_article_count" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_category_permission; ?></td>
		  <td><?php if ($news_setting_category_permission) { ?>
			<input type="checkbox" name="news_setting_category_permission" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_category_permission" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_comment_alert; ?></td>
		  <td><?php if ($news_setting_comment_alert) { ?>
			<input type="checkbox" name="news_setting_comment_alert" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_comment_alert" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_show_create_date; ?></td>
		  <td><?php if ($news_setting_show_create_date) { ?>
			<input type="checkbox" name="news_setting_show_create_date" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_show_create_date" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_show_modify_date; ?></td>
		  <td><?php if ($news_setting_show_modify_date) { ?>
			<input type="checkbox" name="news_setting_show_modify_date" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_show_modify_date" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_show_read_times; ?></td>
		  <td><?php if ($news_setting_show_read_times) { ?>
			<input type="checkbox" name="news_setting_show_read_times" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_show_read_times" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_show_comment_count; ?></td>
		  <td><?php if ($news_setting_show_comment_count) { ?>
			<input type="checkbox" name="news_setting_show_comment_count" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_show_comment_count" value="1" />
			<?php } ?></td>
		</tr>
      </table>
	</div>
	<div id="tab-allarticle">
      <table class="form">
		<tr>
		  <td><?php echo $entry_stick_to_top_menu; ?></td>
		  <td><?php if ($news_setting_all_articles_to_top_menu) { ?>
			<input type="checkbox" name="news_setting_all_articles_to_top_menu" value="1" checked="checked" />
			<?php } else { ?>
			<input type="checkbox" name="news_setting_all_articles_to_top_menu" value="1" />
			<?php } ?></td>
		</tr>
		<tr>
		  <td><?php echo $entry_top_menu_order; ?></td>
          <td><input type="text" name="news_setting_all_articles_top_order" value="<?php echo $news_setting_all_articles_top_order; ?>" size="2" /></td>
		</tr>
      </table>
	  <div id="all-articles-languages" class="htabs">
		<?php foreach ($languages as $language) { ?>
		<a href="#all-articles-language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
		<?php } ?>
	  </div>
	  <?php foreach ($languages as $language) { ?>
	  <div id="all-articles-language<?php echo $language['language_id']; ?>">
	  <table class="form">
		<tr>
		  <td><?php echo $entry_top_menu_title; ?></td>
          <td>
				<input type="text" name="news_setting_all_articles_top_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($news_setting_all_articles_top_title[$language['language_id']]) ? $news_setting_all_articles_top_title[$language['language_id']] : ''; ?>" size="30" />
		  </td>
		</tr>
		<tr>
		  <td><?php echo $entry_meta_keyword; ?></td>
          <td>
			<textarea name="news_setting_all_articles_meta_keyword[<?php echo $language['language_id']; ?>]" cols="40" rows="5"><?php echo isset($news_setting_all_articles_meta_keyword[$language['language_id']]) ? $news_setting_all_articles_meta_keyword[$language['language_id']] : ''; ?></textarea>
		  </td>
		</tr>
		<tr>
		  <td><?php echo $entry_meta_description; ?></td>
          <td>
			<textarea name="news_setting_all_articles_meta_description[<?php echo $language['language_id']; ?>]" cols="40" rows="5"><?php echo isset($news_setting_all_articles_meta_description[$language['language_id']]) ? $news_setting_all_articles_meta_description[$language['language_id']] : ''; ?></textarea>
		  </td>
		</tr>
	  </table>
	  </div>
	  <?php } ?>
    </form>
  </div>
</div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#all-articles-languages a').tabs();
//--></script> 
<?php echo $footer; ?>