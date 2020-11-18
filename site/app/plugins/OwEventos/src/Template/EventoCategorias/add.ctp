<div class="eventoCategorias form">
<?php echo $this->Form->create('EventoCategoria');?>
	<fieldset>
 		<legend><?php echo __d('ow_eventos', 'Adicionar Categoria'); ?></legend>
	<?php
		echo $this->Form->input('evento_categoria_id',['empty' => '--Selecione--', 'label' => 'Categoria']);
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php
echo $this->Form->button('Salvar');
echo $this->Form->end();
?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__d('ow_eventos', 'Listar Categorias'), array('action' => 'index'));?></li>
	</ul>
</div>