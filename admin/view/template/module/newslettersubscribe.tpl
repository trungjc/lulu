<?php echo $header; ?>
<div id="content" class="cp">
      <div class="heading">
        <h1><?php echo $heading_title2; ?></h1>
   
  
   
   
          <div class="buttons">
         <a onclick="$('#form').submit();" class="btn btn-success"><?php echo $button_save; ?></a>
			<a onclick="location = '<?php echo $cancel; ?>';" class="btn btn-danger"><?php echo $button_cancel; ?></a>
         </div>
      </div>
	     <a href="http://opencartmobileapp.com/" target="_blank" class="btn btn-success"><img src="view/javascript/kodecube/arrow.gif" />Check our Awsome Opencart Mobile APP</a>
			<a href="http://kodecube.com/" target="_blank" class="btn btn-success"><img src="view/javascript/kodecube/arrow.gif" />Visit Kodecube</a>
    <?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>

    <script>
    $(document).ready(function(){
      setTimeout(function() {
        $('.success').delay(3000).fadeOut('slow');
      }, 1000);
    });
    </script>
  	<div class="box">
	
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald" />
		<link rel="stylesheet" type="text/css" href="view/javascript/kodecube/kodecube.css" />
		<link rel="stylesheet" type="text/css" href="view/javascript/kodecube/bootstrap/css/bootstrap.css" />
		<script type="text/javascript" src="view/javascript/kodecube/kodecube.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/jquery.switch/jquery.switch.min.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/jquery.switch/prettyCheckable.js"></script>
		<script type="text/javascript" src="view/javascript/kodecube/jscolor.js"></script>
		<link rel="stylesheet" type="text/css" href="view/javascript/kodecube/jquery.switch/jquery.switch.css" />
		<link rel="stylesheet" type="view/javascript/kodecube/jquery.switch/prettyCheckable.css" />


	   <div class="content">
  
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
   <?php if (isset($validation)) { ?>
        <table class="form">
            <tr>
                <td colspan="2">
                    <span style='text-align: center;'><b><?php echo $text_licence_info; ?></b></span>
                </td>
            </tr>
            <tr>
                <td><?php echo $entry_transaction_email; ?></td>
                <td><input type="text" name="email" value="" /></td>
            </tr>
            <tr>
                <td><?php echo $entry_transaction_id; ?></td>
                <td><input type="text" name="newslettersubscribe1_transaction_id" value="" /></td>
            </tr>
        </table>
        <?php } else { ?>
	<!-- subheader 
  			<div id="subheader">
          <table class="form">
		  

       <td class="stats" style="width:137px" align="right">
                <?php echo $entry_subscribemodule; ?>
              </td>
              <td align="left" class="td2" style="width:120px">
                <select class="yes_no" name="newslettersubscribe_subscribemodule">
                <?php if ($newslettersubscribe_subscribemodule): ?>
                <option value="1" selected="selected"><?php echo $text_yes?></option>
                <option value="0"><?php echo $text_no?></option>
                <?php else: ?>
                <option value="1"><?php echo $text_yes?></option>
                <option value="0" selected="selected"><?php echo $text_no?></option>
                <?php endif; ?>
                </select>
              </td>
			  
     
            </tr>
          </table>
        </div> -->

		
<!-- horizontal tabs -->

        <div class="htabs main-tabs ui-tabs">

          
          <a href="#general"><?php echo $tab_general; ?></a>
   <a href="#mail"><?php echo $tab_mail; ?></a>
      <a href="#mailchimp"><?php echo $tab_mailchimp; ?></a>
	   <a href="#error"><?php echo $tab_error; ?></a>
   <a href="#support"><?php echo $tab_support; ?></a>

        </div>
        <!-- horizontal tabs content -->
		
	
	<div id="general" class="ui-tabs-hide">
            <!-- vertical tabs -->
            
            <div class="vtabs vtabs ui-tabs">
          
              <a href="#vtab-1-1"><?php echo "General Option"; ?></a>
			 
<?php foreach ($languages as $language) { ?>
 <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                                    <?php } ?>									
			
            </div>
           
            <!-- vertical tabs content -->
			
          
            <div id="vtab-1-1" class="vtabs-content ui-tabs-hide">
			<table class="form">
	 <input type="hidden" id="newslettersubscribe1_transaction_id" name="newslettersubscribe1_transaction_id" value="<?php echo $newslettersubscribe1_transaction_id; ?>">
	
    <input type="hidden" id="newslettersubscribe_subscribemodule" name="newslettersubscribe_subscribemodule" value="1">
  
        <tr>
          <td><?php echo $entry_unsubscribe; ?></td>
          <td><select class="yes_no" name="option_unsubscribe">
              <?php if ($option_unsubscribe) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>

              <?php } ?>
            </select></td>
        </tr>
       

       

