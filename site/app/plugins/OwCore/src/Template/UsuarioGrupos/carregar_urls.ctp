<div class="owAcos index">
	<h2><?php echo __('URLs Adicionadas');?></h2>

        <div class="table_over">
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('tipo');?></th>
            <th><?php echo $this->Paginator->sort('plugin');?></th>
            <th><?php echo $this->Paginator->sort('controller');?></th>
            <th><?php echo $this->Paginator->sort('action');?></th>
	</tr>
	<?php
	$i = 0; 
        
	foreach ($entradas as $entrada):
            
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo 'URL'; ?>&nbsp;</td>
		<td><?php echo $entrada['plugin']; ?>&nbsp;</td>
		<td><?php echo $entrada['controller']; ?>&nbsp;</td>
		<td><?php echo $entrada['action']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
        </div>
</div>

<div class="owAcos index">
	<h2><?php echo __('URLs Removidas');?></h2>

        <div class="table_over">
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('tipo');?></th>
            <th><?php echo $this->Paginator->sort('plugin');?></th>
            <th><?php echo $this->Paginator->sort('controller');?></th>
            <th><?php echo $this->Paginator->sort('action');?></th>
	</tr>
	<?php
	$i = 0; 
	foreach ($saidas as $saida):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo 'URL'; ?>&nbsp;</td>
		<td><?php echo $saida['plugin']; ?>&nbsp;</td>
		<td><?php echo $saida['controller']; ?>&nbsp;</td>
		<td><?php echo $saida['action']; ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
        </div>


</div>

