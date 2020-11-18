<div class="parametros form">
<?php echo $this->Form->create('Parametro');?>
	<fieldset>
 		<legend><?php echo __('Edit Parametro') . ' ' . $this->Form->value('descricao');?> </legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('tipo', array('type' => 'hidden'));
                $tipo = $this->Form->value('tipo');
                
                if($tipo == Parametro::TIPO_TEXTO_HTML){
                    $this->Html->script('tiny_mce/tiny_mce.js', array('block' => 'script'));
                    $this->Html->script('/ow_core/js/tinymce_edit_parametro.js', array('block' => 'script'));
                }
                
                if($tipo == Parametro::TIPO_TEXTO_SIMPLES || $tipo == Parametro::TIPO_TEXTO_HTML){
                    echo $this->Form->input('valor', array('rows' => 20));
                }
                
                if($tipo == Parametro::TIPO_STRING || $tipo == Parametro::TIPO_INT || $tipo == Parametro::TIPO_FLOAT){
                    echo $this->Form->input('valor', array('type' => 'string'));
                }
                
                if($tipo == Parametro::TIPO_BOOLEANO){
                    echo $this->Form->input('valor', array('options' => array('sim' => 'Sim', 'nao' => 'Não')));
                }
                
                if($tipo == Parametro::TIPO_SELECT){
                    eval('$opcoes = ' . $this->Form->value('opcoes_select') . ';');
                    echo $this->Form->input('valor', array('options' => $opcoes, 'type' => 'select'));
                }
		
		echo $this->Form->input('obs', array('readonly' => 'readonly'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->OwHtml->link(__('List Parametros'), array('action'=>'index'));?></li>
	</ul>
</div>
