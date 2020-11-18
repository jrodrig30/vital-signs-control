<?php use Cake\ORM\TableRegistry; ?>
<?php use OwEventos\Lib\OwEventosUtil; ?>
<div class="eventos view">
<h2><?php echo __d('ow_eventos', 'Evento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $evento['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Evento Categoria'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
                    <?php
                        $categorias = TableRegistry::get('OwEventos.EventoCategorias');
                        $categoria = $categorias->getNomeFull($evento['evento_categoria_id']);
                    ?>
			<?php echo $this->Html->link($categoria, array('controller' => 'evento_categorias', 'action' => 'view', $evento['evento_categoria_id'])); ?>
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Descricao'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $evento['descricao']; ?>
			&nbsp;
		</dd>
                    
                <?php if(strlen($evento['img_destaque'])): ?>
                    <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Img Destaque'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                            <?php echo $this->Html->image('/uploads/eventos/img_destaque/' . $evento['img_destaque']); ?>
                            &nbsp;
                    </dd>
                <?php endif; ?>
                    
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->format($evento['data'], 'd/M/Y'); ?>
			&nbsp;
		</dd>
                
                <?php if(OwEventosUtil::isCampoAtivo('Evento.resumo')){ ?>
                    <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Resumo'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                            <?php echo $evento['resumo']; ?>
                            &nbsp;
                    </dd>
                <?php } ?>
                
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Texto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $evento['texto']; ?>
			&nbsp;
		</dd>
                
                <?php if(OwEventosUtil::isCampoAtivo('Evento.destaque')){ ?>
                    <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Destaque'); ?></dt>
                    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                            <?php echo $evento['destaque'] ? __d('ow_eventos', 'Yes') : __d('ow_eventos', 'No'); ?>
                            &nbsp;
                    </dd>
                <?php } ?>
                
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->format($evento['created'], 'd/M/Y'); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __d('ow_eventos', 'Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Time->format($evento['modified'], 'd/M/Y'); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Editar'), array('action' => 'edit', $evento['id'])); ?> </li>
		<li><?php echo $this->Html->link(
                                                'Remover',
                                                ['action' => 'delete', $evento['id']],
                                                ['confirm' => 'Você deseja remover o Evento ' . $evento['id']. ' - ' . $evento['descricao']]
                                            ); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Listar'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Novo'), array('action' => 'add')); ?> </li>
	</ul>
</div>

<?php if(OwEventosUtil::isMaisFotosAtiva()): ?>
    <div class="related">
        <?php
            $fotos = TableRegistry::get('OwEventos.EventoFotos');
            $eventoFotos = $fotos->find('all')
                           ->where(['evento_id' => $evento['id']]);
        ?>
	<h3><?php echo __d('ow_eventos', 'Fotos Relacionadas');?></h3>
	<?php if (!empty($eventoFotos)):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
            <th><?php echo __d('ow_eventos', 'Arquivo'); ?></th>
            <th><?php echo __d('ow_eventos', 'Legenda'); ?></th>
            <?php if(OwEventosUtil::isCampoAtivo('EventoFoto.ordem')): ?>
                <th><?php echo __d('ow_eventos', 'Ordem'); ?></th>
            <?php endif; ?>
            <th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
            $i = 0;
            foreach ($eventoFotos as $eventoFoto):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
            ?>
            <tr<?php echo $class;?>>
                <!--<td><?php //echo $this->Html->image('/uploads/evento_foto/' . OwEventosUtil::getPastaEventoFotoWeb($eventoFoto['pasta']) . '/' . $eventoFoto['arquivo'], array('width' => 150)); ?></td>-->
                <td><?php echo $this->Html->image('/uploads/eventos/' . $evento->id . '/' . $eventoFoto->arquivo, ['width' => 150]); ?></td>
                <td><?php echo $eventoFoto['legenda'];?></td>
                <?php if(OwEventosUtil::isCampoAtivo('EventoFoto.ordem')): ?>
                    <td><?php echo $eventoFoto['ordem'];?></td>
                <?php endif; ?>
                <td class="actions">
                    <?php echo $this->Html->link(__('Editar'), array('controller' => 'evento_fotos', 'action' => 'edit', $eventoFoto['id'])); ?>
                    <?php echo $this->Html->link(
                                                'Remover',
                                                ['controller' => 'evento_fotos', 'action' => 'delete', $eventoFoto['id']],
                                                ['confirm' => 'Você deseja remover a Foto ' . $eventoFoto['id']. ' - ' . $eventoFoto['legenda']]
                                            ); ?>
                </td>
            </tr>
	<?php endforeach; ?>
	</table>
    <?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__d('ow_eventos', 'Nova Foto'), array('controller' => 'evento_fotos', 'action' => 'add', 'evento_id' => $evento['id']));?> </li>
                        <li><?php echo $this->Html->link(__d('ow_eventos', 'Adicionar ZIP com Fotos'), array('controller' => 'evento_fotos','action' => 'add_zip', 'evento_id' => $evento['id']));?> </li>
		</ul>
	</div>
    </div>
<?php endif; ?>