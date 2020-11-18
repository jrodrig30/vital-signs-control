<div class="eventoCategorias index">
	<h2><?php echo __d('ow_eventos', 'Categorias');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('nome');?></th>
            <th class="actions"><?php echo __('Ações');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($eventoCategorias as $eventoCategoria):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $eventoCategoria['nome']; ?>&nbsp;</td>
		<td class="actions">
                    <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $eventoCategoria['id'])); ?>
                    <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $eventoCategoria['id'])); ?>
                    <?php echo $this->Html->link(
                                                'Remover',
                                                ['action' => 'delete', $eventoCategoria['id']],
                                                ['confirm' => 'Você deseja remover a Categoria ' . $eventoCategoria['id']. ' - ' . $eventoCategoria['nome']]
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
            <?php
                echo $this->Paginator->prev('< ' . __d('ow_eventos', 'previous'), array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('separator' => ''));
                echo $this->Paginator->next(__d('ow_eventos', 'next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__d('ow_eventos', 'Nova Categoria'), array('action' => 'add')); ?></li>
	</ul>
</div>