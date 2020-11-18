<div class="eventoCategorias form">
<?php echo $this->Form->create($categoria);?>
	<fieldset>
 		<legend><?php echo __d('ow_eventos', 'Editar Categoria'); ?></legend>
	<?php
		echo $this->Form->input('id');
                if($categoria['evento_categoria_id'] != null){
                    echo $this->Form->input('evento_categoria_id',['label' => 'Categoria']);
                }
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php
echo $this->Form->button('Salvar');
echo $this->Form->end();
?>
</div>
<div class="actions">
	<h3><?php echo __('Açoes'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link('Remover Categoria',
                                                ['action' => 'delete', $categoria['id']],
                                                ['confirm' => 'Você deseja remover a Categoria ' . $categoria['id']. ' - ' . $categoria['nome']]
                                            ); ?></li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Listar Categorias'), array('action' => 'index'));?></li>
	</ul>
</div>