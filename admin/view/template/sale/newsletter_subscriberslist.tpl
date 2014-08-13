<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php echo $opmbutton; ?>
    <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>

<div class="box">

  <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
	    <div class="buttons">
		<a href="<?php echo $synchcustomer; ?>" class="button"><span><?php echo $text_synchcustomer; ?></span></a>
		<a href="<?php echo $pushlist; ?>" class="button"><span><?php echo $text_pushlist; ?></span></a>
		<a href="<?php echo $insert; ?>" class="button"><span><?php echo $button_insert; ?></span></a>
		<a onclick="document.getElementById('form').submit();" class="button" href="javascript:"><span><?php echo $button_delete; ?></span></a>
		<a class="button" onclick="ajax_upload()" href="javascript:"><?php echo $text_import; ?> </a>
		<a onclick="location = '<?php echo $export; ?>'" class="button" href="javascript:"><span><?php echo $text_export; ?></span></a>

    
    </div>
  </div>
  <div class="content">
    <form action="<?php echo $import; ?>" method="post" enctype="multipart/form-data" id="upload_excel_form" >
      <input type="file" name="excel_subscribers" id="excel_subscribers" style="display:none;"  onchange="$('#upload_excel_form').submit();" />
    </form>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
     
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_email; ?></td>
            <td class="left"><?php echo $column_store; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
		  
		   <tr class="filter">
              <td></td>
              <td></td>
              
              <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" size="30" style="text-align: left;" /></td>
			  <td></td>
              <td><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
		  
		  
		  
        </thead>
        <tbody>
          <?php if ($emails) { ?>
          <?php foreach ($emails as $email) { ?>
          <tr>
            <td style="text-align: center;">
              <input type="checkbox" name="selected[]" value="<?php echo $email['id']; ?>"/>
             </td>
            <td class="left"><?php echo $email['name']; ?></td>
            <td class="left"><?php echo $email['email']; ?></td>
            <td class="left"><?php echo $email['store_name']; ?></td>
            <td class="right"><?php foreach ($email['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
		  
		  
		  
		  
		  
		  
		  
		  
		  
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
  <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/newssubscribers&token=<?php echo $token; ?>';
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	

				
	location = url;
}
//--></script>
<script language="javascript">
function ajax_upload(){ 
  $('#excel_subscribers').trigger('click');
}
</script>