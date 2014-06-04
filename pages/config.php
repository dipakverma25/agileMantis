<?php

	# agileMantis - makes Mantis ready for Scrum

	# agileMantis is free software: you can redistribute it and/or modify
	# it under the terms of the GNU General Public License as published by
	# the Free Software Foundation, either version 2 of the License, or
	# (at your option) any later version.
	#
	# agileMantis is distributed in the hope that it will be useful,
	# but WITHOUT ANY WARRANTY; without even the implied warranty of
	# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	# GNU General Public License for more details.
	#
	# You should have received a copy of the GNU General Public License
	# along with agileMantis. If not, see <http://www.gnu.org/licenses/>.

	# initial plugin config settings
	if(!config_is_set('plugin_agileMantis_gadiv_show_storypoints')){
		config_set('plugin_agileMantis_gadiv_show_storypoints', 0);
	}

	if(!config_is_set('plugin_agileMantis_gadiv_show_rankingorder')){
		config_set('plugin_agileMantis_gadiv_show_rankingorder', 0);
	}

	html_page_top(plugin_lang_get( 'manage_settings_title' ));

	# checks if the current user is administrator oder agileMantis administrator
	if ( current_user_is_administrator() || $_SESSION['ISMANTISADMIN'] == 1 ) {
?>
<br>
<?php
	if($_GET['error'] == 'workday_error'){
		$system = plugin_lang_get( 'manage_settings_error_984100' );
	}

	if($_GET['error'] == 'sprint_length_error'){
		$system = plugin_lang_get( 'manage_settings_error_984101' );
	}

	if($_GET['error'] == 'no_license_error'){
		$system = plugin_lang_get( 'manage_settings_error_984102' );
	}

	if($_GET['error'] == 'could_not_find_error'){
		$system = plugin_lang_get( 'manage_settings_error_984103' );
	}

	if($_GET['error'] == 'empty_license_error'){
		$system = plugin_lang_get( 'manage_settings_error_984104' );
	}

	if($_GET['error'] == 'file_upload_error'){
		$system = plugin_lang_get( 'manage_settings_error_984105' );
	}

	include(PLUGIN_URI.'/pages/footer_menu.php');

	if($_GET['save'] == 'success'){
		echo '<br><center><span style="color:green; font-size:16px; font-weight:bold;">'.plugin_lang_get( 'manage_settings_successfully_saved' ).'</span></center>';
	}

?>
<?php if($system){?>
	<br>
	<center><span style="color:red; font-size:16px; font-weight:bold;"><?php echo $system?></span></center>
<?php }?>
<br>
<table align="center" class="width75" cellspacing="1">
<tr>
	<td colspan="2"><b><?php echo plugin_lang_get( 'manage_settings_title' )?></b></td>
</tr>
<tr>
	<td class="category"><b><?php echo plugin_lang_get( 'manage_settings_options' )?></b></td>
	<td class="category"><b><?php echo plugin_lang_get( 'common_actions' )?></b></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_license_info' )?></td>
	<td class="left">
		<?php
			if(plugin_is_loaded('agileMantisExpert')){
				event_signal( 'EVENT_LOAD_SETTINGS', array( auth_get_current_user_id()) );
			} else {
		?>
		<a href="<?php echo plugin_lang_get( 'license_download_link' )?>"><?php echo plugin_lang_get( 'license_download' )?></a>
		<?php
			}
		?>
	</td>
</tr>
<form action="<?php echo plugin_page('config_edit.php') ?>" method="post" id="config_form" enctype="multipart/form-data">
<input type="hidden" id="deleteField" name="deleteField" value="">
<input type="hidden" id="changeUnit" name="changeUnit" value="">
<?php echo form_security_field('plugin_format_config_edit') ?>
<?php
	if(plugin_is_loaded('agileMantisExpert')){
?>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_upload_license' )?></td>
	<td><input type="file" name="license" size="50" /></td>
</tr>
<?php
	}
?>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_standard_length' )?> (<?php echo plugin_lang_get( 'days' )?>)</td>
	<td class="left">
		<input type="text" size="5" maxlength="3" name="gadiv_sprint_length" value="<?php echo plugin_config_get('gadiv_sprint_length')?>" style="padding-right:5px;text-align:right;">
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_sprint_view' )?></td>
	<td class="left">
		<select name="gadiv_taskboard">
			<option value="0" <?php if(plugin_config_get('gadiv_taskboard')=='0'){echo 'selected';}?>>Sprint Backlog</option>
			<option value="1" <?php if(plugin_config_get('gadiv_taskboard')=='1'){echo 'selected';}?>>Taskboard</option>
		</select>
		<div style="float:right">
			<input type="checkbox" name="gadiv_show_storypoints" <?php if(plugin_config_get('gadiv_show_storypoints') == '1'){echo 'checked';}?> value="1"> <?php echo plugin_lang_get( 'manage_settings_show_storypoints' )?>
			<input type="checkbox" name="gadiv_show_rankingorder" <?php if(plugin_config_get('gadiv_show_rankingorder') == '1'){echo 'checked';}?> <?php if(plugin_config_get('gadiv_ranking_order')=='0'){echo 'disabled';}?> id="show_rankingorder" value="1"> <?php echo plugin_lang_get( 'manage_settings_show_rankingorder' )?>
		</div>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_daily_scrum_mode' )?></td>
	<td><input type="checkbox" name="gadiv_daily_scrum" <?if(plugin_config_get('gadiv_daily_scrum')=='1'){echo 'checked';}?> value="1"></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_storypoints_mode' )?></td>
	<td class="left">
		<select name="gadiv_storypoint_mode">
			<option value="0" <?php if(plugin_config_get('gadiv_storypoint_mode')=='0'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_fibonnaci' )?></option>
			<option value="1" <?php if(plugin_config_get('gadiv_storypoint_mode')=='1'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_free_mode' )?></option>
		</select>
	</td>
</tr>
<?php if(plugin_config_get('gadiv_storypoint_mode') == 0){?>
	<tr <?php echo helper_alternate_class() ?>>
		<td><?php echo plugin_lang_get( 'manage_settings_fibonnaci_numbers' )?> (max. 15)</td>
		<td class="left">
			<select name="gadiv_fibonacci_length">
				<option value="2" <?php if(plugin_config_get('gadiv_fibonacci_length') == 2){?>selected<?php }?>>02 - max. 1</option>
				<option value="3" <?php if(plugin_config_get('gadiv_fibonacci_length') == 3){?>selected<?php }?>>03 - max. 2</option>
				<option value="4" <?php if(plugin_config_get('gadiv_fibonacci_length') == 4){?>selected<?php }?>>04 - max. 3</option>
				<option value="5" <?php if(plugin_config_get('gadiv_fibonacci_length') == 5){?>selected<?php }?>>05 - max. 5</option>
				<option value="6" <?php if(plugin_config_get('gadiv_fibonacci_length') == 6){?>selected<?php }?>>06 - max. 8</option>
				<option value="7" <?php if(plugin_config_get('gadiv_fibonacci_length') == 7){?>selected<?php }?>>07 - max. 13</option>
				<option value="8" <?php if(plugin_config_get('gadiv_fibonacci_length') == 8){?>selected<?php }?>>08 - max. 21</option>
				<option value="9" <?php if(plugin_config_get('gadiv_fibonacci_length') == 9){?>selected<?php }?>>09 - max. 34</option>
				<option value="10" <?php if(plugin_config_get('gadiv_fibonacci_length') == 10){?>selected<?php }?>>10 - max. 55</option>
				<option value="11" <?php if(plugin_config_get('gadiv_fibonacci_length') == 11){?>selected<?php }?>>11 - max. 89</option>
				<option value="12" <?php if(plugin_config_get('gadiv_fibonacci_length') == 12){?>selected<?php }?>>12 - max. 144</option>
				<option value="13" <?php if(plugin_config_get('gadiv_fibonacci_length') == 13){?>selected<?php }?>>13 - max. 233</option>
				<option value="14" <?php if(plugin_config_get('gadiv_fibonacci_length') == 14){?>selected<?php }?>>14 - max. 377</option>
				<option value="15" <?php if(plugin_config_get('gadiv_fibonacci_length') == 15){?>selected<?php }?>>15 - max. 610</option>
			</select>
		</td>
	</tr>
<?php } else {?>
	<input type="hidden" name="gadiv_fibonacci_length" value="<?php echo plugin_config_get('gadiv_fibonacci_length')?>">
<?php }?>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_userstory_unit' )?></td>
	<td class="left">
		<input type="hidden" name="old_userstory_unit_mode" value ="<?php echo plugin_config_get('gadiv_userstory_unit_mode')?>">
		<select name="gadiv_userstory_unit_mode">
			<option value="keine" <?php if(plugin_config_get('gadiv_userstory_unit_mode')=='keine'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_no_unit' )?></option>
			<option value="h" <?php if(plugin_config_get('gadiv_userstory_unit_mode')=='h'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_hours' )?></option>
			<option value="T" <?php if(plugin_config_get('gadiv_userstory_unit_mode')=='T'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_days' )?></option>
			<option value="SP" <?php if(plugin_config_get('gadiv_userstory_unit_mode')=='SP'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_storypoints' )?></option>
		</select>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_task_unit' )?></td>
	<td class="left">
		<input type="hidden" name="old_task_unit_mode" value ="<?php echo plugin_config_get('gadiv_task_unit_mode')?>">
		<select id="gadiv_task_unit_mode" name="gadiv_task_unit_mode" onchange="changeTaskUnit();">
			<option value="keine" <?php if(plugin_config_get('gadiv_task_unit_mode')=='keine'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_no_unit' )?></option>
			<option value="h" <?php if(plugin_config_get('gadiv_task_unit_mode')=='h'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_hours' )?></option>
			<option value="T" <?php if(plugin_config_get('gadiv_task_unit_mode')=='T'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_days' )?></option>
			<option value="SP" <?php if(plugin_config_get('gadiv_task_unit_mode')=='SP'){echo 'selected';}?>><?php echo plugin_lang_get( 'manage_settings_storypoints' )?></option>
		</select>
	</td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo plugin_lang_get( 'manage_settings_workday_length' )?></td>
	<td class="left">
		<input type="text" size="5" maxlength="5" name="gadiv_workday_in_hours" value="<?php echo plugin_config_get('gadiv_workday_in_hours')?>" style="padding-right:5px;text-align:right;">
	</td>
</tr>
<tr class="spacer">
<td></td>
</tr>
<tr>
    <td class="center" colspan=2>
        <input type="submit" name="submit_button" class="button" value="<?php echo plugin_lang_get( 'button_save' )?>">
    </td>
</tr>
</table>
<br>
<table align="center" class="width75" cellspacing="1">
<tr>
	<td colspan="2"><b><?php echo plugin_lang_get( 'manage_settings_additional_fields' )?></b></td>
</tr>
<tr>
	<td class="category"><b><?php echo plugin_lang_get( 'manage_settings_field' )?></b></td>
	<td class="category"><center><b><?php echo plugin_lang_get( 'manage_settings_activate' )?></b></center></td>
	<td class="category"><center><b><?php echo plugin_lang_get( 'button_remove' )?></b></center></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo lang_get( 'RankingOrder' ) ?></td>
	<td class="left"><center><input type="checkbox" id="gadiv_ranking_order" name="gadiv_ranking_order" <?php if(plugin_config_get('gadiv_ranking_order')=='1'){echo 'checked';}?> value="1" onClick="enableButton('gadiv_ranking_order');"></center></td>
	<td><center><input type="submit" id="gadiv_ranking_order_button" name="remove_custom_field[RankingOrder]" class="button" value="<?php echo plugin_lang_get( 'manage_settings_remove_from_project' )?>" <?php if(plugin_config_get('gadiv_ranking_order')=='1'){echo 'disabled';}?> onclick="deleteProjectField('Rangfolge','RankingOrder'); return false;"></center></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo lang_get( 'Presentable' ) ?></td>
	<td class="left"><center><input type="checkbox" id="gadiv_presentable" name="gadiv_presentable" <?php if(plugin_config_get('gadiv_presentable')=='1'){echo 'checked';}?> value="1" onChange="enableButton('gadiv_presentable');"></center></td>
	<td><center><input type="submit" id="gadiv_presentable_button" name="remove_custom_field[Presentable]" class="button" value="<?php echo plugin_lang_get( 'manage_settings_remove_from_project' )?>" <?php if(plugin_config_get('gadiv_presentable')=='1'){echo 'disabled';}?> onclick="deleteProjectField('Präsentabel','Presentable'); return false;"></center></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo lang_get( 'Technical' ) ?></td>
	<td class="left"><center><input type="checkbox" id="gadiv_technical" name="gadiv_technical" <?php if(plugin_config_get('gadiv_technical')=='1'){echo 'checked';}?> value="1" onChange="enableButton('gadiv_technical');"></center></td>
	<td><center><input type="submit" id="gadiv_technical_button" name="remove_custom_field[Technical]" class="button" value="<?php echo plugin_lang_get( 'manage_settings_remove_from_project' )?>" <?php if(plugin_config_get('gadiv_technical')=='1'){echo 'disabled';}?> onclick="deleteProjectField('Technisch','Technical'); return false;"></center></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo lang_get( 'InReleaseDocu' ) ?></td>
	<td class="left"><center><input type="checkbox" id="gadiv_release_documentation"  name="gadiv_release_documentation" <?php if(plugin_config_get('gadiv_release_documentation')=='1'){echo 'checked';}?> value="1" onChange="enableButton('gadiv_release_documentation');"></center></td>
	<td><center><input type="submit" id="gadiv_release_documentation_button" name="remove_custom_field[inReleaseDocu]" class="button" value="<?php echo plugin_lang_get( 'manage_settings_remove_from_project' )?>" <?php if(plugin_config_get('gadiv_release_documentation')=='1'){echo 'disabled';}?> onclick="deleteProjectField('In Freigabedoku','inReleaseDocu'); return false;"></center></td>
</tr>
<tr <?php echo helper_alternate_class() ?>>
	<td><?php echo lang_get( 'PlannedWork' ) ?></td>
	<td class="left"><center><input type="checkbox" id="gadiv_tracker_planned_costs" name="gadiv_tracker_planned_costs" <?php if(plugin_config_get('gadiv_tracker_planned_costs')=='1'){echo 'checked';}?> value="1" onChange="enableButton('gadiv_tracker_planned_costs');"></center></td>
	<td><center><input type="submit" id="gadiv_tracker_planned_costs_button" name="remove_custom_field[PlannedWork]" class="button" value="<?php echo plugin_lang_get( 'manage_settings_remove_from_project' )?>" <?php if(plugin_config_get('gadiv_tracker_planned_costs')=='1'){echo 'disabled';}?> onclick="deleteProjectField('Planaufwand','PlannedWork'); return false;"></center></td>
</tr>
<tr class="spacer">
<td></td>
</tr>
<tr>
    <td class="center" colspan="3">
        <input type="submit" name="submit_button" class="button" value="<?php echo plugin_lang_get( 'button_save' )?>">
    </td>
</tr>
</table>
	<script type="text/javascript" language="javascript">
		// change task unit warning
		function changeTaskUnit(){
			var returnConfirm = confirm("<?php echo plugin_lang_get( 'manage_settings_error_106102' )?>"+"\r\n"+"<?php echo plugin_lang_get( 'manage_settings_error_106102B' )?>"+"\r\n"+"<?php echo plugin_lang_get( 'manage_settings_error_106102C' )?>");
			if(returnConfirm){
				document.getElementById("changeUnit").value = "deleteUnit";
			}
			if(!returnConfirm){
				for(var i = 0; i < document.getElementById("gadiv_task_unit_mode").length; i++){
					if(document.getElementById("gadiv_task_unit_mode").options[i].value == '<?php echo plugin_config_get('gadiv_task_unit_mode') ?>'){
						document.getElementById("gadiv_task_unit_mode").selectedIndex = i;
					}
				}
			}
		}

		// warning, if user really wants to delete the selected custom field
		function deleteProjectField(fieldname,fieldname_database){
			var returnConfirm = confirm("Möchten Sie das Feld '"+fieldname+"' wirklich löschen?");
			if(returnConfirm){
				document.getElementById("deleteField").value = fieldname_database;
				document.getElementById("config_form").submit();
			}
		}

		// enables agileMantis custom field delete button
		function enableButton(fieldname){
			var fieldname2 = fieldname+'_button';
			if(document.getElementById(fieldname2).disabled == true){
				document.getElementById(fieldname2).disabled = false;
			} else {
				document.getElementById(fieldname2).disabled = true;
			}
			if(document.getElementById(fieldname).readOnly == true){
				document.getElementById(fieldname).readOnly = false;
			} else {
				document.getElementById(fieldname).readOnly = true;
			}
			if(fieldname == "gadiv_ranking_order"){
				if(document.getElementById(fieldname2).disabled == false && fieldname == "gadiv_ranking_order"){
					document.getElementById("show_rankingorder").disabled = true;
				} else {
					document.getElementById("show_rankingorder").disabled = false;
				}
			}
		}
	</script>
</form>
<?php
	} else {
?>
		<br>
			<center><span style="color:red; font-size:16px; font-weight:bold;"><?php echo plugin_lang_get( 'manage_settings_error_921100' )?></span></center>
<?php
	}
?>
<?php html_page_bottom() ?>