<tr>
              <td><?php echo $entry_force; ?></td>
          <td><select name="newslettersubscribe_force">
              <?php if ($newslettersubscribe_force) { ?>
             <option value='1' <?php if ($newslettersubscribe_force == '1') { echo "selected"; } ?>><?php echo $text_yes?></option>
              <option value='0' <?php if ($newslettersubscribe_force == '0') { echo "selected"; } ?>><?php echo $text_no?></option>
		   <option value='2' <?php if ($newslettersubscribe_force == '2') { echo "selected"; } ?>><?php echo $text_closebutton?></option>
              <?php } else { ?>
             <option value="1"><?php echo $text_yes?></option>
              <option value="0" selected="selected"><?php echo $text_no?></option>
		  <option value="2"><?php echo $text_closebutton?></option>
             


              <?php } ?>
            </select> </td>
 </tr> 

<tr>
          <td><?php echo $entry_popupdisplay; ?> </td>
          <td><select name="newslettersubscribe_popupdisplay">
              <?php if ($newslettersubscribe_popupdisplay) { ?>
              <option value="1" selected="selected"><?php echo $text_onetime?></option>
              <option value="0"><?php echo $text_always?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_onetime?></option>
              <option value="0" selected="selected"><?php echo $text_always?></option>
              <?php } ?>
            </select> </td>
        </tr>
<tr>
          <td><?php echo $entry_popupdelay; ?> </td>
 <td><input class="small" type="text" name="newslettersubscribe_popupdelay" value="<?php echo $newslettersubscribe_popupdelay; ?>" /></td>
            </tr>
			
			
			
			

 <tr>
          <td><?php echo $entry_mail; ?> </td>
          <td><select class="yes_no" name="newslettersubscribe_mail_status">
              <?php if ($newslettersubscribe_mail_status) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select> </td>
        </tr>

 <tr>
              <td><?php echo $entry_localemail; ?></td>

         <td><select class="yes_no" name="newslettersubscribe_localemail">
              <?php if ($newslettersubscribe_localemail) { ?>
               <option value="1" selected="selected"><?php echo $text_yes?></option>
              <option value="0"><?php echo $text_no?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes?></option>
              <option value="0" selected="selected"><?php echo $text_no?></option>
              <?php } ?>
            </select> </td>
        </tr>

		
		        <tr>
          <td><?php echo($entry_options); ?> </td>
          <td> 
          <?php 
            $tmp_option_list = array('Select','1','2','3','4','5','6');
          ?>
          <select name="newslettersubscribe_option_field"">  
              <?php  
                foreach($tmp_option_list as $key=>$opt) {
                  if($newslettersubscribe_option_field == $key){
                    echo("<option value='".$key."' selected='selected'>".$opt."</option>");
                  }else{
                    echo("<option value='".$key."'>".$opt."</option>");
                  }
                }
              ?>                 
                </select> 
          </td>
        </tr>

			
			</table>
           
