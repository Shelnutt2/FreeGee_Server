<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/developer/freegee') ?>" id="list"><?php echo lang('freegee_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('FreeGee.Developer.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/developer/freegee/create') ?>" id="create_new"><?php echo lang('freegee_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>