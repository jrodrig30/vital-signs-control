<div class="parametros form">
<?php echo $this->Form->create('Parametro');?>
	<fieldset>
 		<legend><?php echo __('Add Parametro');?></legend>
	<?php
                echo $this->Form->input('tipo', array('options' => Parametro::getTipos()));
                echo $this->Form->input('descricao');
		echo $this->Form->input('nome');
		echo $this->Form->input('valor');
		echo $this->Form->input('obs');
                echo $this->Form->input('opcoes_select');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->OwHtml->link(__('List Parametros'), array('action'=>'index'));?></li>
	</ul>
</div>