</div> 
		
           <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>" class="vtabs-content ui-tabs-hide">
             <table class="form">
		 <td><?php echo $entry_popupheaderimage; ?> </td>
 <td valign="top"><div class="image"><img src="<?php echo $thumb2[$language['language_id']]; ?>" alt="" id="thumb<?php echo $language['language_id']; ?>" />
                  <input type="hidden" name="newslettersubscribe_<?php echo $language['language_id']; ?>_popupheaderimage" value="<?php echo $newslettersubscribe[$language['language_id']]['popupheaderimage']; ?>" id="image<?php echo $language['language_id']; ?>" />
                  <br />
                  <a onclick="image_upload('image<?php echo $language['language_id']; ?>', 'thumb<?php echo $language['language_id']; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $language['language_id']; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $language['language_id']; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div></td>

	  
<tr>

              <td><?php echo $entry_popupline1; ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>

			
		       <td><textarea name="newslettersubscribe_popupline1_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_popupline1[$language['language_id']]) ? $newslettersubscribe_popupline1[$language['language_id']]['line'] : ''; ?></textarea></td>
              </tr>	
			

<tr>
              <td><?php echo $entry_popupline2; ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
   <td><textarea name="newslettersubscribe_popupline2_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_popupline2[$language['language_id']]) ? $newslettersubscribe_popupline2[$language['language_id']]['line'] : ''; ?></textarea></td>
              </tr>	
		
		
		 <?php  for($l=1;$l<=6;$l++){ ?>
		<tr>
               <td><?php echo $entry_optionfield[$l]; ?><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
			  
   <td>
		  <input type='text' name='newslettersubscribe_optionfield_<?php echo $language['language_id']; ?><?php echo $l; ?>' value='<?php echo $newslettersubscribe_optionfield[$language['language_id']][$l]; ?>'>
   </td>
              </tr>	
			  
			
			<?php } ?>		

											
                                        </table>
            </div>
			
			<?php } ?>			
               </div>
	
	
	
        <div id="mail" class="ui-tabs-hide">
            <!-- vertical tabs -->
            
            <div class="vtabs vtabs ui-tabs">
          
              
