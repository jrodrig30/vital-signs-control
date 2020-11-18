<div class="owMenus view table_over">
<h2><?php echo __('Ow Menu');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ow Menu Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['menu_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Plugin'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['plugin']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Controller'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['controller']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Action'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['action']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ordem'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owMenu['Menu']['ordem']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ow Menu'), array('action' => 'edit', $owMenu['Menu']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Ow Menu'), array('action' => 'delete', $owMenu['Menu']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owMenu['Menu']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ow Menus'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ow Menu'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ow Menus'), array('controller' => 'ow_menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ow Menu'), array('controller' => 'ow_menus', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Ow Menus');?></h3>
	<?php if (!empty($owMenu['Menu'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ow Menu Id'); ?></th>
		<th><?php echo __('Nome'); ?></th>
		<th><?php echo __('Plugin'); ?></th>
		<th><?php echo __('Controller'); ?></th>
		<th><?php echo __('Action'); ?></th>
		<th><?php echo __('Ordem'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($owMenu['Menu'] as $owMenu):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $owMenu['id'];?></td>
			<td><?php echo $owMenu['menu_id'];?></td>
			<td><?php echo $owMenu['nome'];?></td>
			<td><?php echo $owMenu['plugin'];?></td>
			<td><?php echo $owMenu['controller'];?></td>
			<td><?php echo $owMenu['action'];?></td>
			<td><?php echo $owMenu['ordem'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'ow_menus', 'action' => 'view', $owMenu['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'ow_menus', 'action' => 'edit', $owMenu['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'ow_menus', 'action' => 'delete', $owMenu['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owMenu['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ow Menu'), array('controller' => 'ow_menus', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
