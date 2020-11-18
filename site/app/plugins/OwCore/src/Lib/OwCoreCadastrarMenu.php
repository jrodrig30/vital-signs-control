<?php
namespace OwCore\Lib;

class OwCoreCadastrarMenu {
    
    private $Menu;
    
    function __construct() {
        App::uses('ClassRegistry', 'Utility');
        $this->Menu = ClassRegistry::init('OwCore.Menu');
    }
    
    public function cadastrar(array $menus, $menu_id = ''){
        foreach($menus as $menu){
            $options = $this->getOptionsBusca($menu, $menu_id);
            $achou = $this->Menu->find('first', $options);
            $id = null;
            if(empty($achou)){
                $this->Menu->create();
                if(!$this->Menu->save($this->getDadosSalvar($menu, $menu_id))){
                    throw new Exception('Não foi possível salvar o menu!');
                }
                $id = $this->Menu->id;
            }else{
                $id = $achou['Menu']['id'];
            }
            
            if(isset($menu['submenus'])){
                $this->cadastrar($menu['submenus'], $id);
            }
        }
    }
    
    private function getOptionsBusca($menu, $menu_id = ''){
        $nome = isset($menu['nome']) ? $menu['nome'] : '';
        $plugin = isset($menu['plugin']) ? $menu['plugin'] : '';
        $controller = isset($menu['controller']) ? $menu['controller'] : '';
        $action = isset($menu['action']) ? $menu['action'] : '';
        $ordem = isset($menu['ordem']) ? $menu['ordem'] : '';
            
        $options = array(
            'conditions' => array(),
            'recursive' => -1
        );

        if(strlen($nome)){
            $options['conditions']['Menu.nome'] = $nome;
        }

        if(strlen($plugin)){
            $options['conditions']['Menu.plugin'] = $plugin;
        }

        if(strlen($controller)){
            $options['conditions']['Menu.controller'] = $controller;
        }

        if(strlen($action)){
            $options['conditions']['Menu.action'] = $action;
        }

        if(strlen($ordem)){
            $options['conditions']['Menu.ordem'] = $ordem;
        }

        if(strlen($menu_id)){
            $options['conditions']['Menu.menu_id'] = $menu_id;
        }

        return $options;
    }
    
    private function getDadosSalvar($menu, $menu_id = ''){
        $nome = isset($menu['nome']) ? $menu['nome'] : '';
        $plugin = isset($menu['plugin']) ? $menu['plugin'] : '';
        $controller = isset($menu['controller']) ? $menu['controller'] : '';
        $action = isset($menu['action']) ? $menu['action'] : '';
        $ordem = isset($menu['ordem']) ? $menu['ordem'] : '';
        
        
        $dados = array('Menu' => array());
        if(strlen($nome)){
            $dados['Menu']['nome'] = $nome;
        }

        if(strlen($plugin)){
            $dados['Menu']['plugin'] = $plugin;
        }

        if(strlen($controller)){
            $dados['Menu']['controller'] = $controller;
        }

        if(strlen($action)){
            $dados['Menu']['action'] = $action;
        }

        if(strlen($ordem)){
            $dados['Menu']['ordem'] = $ordem;
        }

        if(strlen($menu_id)){
            $dados['Menu']['menu_id'] = $menu_id;
        }

        return $dados;
    }
}