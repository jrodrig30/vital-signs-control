<div class="owMenus form">
<?php echo $this->Form->create('Menu');?>
	<fieldset>
 		<legend><?php echo __('Add Ow Menu'); ?></legend>
	<?php
		echo $this->Form->input('menu_id',array('empty' => '','options' => $ow_menus));
		echo $this->Form->input('nome');
		echo $this->Form->input('plugin');
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('ordem');
                echo $this->Form->input('ativo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Ow Menus'), array('action' => 'index'));?></li>
	</ul>
</div>