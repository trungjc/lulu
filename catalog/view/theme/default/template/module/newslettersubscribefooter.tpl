<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/fancybox/newslettersubscribefooter.css" media="screen" />
<?php


$top=93;
if($option_fields<=2) {
$top=93;
}
if($option_fields>=3) {
$top=85;
}
?>

<style>
.yellow-strip-wrap {
top: <?php echo $top; ?>%;
}
</style>

<div class="yellow-strip-wrap">
		<div class="yellow-strip-content">
			<div class="subscription-skip">
				&nbsp;</div>
			<div class="yellow-strip-text" id="emailstrip">
				<?php echo $heading_title; ?></div>
			<form name="subscribef" id="subscribef"   >
				<div class="yellow-strip-inputbox">
					

<input class="form-fld" id="subscribe_name" name="subscribe_name" size="63" onblur="if(this.value=='')this.value=this.defaultValue;" onfocus="if(this.value==this.defaultValue)this.value='';" type="text" value="<?php echo $entry_name; ?>" />
<input class="form-fld" id="subscribe_email" name="subscribe_email" size="63" onblur="if(this.value=='')this.value=this.defaultValue;" onfocus="if(this.value==this.defaultValue)this.value='';" type="text" value="<?php echo $entry_email; ?>" />

<?php for($ns=1;$ns<=$option_fields;$ns++) { ?>

<input class="form-fld" id="option<?php echo $ns; ?>" name="option<?php echo $ns; ?>" size="30" onblur="if(this.value=='')this.value=this.defaultValue;" onfocus="if(this.value==this.defaultValue)this.value='';" type="text" value="<?php echo $option_fields_[$ns]; ?>" />

    
	
  <?php } ?>

     <a class="button2" onclick="email_subscribefooter()"><span><?php echo $entry_button; ?></span></a><?php if($option_unsubscribe) { ?>
          <a class="button2" onclick="email_unsubscribefooter()" style="margin-top:4px;"><span><?php echo $entry_unbutton; ?></span></a>
      <?php } ?> 

<b id="subscribef_result"></b>
</div>
					</form>
		</div>
	
</div>
<script language="javascript">

$(".subscription-skip").click(function () {
   $(".yellow-strip-wrap").fadeOut('slow');
});


</script>


<script language="javascript">
	function email_subscribefooter(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/subscribefooter',
			dataType: 'html',
            data:$("#subscribef").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
function email_unsubscribefooter(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/unsubscribefooter',
			dataType: 'html',
            data:$("#subscribef").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
</script>