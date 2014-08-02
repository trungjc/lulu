
  <div id="frm_subscribe" style="display: none;">
      <div class="newletter" style="width: 500px;text-align: center">
          <div >
           <h1>Welcome to Lulu & Lipstick </h1>
            <p>Subscribe to Lulu and Lipstick and receive the lastest news on what's new in beauty from around the world , our amazing giveaways, celebrity trends and our sensational sales.
            <br/>  I hope you will join us. love Lulu
            </p>
   
      </div>
      
      
     
  <form name="subscribe" id="subscribe">
  <table border="0" cellpadding="2" cellspacing="2">
  <tr>
     <td align="left">First Name &nbsp;<br /><input type="text" value="" name="subscribe_name" id="subscribe_name"> </td>
     <td align="left">Last Name &nbsp;<br /><input type="text" value="" name="last_name" id="last_name"> </td>
   
  </tr>
   <tr>
       <td align="left" colspan="2"><span class="required">*</span>&nbsp;<?php echo $entry_email; ?><br /><input style="width: 490px" type="text" value="" name="subscribe_email" id="subscribe_email"></td>
     
   </tr>
  
   
   <?php for($ns=1;$ns<=$option_fields;$ns++) { ?>

      <tr>
     <td align="left"><?php echo $option_fields_[$ns]; ?>&nbsp;<br /><input type="text" value="" name="option<?php echo $ns; ?>" id="option<?php echo $ns; ?>"> </td>
   </tr>
	
  <?php } ?>
   
   <tr>
     <td align="right"  colspan="2">
     <a class="button" onclick="email_subscribe()"><span><?php echo $entry_button; ?></span></a>
	 <?php if($option_unsubscribe) { ?>
          <a class="button" onclick="email_unsubscribe()" ><span><?php echo $entry_unbutton; ?></span></a>
      <?php } ?>   
	  
     </td>
   </tr>
    <tr>
        <td align="center" colspan="2" ><a href=""  class="close-newletter">Don't show this again</a></td>
   </tr>
   <tr>
     <td align="center" id="subscribe_result" colspan="2" ></td>
   </tr>
  </table>
  </form>
  </div>
  </div>

<script language="javascript">
    $(document).ready(function(){
         var newletter = $("#frm_subscribe").html();
    $("#frm_subscribe").remove();
    $('a[href="#frm_subscribe"]').click(function(){
            $.fancybox(newletter);
        });
        
      
    });
        
	
function email_subscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/subscribe',
			dataType: 'html',
            data:$("#subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
function email_unsubscribe(){
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/newslettersubscribe/unsubscribe',
			dataType: 'html',
            data:$("#subscribe").serialize(),
			success: function (html) {
				eval(html);
			}}); 
}
     
</script>


