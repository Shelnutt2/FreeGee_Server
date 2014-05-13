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

if (isset($action_dependencies))
{
	$action_dependencies = (array) $action_dependencies;
}
$id = isset($action_dependencies['id']) ? $action_dependencies['id'] : '';

?>
<div class="admin-box">
	<h3>Action Dependencies</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('base_id') ? 'error' : ''; ?>">
				<?php echo form_label('Base Action ID'. lang('bf_form_label_required'), 'action_dependencies_base_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='action_dependencies_base_id' type='text' name='action_dependencies_base_id'  value="<?php echo set_value('action_dependencies_base_id', isset($action_dependencies['base_id']) ? $action_dependencies['base_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('base_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('base_name') ? 'error' : ''; ?>">
				<?php echo form_label('Base Action Name'. lang('bf_form_label_required'), 'action_dependencies_base_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='action_dependencies_base_name' type='text' name='action_dependencies_base_name'  value="<?php echo set_value('action_dependencies_base_name', isset($action_dependencies['base_name']) ? $action_dependencies['base_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('base_name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('dependency_id') ? 'error' : ''; ?>">
				<?php echo form_label('Dependency Action ID'. lang('bf_form_label_required'), 'action_dependencies_dependency_id', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='action_dependencies_dependency_id' type='text' name='action_dependencies_dependency_id'  value="<?php echo set_value('action_dependencies_dependency_id', isset($action_dependencies['dependency_id']) ? $action_dependencies['dependency_id'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('dependency_id'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('dependency_name') ? 'error' : ''; ?>">
				<?php echo form_label('Dependency Action Name'. lang('bf_form_label_required'), 'action_dependencies_dependency_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='action_dependencies_dependency_name' type='text' name='action_dependencies_dependency_name'  value="<?php echo set_value('action_dependencies_dependency_name', isset($action_dependencies['dependency_name']) ? $action_dependencies['dependency_name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('dependency_name'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('action_dependencies_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/action_dependencies', lang('action_dependencies_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>