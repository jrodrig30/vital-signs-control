<div class="owGrupos form">
<?php echo $this->Form->create('UsuarioGrupo');?>
	<fieldset>
 		<legend><?php echo __('Edit Ow Grupo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
		echo $this->Form->input('identificacao');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->OwHtml->link(__('Delete'), array('action' => 'delete', $this->Form->value('UsuarioGrupo.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('UsuarioGrupo.id'))); ?></li>
		<li><?php echo $this->OwHtml->link(__('List Ow Grupos'), array('action' => 'index'));?></li>
		<li><?php echo $this->OwHtml->link(__('List Ow Permissos'), array('controller' => 'ow_permissos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Ow Permisso'), array('controller' => 'ow_permissos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('List Usuarios'), array('controller' => 'usuarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->OwHtml->link(__('New Usuario'), array('controller' => 'usuarios', 'action' => 'add')); ?> </li>
	</ul>
</div>