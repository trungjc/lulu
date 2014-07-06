<?php echo $header; ?><?php echo $content_top; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
 
    <div class="contact-info">
      <div class="contents"><div><?php echo $address; ?></div></div>
    </div>
    <div class="contents cleafix">
        <div class="left-contact">
        <div class="clearfix row row1">
            <div class="left">
                <label><?php echo $entry_name; ?></label>
                <input type="text" name="name" value="<?php echo $name; ?>" /> <br />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?>
            </div>
            <div class="right">
                <label>Last Name</label>
                <input type="text" name="name" value="<?php echo $name; ?>" /> <br />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?>
            </div>
        </div>
        <div class="clearfix row row2">
            <label><?php echo $entry_email; ?></label>
            <input type="text" name="email" value="<?php echo $email; ?>" />

            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?>
        </div>
        <div class="clearfix row row3">
            <label><?php echo $entry_enquiry; ?></b><label />
            <textarea name="enquiry" cols="40" rows="10" style="width: 99%;"><?php echo $enquiry; ?></textarea>
            <br />
            <?php if ($error_enquiry) { ?>
            <span class="error"><?php echo $error_enquiry; ?></span>
            <?php } ?>
        </div>
        <div class="buttons"><input type="submit" value="Send" class="button" /></div>
     </div>
     <div class="right-contact">
         <h3>is there anything we can help with ?</h3>
         <div class="accordion">
            <div class="accordion-heading">
                what brands do you stock ?
            </div>
            <div class="accordion-content">
           Luu and lipstick's customer service is ready to assist you.please let us know as much information in your enquiry . you can also find answers to frequently asked questions in the online customer service section by click on the links to the right.
            </div>
        </div>
         <div class="accordion">
            <div class="accordion-heading">
                what are your delivery options ?
            </div>
            <div class="accordion-content">
            Luu and lipstick's customer service is ready to assist you.please let us know as much information in your enquiry . you can also find answers to frequently asked questions in the online customer service section by click on the links to the right.
            </div>
          </div>
           <div class="accordion">
                <div class="accordion-heading">
                how long will it takefor my order to arrive ?
                </div>
                <div class="accordion-content">
                this is content of answer
                </div>
           </div>
              <div class="accordion">
                <div class="accordion-heading">
                    can i track my parcel ?
                </div>
                <div class="accordion-content">
                this is content of answer
                </div>
            </div>
            <div class="accordion">
            <div class="accordion-heading">
                what brands do you stock ?
            </div>
            <div class="accordion-content">
            this is content of answer
            </div>
        </div>
         <div class="accordion">
            <div class="accordion-heading">
                what are your delivery options ?
            </div>
            <div class="accordion-content">
            this is content of answer
            </div>
          </div>
           <div class="accordion">
                <div class="accordion-heading">
                how long will it takefor my order to arrive ?
                </div>
                <div class="accordion-content">
                this is content of answer
                </div>
           </div>
              <div class="accordion">
                <div class="accordion-heading">
                    can i track my parcel ?
                </div>
                <div class="accordion-content">
                this is content of answer
                </div>
            </div>
         
         <div class="viewall">
             <a href="<?php echo HTTP_SERVER ; ?>index.php?route=information/information&information_id=9">view all FAQ's</a>
         </div>
     </div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>