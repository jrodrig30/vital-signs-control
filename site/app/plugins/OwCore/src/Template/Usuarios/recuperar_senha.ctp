<div class="usuarios form">
<?php echo $this->Form->create('NovaSenha',array('url' => array('controller' => 'usuarios','action' => 'recuperar_senha')));?>
	<fieldset>
 		<legend><?php echo __('Esqueci minha senha');?></legend>
	<?php
		echo $this->Form->input('email',array('label' => __('Informe seu email')));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php echo $this->OwHtml->link('Voltar',array('action' => 'login')) ?>
