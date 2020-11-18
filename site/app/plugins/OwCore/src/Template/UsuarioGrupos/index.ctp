<div class="owGrupos index">
    <h2><?php echo __('Ow Grupos'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('nome'); ?></th>
            <th><?php echo $this->Paginator->sort('identificacao'); ?></th>
            <th><?php echo $this->Paginator->sort('root'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($owGrupos as $owGrupo):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td><?php echo $owGrupo['UsuarioGrupo']['nome']; ?>&nbsp;</td>
                <td><?php echo $owGrupo['UsuarioGrupo']['identificacao']; ?>&nbsp;</td>
                <td><?php echo UsuarioGrupo::isRootRegistro($owGrupo) ? 'Sim' : 'Não'; ?>&nbsp;</td>
                <td class="actions">
                    <?php if (UsuarioGrupo::isRootRegistro($owGrupo)): ?>
                        <?php echo $this->OwHtml->link(__('Remover Root'), array('action' => 'remover_root', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php else: ?>
                        <?php echo $this->OwHtml->link(__('Tornar Root'), array('action' => 'tornar_root', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php endif; ?>
                    <?php echo $this->OwHtml->link(__('Setar Permissões URL'), array('action' => 'setar_permissoes', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php echo $this->OwHtml->link(__('Setar Permissões Objeto'), array('action' => 'setar_permissoes_objetos', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php echo $this->OwHtml->link(__('Exportar Permissões'), array('action' => 'exportar_permissoes', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php echo $this->OwHtml->link(__('Importar Permissões'), array('action' => 'importar_permissoes', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php echo $this->OwHtml->link(__('View'), array('action' => 'view', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php echo $this->OwHtml->link(__('Edit'), array('action' => 'edit', $owGrupo['UsuarioGrupo']['id'])); ?>
                    <?php echo $this->OwHtml->link(__('Delete'), array('action' => 'delete', $owGrupo['UsuarioGrupo']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $owGrupo['UsuarioGrupo']['id'])); ?>
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
        echo $this->Paginator->prev('« ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->OwHtml->link(__('New Ow Grupo'), array('action' => 'add')); ?></li>
         <li><?php echo $this->OwHtml->link(__('Carregar URLs'), array('action' => 'carregar_urls')); ?></li>
    </ul>
</div>