<div class="owAcos view table_over">
<h2><?php echo __('Ow Aco');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Tipo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['tipo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Plugin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['plugin']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Controller'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['controller']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Action'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['action']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Objeto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owAco['Aco']['objeto']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->OwHtml->link(__('Edit Ow Aco'), array('action' => 'edit', $owAco['Aco']['id'])); ?> </li>
		<li><?php echo $this->OwHtml->link(__('Delete Ow Aco'), array('action' => 'delete', $owAco['Aco']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owAco['Aco']['id'])); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Ow Acos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Ow Aco'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Ow Permissoes'), array('controller' => 'ow_permissoes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Ow Permissao'), array('controller' => 'ow_permissoes', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Ow Permissoes');?></h3>
	<?php if (!empty($owAco['Permissao'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ow Grupo Id'); ?></th>
		<th><?php echo __('Ow Aco Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($owAco['Permissao'] as $owPermissao):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $owPermissao['id'];?></td>
			<td><?php echo $owPermissao['usuario_grupo_id'];?></td>
			<td><?php echo $owPermissao['aco_id'];?></td>
			<td class="actions">
				<?php echo $this->OwHtml->link(__('View'), array('controller' => 'ow_permissoes', 'action' => 'view', $owPermissao['id'])); ?>
				<?php echo $this->OwHtml->link(__('Edit'), array('controller' => 'ow_permissoes', 'action' => 'edit', $owPermissao['id'])); ?>
				<?php echo $this->OwHtml->link(__('Delete'), array('controller' => 'ow_permissoes', 'action' => 'delete', $owPermissao['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owPermissao['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->OwHtml->link(__('New Ow Permissao'), array('controller' => 'ow_permissoes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
