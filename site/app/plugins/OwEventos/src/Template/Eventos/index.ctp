<?php use Cake\ORM\TableRegistry; ?>
<?php use OwEventos\Lib\OwEventosUtil; ?>
<div class="eventos index">
	<h2><?php echo __d('ow_eventos','Eventos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <?php if(OwEventosUtil::isCategoriasAtiva()): ?>
                <th><?php echo $this->Paginator->sort('Categoria');?></th>
            <?php endif; ?>
                
            <th><?php echo $this->Paginator->sort('descricao', __d('ow_eventos', 'Descriço'));?></th>
            <th><?php echo $this->Paginator->sort('data', __d('ow_eventos', 'Data'));?></th>
            <?php if(OwEventosUtil::isCampoAtivo('Evento.destaque')){ ?>
                <th><?php echo $this->Paginator->sort('destaque', __d('ow_eventos', 'Destaque'));?></th>
            <?php } ?>
            <th class="actions"><?php echo __('Ações');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($eventos as $evento):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
                <?php if(OwEventosUtil::isCategoriasAtiva()): 
                            if(!empty($evento['evento_categoria_id'])): ?>
                                <td>
                                    <?php 
                                    $categorias = TableRegistry::get('OwEventos.EventoCategorias');
                                    $categoria = $categorias->getNomeFull($evento['evento_categoria_id']);
                                    echo $this->Html->link($categoria, array('controller' => 'evento_categorias', 'action' => 'view', $evento['evento_categoria_id'])); ?>
                                </td>
                            
                    <?php   else:?> 
                                <td>
                                    <?php echo '';?>
                                </td>
                    <?php   endif;
                        endif;?>
                
		<td><?php echo $evento['descricao']; ?>&nbsp;</td>
		<td><?php echo $this->Time->format($evento['data'], 'd-mM-Y'); ?>&nbsp;</td>
                
                <?php if(OwEventosUtil::isCampoAtivo('Evento.destaque')){ ?>
                    <td><?php echo $evento['destaque'] ? __d('ow_eventos', 'Yes') : __d('ow_eventos', 'No'); ?>&nbsp;</td>
                <?php } ?>
                    
		<td class="actions">
                        <?php 
                        if(OwEventosUtil::isMaisFotosAtiva()){
                            echo $this->Html->link(__d('ow_eventos', 'Adicionar Foto'), array('controller' => 'evento_fotos','action' => 'add', 'evento_id' => $evento['id']));
                            echo $this->Html->link(__d('ow_eventos', 'Adicionar ZIP com Fotos'), array('controller' => 'evento_fotos','action' => 'add_zip', 'evento_id' => $evento['id']));
                        }
                        echo $this->Html->link(__('Ver'), array('action' => 'view', $evento['id']));
			echo $this->Html->link(__('Editar'), array('action' => 'edit', $evento['id']));
                        echo $this->Html->link(
                                                'Remover',
                                                ['action' => 'delete', $evento['id']],
                                                ['confirm' => 'Você deseja remover o Evento ' . $evento['id']. ' - ' . $evento['descricao']]
                                            );
                        ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __d('ow_eventos', 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}')
	));
	?>	</p>

	<div class="paging">
            <?php
                echo $this->Paginator->prev('< ' . __d('ow_eventos', 'previous'), array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('separator' => ''));
                echo $this->Paginator->next(__d('ow_eventos', 'next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Ações'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Novo Evento'), array('action' => 'add')); ?></li>
                <?php if(OwEventosUtil::isCampoAtivo('destaque')): ?>
                    <li><?php echo $this->Html->link(__d('ow_eventos', 'Cancelar Eventos Destaque'), array('action' => 'cancelar_destaques')); ?></li>
                <?php endif; ?>
	</ul>
</div>