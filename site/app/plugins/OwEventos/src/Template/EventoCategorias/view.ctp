<div class="eventoCategorias view">
<h2><?php echo __d('ow_eventos', 'Categoria');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoCategoria['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoCategoria['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoCategoria['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventoCategoria['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Editar Categoria'), array('action' => 'edit', $eventoCategoria['id'])); ?> </li>
		<li><?php echo $this->Html->link(
                                                'Remover Categoria',
                                                ['action' => 'delete', $eventoCategoria['id']],
                                                ['confirm' => 'Você deseja remover a Categoria ' . $eventoCategoria['id']. ' - ' . $eventoCategoria['nome']]
                                            ); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Listar Categorias'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Nova Categoria'), array('action' => 'add')); ?> </li>
	</ul>
</div>
