<?php

$num_columns	= 14;
$can_delete	= $this->auth->has_permission('Actions.Content.Delete');
$can_edit		= $this->auth->has_permission('Actions.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Actions</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Name</th>
					<th>Description</th>
					<th>Category</th>
					<th>Minimum API Version</th>
					<th>Zip File Name</th>
					<th>Zip File Location</th>
					<th>md5sum</th>
					<th>Stock Only</th>
					<th>Hidden</th>
					<th>Stock SW Versions</th>
					<th>Android API Versions</th>
					<th>Priority</th>
					<th>Action Dependencies</th>
					<th>Pre Preform Message</th>
					<th>Success Message</th>
					<th>Reboot to Recovery Required for action</th>
					<th>Beta Feed Only</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('actions_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/actions/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->name); ?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td><?php e($record->description) ?></td>
					<td><?php e($record->category) ?></td>
					<td><?php e($record->minapiversion) ?></td>
					<td><?php e($record->zipfile) ?></td>
					<td><?php e($record->zipfilelocation) ?></td>
					<td><?php e($record->md5sum) ?></td>
					<td><?php e($record->stockonly) ?></td>
					<td><?php e($record->hidden) ?></td>
					<td><?php e($record->swversions) ?></td>
					<td><?php e($record->androidsdkversion) ?></td>
					<td><?php e($record->priority) ?></td>
					<td><?php $this->load->model('actions_model'); if($record->dependencies == 1){
						$outString = '';
						foreach(json_decode(json_encode($this->actions_model->get_dependencies_by_name($record->name))) as $dep_id => $dep){
							$array = get_object_vars($dep);
							$outString .= ($array['dependency_name'].", ");
						}
						e(strrev(implode(strrev(''), explode(',', strrev($outString), 2))));
					} ?></td>
					<td><?php e($record->premessage) ?></td>
					<td><?php e($record->successmessage) ?></td>
					<td><?php e($record->rebootrecovery) ?></td>
					<td><?php e($record->betaonly) ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
</div>