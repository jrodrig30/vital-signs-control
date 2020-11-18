<div class="owMenus index">
	<h2><?php echo __('Ow Menus');?></h2>
        <div class="table_over">
	<table cellpadding="0" cellspacing="0">
	<tr>
                        <th>Menu</th>
			<th><?php echo $this->Paginator->sort('nome');?></th>
			<th><?php echo $this->Paginator->sort('plugin');?></th>
			<th><?php echo $this->Paginator->sort('controller');?></th>
			<th><?php echo $this->Paginator->sort('action');?></th>
			<th><?php echo $this->Paginator->sort('ordem');?></th>
                        <th><?php echo $this->Paginator->sort('ativo');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($owMenus as $owMenu):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
                <td><?php echo $owMenu['MenuPai']['nome']; ?>&nbsp;</td>
		<td><?php echo $owMenu['Menu']['nome']; ?>&nbsp;</td>
		<td><?php echo $owMenu['Menu']['plugin']; ?>&nbsp;</td>
		<td><?php echo $owMenu['Menu']['controller']; ?>&nbsp;</td>
		<td><?php echo $owMenu['Menu']['action']; ?>&nbsp;</td>
		<td><?php echo $owMenu['Menu']['ordem']; ?>&nbsp;</td>
                <td><?php echo $owMenu['Menu']['ativo'] ? 'Sim' : 'Não'; ?>&nbsp;</td>
		<td class="actions">
			<?php 
                        if($owMenu['Menu']['ativo']){
                            echo $this->Html->link(__('Desativar'), array('action' => 'desativar', $owMenu['Menu']['id']));
                        }else{
                            echo $this->Html->link(__('Ativar'), array('action' => 'ativar', $owMenu['Menu']['id']));
                        }
                        echo $this->Html->link(__('View'), array('action' => 'view', $owMenu['Menu']['id']));
			echo $this->Html->link(__('Edit'), array('action' => 'edit', $owMenu['Menu']['id']));
			echo $this->Html->link(__('Delete'), array('action' => 'delete', $owMenu['Menu']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owMenu['Menu']['id'])); 
                        ?>
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
		<li><?php echo $this->Html->link(__('New Ow Menu'), array('action' => 'add')); ?></li>
	</ul>
</div>