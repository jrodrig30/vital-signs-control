<div class="usuarios index">
<h2><?php echo __('Usuarios');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __d('ow_eventos', 'Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}')
));
?></p>
<div class="table_over">
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('nome');?></th>
	<th><?php echo $this->Paginator->sort('email');?></th>
        <th><?php echo $this->Paginator->sort('ativo');?></th>
        <th>Grupo</th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($usuarios as $usuario):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $usuario['Usuario']['nome'] . ( $usuario['Usuario']['ativo'] == 0 ? " (Inativo)" : '' ); ?>
		</td>
		<td>
			<?php echo $usuario['Usuario']['email']; ?>
		</td>
                <td>
			<?php echo $usuario['Usuario']['ativo'] ? 'Sim' : 'Não'; ?>
		</td>
                <td>
			<?php echo $usuario['UsuarioGrupo']['nome']; ?>
		</td>
		<td class="actions">
			<?php echo $this->OwHtml->link(__('View'), array('action'=>'view', $usuario['Usuario']['id'])); ?>
			<?php echo $this->OwHtml->link(__('Edit'), array('action'=>'edit', $usuario['Usuario']['id'])); ?>
			<?php echo $this->OwHtml->link(__('Remover'), array('action'=>'delete', $usuario['Usuario']['id']), null, sprintf(__('Você tem certeza que deseja remover # %s?'), $usuario['Usuario']['nome'])); ?>

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
<div class="actions">
	<ul>
		<li><?php echo $this->OwHtml->link(__('New Usuario'), array('action'=>'add')); ?></li>
	</ul>
</div>
