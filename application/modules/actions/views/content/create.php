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

if (isset($actions))
{
	$actions = (array) $actions;
}
$id = isset($actions['id']) ? $actions['id'] : '';

?>
<div class="admin-box">
	<h3>Actions</h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
		<fieldset>

			<div class="control-group <?php echo form_error('name') ? 'error' : ''; ?>">
				<?php echo form_label('Name'. lang('bf_form_label_required'), 'actions_name', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_name' type='text' name='actions_name'  value="<?php echo set_value('actions_name', isset($actions['name']) ? $actions['name'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('name'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
				<?php echo form_label('Description'. lang('bf_form_label_required'), 'actions_description', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_description' type='text' name='actions_description'  value="<?php echo set_value('actions_description', isset($actions['description']) ? $actions['description'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('description'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('minapiversion') ? 'error' : ''; ?>">
				<?php echo form_label('Minimum API Version'. lang('bf_form_label_required'), 'actions_minapiversion', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_minapiversion' type='text' name='actions_minapiversion'  value="<?php echo set_value('actions_minapiversion', isset($actions['minapiversion']) ? $actions['minapiversion'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('minapiversion'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('zipfile') ? 'error' : ''; ?>">
				<?php echo form_label('Zip File Name'. lang('bf_form_label_required'), 'actions_zipfile', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_zipfile' type='text' name='actions_zipfile'  value="<?php echo set_value('actions_zipfile', isset($actions['zipfile']) ? $actions['zipfile'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('zipfile'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('zipfilelocation') ? 'error' : ''; ?>">
				<?php echo form_label('Zip File Location'. lang('bf_form_label_required'), 'actions_zipfilelocation', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_zipfilelocation' type='text' name='actions_zipfilelocation'  value="<?php echo set_value('actions_zipfilelocation', isset($actions['zipfilelocation']) ? $actions['zipfilelocation'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('zipfilelocation'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('md5sum') ? 'error' : ''; ?>">
				<?php echo form_label('md5sum'. lang('bf_form_label_required'), 'actions_md5sum', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_md5sum' type='text' name='actions_md5sum' maxlength="32" value="<?php echo set_value('actions_md5sum', isset($actions['md5sum']) ? $actions['md5sum'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('md5sum'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('stockonly') ? 'error' : ''; ?>">
				<?php echo form_label('Stock Only'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_stockonly_label') ); ?>
				<div class='controls' aria-labelled-by='actions_stockonly_label'>
					<label class='radio' for='actions_stockonly_option1'>
						<input id='actions_stockonly_option1' name='actions_stockonly' type='radio' class='' value='1' <?php echo set_radio('actions_stockonly', TRUE, TRUE); ?> />
						True
					</label>
					<label class='radio' for='actions_stockonly_option2'>
						<input id='actions_stockonly_option2' name='actions_stockonly' type='radio' class='' value='0' <?php echo set_radio('actions_stockonly', FALSE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('stockonly'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('hidden') ? 'error' : ''; ?>">
				<?php echo form_label('Hidden'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_hidden_label') ); ?>
				<div class='controls' aria-labelled-by='actions_hidden_label'>
					<label class='radio' for='actions_hidden_option1'>
						<input id='actions_hidden_option1' name='actions_hidden' type='radio' class='' value='1' <?php echo set_radio('actions_hidden', TRUE, TRUE); ?> />
						True
					</label>
					<label class='radio' for='actions_hidden_option2'>
						<input id='actions_hidden_option2' name='actions_hidden' type='radio' class='' value='0' <?php echo set_radio('actions_hidden', FALSE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('hidden'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('priority') ? 'error' : ''; ?>">
				<?php echo form_label('Priority'. lang('bf_form_label_required'), 'actions_priority', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_priority' type='text' name='actions_priority'  value="<?php echo set_value('actions_priority', isset($actions['priority']) ? $actions['priority'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('priority'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('dependencies') ? 'error' : ''; ?>">
				<?php echo form_label('Action Dependencies'. lang('bf_form_label_required'), 'actions_dependencies', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<label class='checkbox' for='actions_dependencies'>
						<input type='checkbox' id='actions_dependencies' name='actions_dependencies' value='1' <?php echo (isset($actions['dependencies']) && $actions['dependencies'] == 1) ? 'checked="checked"' : set_checkbox('actions_dependencies', 1); ?>>
						<span class='help-inline'><?php echo form_error('dependencies'); ?></span>
					</label>
				</div>
			</div>

			<div class="control-group <?php echo form_error('successmessage') ? 'error' : ''; ?>">
				<?php echo form_label('Success Message'. lang('bf_form_label_required'), 'actions_successmessage', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_successmessage' type='text' name='actions_successmessage'  value="<?php echo set_value('actions_successmessage', isset($actions['successmessage']) ? $actions['successmessage'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('successmessage'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('rebootrecovery') ? 'error' : ''; ?>">
				<?php echo form_label('Reboot to Recovery Required for action'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_rebootrecovery_label') ); ?>
				<div class='controls' aria-labelled-by='actions_rebootrecovery_label'>
					<label class='radio' for='actions_rebootrecovery_option1'>
						<input id='actions_rebootrecovery_option1' name='actions_rebootrecovery' type='radio' class='' value='1' <?php echo set_radio('actions_rebootrecovery', TRUE, TRUE); ?> />
						True
					</label>
					<label class='radio' for='actions_rebootrecovery_option2'>
						<input id='actions_rebootrecovery_option2' name='actions_rebootrecovery' type='radio' class='' value='0' <?php echo set_radio('actions_rebootrecovery', FALSE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('rebootrecovery'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('actions_action_create'); ?>"  />
				<?php echo lang('bf_or'); ?>
				<?php echo anchor(SITE_AREA .'/content/actions', lang('actions_cancel'), 'class="btn btn-warning"'); ?>
				
			</div>
		</fieldset>
    <?php echo form_close(); ?>
</div>