<div class="eventoFotos view">
<h2><?php echo __d('ow_eventos', 'Evento Foto');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoFoto['EventoFoto']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Evento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($eventoFoto['Evento']['id'], array('controller' => 'eventos', 'action' => 'view', $eventoFoto['Evento']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Arquivo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoFoto['EventoFoto']['arquivo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Legenda'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoFoto['EventoFoto']['legenda']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Ordem'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoFoto['EventoFoto']['ordem']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoFoto['EventoFoto']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoFoto['EventoFoto']['updated']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Edit Evento Foto'), array('action' => 'edit', $eventoFoto['EventoFoto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Delete Evento Foto'), array('action' => 'delete', $eventoFoto['EventoFoto']['id']), null, sprintf(__d('ow_eventos', 'Are you sure you want to delete # %s?'), $eventoFoto['EventoFoto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'List Evento Fotos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'New Evento Foto'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'List Eventos'), array('controller' => 'eventos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'New Evento'), array('controller' => 'eventos', 'action' => 'add')); ?> </li>
	</ul>
</div>
