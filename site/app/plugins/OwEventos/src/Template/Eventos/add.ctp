<?php 
use Cake\Core\Configure;
use Cake\I18n\Time;
echo $this->Html->css('OwEventos.eventos.css'); 
$desabilitarTinyMce = Configure::read('OwEventos.DesabilitarTinyMce') === TRUE;
if(!$desabilitarTinyMce){
    echo $this->element('OwEventos.tinymce');
}
use OwEventos\Lib\OwEventosUtil;
?>
<div class="eventos form">
<?php echo $this->Form->create('Evento',array('type' => 'file', 'novalidate' => true));?>
	<fieldset>
 		<legend><?php echo __d('ow_eventos', 'Adicionar Evento'); ?></legend>
	<?php
                if(isset($eventoCategorias) && count($eventoCategorias)){
                    echo $this->Form->input('evento_categoria_id', ['empty' => '--Selecione--', 'label' => 'Evento Categoria']);
                }
                
		echo $this->Form->input('descricao');
                
                if(OwEventosUtil::isCampoAtivo('Evento.img_destaque')){
                    echo $this->Form->input('img_destaque',array('type' => 'file', 'label' => __d('ow_eventos', 'Img Destaque')));
                }
                
                if(OwEventosUtil::isCampoAtivo('Evento.data')){
                    $this->Form->templates(
                        ['dateWidget' => '{{day}}{{month}}{{year}}']
                      );
                    echo $this->Form->input('data', ['type'=>'date'], ['label' => 'Data']);
                }
                
                
                
                if(OwEventosUtil::isCampoAtivo('Evento.resumo')){
                    echo $this->Form->input('resumo');
                }
                
                if(OwEventosUtil::isCampoAtivo('Evento.texto')){
                    echo $this->Form->input('texto');
                }
                
                if(OwEventosUtil::isCampoAtivo('Evento.destaque')){
                    echo $this->Form->input('destaque', ['type' => 'checkbox', 'checked']);
                }
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
		<li><?php echo $this->Html->link(__d('ow_eventos', 'List Eventos'), array('action' => 'index'));?></li>
	</ul>
</div>