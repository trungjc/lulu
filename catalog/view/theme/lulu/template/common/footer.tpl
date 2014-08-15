<div id="footer">
  <?php if ($informations) { ?>
  <div class="column">
    <h3><?php echo $text_information; ?></h3>
    <ul>
      <?php foreach ($informations as $information) { ?>
      <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>
  <div class="column">
    <h3><?php echo $text_service; ?></h3>
    <ul>
      <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
      <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
      <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
    </ul>
  </div>
  <div class="column">
    <h3><?php echo $text_extra; ?></h3>
    <ul>
      <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
      <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
      <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
      <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
    </ul>
  </div>
  <div class="column">
    <h3><?php echo $text_account; ?></h3>
    <ul>
      <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
    </ul>
  </div>
</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<div id="powered"><?php echo $powered; ?></div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
</div>

<script type="text/javascript" src="<?php echo $base;?>catalog/view/theme/lulu/js/jquery.selectbox-0.1.3.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $base;?>catalog/view/theme/lulu/stylesheet/jquery.selectbox.css" >
<script type="text/javascript">
    jQuery(document).ready(function(){ 
        jQuery('select').selectbox();
        jQuery('.accordion-heading').click(function(){
        jQuery('.accordion-heading').removeClass('active');
            jQuery(this).addClass('active');
        });
        //alert(1);
        
             jQuery('#supermenu ul li div.bigdiv').each(function(index, elem){
                 var test = jQuery(elem);
                 test.css('position', 'static');
                test.css('visibility', 'hidden').show();
                
        
        /*
                var  width =  0;
                test.find('.supermenu-left .withchild,.supermenu-left .withimage').each(function(idx, e) {
                    width += jQuery(e).width();
                });
*/
                  test.css("width",test.width()); 
                  test.css('position', 'absolute');
                  test.hide().css('visibility', 'visible');
              });
     
       
       
            
function getUnvisibleDimensions(obj) {
    //alert(3);
    if (jQuery(obj).length == 0) {
        return false;
    }
    var clone = jQuery(obj).clone();
    clone.css({
        visibility:'hidden',
        width : '',
        height: '',
        display:'block',
        maxWidth : '',
        maxHeight: ''
    });
   // alert(5);
    jQuery('body').append(clone);
    var width = clone.outerWidth();
//        height = clone.outerHeight();
    clone.remove();
  alert(width);
    return width;
    
     
     
    }
});
     
    
</script>
</body></html>