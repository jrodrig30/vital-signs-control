<?php
namespace OwCore\Shell\Task;
use Cake\Console\Shell;

class CarregarTask extends Shell {

    public $description = 'Popula a tabela de menus';
    
    public function execute() {
        $menus = array(
            array(
                'nome' => 'Sistema',
                'ordem' => 900,
                'submenus' => array(
                    array(
                        'nome' => 'Trocar Minha Senha',
                        'plugin' => 'ow_core',
                        'controller' => 'usuarios',
                        'action' => 'trocar_minha_senha',
                        'ordem' => 200,
                    ),
                    array(
                        'nome' => 'Meus Dados',
                        'plugin' => 'ow_core',
                        'controller' => 'usuarios',
                        'action' => 'meus_dados',
                        'ordem' => 300,
                    ),
                    array(
                        'nome' => 'Usuários',
                        'plugin' => 'ow_core',
                        'controller' => 'usuarios',
                        'action' => 'index',
                        'ordem' => 400,
                    ),
                    array(
                        'nome' => 'Parâmetros',
                        'plugin' => 'ow_core',
                        'controller' => 'parametros',
                        'action' => 'index',
                        'ordem' => 500,
                    ),
                    array(
                        'nome' => 'Menus',
                        'plugin' => 'ow_core',
                        'controller' => 'menus',
                        'action' => 'index',
                        'ordem' => 600,
                    ),
                    array(
                        'nome' => 'Acos',
                        'plugin' => 'ow_core',
                        'controller' => 'acos',
                        'action' => 'index',
                        'ordem' => 700,
                    ),
                    array(
                        'nome' => 'Grupos',
                        'plugin' => 'ow_core',
                        'controller' => 'usuario_grupos',
                        'action' => 'index',
                        'ordem' => 800,
                    ),
                    array(
                        'nome' => 'Sair',
                        'plugin' => 'ow_core',
                        'controller' => 'usuarios',
                        'action' => 'logout',
                        'ordem' => 900,
                    ),
                )
            )
        );
        
        App::uses('OwCoreCadastrarMenu', 'OwCore.Lib');
        $c = new OwCoreCadastrarMenu();
        $c->cadastrar($menus);
        
        $this->out('Menus do OwCore cadastrados com sucesso');
    }
    
}

