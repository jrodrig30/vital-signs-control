<div class="owAcos index">
	<h2><?php echo __('Ow Acos');?></h2>
        
        <?php 
        $opcoes['campos'] = array(
            'Aco.tipo' => array(
                'label' => 'Tipo',
                'options_valor' => array(
                    'options' => Aco::getTipoObjetos(),
                    'empty' => 'Todos'
                ),
                'options_tipo' => array(
                    'default' => OwBuscaTipoBusca::TIPO_IGUAL_A
                )
            ),
            'Aco.plugin' => array(
                'label' => 'Plugin'
            ),
            'Aco.controller' => array(
                'label' => 'Controller'
            ),
            'Aco.objeto' => array(
                'label' => 'Objeto'
            )
        );

        echo $this->OwBusca->mostrarFiltros($opcoes); 
        ?>
        <div class="table_over">
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('tipo');?></th>
            <th><?php echo $this->Paginator->sort('plugin');?></th>
            <th><?php echo $this->Paginator->sort('controller');?></th>
            <th><?php echo $this->Paginator->sort('action');?></th>
            <th><?php echo $this->Paginator->sort('objeto');?></th>
            <th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($owAcos as $owAco):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo Aco::getNomeTipoObjeto($owAco['Aco']['tipo']); ?>&nbsp;</td>
		<td><?php echo $owAco['Aco']['plugin']; ?>&nbsp;</td>
		<td><?php echo $owAco['Aco']['controller']; ?>&nbsp;</td>
		<td><?php echo $owAco['Aco']['action']; ?>&nbsp;</td>
		<td><?php echo $owAco['Aco']['objeto']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->OwHtml->link(__('View'), array('action' => 'view', $owAco['Aco']['id'])); ?>
			<?php echo $this->OwHtml->link(__('Edit'), array('action' => 'edit', $owAco['Aco']['id'])); ?>
			<?php echo $this->OwHtml->link(__('Delete'), array('action' => 'delete', $owAco['Aco']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owAco['Aco']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
        </div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __d('ow_eventos', 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}')
	));
	?>	</p>

	<div class="paging">
		<?php
                    echo $this->Paginator->prev('« ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => ''));
                    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                ?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->OwHtml->link(__('New Ow Aco'), array('action' => 'add')); ?></li>
	</ul>
</div>