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
  <b><?php echo $text_critea; ?></b>
  <div class="content">
    <p><?php echo $entry_search; ?>
      <?php if ($filter_title) { ?>
      <input type="text" name="filter_title" value="<?php echo $filter_title; ?>" />
      <?php } else { ?>
      <input type="text" name="filter_title" value="<?php echo $filter_title; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
      <?php } ?>
      <select name="filter_news_category_id">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['news_category_id'] == $filter_news_category_id) { ?>
        <option value="<?php echo $category_1['news_category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['news_category_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['news_category_id'] == $filter_news_category_id) { ?>
        <option value="<?php echo $category_2['news_category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['news_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['news_category_id'] == $filter_news_category_id) { ?>
        <option value="<?php echo $category_3['news_category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['news_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
      <?php if ($filter_sub_news_category) { ?>
      <input type="checkbox" name="filter_sub_news_category" value="1" id="sub_category" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="filter_sub_news_category" value="1" id="sub_category" />
      <?php } ?>
      <label for="sub_category"><?php echo $text_search_sub_category; ?></label>
    </p>
    <?php if ($filter_intro) { ?>
    <input type="checkbox" name="filter_intro" value="1" id="filter_intro" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="filter_intro" value="1" id="filter_intro" />
    <?php } ?>
    <label for="filter_intro"><?php echo $entry_intro; ?></label>
    <?php if ($filter_content) { ?>
    <input type="checkbox" name="filter_content" value="1" id="filter_content" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="filter_content" value="1" id="filter_content" />
    <?php } ?>
    <label for="filter_content"><?php echo $entry_content; ?></label>
  </div>
  <div class="buttons">
    <div class="right"><a id="button-search" class="button"><span><?php echo $button_search; ?></span></a></div>
  </div>
  <h2><?php echo $text_search; ?></h2>
	<?php 
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/articles.tpl')) {
			include(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/articles.tpl');
		} else {
			include(DIR_TEMPLATE . 'default/template/news/articles.tpl');
		}
	?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#content input[name=\'filter_title\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').bind('click', function() {
	url = 'index.php?route=news/search';
	
	var filter_title = $('#content input[name=\'filter_title\']').attr('value');
	
	if (filter_title) {
		url += '&filter_title=' + encodeURIComponent(filter_title);
	}

	var filter_news_category_id = $('#content select[name=\'filter_news_category_id\']').attr('value');
	
	if (filter_news_category_id > 0) {
		url += '&filter_news_category_id=' + encodeURIComponent(filter_news_category_id);
	}
	
	var filter_sub_news_category = $('#content input[name=\'filter_sub_news_category\']:checked').attr('value');
	
	if (filter_sub_news_category) {
		url += '&filter_sub_news_category=true';
	}
		
	var filter_content = $('#content input[name=\'filter_content\']:checked').attr('value');
	
	if (filter_content) {
		url += '&filter_content=true';
	}

	var filter_intro = $('#content input[name=\'filter_intro\']:checked').attr('value');
	
	if (filter_intro) {
		url += '&filter_intro=true';
	}

	location = url;
});

//--></script> 
<?php echo $footer; ?>