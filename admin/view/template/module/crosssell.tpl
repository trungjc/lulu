<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_title; ?></td>
              <td class="left"><?php echo $entry_relation_criteria; ?></td>
              <td class="left"><?php echo $entry_dimension; ?></td>
              <td class="left"><?php echo $entry_limit; ?></td>
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


              <td style="vertical-align: top" class="left">              
		          <?php foreach ($languages as $language) { ?>
		          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name'] . " " . $entry_title; ?> <input type="text" name="crosssell_module[<?php echo $module_row; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo (isset($module['title'][$language['language_id']]) ? $module['title'][$language['language_id']] : ''); ?>" /><br/>
		          <?php } ?>
              
              </td>


	           <td style="vertical-align: top" class="left">
	           	<input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][related]" <?php echo (isset($module['related']) and $module['related']) ? 'checked="checked"' : ''; ?>/> <?php echo $entry_related; ?><br/>
	           	<input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][alsobought]" <?php echo (isset($module['alsobought']) and $module['alsobought']) ? 'checked="checked"' : ''; ?>/> <?php echo $entry_alsobought; ?><br/>
	           	<input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][category]" <?php echo (isset($module['category']) and $module['category']) ? 'checked="checked"' : ''; ?>/> <?php echo $entry_category; ?><br/>
	           	<input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][manufacturer]" <?php echo (isset($module['manufacturer']) and $module['manufacturer']) ? 'checked="checked"' : ''; ?>/> <?php echo $entry_manufacturer; ?><br/>
<br />
	           <?php echo $entry_options; ?>:<br/>
	           <div>
	           <div class="scrollbox">
			            <?php $class = 'odd'; ?>
                        <?php foreach ($options as $o) { ?>
						<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	                       <div class="<?php echo $class; ?>">
			                  <?php if (isset($module['option_id']) and is_array($module['option_id']) and in_array($o['option_id'], $module['option_id'])) { ?>
			                     <input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][option_id][]" value="<?php echo $o['option_id']; ?>" checked="checked" />
			                  <?php echo $o['name']; ?>
			                  <?php } else { ?>
			                     <input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][option_id][]" value="<?php echo $o['option_id']; ?>" />
			                  <?php echo $o['name']; ?>
			                  <?php } ?>
                           </div>
						<?php } ?>
	           </div>
	           <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect; ?></a>
	           </div>
<br />			  
			            <?php echo $entry_attribs; ?>:<br/>
			            <div>
			            <div class="scrollbox">
			                <?php $class = 'odd'; ?>
			                <?php foreach ($attributes as $a) { ?>
			                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
			                <div class="<?php echo $class; ?>">
			                  <?php if (isset($module['attribute_id']) and is_array($module['attribute_id']) and in_array($a['attribute_id'], $module['attribute_id'])) { ?>
			                  <input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][attribute_id][]" value="<?php echo $a['attribute_id']; ?>" checked="checked" />
			                  <?php echo $a['name']; ?>
			                  <?php } else { ?>
			                  <input type="checkbox" name="crosssell_module[<?php echo $module_row; ?>][attribute_id][]" value="<?php echo $a['attribute_id']; ?>" />
			                  <?php echo $a['name']; ?>
			                  <?php } ?>
			                </div>
			                <?php } ?>
			              </div>
			              <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect; ?></a>
			              </div>

			  </td>
              
              <td style="vertical-align: top" class="left"><input type="text" name="crosssell_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" />
                <input type="text" name="crosssell_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3" />
                <?php if (isset($error_dimension[$module_row])) { ?>
                <span class="error"><?php echo $error_dimension[$module_row]; ?></span>
                <?php } ?>
			  </td>
              <td style="vertical-align: top" class="right"><input type="text" name="crosssell_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="3" /></td>
              <td style="vertical-align: top" class="left"><select name="crosssell_module[<?php echo $module_row; ?>][layout_id]" id="crosssell_module_layout_<?php echo $module_row; ?>">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option id="crosssell_module_layout_<?php echo $module_row; ?>_option_<?php echo $layout['layout_id']; ?>" value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option id="crosssell_module_layout_<?php echo $module_row; ?>_option_<?php echo $layout['layout_id']; ?>" value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                
                
                </td>
              <td style="vertical-align: top" class="left"><select name="crosssell_module[<?php echo $module_row; ?>][position]">
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
                </select>
				</td>
              <td style="vertical-align: top" class="left"><select name="crosssell_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="crosssell_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>
          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="9" class="right"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript"><!--