<?php foreach ($languages as $language) { ?>
 <a href="#subscribe<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php echo $subscribe; ?>-<?php echo $language['name']; ?></a>
  <a href="#unsubscribe<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><?php echo $unsubscribe; ?>-<?php echo $language['name']; ?></a>
                                    <?php } ?>	
         
            </div>
           

			  
   <?php foreach ($languages as $language) { ?>
          <div id="subscribe<?php echo $language['language_id']; ?>" class="vtabs-content ui-tabs-hide">
             <table class="form">
		

		<tr>
          <td><?php echo $entry_subject_custumer; ?> </td>
		  
		  <td><textarea name="newslettersubscribe_subject_<?php echo $language['language_id']; ?>_custumer" cols="200" rows="2"><?php echo isset($newslettersubscribe_subject[$language['language_id']]['custumer']) ? $newslettersubscribe_subject[$language['language_id']]['custumer'] : ''; ?></textarea></td>
              </tr>	
			
		  
		  
		  
		  

			
			<tr>
          <td><?php echo $entry_mail_custumer; ?> </td>
		  <td><textarea name="newslettersubscribe_mail_<?php echo $language['language_id']; ?>_custumer" cols="100" rows="10"><?php echo isset($newslettersubscribe_mail[$language['language_id']]['custumer']) ? $newslettersubscribe_mail[$language['language_id']]['custumer'] : ''; ?></textarea></td>
                                            </tr>
		 
			
		<tr>
          <td><?php echo $entry_subject_admin; ?> </td>
		  <td><textarea name="newslettersubscribe_subject_<?php echo $language['language_id']; ?>_admin" cols="200" rows="2"><?php echo isset($newslettersubscribe_subject[$language['language_id']]['admin']) ? $newslettersubscribe_subject[$language['language_id']]['admin'] : ''; ?></textarea></td>
              </tr>	

			
			<tr>
          <td><?php echo $entry_mail_admin; ?> </td>
		  	  <td><textarea name="newslettersubscribe_mail_<?php echo $language['language_id']; ?>_admin" cols="100" rows="10"><?php echo isset($newslettersubscribe_mail[$language['language_id']]['admin']) ? $newslettersubscribe_mail[$language['language_id']]['admin'] : ''; ?></textarea></td>
                                            </tr>
		

			
			  
			</table>  
			</div>
			<?php } ?>
			
			<?php foreach ($languages as $language) { ?>
          <div id="unsubscribe<?php echo $language['language_id']; ?>" class="vtabs-content ui-tabs-hide">
             <table class="form">
		

		<tr>
          <td><?php echo $entry_unsubject_custumer; ?> </td>
		  
		  <td><textarea name="newslettersubscribe_unsubject_<?php echo $language['language_id']; ?>_custumer" cols="200" rows="2"><?php echo isset($newslettersubscribe_unsubject[$language['language_id']]['custumer']) ? $newslettersubscribe_unsubject[$language['language_id']]['custumer'] : ''; ?></textarea></td>
              </tr>	
			
		  
		  
		  
		  

			
			<tr>
          <td><?php echo $entry_unmail_custumer; ?> </td>
		  <td><textarea name="newslettersubscribe_unmail_<?php echo $language['language_id']; ?>_custumer" cols="100" rows="10"><?php echo isset($newslettersubscribe_unmail[$language['language_id']]['custumer']) ? $newslettersubscribe_unmail[$language['language_id']]['custumer'] : ''; ?></textarea></td>
                                            </tr>
		 
			
		<tr>
          <td><?php echo $entry_unsubject_admin; ?> </td>
		  <td><textarea name="newslettersubscribe_unsubject_<?php echo $language['language_id']; ?>_admin" cols="200" rows="2"><?php echo isset($newslettersubscribe_unsubject[$language['language_id']]['admin']) ? $newslettersubscribe_unsubject[$language['language_id']]['admin'] : ''; ?></textarea></td>
              </tr>	

			
			<tr>
          <td><?php echo $entry_unmail_admin; ?> </td>
		  	  <td><textarea name="newslettersubscribe_unmail_<?php echo $language['language_id']; ?>_admin" cols="100" rows="10"><?php echo isset($newslettersubscribe_unmail[$language['language_id']]['admin']) ? $newslettersubscribe_unmail[$language['language_id']]['admin'] : ''; ?></textarea></td>
                                            </tr>
		

			
			  
			</table>  
			</div>
			<?php } ?>
		  
		  
		   </div>
	   
	   <div id="support" class="ui-tabs-hide">
	               <div class="vtabs vtabs ui-tabs">
          
     <a href="#vtab-1-4"><?php echo $tab_support; ?></a>
         
            </div>
	         <div id="vtab-1-4" class="vtabs-content ui-tabs-hide">
              <iframe src="http://kodecube.com/ocadds/add1.html" width="730" height="500"></iframe>
			<table class="form">  
			
			<?php echo $text_info; ?>

		</table>
        </div>
	   </div>
	   
	   
	   <div id="mailchimp" class="ui-tabs-hide">
            <!-- vertical tabs -->
            
            <div class="vtabs vtabs ui-tabs">
          
              <a href="#vtab-1-3"><?php echo "General Option"; ?></a>
<?php foreach ($stores as $store) { ?>
<a href="#store<?php echo $store['store_id']; ?>"><?php echo "Store:"; ?> <?php echo $store['name']; ?></a>
                                    <?php } ?>	
         
            </div>
           
            <!-- vertical tabs content -->
          
            <div id="vtab-1-3" class="vtabs-content ui-tabs-hide">
              
			  
			      
			<table class="form">  
			
					
			  <tr>
			  			  
			  
			  
			  
			  
          <td><?php echo $entry_msync; ?> </td>
		  <td><select class="yes_no" name="newslettersubscribe_mailchimp_msync">
              <?php if ($newslettersubscribe_mailchimp_msync) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select> </td>
          
        </tr>

			<tr>
			 <td><?php echo $entry_double_optin; ?> </td>
	  <td><select class="yes_no" name="newslettersubscribe_mailchimp_optin">
              <?php if ($newslettersubscribe_mailchimp_optin) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select> </td>              
		  </tr>
			<tr>
          <td><?php echo $entry_mwelcome; ?> </td>		  
		    <td><select class="yes_no" name="newslettersubscribe_mailchimp_mwelcome">
              <?php if ($newslettersubscribe_mailchimp_mwelcome) { ?>
              <option value="1" selected="selected"><?php echo $text_yes; ?></option>
              <option value="0"><?php echo $text_no; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_yes; ?></option>
              <option value="0" selected="selected"><?php echo $text_no; ?></option>
              <?php } ?>
            </select> </td>              
		  </tr>
			
			
			
			
