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

	# check wether sprint backlog or taskboard is called
	$_GET['page'] = str_replace('agileMantis/','',$_GET['page']);
	$page_name = str_replace('.php','',$_GET['page']);

	# set sprint backlog or taskboard header title, button textes and links
	if($page_name == 'sprint_backlog'){$header_title = plugin_lang_get( 'sprint_backlog_title' );$switch_button_text = 'Taskboard'; $switch_button_tag = 'taskboard';$switch_form_link = 'taskboard.php';}
	if($page_name == 'taskboard'){$header_title = plugin_lang_get( 'taskboard_title' );$switch_button_text = 'Sprint Backlog'; $switch_button_tag = 'sprint_backlog';$switch_form_link = 'sprint_backlog.php';}
	if($page_name == 'daily_scrum_meeting'){$header_title = 'Daily Scrum Taskboard';$switch_button_text = 'Taskboard'; $switch_button_tag = 'taskboard';$switch_form_link = 'sprint_backlog.php';}
?>
<table align="center" class="width100" cellspacing="1">
	<tr>
		<td colspan="7">
			<b><?php echo $header_title?></b>
			<form action="<?php echo plugin_page("availability.php")?>" method="post">
				<input type="hidden" name="team_id" value="<?php echo $s['team_id']?>">
				<input type="hidden" name="month" value="2">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<?php if($page_name == 'sprint_backlog'){?>
					<input type="hidden" name="fromSprintBacklog" value="1">
				<?php }?>
				<?if($page_name == 'taskboard'){?>
					<input type="hidden" name="fromTaskboard" value="1">
				<?php } ?>
				<?if($page_name == 'daily_scrum_meeting'){?>
					<input type="hidden" name="fromDailyScrum" value="1">
				<?php } ?>
				<?php
					# get all team developer
					$team->id = $s['team_id'];
					$team_member = $team->getTeamDeveloper();
					if(!empty($team_member)){
						foreach($team_member AS $num => $row){
							if($row['id'] > 0){?>
							<input type="hidden" name="kalender[<?php echo $row['id']?>]" value="Open Calender">
				<?php
							}
						}
					}
				?>
				<input type="submit" name="manage_availability" value="<?php echo plugin_lang_get( 'sprint_backlog_availability' )?>" <?php echo $disable_button?>>
			</form>
			<form action="<?php echo plugin_page("capacity.php")?>" method="post">
				<input type="hidden" name="sprint" value="<?php echo $s['name']?>">
				<?php if($page_name == 'sprint_backlog'){?>
					<input type="hidden" name="fromSprintBacklog" value="1">
				<?php }?>
				<?if($page_name == 'taskboard'){?>
					<input type="hidden" name="fromTaskboard" value="1">
				<?php } ?>
				<?if($page_name == 'daily_scrum_meeting'){?>
					<input type="hidden" name="fromDailyScrum" value="1">
				<?php } ?>
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="hidden" name="start" value="<?php echo date('d.m.Y',$s['start'])?>">
				<input type="hidden" name="end" value="<?php echo date('d.m.Y',$s['end'])?>">
				<input type="hidden" name="team" value="<?php echo $s['team_id']?>">
				<input type="hidden" name="submit_button" value="Zu den Entwicklungskapazitäten">
				<input type="submit" name="manage_developer_capacities" value="<?php echo plugin_lang_get( 'sprint_backlog_capacity' )?>" <?php echo $disable_button?>>
			</form>
			<form action="<?php echo plugin_page("assume_userstories.php")?>" method="post">
				<input type="hidden" name="product_backlog" value="<?php echo $sprint->getProductBacklogByTeam($s['team_id']);?>">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="hidden" name="fromPage" value="<?php echo $_GET['page']?>">
				<?if($page_name == 'taskboard'){?>
					<input type="hidden" name="fromTaskboard" value="1">
				<?php } ?>
				<?if($page_name == 'daily_scrum_meeting'){?>
					<input type="hidden" name="fromDailyScrum" value="1">
				<?php } ?>
				<input type="submit" name="assume_userstories" value="<?php echo plugin_lang_get( 'sprint_backlog_assume_userstory' )?>" <?php echo $disable_button?>>
			</form>
			<form action="<?php echo plugin_page($switch_form_link)?>" method="post">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="submit" name="<?php echo $switch_button_tag?>" value="<?php echo $switch_button_text?>" <?php if($page_name == 'daily_scrum_meeting'){?>disabled<?php }?>>
			</form>
			<form action="<?php echo plugin_page("statistics.php")?>" method="post" target="_blank">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="submit" name="statistics" value="<?php echo plugin_lang_get( 'statistics_title' )?>">
			</form>
		</td>
	</tr>