//--></script> 


<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';

	html += ' <td style="vertical-align: top" class="left">';              
		          <?php foreach ($languages as $language) { ?>
	html += '     <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name'] . " " . $entry_title; ?> <input type="text" name="crosssell_module['+module_row+'][title][<?php echo $language['language_id']; ?>]" value="" /><br/>';
		          <?php } ?>
              
	html += ' </td>';
	html += ' <td style="vertical-align: top" class="left">';
	html += ' 	<input type="checkbox" name="crosssell_module['+module_row+'][related]" checked="checked"/> <?php echo $entry_related; ?><br/>';
	html += '   <input type="checkbox" name="crosssell_module['+module_row+'][alsobought]" checked="checked"/> <?php echo $entry_alsobought; ?><br/>';
	html += '   <input type="checkbox" name="crosssell_module['+module_row+'][category]" checked="checked"/> <?php echo $entry_category; ?><br/>';
	html += '   <input type="checkbox" name="crosssell_module['+module_row+'][manufacturer]" checked="checked"/> <?php echo $entry_manufacturer; ?><br/>';
	html += ' <br/>';
	
	html += '           <?php echo $entry_options; ?>:<br/>';
	html += '			<div><div class="scrollbox">';
			                <?php $class = 'odd'; ?>
<?php foreach ($options as $o) { ?>
						<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	html += '               <div class="<?php echo $class; ?>"><input type="checkbox" name="crosssell_module['+module_row+'][option_id][]" value="<?php echo $o['option_id']; ?>" /><?php echo addslashes($o['name']); ?></div>';
						<?php } ?>
	html += '             </div>';
	html += '             <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect; ?></a>';
	html += ' 			</div>';
	html += ' <br/>';
	html += '           <?php echo $entry_attribs; ?>:<br/>';
	html += '            <div><div class="scrollbox">';
	               <?php $class = 'odd'; ?>
			            <?php foreach ($attributes as $a) { ?>
			                 <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
	html += '                <div class="<?php echo $class; ?>"><input type="checkbox" name="crosssell_module['+module_row+'][attribute_id][]" value="<?php echo $a['attribute_id']; ?>" /><?php echo addslashes($a['name']); ?></div>';
						<?php } ?>
	html += '             </div>';
	html += '             <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect; ?></a>';
	html += ' 			</div>';
	html += ' </td>';

               
    html += '<td style="vertical-align: top" class="left">';
	html += '	<input type="text" name="crosssell_module[' + module_row + '][width]" value="80" size="3" />';
    html += '	<input type="text" name="crosssell_module[' + module_row + '][height]" value="80" size="3" />';
	html += '</td>';
	html += ' <td style="vertical-align: top" class="right"><input type="text" name="crosssell_module['+module_row+'][limit]" value="" size="3" /></td>';
	html += '    <td class="left" style="vertical-align: top"><select name="crosssell_module[' + module_row + '][layout_id]" id="crosssell_module_layout_'+module_row+'">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option id="crosssell_module_layout_'+module_row+'_option_<?php echo $layout['layout_id']; ?>"  value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select>';


	
	html += '    </td>';
	html += '    <td class="left" style="vertical-align: top"><select name="crosssell_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left" style="vertical-align: top"><select name="crosssell_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="crosssell_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);


	module_row++;
}
//--></script> 
<?php echo $footer; ?>