</table>
            </div>
       
     
              
			  
			  
			             <?php foreach ($stores as $store) { ?>
          <div id="store<?php echo $store['store_id']; ?>" class="vtabs-content ui-tabs-hide">
             <table class="form">

            <tr>
			
			
		
		
		
		
		
		<tr>
		
		
		
		
          <td><?php echo $entry_mapi; ?> </td>
		   <td>
		   <input type="text" name="newslettersubscribe_<?php echo $store['store_id']; ?>_mailchimpapi" value="<?php echo $newslettersubscribe[$store['store_id']]['mailchimpapi']; ?>" id="mailchimpidf" />
		   </td>
		      </tr>	

			
			<tr>
          <td><?php echo $entry_mid; ?> </td>
		  
		     <td>
		   <input type="text" name="newslettersubscribe_<?php echo $store['store_id']; ?>_mailchimplistid" value="<?php echo $newslettersubscribe[$store['store_id']]['mailchimplistid']; ?>" id="mailchimplistidf" />
		   </td>
		   
		  
		      
    </tr>  
			  
			  
			</table>  
			</div>
			<?php } ?>
			
	   </div>
	   <div id="error" class="ui-tabs-hide">
	               <div class="vtabs vtabs ui-tabs">
          
              
<?php foreach ($languages as $language) { ?>
 <a href="#error<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                                    <?php } ?>	
         
            </div>
	   
	    <?php foreach ($languages as $language) { ?>
          <div id="error<?php echo $language['language_id']; ?>" class="vtabs-content ui-tabs-hide">
             <table class="form">
		

		<tr>
          <td><?php echo $fheading_title; ?> </td>
		  <td><textarea name="newslettersubscribe_fheading_title_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fheading_title[$language['language_id']]) ? $newslettersubscribe_fheading_title[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>	
			<tr>
          <td><?php echo $fentry_email; ?> </td>
		  <td><textarea name="newslettersubscribe_fentry_email_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fentry_email[$language['language_id']]) ? $newslettersubscribe_fentry_email[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
			<tr>
          <td><?php echo $fentry_name; ?> </td>
		  <td><textarea name="newslettersubscribe_fentry_name_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fentry_name[$language['language_id']]) ? $newslettersubscribe_fentry_name[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
			<tr>
          <td><?php echo $fentry_button; ?> </td>
		  <td><textarea name="newslettersubscribe_fentry_button_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fentry_button[$language['language_id']]) ? $newslettersubscribe_fentry_button[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
			<tr>
          <td><?php echo $fentry_unbutton; ?> </td>
		  <td><textarea name="newslettersubscribe_fentry_unbutton_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fentry_unbutton[$language['language_id']]) ? $newslettersubscribe_fentry_unbutton[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
		<tr>
          <td><?php echo $ftext_subscribe; ?> </td>
		  <td><textarea name="newslettersubscribe_ftext_subscribe_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_ftext_subscribe[$language['language_id']]) ? $newslettersubscribe_ftext_subscribe[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
				<tr>
          <td><?php echo $ferror_invalid; ?> </td>
		  
	  <td><textarea name="newslettersubscribe_ferror_invalid_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_ferror_invalid[$language['language_id']]) ? $newslettersubscribe_ferror_invalid[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
		
		
					<tr>
          <td><?php echo $ferror_nameinvalid; ?> </td>
		  
	  <td><textarea name="newslettersubscribe_fnameinvalid_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fnameinvalid[$language['language_id']]) ? $newslettersubscribe_fnameinvalid[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
					<tr>
          <td><?php echo $ferror_optioninvalid; ?> </td>
		  
	  <td><textarea name="newslettersubscribe_foptioninvalid_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_foptioninvalid[$language['language_id']]) ? $newslettersubscribe_foptioninvalid[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
		
		
				<tr>
          <td><?php echo $fsubscribe; ?> </td>
		  <td><textarea name="newslettersubscribe_fsubscribe_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fsubscribe[$language['language_id']]) ? $newslettersubscribe_fsubscribe[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
				<tr>
          <td><?php echo $funsubscribe; ?> </td>
		  <td><textarea name="newslettersubscribe_funsubscribe_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_funsubscribe[$language['language_id']]) ? $newslettersubscribe_funsubscribe[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
				<tr>
          <td><?php echo $falreadyexist; ?> </td>
		  <td><textarea name="newslettersubscribe_falreadyexist_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_falreadyexist[$language['language_id']]) ? $newslettersubscribe_falreadyexist[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
						<tr>
          <td><?php echo $fnotexist; ?> </td>
		  <td><textarea name="newslettersubscribe_fnotexist_<?php echo $language['language_id']; ?>_line" cols="50" rows="3"><?php echo isset($newslettersubscribe_fnotexist[$language['language_id']]) ? $newslettersubscribe_fnotexist[$language['language_id']]['line'] : ''; ?></textarea></td>
        </tr>
			  
			  </table></div><?php } ?>

	   </div>
	   
      <table id="module" class="list">
        <thead>
          <tr><td class="left">type</td>
            <td class="left"><?php echo $entry_layout; ?></td>

            <td class="left"><?php echo $entry_position; ?></td>
            <td class="left"><?php echo $entry_status; ?></td>
            <td class="right"><?php echo $entry_sort_order; ?></td>
            <td></td>
          </tr>
        </thead>
        <?php $module_row = 0; ?>
        <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
          <tr> 

<td class="left"><select name="newslettersubscribe_module[<?php echo $module_row; ?>][type]">
                <?php if ($module['type'] == 'thickbox') { ?>
                <option value="thickbox" selected="selected">thickbox</option>
                <?php } else { ?>
                <option value="thickbox">thickbox</option>
                <?php } ?>
                <?php if ($module['type'] == 'popup') { ?>
                <option value="popup" selected="selected">popup</option>
                <?php } else { ?>
                <option value="popup">popup</option>
                <?php } ?>
                <?php if ($module['type'] == 'normal') { ?>
                <option value="normal" selected="selected">normal</option>
                <?php } else { ?>
                <option value="normal">normal</option>
                <?php } ?>
                <?php if ($module['type'] == 'footer') { ?>
                <option value="footer" selected="selected">footer</option>
                <?php } else { ?>
                <option value="footer">footer</option>
                <?php } ?>

                <?php if ($module['type'] == 'footer2') { ?>
                <option value="footer2" selected="selected">footer2</option>
                <?php } else { ?>
                <option value="footer2">footer2</option>
                <?php } ?>
<?php if ($module['type'] == 'slideright') { ?>
                <option value="slideright" selected="selected">slideright</option>
                <?php } else { ?>
                <option value="slideright">slideright</option>
                <?php } ?>

<?php if ($module['type'] == 'slideleft') { ?>
                <option value="slideleft" selected="selected">slideleft</option>
                <?php } else { ?>
                <option value="slideleft">slideleft</option>
                <?php } ?>

              </select></td>



            <td class="left"><select name="newslettersubscribe_module[<?php echo $module_row; ?>][layout_id]">
                <?php foreach ($layouts as $layout) { ?>
                <?php if($layout['layout_id'] == $module['layout_id']){ ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
            <td class="left"><select name="newslettersubscribe_module[<?php echo $module_row; ?>][position]">
                <?php if ($module['position'] == 'content_top') { ?>
                <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                <?php } else { ?>
                <option value="content_top"><?php echo $text_content_top; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'content_bottom') { ?>
                <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                <?php } else { ?>
                <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_left') { ?>
                <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                <?php } else { ?>
                <option value="column_left"><?php echo $text_column_left; ?></option>
                <?php } ?>
                <?php if ($module['position'] == 'column_right') { ?>
                <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                <?php } else { ?>
                <option value="column_right"><?php echo $text_column_right; ?></option>
                <?php } ?>
              </select></td>
            <td class="left"><select name="newslettersubscribe_module[<?php echo $module_row; ?>][status]">
                <?php if ($module['status']) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            <td class="right"><input type="text" name="newslettersubscribe_module[<?php echo $module_row; ?>][sort_order]" class="small" value="<?php echo $module['sort_order'];  ?>" size="3" /></td>
            <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
          </tr>
        </tbody>
        <?php $module_row++; ?>
        <?php } ?>
        <tfoot>
          <tr>
            <td colspan="5"></td>
            <td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
          </tr>
        </tfoot>
      </table>
	  
	     <?php } ?>
	
    </form>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
html += '  <tr>';
html += '    <td class="left"><select name="newslettersubscribe_module[' + module_row + '][type]">';
	html += '      <option value="thickbox">thickbox</option>';
	html += '      <option value="popup">popup</option>';
	html += '      <option value="normal">normal</option>';
	html += '      <option value="footer">footer</option>';
	html += '      <option value="footer2">footer2</option>';
html += '      <option value="slideleft">slideleft</option>';
 html += '      <option value="slideright">slideright</option>';
	html += '    </select></td>';

	
	html += '    <td class="left"><select name="newslettersubscribe_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="newslettersubscribe_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="newslettersubscribe_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" class="small" name="newslettersubscribe_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	
	module_row++;
}

