<div class="parametros index">
<h2><?php echo __('Parametros');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __d('ow_eventos', 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}')
));
?></p>
<div class="table_over">
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('descricao');?></th>
	<th><?php echo $this->Paginator->sort('valor');?></th>
	<th><?php echo $this->Paginator->sort('obs');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($parametros as $parametro):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $parametro['Parametro']['descricao']; ?></td>
		<td><?php echo $parametro['Parametro']['valor']; ?></td>
		<td><?php echo $parametro['Parametro']['obs']; ?></td>
		<td class="actions">
			<?php echo $this->OwHtml->link(__('View'), array('action'=>'view', $parametro['Parametro']['id'])); ?>
			<?php echo $this->OwHtml->link(__('Edit'), array('action'=>'edit_cliente', $parametro['Parametro']['id'])); ?>
			<!-- <?php echo $this->OwHtml->link(__('Delete'), array('action'=>'delete', $parametro['Parametro']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $parametro['Parametro']['id'])); ?>-->
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
</div>
<div class="paging">
    <?php
        echo $this->Paginator->prev('« ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
<!--
<div class="actions">
	<ul>
		<li><?php echo $this->OwHtml->link(__('New Parametro'), array('action'=>'add')); ?></li>
	</ul>
</div>
-->