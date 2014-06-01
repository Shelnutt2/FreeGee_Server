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

if (isset($device_actions))
{
	$device_actions = (array) $device_actions;
}
$id = isset($device_actions['id']) ? $device_actions['id'] : '';

?>
<div class="admin-box">
	<h3>Device Actions</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('device_model') ? 'error' : ''; ?>">
				<?php echo form_label('Device Model'. lang('bf_form_label_required'), 'device_actions_device_model', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='device_actions_device_model' type='text' name='device_actions_device_model'  value="<?php echo set_value('device_actions_device_model', isset($device_actions['device_model']) ? $device_actions['device_model'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('device_model'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('device_name') ? 'error' : ''; ?>">
				<?php echo form_label('Device Name'. lang('bf_form_label_required'), 'device_actions_device_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='device_actions_device_name' type='text' name='device_actions_device_name'  value="<?php echo set_value('device_actions_device_name', isset($device_actions['device_name']) ? $device_actions['device_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('device_name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('action_id') ? 'error' : ''; ?>">
				<?php echo form_label('Action ID'. lang('bf_form_label_required'), 'device_actions_action_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='device_actions_action_id' type='text' name='device_actions_action_id'  value="<?php echo set_value('device_actions_action_id', isset($device_actions['action_id']) ? $device_actions['action_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('action_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('action_name') ? 'error' : ''; ?>">
				<?php echo form_label('Action Name'. lang('bf_form_label_required'), 'device_actions_action_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='device_actions_action_name' type='text' name='device_actions_action_name'  value="<?php echo set_value('device_actions_action_name', isset($device_actions['action_name']) ? $device_actions['action_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('action_name'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('device_actions_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/device_actions', lang('device_actions_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('Device_Actions.Content.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('device_actions_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('device_actions_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>