<div class="box">
  <div class="box-content">
    <ul class="box-filter">
      <?php foreach ($filter_groups as $filter_group) { ?>
      <li class="first"><span id="filter-group<?php echo $filter_group['filter_group_id']; ?>">Refine by <span><?php echo $filter_group['name']; ?></span></span>
        <ul>
          <?php foreach ($filter_group['filter'] as $filter) { ?>
         
          <li>
              <a href="<?php echo HTTP_SERVER; ?>index.php?route=product/category&path=20&filter=<?php echo $filter['filter_id']; ?>" ><?php echo $filter['name']; ?></a>
          </li>
         
          <?php } ?>
        </ul>
      </li>
      <?php } ?>
    </ul>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').bind('click', function() {
	filter = [];
	
	$('.box-filter input[type=\'checkbox\']:checked').each(function(element) {
		filter.push(this.value);
	});
	
	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
//--></script> 
