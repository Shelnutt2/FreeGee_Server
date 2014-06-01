<?php

$validation_errors = validation_errors();

if ($validation_errors) :
?>
<div class="alert alert-block alert-error fade in">
	<a class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading">Please fix the following errors:</h4>
	<?php echo $validation_errors; ?>
</div>
<?php
endif;

if (isset($devices))
{
	$devices = (array) $devices;
}
$id = isset($devices['id']) ? $devices['id'] : '';

?>
<div class="admin-box">
	<h3>Devices</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label('Name'. lang('bf_form_label_required'), 'devices_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_name' type='text' name='devices_name'  value="<?php echo set_value('devices_name', isset($devices['name']) ? $devices['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('model') ? 'error' : ''; ?>">
				<?php echo form_label('Model Number'. lang('bf_form_label_required'), 'devices_model', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_model' type='text' name='devices_model'  value="<?php echo set_value('devices_model', isset($devices['model']) ? $devices['model'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('model'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('image') ? 'error' : ''; ?>">
				<?php echo form_label('Device Image', 'devices_image', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_image' type='text' name='devices_image'  value="<?php echo set_value('devices_image', isset($devices['image']) ? $devices['image'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('image'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('carrier') ? 'error' : ''; ?>">
				<?php echo form_label('Carrier'. lang('bf_form_label_required'), 'devices_carrier', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_carrier' type='text' name='devices_carrier'  value="<?php echo set_value('devices_carrier', isset($devices['carrier']) ? $devices['carrier'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('carrier'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('firmware') ? 'error' : ''; ?>">
				<?php echo form_label('Stock Software Version', 'devices_firmware', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_firmware' type='text' name='devices_firmware'  value="<?php echo set_value('devices_firmware', isset($devices['firmware']) ? $devices['firmware'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('firmware'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('bootloader_exploit') ? 'error' : ''; ?>">
				<?php echo form_label('Bootloader Exploit', '', array('class' => 'control-label', 'id' => 'devices_bootloader_exploit_label') ); ?>
				<div class='controls' aria-labelled-by='devices_bootloader_exploit_label'>
					<label class='radio' for='devices_bootloader_exploit_option1'>
						<input id='devices_bootloader_exploit_option1' name='devices_bootloader_exploit' type='radio' class='' value='option1' <?php echo set_radio('devices_bootloader_exploit', 'option1', TRUE); ?> />
						Radio option 1
					</label>
					<label class='radio' for='devices_bootloader_exploit_option2'>
						<input id='devices_bootloader_exploit_option2' name='devices_bootloader_exploit' type='radio' class='' value='option2' <?php echo set_radio('devices_bootloader_exploit', 'option2'); ?> />
						Radio option 2
					</label>
					<span class='help-inline'><?php echo form_error('bootloader_exploit'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('partition_map') ? 'error' : ''; ?>">
				<?php echo form_label('Partition Map', 'devices_partition_map', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_partition_map' type='text' name='devices_partition_map'  value="<?php echo set_value('devices_partition_map', isset($devices['partition_map']) ? $devices['partition_map'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('partition_map'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('maintainers') ? 'error' : ''; ?>">
				<?php echo form_label('Freegee Maintainers'. lang('bf_form_label_required'), 'devices_maintainers', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='devices_maintainers'>
						<input type='checkbox' id='devices_maintainers' name='devices_maintainers' value='1' <?php echo (isset($devices['maintainers']) && $devices['maintainers'] == 1) ? 'checked="checked"' : set_checkbox('devices_maintainers', 1); ?>>
						<span class='help-inline'><?php echo form_error('maintainers'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('actions') ? 'error' : ''; ?>">
				<?php echo form_label('Actions', 'devices_actions', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='devices_actions'>
						<input type='checkbox' id='devices_actions' name='devices_actions' value='1' <?php echo (isset($devices['actions']) && $devices['actions'] == 1) ? 'checked="checked"' : set_checkbox('devices_actions', 1); ?>>
						<span class='help-inline'><?php echo form_error('actions'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('buildprop_id') ? 'error' : ''; ?>">
				<?php echo form_label('Build.prop Device ID'. lang('bf_form_label_required'), 'devices_buildprop_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_buildprop_id' type='text' name='devices_buildprop_id'  value="<?php echo set_value('devices_buildprop_id', isset($devices['buildprop_id']) ? $devices['buildprop_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('buildprop_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('buildprop_sw_id') ? 'error' : ''; ?>">
				<?php echo form_label('Build.prop Software ID', 'devices_buildprop_sw_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='devices_buildprop_sw_id' type='text' name='devices_buildprop_sw_id'  value="<?php echo set_value('devices_buildprop_sw_id', isset($devices['buildprop_sw_id']) ? $devices['buildprop_sw_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('buildprop_sw_id'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('devices_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/devices', lang('devices_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>