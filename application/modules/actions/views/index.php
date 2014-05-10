<div>
	<h1 class="page-header">Actions</h1>
</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				
		<th>Name</th>
		<th>Description</th>
		<th>Minimum API Version</th>
		<th>Zip File Name</th>
		<th>Zip File Location</th>
		<th>md5sum</th>
		<th>Stock Only</th>
		<th>Hidden</th>
		<th>Priority</th>
		<th>Action Dependencies</th>
		<th>Success Message</th>
		<th>Reboot to Recovery Required for action</th>
			</tr>
		</thead>
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td>
						<?php if ($field == 'deleted'): ?>
							<?php e(($value > 0) ? lang('actions_true') : lang('actions_false')); ?>
						<?php else: ?>
							<?php e($value); ?>
						<?php endif ?>
					</td>
				<?php endif; ?>
				
			<?php endforeach; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>