<div class="usuarios form">
<?php echo $this->Form->create('TrocarSenha',array('url' => '/ow_core/usuarios/trocar_minha_senha'));?>
	<fieldset>
 		<legend><?php echo __('Trocar minha senha');?></legend>
	<?php
                echo $this->Form->input('senha',array('type' => 'password'));
                echo $this->Form->input('senha_confirma',array('type' => 'password'));
	?>
	</fieldset>
<?php
echo $this->Form->button('Salvar');
echo $this->Form->end();
?>
</div>
