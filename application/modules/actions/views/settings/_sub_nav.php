<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/settings/actions') ?>" id="list"><?php echo lang('actions_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Actions.Settings.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/settings/actions/create') ?>" id="create_new"><?php echo lang('actions_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>