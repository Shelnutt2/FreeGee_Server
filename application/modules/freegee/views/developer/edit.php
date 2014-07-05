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

if (isset($freegee))
{
	$freegee = (array) $freegee;
}
$id = isset($freegee['id']) ? $freegee['id'] : '';

?>
<div class="admin-box">
	<h3>FreeGee</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('api_version') ? 'error' : ''; ?>">
				<?php echo form_label('API Version'. lang('bf_form_label_required'), 'freegee_api_version', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='freegee_api_version' type='text' name='freegee_api_version'  value="<?php echo set_value('freegee_api_version', isset($freegee['api_version']) ? $freegee['api_version'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('api_version'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('min_client') ? 'error' : ''; ?>">
				<?php echo form_label('Minimum Supported Client Version'. lang('bf_form_label_required'), 'freegee_min_client', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='freegee_min_client' type='text' name='freegee_min_client' maxlength="32" value="<?php echo set_value('freegee_min_client', isset($freegee['min_client']) ? $freegee['min_client'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('min_client'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('freegee_action_edit'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/developer/freegee', lang('freegee_cancel'), 'class="btn btn-warning"'); ?>
				
			<?php if ($this->auth->has_permission('FreeGee.Developer.Delete')) : ?>
				or
				<button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php e(js_escape(lang('freegee_delete_confirm'))); ?>'); ">
					<span class="icon-trash icon-white"></span>&nbsp;<?php echo lang('freegee_delete_record'); ?>
				</button>
			<?php endif; ?>
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>