<div class="usuarios view table_over">
<h2><?php echo __('Usuario');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Grupo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['UsuarioGrupo']['nome']; ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Ativo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usuario['Usuario']['ativo'] ? "sim" : "não"; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->OwHtml->link(__('Edit Usuario'), array('action'=>'edit', $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->OwHtml->link(__('Delete Usuario'), array('action'=>'delete', $usuario['Usuario']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $usuario['Usuario']['id'])); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Usuarios'), array('action'=>'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Usuario'), array('action'=>'add')); ?> </li>
	</ul>
</div>
