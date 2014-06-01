<div>
	<h1 class="page-header">Devices</h1>
</div>

<br />

<?php if (isset($records) && is_array($records) && count($records)) : ?>
				
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				
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
		<tbody>
		
		<?php foreach ($records as $record) : ?>
			<?php $record = (array)$record;?>
			<tr>
			<?php foreach($record as $field => $value) : ?>
				
				<?php if ($field != 'id') : ?>
					<td>
						<?php if ($field == 'deleted'): ?>
							<?php e(($value > 0) ? lang('devices_true') : lang('devices_false')); ?>
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