</table>
<br>
<table align="center" class="width100" cellspacing="1">
	<tr>
		<td colspan="7">
			<b>Sprint</b>
			<form action="<?php echo plugin_page("edit_sprint.php")?>" method="post">
				<input type="hidden" name="id" value="<?php echo $s['id']?>">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<?php if($page_name == 'sprint_backlog'){?>
					<input type="hidden" name="fromSprintBacklog" value="1">
				<?php }?>
				<?if($page_name == 'taskboard'){?>
					<input type="hidden" name="fromTaskboard" value="1">
				<?php } ?>
				<?if($page_name == 'daily_scrum_meeting'){?>
					<input type="hidden" name="fromDailyScrum" value="1">
				<?php } ?>
				<input type="submit" name="edit_sprint" value="<?php echo plugin_lang_get( 'sprint_backlog_edit_sprint' )?>" <?php echo $disable_button?>>
			</form>
			<?php 
				if($s['status']!=1 && $s['start'] - 86400 <= time() && (time() <= $s['end'] || $s['start'] + 86400 > $s['end']) && $sprint->previousSprintIsClosed($s['team_id'], $sprint->sprint_id) == true){
					$disabled = '';
				} else {
					$disabled = 'disabled';
				}
			?>
			<?php if($still_tasks_without_planning == true){?>
			<form action="<?php echo plugin_page($_GET['page'])?>" method="post">
				<input type="hidden" name="id" value="<?php echo $s['id']?>">
				<input type="hidden" name="name" value="<?php echo $s['name']?>">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="hidden" name="preConfirmSprint" value="" id="preConfirmSprint">
				<input type="submit" name="preconfirm_sprint" value="<?php echo plugin_lang_get( 'sprint_backlog_confirm_sprint' )?>" onClick="acceptSprintPreConfirm();" <?php echo $disabled?> <?php echo $disable?> <?php echo $disable_button?> <?php echo $disable_confirm_button?>>
			</form>
			<?php } else {?>
			<form action="<?php echo plugin_page($_GET['page'])?>" method="post">
				<input type="hidden" name="id" value="<?php echo $s['id']?>">
				<input type="hidden" name="name" value="<?php echo $s['name']?>">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="hidden" name="confirmSprint" value="" id="confirmSprint">
				<input type="submit" name="confirm_sprint" value="<?php echo plugin_lang_get( 'sprint_backlog_confirm_sprint' )?>" onClick="acceptSprintConfirm();" <?php echo $disabled?> <?php echo $disable?> <?php echo $disable_button?> <?php echo $disable_confirm_button?>>
			</form>
			<?php }?>
			<?php 
			$disable_copy = 'disabled';
			$disable_close = 'disabled';
			if($s['status']!=0 && $s['status']!=2 && $sprint->allTasksAndStoriesAreClosed($s['name']) == false && ( time() >= $s['end'] || $s['start'] + 86400 > $s['end'])){
				$disable_copy = '';
			} elseif($s['status']!=0 && $s['status']!=2 && $sprint->allTasksAndStoriesAreClosed($s['name']) == true && ( time() >= $s['end']  || $s['start'] + 86400 > $s['end'])){
				$disable_close = '';
			}?>
			<form action="<?php echo plugin_page($_GET['page'])?>" method="post">
				<input type="hidden" name="closeUserStories" id="closeUserStories" value="">
				<input type="hidden" name="id" value="<?php echo $s['id']?>">
				<input type="hidden" name="name" value="<?php echo $s['name']?>">
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="submit" name="close_sprint" value="<?php echo plugin_lang_get( 'sprint_backlog_close_sprint_button' )?>" onClick="confirmCloseUserstories();" <?php echo $disable_close?> <?php echo $disable?> <?php echo $disable_button?>>
			</form>
			<form action="<?php echo plugin_page('divide_userstories.php')?>" method="post">
				<input type="hidden" name="sprint_id" value="<?php echo $s['id']?>">
				<input type="hidden" name="name" value="<?php echo $s['name']?>">
				<input type="hidden" name="fromPage" value="<?php echo $page_name?>">
				<?if($page_name == 'taskboard'){?>
					<input type="hidden" name="fromTaskboard" value="1">
				<?php } ?>
				<?if($page_name == 'daily_scrum_meeting'){?>
					<input type="hidden" name="fromDailyScrum" value="1">
				<?php } ?>
				<input type="hidden" name="sprintName" value="<?php echo $s['name']?>">
				<input type="hidden" name="team_id" value="<?php echo $s['team_id']?>">
				<input type="submit" name="copy_userstories" value="<?php echo plugin_lang_get( 'sprint_backlog_divide_userstories' )?>" <?php echo $disable_copy?> <?php echo $disable?> <?php echo $disable_button?>>
			</form>
			<form action="<?php echo plugin_page($_GET['page'])?>" method="post">
				<input type="submit" name="chose_sprint" value="<?php echo plugin_lang_get( 'sprint_backlog_chose_sprint' )?>">
			</form>
		</td>
	</tr>
	<tr>
		<td class="category">Sprint</td>
		<td class="category"><?php echo plugin_lang_get( 'sprint_backlog_begin' )?></td>
		<td class="category"><?php echo plugin_lang_get( 'sprint_backlog_end' )?></td>
		<td class="category">Story Points</td>
		<td class="category"><?php echo plugin_lang_get( 'sprint_backlog_rest' )?></td>
		<td class="category"><?php echo plugin_lang_get( 'sprint_backlog_restB' )?> <?php echo $unit?></td>
		<td class="category"><?php echo plugin_lang_get( 'sprint_backlog_restC' )?> (h)</td>
		<td class="category">Team</td>
		<td class="category">Product Backlog</td>
	</tr>
	<?php
		# sprint status colours 
		switch ($s['status']){
			default:
			case '0':
				$bgcolor = '#fcbdbd';
			break;
			case '1':
				$bgcolor = '#C2DFFF';
			break;
			case '2':
				$bgcolor = '#c9ccc4';
			break;
		}
		$sprint->id = $s['pb_id'];
		$productBacklog = $sprint->getSelectedProductBacklog();
	?>
	<tr style="background-color:<?php echo $bgcolor;?>">
		<td><?php echo $s['name']?></td>
		<td><?php echo date('d.m.Y',$s['start']) ?></td>
		<td><?php echo date('d.m.Y',$s['end']) ?></td>
		<td><?php echo $gesamt_storypoints?></td>
		<td><?php echo $anzahl_tage?> <?php echo plugin_lang_get( 'days' )?></td>
		<td><?php echo $span_left?><?php echo sprintf("%.2f",$planned_capacity)?><?php echo $span_right?></td>
		<td><?php echo $span_left?><?php echo sprintf("%.2f",$capacity)?><?php echo $span_right?></td>
		<td><?php echo $sprint->getTeamById($s['team_id']);?></td>
		<td><?php echo $productBacklog[0]['name']?></td>
	</tr>
	<?php if(!empty($s['description'])){?>
		<tr>
			<td class="category" colspan="9"><b><?php echo plugin_lang_get( 'sprint_backlog_sprint_goal' )?></b></td>
		</tr>
		<tr style="background-color:<?php echo $bgcolor;?>">
			<td colspan="9">
				<?php echo nl2br($s['description'])?>
			</td>
		</tr>
	<?php }?>
</table>