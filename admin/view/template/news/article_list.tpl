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
    <div class="heading">
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><span><?php echo $button_copy; ?></span></a><a onclick="$('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
  <div class="content">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'nd.title') { ?>
              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
              <?php } ?>
			</td>
            <td class="left"><?php if ($sort == 'nc.news_category_id') { ?>
              <a href="<?php echo $sort_category; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_category; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_category; ?>"><?php echo $column_category; ?></a>
              <?php } ?>
			</td>
            <td class="left"><?php if ($sort == 'nd.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'nd.date_modified') { ?>
              <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_comment; ?></td>
            <td class="right"><?php if ($sort == 'n.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
              <?php } ?></td>
            <td class="left"><?php echo $column_status; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
            <tr class="filter">
              <td></td>
              <td><input type="text" name="filter_title" value="<?php echo $filter_title; ?>" /></td>
              <td><select name="filter_category_id">
                  <option value="0"></option>
				  <?php foreach ($categories as $category) { 
						if (!is_null($filter_category_id) && $category['news_category_id'] == $filter_category_id) {
							echo '<option value="' . $category['news_category_id'] . '" selected="selected">' . $category['name'] . '</option>';
						} else {
							echo '<option value="' . $category['news_category_id'] . '">' . $category['name'] . '</option>';
						}
				    } ?>				  
              </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
            </tr>
          <?php if ($newss) { ?>
          <?php foreach ($newss as $news) { ?>
          <tr>
            <td style="text-align: center;"><?php if ($news['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $news['news_id']; ?>" />
              <?php } ?></td>
            <td class="left"><?php echo $news['title']; ?></td>
            <td class="left">
				<?php $class = 'odd'; ?>
				<?php foreach ($categories as $category) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="<?php echo $class; ?>">
					<?php if (in_array($category['news_category_id'], $news['category'])) { ?>
						<?php echo $category['name']; ?>
					<?php } ?>
					</div>
				<?php } ?>
			</td>
            <td class="left"><?php echo $news['date_added']; ?></td>
            <td class="left"><?php echo $news['date_modified']; ?></td>
            <td class="right">
				<a href="<?php echo $news['comment_link']; ?>">
					<?php echo $news['approved_comment']; ?> / <?php echo $news['comment_total']; ?>
				</a>
			</td>
            <td class="right"><?php echo $news['sort_order']; ?></td>
            <td class="left"><?php echo $news['status']; ?></td>
            <td class="right"><?php foreach ($news['action'] as $action) { ?>
              [ <a href="<?php echo $action['href_view']; ?>" target="_blank"><?php echo $action['text_view']; ?></a> ]
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=news/article&token=<?php echo $token; ?>';
	
	var filter_category_id = $('select[name=\'filter_category_id\']').attr('value');
	
	if (filter_category_id != 0) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}
	
	var filter_title = $('input[name=\'filter_title\']').attr('value');
	
	if (filter_title) {
		url += '&filter_title=' + encodeURIComponent(filter_title);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_title\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=news/article/autocomplete&token=<?php echo $token; ?>&filter_title=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.title,
						value: item.news_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_title\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script> 
<?php echo $footer; ?>