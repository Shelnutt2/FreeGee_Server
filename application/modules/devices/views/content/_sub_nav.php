<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/devices') ?>" id="list"><?php echo lang('devices_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Devices.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/devices/create') ?>" id="create_new"><?php echo lang('devices_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>