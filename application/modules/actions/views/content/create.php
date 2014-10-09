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
			
			<div class="control-group <?php echo form_error('category') ? 'error' : ''; ?>">
				<?php echo form_label('category'. lang('bf_form_label_required'), 'actions_category', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_category' type='text' name='actions_category'  value="<?php echo set_value('actions_category', isset($actions['category']) ? $actions['category'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('category'); ?></span>
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
					<input id='actions_zipfile' type='text' name='actions_zipfile' value="<?php echo set_value('actions_zipfile', isset($actions['zipfile']) ? $actions['zipfile'] : ''); ?>" />
					<button type="button" onclick="openKCFinder(actions_zipfile,actions_zipfilelocation)">Select or Upload Action Zip</button>
					<span class='help-inline'><?php echo form_error('zipfile'); ?></span>
					<script type="text/javascript">
					function openKCFinder(field, field2) {
					    window.KCFinder = {
					        callBack: function(url) {
					            field.value = url.replace(/^.*(\\|\/|\:)/, '');
					            field2.value = url;
					            window.KCFinder = null;
					        }
					    };
					    window.open('/public/kcfinder/browse.php?type=zips&dir=public/actions', 'kcfinder_textbox',
					        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
					        'resizable=1, scrollbars=0, width=800, height=600'
					    );
					}

					</script>
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
				<?php echo form_label('md5sum', 'actions_md5sum', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_md5sum' type='text' name='actions_md5sum' maxlength="32" value="<?php echo set_value('actions_md5sum', isset($actions['md5sum']) ? $actions['md5sum'] : ''); ?>" readonly />
					<span class='help-inline'><?php echo form_error('md5sum'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('stockonly') ? 'error' : ''; ?>">
				<?php echo form_label('Stock Only'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_stockonly_label') ); ?>
				<div class='controls' aria-labelled-by='actions_stockonly_label'>
					<label class='radio' for='actions_stockonly_option1'>
						<input id='actions_stockonly_option1' name='actions_stockonly' type='radio' class='' value='1' <?php echo set_radio('actions_stockonly', TRUE, FALSE); ?> />
						True
					</label>
					<label class='radio' for='actions_stockonly_option2'>
						<input id='actions_stockonly_option2' name='actions_stockonly' type='radio' class='' value='0' <?php echo set_radio('actions_stockonly', FALSE, TRUE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('stockonly'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('hidden') ? 'error' : ''; ?>">
				<?php echo form_label('Hidden'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_hidden_label') ); ?>
				<div class='controls' aria-labelled-by='actions_hidden_label'>
					<label class='radio' for='actions_hidden_option1'>
						<input id='actions_hidden_option1' name='actions_hidden' type='radio' class='' value='1' <?php echo set_radio('actions_hidden', TRUE, FALSE); ?> />
						True
					</label>
					<label class='radio' for='actions_hidden_option2'>
						<input id='actions_hidden_option2' name='actions_hidden' type='radio' class='' value='0' <?php echo set_radio('actions_hidden', FALSE, TRUE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('hidden'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('swversions') ? 'error' : ''; ?>">
				<?php echo form_label('swversions', 'actions_swversions', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_swversions' type='text' name='actions_swversions' value="<?php echo set_value('actions_swversions', isset($actions['swversions']) ? $actions['swversions'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('swversions'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('androidsdkversion') ? 'error' : ''; ?>">
				<?php echo form_label('androidsdkversion', 'actions_androidsdkversion', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_androidsdkversion' type='text' name='actions_androidsdkversion' value="<?php echo set_value('actions_androidsdkversion', isset($actions['androidsdkversion']) ? $actions['androidsdkversion'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('androidsdkversion'); ?></span>
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
				<?php echo form_label('Action Dependencies', 'actions_dependencies', array('class' => 'control-label') ); ?>
				<div class='controls'>
						<?php $this->load->model('actions/actions_model'); echo $this->actions_model->createOptions('actions_dependencies[]', $this->actions_model->find_all_names(), array(), 'checkbox'); ?> 
				</div>
			</div>

			<div class="control-group <?php echo form_error('premessage') ? 'error' : ''; ?>">
				<?php echo form_label('Pre Perform Message', 'actions_premessage', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_premessage' type='text' name='actions_premessage'  value="<?php echo set_value('actions_premessage', isset($actions['premessage']) ? $actions['premessage'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('premessage'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('successmessage') ? 'error' : ''; ?>">
				<?php echo form_label('Success Message', 'actions_successmessage', array('class' => 'control-label') ); ?>
				<div class='controls'>
					<input id='actions_successmessage' type='text' name='actions_successmessage'  value="<?php echo set_value('actions_successmessage', isset($actions['successmessage']) ? $actions['successmessage'] : ''); ?>" />
					<span class='help-inline'><?php echo form_error('successmessage'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('rebootrecovery') ? 'error' : ''; ?>">
				<?php echo form_label('Reboot to Recovery Required for action?'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_rebootrecovery_label') ); ?>
				<div class='controls' aria-labelled-by='actions_rebootrecovery_label'>
					<label class='radio' for='actions_rebootrecovery_option1'>
						<input id='actions_rebootrecovery_option1' name='actions_rebootrecovery' type='radio' class='' value='1' <?php echo set_radio('actions_rebootrecovery', TRUE); ?> />
						True
					</label>
					<label class='radio' for='actions_rebootrecovery_option2'>
						<input id='actions_rebootrecovery_option2' name='actions_rebootrecovery' type='radio' class='' value='0' <?php echo set_radio('actions_rebootrecovery', FALSE, TRUE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('rebootrecovery'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('betaonly') ? 'error' : ''; ?>">
				<?php echo form_label('Only listed in Beta Feed?'. lang('bf_form_label_required'), '', array('class' => 'control-label', 'id' => 'actions_betaonly_label') ); ?>
				<div class='controls' aria-labelled-by='actions_betaonly_label'>
					<label class='radio' for='actions_betaonly_option1'>
						<input id='actions_betaonly_option1' name='actions_betaonly' type='radio' class='' value='1' <?php echo set_radio('actions_betaonly', TRUE,  (isset($actions['betaonly']) && $actions['betaonly'] == 1) ? TRUE : FALSE); ?> />
						True
					</label>
					<label class='radio' for='actions_betaonly_option2'>
						<input id='actions_betaonly_option2' name='actions_betaonly' type='radio' class='' value='0' <?php echo set_radio('actions_betaonly', FALSE,  ((isset($actions['betaonly']) && $actions['betaonly'] == 0) || !isset($actions['betaonly'])) ? TRUE : FALSE); ?> />
						False
					</label>
					<span class='help-inline'><?php echo form_error('betaonly'); ?></span>
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
