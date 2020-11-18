<?php use Cake\ORM\TableRegistry; ?>
<div class="eventoFotos index">
	<h2><?php echo __d('ow_eventos', 'Evento Fotos');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('evento_id');?></th>
			<th><?php //echo $this->Paginator->sort('arquivo');?></th>
			<th><?php echo $this->Paginator->sort('legenda');?></th>
			<th><?php echo $this->Paginator->sort('ordem');?></th>
			<th><?php //echo $this->Paginator->sort('created');?></th>
			<th><?php //echo $this->Paginator->sort('updated');?></th>
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
		<td><?php echo $eventoFoto['id']; ?>&nbsp;</td>
		<td>
			<?php 
                        $categorias = TableRegistry::get('OwEventos.EventoCategorias');
                        $categoria = $categorias->getNomeFull($eventoFoto['evento_categoria_id']);
                        echo $this->Html->link($categoria, array('controller' => 'eventos', 'action' => 'view', $eventoFoto['evento_categoria_id'])); ?>
		</td>
		<td><?php //echo $eventoFoto['arquivo']; ?>&nbsp;</td>
		<td><?php echo $eventoFoto['legenda']; ?>&nbsp;</td>
		<td><?php //echo $eventoFoto['ordem']; ?>&nbsp;</td>
		<td><?php echo $eventoFoto['created']; ?>&nbsp;</td>
		<td><?php //echo $eventoFoto['updated']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $eventoFoto['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $eventoFoto['id'])); ?>
			<?php echo $this->Html->link(
                                                'Remover',
                                                ['action' => 'delete', $eventoFoto['id']],
                                                ['confirm' => 'Você deseja remover a Foto ' . $eventoFoto['id']. ' - ' . $eventoFoto['legenda']]
                                            ); ?>
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
		<?php echo $this->Paginator->prev('<< ' . __d('ow_eventos', 'previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__d('ow_eventos', 'next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'New Evento Foto'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'List Eventos'), array('controller' => 'eventos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'New Evento'), array('controller' => 'eventos', 'action' => 'add')); ?> </li>
	</ul>
</div>