<div class="usuarios form">
<?php echo $this->Form->create('Usuario');?>
	<fieldset>
 		<legend><?php echo __('Edit Usuario');?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('usuario_grupo_id',array('options' => $ow_grupos));
		echo $this->Form->input('nome');
		echo $this->Form->input('email');
		echo $this->Form->input('senha',array('type' => 'password'));
		echo $this->Form->input('senha_confirma',array('type' => 'password'));
		echo $this->Form->input('ativo');
		echo $this->Form->input('hash',array('type' => 'hidden','value' => 1));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->OwHtml->link(__('Delete'), array('action'=>'delete', $this->Form->value('Usuario.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Usuario.id'))); ?></li>
		<li><?php echo $this->OwHtml->link(__('List Usuarios'), array('action'=>'index'));?></li>
	</ul>
</div>
