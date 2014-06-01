<?php

$num_columns	= 12;
$can_delete	= $this->auth->has_permission('Devices.Reports.Delete');
$can_edit		= $this->auth->has_permission('Devices.Reports.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>
<div class="admin-box">
	<h3>Devices</h3>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>Name</th>
					<th>Model Number</th>
					<th>Device Image</th>
					<th>Carrier</th>
					<th>Stock Software Version</th>
					<th>Bootloader Exploit</th>
					<th>Partition Map</th>
					<th>Freegee Maintainers</th>
					<th>Actions</th>
					<th>Build.prop Device ID</th>
					<th>Build.prop Software ID</th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('devices_delete_confirm'))); ?>')" />
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
					<td><?php echo anchor(SITE_AREA . '/reports/devices/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->name); ?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td><?php e($record->model) ?></td>
					<td><?php e($record->image) ?></td>
					<td><?php e($record->carrier) ?></td>
					<td><?php e($record->firmware) ?></td>
					<td><?php e($record->bootloader_exploit) ?></td>
					<td><?php e($record->partition_map) ?></td>
					<td><?php e($record->maintainers) ?></td>
					<td><?php e($record->actions) ?></td>
					<td><?php e($record->buildprop_id) ?></td>
					<td><?php e($record->buildprop_sw_id) ?></td>
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