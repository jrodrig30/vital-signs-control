<?php

use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';
if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
    ?>
    <ul class="sidebar-menu">
        <li class="header">MENU PRINCIPAL</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Monitoramento</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo $this->Url->build('/monitoramentos/pacientes'); ?>"><i class="fa fa-circle-o"></i> Pacientes</a></li>
                <li><a href="<?php echo $this->Url->build('/monitoramentos/simulacoes'); ?>"><i class="fa fa-circle-o"></i> Simulação </a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i> <span>Cadastro de Diagnósticos</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo $this->Url->build('/diagnosticos/index'); ?>"><i class="fa fa-circle-o"></i> Listar</a></li>
                <li><a href="<?php echo $this->Url->build('/diagnosticos/add'); ?>"><i class="fa fa-circle-o"></i> Adicionar</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i> <span>Cadastro de Sinais Vitais</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo $this->Url->build('/sinais/index'); ?>"><i class="fa fa-circle-o"></i> Listar</a></li>
                <li><a href="<?php echo $this->Url->build('/sinais/add'); ?>"><i class="fa fa-circle-o"></i> Adicionar</a></li>
            </ul>
        </li
        
        
    </ul>
<?php } ?>
