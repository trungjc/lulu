<?php
//OpenCart Extension
//Project Name: OpenCart News
//Author: Fanha Giang a.k.a fanha99
//Email (PayPal Account): fanha99@gmail.com
//License: Commercial
?>
<div class="boxs">
  <div class="box-contents">
    <ul class="category-new">
        <?php foreach ($categories as $category) { ?>
        <li>
          <?php if ($category['category_id'] == $news_category_id) { ?>
          <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
          <?php } else { ?>
          <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
          <?php } ?>
          <?php if ($category['children']) { ?>
          <ul>
            <?php foreach ($category['children'] as $child) { ?>
            <li>
              <?php if ($child['news_category_id'] == $child_id) { ?>
              <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
              <?php } else { ?>
              <a href="<?php echo $child['href']; ?>"> <?php echo $child['name']; ?></a>
              <?php } ?>
			   <ul>
				<?php foreach ($child['children'] as $child_child) { ?>
				<li>				 
				  <a href="<?php echo $child_child['href']; ?>"> <?php echo $child_child['name']; ?></a>						  
				</li>
				<?php } ?>
			  </ul>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
