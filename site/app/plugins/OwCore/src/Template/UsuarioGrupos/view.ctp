<div class="owGrupos view table_over">
<h2><?php echo __('Ow Grupo');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owGrupo['UsuarioGrupo']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owGrupo['UsuarioGrupo']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Identificacao'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owGrupo['UsuarioGrupo']['identificacao']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Root'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $owGrupo['UsuarioGrupo']['root']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->OwHtml->link(__('Edit Ow Grupo'), array('action' => 'edit', $owGrupo['UsuarioGrupo']['id'])); ?> </li>
		<li><?php echo $this->OwHtml->link(__('Delete Ow Grupo'), array('action' => 'delete', $owGrupo['UsuarioGrupo']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owGrupo['UsuarioGrupo']['id'])); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Ow Grupos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Ow Grupo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Ow Permissos'), array('controller' => 'ow_permissos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Ow Permisso'), array('controller' => 'ow_permissos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Ow Permissos');?></h3>
	<?php if (!empty($owGrupo['OwPermisso'])):?>
        <div class="table_over">
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ow Grupo Id'); ?></th>
		<th><?php echo __('Ow Aco Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($owGrupo['OwPermisso'] as $owPermisso):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $owPermisso['id'];?></td>
			<td><?php echo $owPermisso['usuario_grupo_id'];?></td>
			<td><?php echo $owPermisso['aco_id'];?></td>
			<td class="actions">
				<?php echo $this->OwHtml->link(__('View'), array('controller' => 'ow_permissos', 'action' => 'view', $owPermisso['id'])); ?>
				<?php echo $this->OwHtml->link(__('Edit'), array('controller' => 'ow_permissos', 'action' => 'edit', $owPermisso['id'])); ?>
				<?php echo $this->OwHtml->link(__('Delete'), array('controller' => 'ow_permissos', 'action' => 'delete', $owPermisso['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owPermisso['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
        </div>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->OwHtml->link(__('New Ow Permisso'), array('controller' => 'ow_permissos', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Usuarios');?></h3>
	<?php if (!empty($owGrupo['Usuario'])):?>
        <div class="table_over">
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Ow Grupo Id'); ?></th>
		<th><?php echo __('Empresa Id'); ?></th>
		<th><?php echo __('Ecf Terminal Id'); ?></th>
		<th><?php echo __('Nome'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Senha'); ?></th>
		<th><?php echo __('Ativo'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($owGrupo['Usuario'] as $usuario):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $usuario['id'];?></td>
			<td><?php echo $usuario['usuario_grupo_id'];?></td>
			<td><?php echo $usuario['empresa_id'];?></td>
			<td><?php echo $usuario['ecf_terminal_id'];?></td>
			<td><?php echo $usuario['nome'];?></td>
			<td><?php echo $usuario['email'];?></td>
			<td><?php echo $usuario['senha'];?></td>
			<td><?php echo $usuario['ativo'];?></td>
			<td><?php echo $usuario['created'];?></td>
			<td><?php echo $usuario['updated'];?></td>
			<td class="actions">
				<?php echo $this->OwHtml->link(__('View'), array('controller' => 'usuarios', 'action' => 'view', $usuario['id'])); ?>
				<?php echo $this->OwHtml->link(__('Edit'), array('controller' => 'usuarios', 'action' => 'edit', $usuario['id'])); ?>
				<?php echo $this->OwHtml->link(__('Delete'), array('controller' => 'usuarios', 'action' => 'delete', $usuario['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $usuario['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
        </div>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->OwHtml->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
