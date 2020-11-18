<?php
namespace OwCore\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use OwCore\Lib\PermissaoLib;
use Cake\ORM\TableRegistry;

class OwMenuSisComponent extends Component {
    
    var $Controller = null;
    var $menu_final = array();
    var $components = array('Auth');
    
    public function startup(Event $event) {
        $this->Controller = $this->_registry->getController();
    }

    public function getMenu() {
        $this->Menu = TableRegistry::get('OwCore.Menus');

        $menu_final = array();
        if (!PermissaoLib::sistemaAtivo()) {            
            return $menu_final;
        }        
        
        $full_menu = $this->Menu->getFullMenu();
        //debug($full_menu);
        //exit;
        foreach ($full_menu as $menu) {
           
            $url = $this->montaUrl($menu);
             
            $link = array(
                'nome' => $menu['nome'],
            );
            
            if(strlen($url)){   
                if (!PermissaoLib::temPermissaoUrl( PermissaoLib::getIdGrupoUsuarioSessao() , $url)) {
                    continue;
                }
                $link['url'] = $url;
            }
             
            $subMenus = $this->getSubMenus($menu);
            
            if (count($subMenus)) {
                $link['SubMenus'] = $subMenus;
            }
            
            if(count($subMenus) || strlen($url)){
                $menu_final[] = $link;
            }
            
        }

        return $menu_final;
    }
    
    private function montaUrl( $menu ){
        $link = '';

        if (strlen($menu['plugin'])) {
            $link .= '/' . $menu['plugin'];
        }

        if (strlen($menu['controller'])) {
            $link .= '/' . $menu['controller'];
        }
        
        if (strlen($menu['action'])) {
            $link .= '/' . $menu['action'];
        }

        return $link;
    }
    
    private function getSubMenus($menu){
        if(!isset($menu['SubMenus'])){
            return array();
        }
        
        $subMenus = array();
        foreach ($menu['SubMenus'] as $subMenu) {
            $url = $this->montaUrl($subMenu);
            if (PermissaoLib::temPermissaoUrl( PermissaoLib::getIdGrupoUsuarioSessao() , $url)) {
                 $s = array(
                    'nome' => $subMenu['nome'],
                    'url' => $url
                );
                
                $sub = $this->getSubMenus($subMenu);
                if(count($sub)){
                    $s['SubMenus'] = $sub;
                }
                $subMenus[] = $s;
            }
        }
        
        return $subMenus;
    }

}