<?php
namespace OwCore\Shell\Task;
use Cake\Console\Shell;

class CarregarMenuTask extends Shell {

    public $description = 'Popula a tabela de menus';
    public $uses = array('OwCore.Menu');
    
    public function execute() {
        
    }
    
}

