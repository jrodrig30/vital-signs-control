<?php
namespace OwCore\View\Helper;

use OwCore\Lib\PermissaoLib;
use Cake\View\Helper\HtmlHelper;


class OwHtmlHelper extends HtmlHelper {
    
    public $helpers = array('Session', 'Form', 'Url');    

    private function isUrlExterna($url){
        return is_string($url) && preg_match('/^http(s)?/', $url);
    }

    private function getCurrentUsuarioGrupoId(){
        static $current_usuario_grupo_id = null;
        if($current_usuario_grupo_id == null){
            $current_usuario_grupo_id = PermissaoLib::getIdGrupoUsuarioSessao();
        }
        return $current_usuario_grupo_id;
    }
    
    public function url($url = null, $full = false) {
        if($this->temPermissao($url)){
            return $this->Url->build($url,$full);
        }
        return false;
    }

    public function link($title, $url = null, array $options = array()) {
        if($this->temPermissao($url)){
            return $this->Url->build($title, $url, $options);
        }

        return false;
    }
    
    public function postLink($title, $url = null, $options = array(), $confirmMessage = false) {
        if($this->temPermissao($url)){
            return $this->Form->postLink($title, $url, $options, $confirmMessage);
        }
        
        return false;
    }
    
    private function temPermissao($url){
        if(!PermissaoLib::sistemaAtivo()){
            return true;
        }
        
        if($this->isUrlExterna($url)){
            return true;
        }
        
        if(PermissaoLib::temPermissaoUrl($this->getCurrentUsuarioGrupoId(), $url)){
            return true;
        }
        
        return false;
    }
    
}