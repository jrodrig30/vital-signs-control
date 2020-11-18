<?php
namespace OwCore\View\Helper;

use Cake\View\Helper;


class MenuHelpHelper extends Helper {
    
    public $helpers = array('OwCore.OwHtml', 'Url');
    
    public function addScripts(){
        
    }
    
    public function getHTMLMenu($menus){
        $html = '<ul class="sf-menu">';
        foreach($menus as $menu){
            $html .= '<li>';
            $html .= '<a href="'. (isset($menu['url']) ? $this->OwHtml->url($menu['url']) : '#') .'">' .  $menu['nome'] . '</a>';
            $html .= $this->getSubMenus($menu, 1);
            $html .= '</li>';
        }
        $html .= '</ul>';
        
        return $html;
    }
    
    private function getSubMenus(&$menu, $nivel){
        if(!isset($menu['SubMenus'])){
            return '';
        }
        
        $html = '<ul class="nivel_'. $nivel .'">';
        foreach($menu['SubMenus'] as $m){
            $html .= '<li>';
            $html .= '<a href="'. (isset($m['url']) ? $this->OwHtml->url($m['url']) : '#') .'">' .  $m['nome'] . '</a>';
            $html .= $this->getSubMenus($m, ($nivel + 1));
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
}