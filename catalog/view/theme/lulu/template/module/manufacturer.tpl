<div class="manuff_block">
    <select onchange="location = this.value">
      <option value=""><?php echo $heading_title; ?></option>
      <?php foreach ($manufacturers as $manufacturer) { ?>
      <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
      <option value="<?=$manufacturer['href']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
      <?php } else { ?>
      <option value="<?=$manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></option>
      <?php } ?>
      <?php } ?>
    </select>
</div>