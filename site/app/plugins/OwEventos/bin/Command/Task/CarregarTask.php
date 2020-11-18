<?php
namespace Console\Command\Task;

class CarregarTask extends Shell {

    public $description = 'Popula a tabela de menus';
    
    public function main() {
        $menus = array(
            array(
                'nome' => 'Eventos',
                'ordem' => 700,
                'submenus' => array(
                    array(
                        'nome' => 'Categorias',
                        'plugin' => 'ow_eventos',
                        'controller' => 'evento_categorias',
                        'action' => 'index',
                        'ordem' => 100,
                    ),
                    array(
                        'nome' => 'Eventos',
                        'plugin' => 'ow_eventos',
                        'controller' => 'eventos',
                        'action' => 'index',
                        'ordem' => 200,
                    ),
                )
            )
        );
        
        use OwCore\Lib\OwCoreCadastrarMenu;
        $c = new OwCoreCadastrarMenu();
        $c->cadastrar($menus);
        
        $this->out('Menus do OwEventos cadastrados com sucesso');
    }
    
}

