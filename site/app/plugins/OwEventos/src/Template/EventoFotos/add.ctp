<div class="eventoFotos form">
<?php echo $this->Form->create('EventoFoto', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __d('ow_eventos', 'Adicionar Foto'); ?></legend>
	<?php
		echo $this->Form->input('evento_id', ['type' => 'hidden', 'value' => $foto]);
		echo $this->Form->input('arquivo', ['type' => 'file']);
		echo $this->Form->input('legenda');
		echo $this->Form->input('ordem', ['type' => 'hidden', 'value' => 0]);
	?>
	</fieldset>
<?php
echo $this->Form->button('Salvar');
echo $this->Form->end();
?>
</div>