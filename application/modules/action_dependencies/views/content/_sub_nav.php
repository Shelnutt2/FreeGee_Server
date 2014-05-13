<ul class="nav nav-pills">
	<li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/action_dependencies') ?>" id="list"><?php echo lang('action_dependencies_list'); ?></a>
	</li>
	<?php if ($this->auth->has_permission('Action_Dependencies.Content.Create')) : ?>
	<li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
		<a href="<?php echo site_url(SITE_AREA .'/content/action_dependencies/create') ?>" id="create_new"><?php echo lang('action_dependencies_new'); ?></a>
	</li>
	<?php endif; ?>
</ul>