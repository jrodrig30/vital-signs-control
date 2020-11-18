<?php

namespace OwCore\Shell\Task;

use Cake\Console\Shell;
use OwCore\Lib\CarregaActionsLib;

class CarregaActionsTask extends Shell {

    //Used when printing instructions
    public $description = 'Carrega plugins, controllers e metodos na tabela de ow_acos';
    public $actionBlackList = array('getUsuarioId', 'getEmpresaId');
    
    public function main() {
        $c = new CarregaActionsLib();
        $c->atualizarCadastroUrls();
    }      
}
