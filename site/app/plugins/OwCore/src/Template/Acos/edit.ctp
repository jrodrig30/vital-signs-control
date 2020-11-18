<?php echo $this->element('script_aco') ?>
<div class="owAcos form">
<?php echo $this->Form->create('Aco');?>
	<fieldset>
 		<legend><?php __('Edit Ow Aco'); ?></legend>
	<?php
            echo $this->Form->input('id');
            echo $this->Form->input('tipo', array('options' => Aco::getTipoObjetos()));
            echo '<div id="TipoU" style="display: none;">';
                echo $this->Form->input('plugin');
                echo $this->Form->input('controller');
                echo $this->Form->input('action');
            echo '</div>';
            
            echo '<div id="TipoO" style="display: none;">';
                echo $this->Form->input('objeto');
            echo '</div>';
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->OwHtml->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Aco.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Aco.id'))); ?></li>
        <li><?php echo $this->OwHtml->link(__('List Ow Acos', true), array('action' => 'index'));?></li>
    </ul>
</div>