$('#form').bind('submit', function() {
	var module = new Array(); 

	$('#module tbody').each(function(index, element) {
		module[index] = $(element).attr('id').substr(10);
	});
	
	$('input[name=\'newslettersubscribe_module\']').attr('value', module.join(','));
});
//--></script>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
 
<script type="text/javascript">

$(function(){
  $('.htabs a').click(function(){
    $.address.value($(this).attr('href').substr(1));
  });

  $('.vtabs a').click(function(){
    $.address.value($('.htabs a.selected').attr('href').substr(1) + '/' + $(this).attr('href').substr(1));
  });

  $.address.init(function(event){
    var main = event.pathNames.length > 0 ? event.pathNames[0] : $('.htabs a').first().attr('href').substr(1);
    var sec = event.pathNames.length > 1 ? event.pathNames[1] : $('#' + main + ' .vtabs a').first().attr('href').substr(1);
    $('a[href="#' + main +'"]').click();
    $('a[href="#' + sec +'"]').click();
  });
});

(function(){
  $('.main-tabs a').tabs();
  $('.vtabs a').tabs();
  $('.main-tabs a').click(function(){
      var tab = $(this).attr("href");
      $(tab + ' .vtabs a').first().click();
      if (tab === '#main-tabs-fonts') {
        $('.preview-fonts').show();
      } else {
        $('.preview-fonts').hide();
      }
  });
  $('.ui-tabs-hide').removeClass('ui-tabs-hide');
  // $('a[href=#main-tabs-menus]').click();
  // $('a[href=#vtab-menus-categories_menu]').click();
})();
function showValue(str,name){//////////this is possible in class name only not in id.
	
	
	document.getElementsByName(name)[0].value = str;
	
}


</script>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
        
        CKEDITOR.replace('newslettersubscribe_unmail_<?php echo $language['language_id']; ?>_custumer', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });
		   
        CKEDITOR.replace('newslettersubscribe_unmail_<?php echo $language['language_id']; ?>_admin', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });			
		        CKEDITOR.replace('newslettersubscribe_mail_<?php echo $language['language_id']; ?>_custumer', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });
		   
        CKEDITOR.replace('newslettersubscribe_mail_<?php echo $language['language_id']; ?>_admin', {
            filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
            filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
        });	
<?php } ?>

//--></script> 