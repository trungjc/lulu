<?php echo $header; ?><?php echo $content_top; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php //echo $column_left; ?><?php //echo $column_right; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <div class="login-content">
    <div class="left">
      <h1>  Welcome  !</h1> 
      <p>
      Lulu and lipstick's customer service is ready to assist you. please let us knows as much information in your enquiry . You can also find answer to frequently asked question in the online customer service section by click on the links to the right.
      </p>
      <p>Benefits: </p>
      <ul>
          <li>Benefits  1</li>
           <li>Benefits  2</li>
            <li>Benefits  3</li>
             <li>Benefits  4</li>
              <li>Benefits 5 </li>
      </ul>
      <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the order you have previously made.</p>
      
    </div>
    <div class="right">
      <h2 style="color: #d64599">already a loyal lulu ?</h2>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="submitForm" value="login" />
        <div class="content">
            <table class="form">
                <tr>
                    <td colspan="2">
                   <?php echo $entry_email; ?><br />
                    <input type="text" name="email" value="<?php echo $email; ?>" />
                    </td>
                  
                </tr>
                 <tr>
                    <td colspan="2">
                  <?php echo $entry_password; ?><br />
                   <input type="password" name="password" value="<?php echo $password; ?>" />
                    </td>
                  
                </tr>
                  <tr>
                      <td align="left">
                            <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                    
                    </td>
                   <td class="buttons" align="right" style="width:50%">
                    
                    <input type="submit" value="<?php echo $button_login; ?>" class="button"/>
                        <?php if ($redirect) { ?>
                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                        <?php } ?>
                    </td>
                </tr>
            </table>
          
         
         
          
        </div>
      </form>

      <div class="register-content">
        <p><?php echo $text_account_already; ?></p>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="submitForm" value="register" />
          <h2 style="color: #d64599"><?php echo $text_your_details; ?></h2>
          <div class="content">
            <table class="form">
              <tr>
                <td style="width: 50%;"><span class="required">*</span> <?php echo $entry_firstname; ?><br/>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" />
                  <?php if ($error_firstname) { ?>
                  <span class="error"><?php echo $error_firstname; ?></span>
                  <?php } ?>
                </td>
                <td><span class="required">*</span> <?php echo $entry_lastname; ?><br/>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" />
                  <?php if ($error_lastname) { ?>
                  <span class="error"><?php echo $error_lastname; ?></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                  <td colspan="2"><span class="required">*</span> <?php echo $entry_email; ?><br/>
                  <input type="text" name="email" value="<?php echo $email; ?>" />
                  <?php if ($error_email) { ?>
                  <span class="error"><?php echo $error_email; ?></span>
                  <?php } ?>
                  </td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_telephone; ?><br/>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" />
                  <?php if ($error_telephone) { ?>
                  <span class="error"><?php echo $error_telephone; ?></span>
                  <?php } ?>
                </td>
                <td>DATE OF BIRTH<br/>
                <input type="text" name="banca" value="<?php echo $banca; ?>" />
                </td>
              </tr>
              
              <tr  style="display:none;">
                <td>entry_iban</td>
                <td><input type="text" name="iban" value="<?php echo $iban; ?>" /></td>
              </tr>
              <tr style="display:none;">
                <td><?php echo $entry_fax; ?></td>
                <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
              </tr>

              <tr  style="display:none;">
                <td><?php echo $entry_company; ?></td>
                <td><input type="text" name="company" value="<?php echo $company; ?>" /></td>
              </tr>        
              <tr style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;"  style="display:none">
                <td><?php echo $entry_customer_group; ?></td>
                <td><?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                  <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                  <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                  <br />
                  <?php } else { ?>
                  <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>" id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" />
                  <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                  <br />
                  <?php } ?>
                  <?php } ?></td>
              </tr>      
              <tr id="company-id-display">
                <td><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?></td>
                <td><input type="text" name="company_id" value="<?php echo $company_id; ?>" />
                  <?php if ($error_company_id) { ?>
                  <span class="error"><?php echo $error_company_id; ?></span>
                  <?php } ?></td>
              </tr>
              <tr id="tax-id-display">
                <td><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?></td>
                <td><input type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
                  <?php if ($error_tax_id) { ?>
                  <span class="error"><?php echo $error_tax_id; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                  <td colspan="2"><span class="required">*</span> <?php echo $entry_address_1; ?><br/>
                  <input type="text" name="address_1" value="<?php echo $address_1; ?>" />
                  <?php if ($error_address_1) { ?>
                  <span class="error"><?php echo $error_address_1; ?></span>
                  <?php } ?>
                  </td>
              </tr>
              <tr  style="display:none">
                <td><?php echo $entry_address_2; ?></td>
                <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" /></td>
              </tr>
              <tr  style="display:none">
                <td><span class="required">*</span> <?php echo $entry_city; ?></td>
                <td><input type="text" name="city" value="<?php echo $city; ?>" />
                  <?php if ($error_city) { ?>
                  <span class="error"><?php echo $error_city; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                  <td class="reset-select">
                    <span class="required">*</span> <?php echo $entry_zone; ?><br/>
                <select name="zone_id">
                <option value=""> --- Please Select --- </option>
                <option value="191">Australian Capital Territory</option>
                <option value="192">New South Wales</option>
                <option value="193">Northern Territory</option>
                <option value="194">Queensland</option>
                <option value="195">South Australia</option>
                <option value="196">Tasmania</option>
                <option value="197">Victoria</option>
                <option value="198">Western Australia</option>
                </select>
                  <?php if ($error_zone) { ?>
                  <span class="error"><?php echo $error_zone; ?></span>
                  <?php } ?>
                  
                    
                   </td>
                <td>
                     <span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?><br/>
                    <input type="text" name="postcode" value="<?php echo $postcode; ?>" />
                  <?php if ($error_postcode) { ?>
                  <span class="error"><?php echo $error_postcode; ?></span>
                  <?php } ?></td>
              </tr>
              <tr style="display:none;">
                <td><span class="required">*</span> <?php echo $entry_country; ?></td>
                <td><select name="country_id">
                    <option value=""><?php echo $text_select; ?></option>
                    <?php foreach ($countries as $country) { ?>
                    <?php if ($country['country_id'] == $country_id) { ?>
                    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <?php if ($error_country) { ?>
                  <span class="error"><?php echo $error_country; ?></span>
                  <?php } ?></td>
              </tr>

              <tr>
                <td><span class="required">*</span> <?php echo $entry_password; ?><br/>
                <input type="password" name="password" value="<?php echo $password; ?>" />
                  <?php if ($error_password) { ?>
                  <span class="error"><?php echo $error_password; ?></span>
                  <?php } ?>
                </td>
                <td>
                <span class="required">*</span> <?php echo $entry_confirm; ?><br/>
                <input type="password" name="confirm" value="<?php echo $confirm; ?>" />
                  <?php if ($error_confirm) { ?>
                  <span class="error"><?php echo $error_confirm; ?></span>
                  <?php } ?>
                </td>
              </tr>
              <tr>
                  <td colspan="2">
                   <?php if ($text_agree) { ?>
          <div class="buttons">
              <div class="rights">
              <?php if ($agree) { ?>
              <input  type="checkbox" name="agree" value="1" checked="checked" />
              <?php } else { ?>
              <input  type="checkbox" name="agree" value="1" checked="checked" />
              <?php } ?>
              <span style="font-size: 13px"><?php echo $text_agree; ?></span>
              <div class="cleafix" style="margin-top:15px;">
                  <input type="submit" value="Sign Up" class="button" style="float: right"/>
              </div>
            </div>
          </div>
          <?php } else { ?>
          <div class="buttons">
            <div class="rights">
              <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
            </div>
          </div>
          <?php } ?>
                  </td>
              </tr>

            </table>
          </div>
          <div class="content" style="display:none">
            <table class="form">
              <tr>
                <td><?php echo $entry_newsletter; ?></td>
                <td><?php if ($newsletter) { ?>
                  <input type="radio" name="newsletter" value="1" checked="checked" />
                  <?php echo $text_yes; ?>
                  <input type="radio" name="newsletter" value="0" />
                  <?php echo $text_no; ?>
                  <?php } else { ?>
                  <input type="radio" name="newsletter" value="1" />
                  <?php echo $text_yes; ?>
                  <input type="radio" name="newsletter" value="0" checked="checked" />
                  <?php echo $text_no; ?>
                  <?php } ?></td>
              </tr>
            </table>
          </div>
         
        </form>
      <script type="text/javascript"><!--
      $('input[name=\'customer_group_id\']:checked').live('change', function() {
        var customer_group = [];
        
      <?php foreach ($customer_groups as $customer_group) { ?>
        customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
        customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
        customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
        customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
        customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
      <?php } ?>  
        /*
        hardcode for hidden fields
        */
        customer_group[this.value]['company_id_display'] = 0;
        customer_group[this.value]['company_id_required'] = 0;
        customer_group[this.value]['tax_id_display'] = 0;
        customer_group[this.value]['tax_id_required'] = 0;
        if (customer_group[this.value]) {
          if (customer_group[this.value]['company_id_display'] == '1') {
            $('#company-id-display').show();
          } else {
            $('#company-id-display').hide();
          }
          if (customer_group[this.value]['company_id_required'] == '1') {
            $('#company-id-required').show();
          } else {
            $('#company-id-required').hide();
          }
          
          if (customer_group[this.value]['tax_id_display'] == '1') {
            $('#tax-id-display').show();
          } else {
            $('#tax-id-display').hide();
          }
          
          if (customer_group[this.value]['tax_id_required'] == '1') {
            $('#tax-id-required').show();
          } else {
            $('#tax-id-required').hide();
          } 
        }
      });

      $('input[name=\'customer_group_id\']:checked').trigger('change');
      //--></script> 
      <script type="text/javascript"><!--
      $('select[name=\'country_id\']').bind('change', function() {
        $.ajax({
          url: 'index.php?route=account/register/country&country_id=' + this.value,
          dataType: 'json',
          beforeSend: function() {
            $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
          },
          complete: function() {
            $('.wait').remove();
          },      
          success: function(json) {
            if (json['postcode_required'] == '1') {
              $('#postcode-required').show();
            } else {
              $('#postcode-required').hide();
            }
            
            html = '<option value=""><?php echo $text_select; ?></option>';
            
            if (json['zone'] != '') {
              for (i = 0; i < json['zone'].length; i++) {
                    html += '<option value="' + json['zone'][i]['zone_id'] + '"';
                  
                if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                      html += ' selected="selected"';
                  }
        
                  html += '>' + json['zone'][i]['name'] + '</option>';
              }
            } else {
              html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
            }
            
            $('select[name=\'zone_id\']').html(html);
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
      });

      $('select[name=\'country_id\']').trigger('change');
      //--></script> 
      <script type="text/javascript"><!--
      $(document).ready(function() {
        $('.colorbox').colorbox({
          width: 640,
          height: 480
        });
      });
      //--></script> 
    </div>
    <!-- end register block -->

    </div>
  </div>

  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script> 
<?php echo $footer; ?>