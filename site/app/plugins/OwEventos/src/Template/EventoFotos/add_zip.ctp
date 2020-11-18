<div class="eventoFotos form">
<?php echo $this->Form->create('EventoFoto', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __d('ow_eventos', 'Adicionar ZIP com Fotos'); ?></legend>
	<?php
		echo $this->Form->input('evento_id', ['type' => 'hidden', 'value' => $foto]);
		echo $this->Form->input('arquivo_zip', array('type' => 'file', 'after' => 'Tamanho máximo do arquivo: ' . ini_get('upload_max_filesize')));
	?>
	</fieldset>
<?php
echo $this->Form->button('Salvar');
echo $this->Form->end();
?>
</div>