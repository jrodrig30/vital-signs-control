<div class="eventoFotos form">
<?php echo $this->Form->create($foto, array('type' => 'file'));?>
	<fieldset>
 		<legend><?php echo __d('ow_eventos', 'Editar Foto'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('evento_id', array('type' => 'hidden'));
                echo $this->Form->input('pasta', array('type' => 'hidden'));
		echo $this->Form->input('arquivo', array('type' => 'file'));
		echo $this->Form->input('legenda');
                if(OwEventosUtil::isCampoAtivo('EventoFoto.ordem')){
                    echo $this->Form->input('ordem');
                }
	?>
	</fieldset>
<?php
echo $this->Form->button('Salvar');
echo $this->Form->end();
?>
</div>