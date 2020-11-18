<?php

namespace OwBusca\Lib;

use Cake\Core\Configure;
use \Exception;
/**
 * Description of Config
 *
 * @author Gerson Felipe Schwinn <gerson@onehost.com.br>
 */
class Config {
    
    private $config;
    
    public function __construct($config = []) {
        $defaultConfig = [
            'camposTrim' => [],
            'trimTodosCampos' => false,
            'trocarEspacosDuplos' => false
        ];
        
        try{
            Configure::load('ow_busca');
            $config = $config + Configure::read('OwBusca');
        }catch(Exception $e){ }
        
        $this->config = $config + $defaultConfig;
    }
    
    public function getConfig() {
        return $this->config;
    }
    
    /**
     * @return boolean
     */
    public function trimTodosCampos($trim = null) {
        if($trim !== null) {
            $this->config['trimTodosCampos'] = $trim;
        }
        
        return $this->config['trimTodosCampos'];
    }
    
    /**
     * @return boolean
     */
    public function trocarEspacosDuplos() {
        return $this->config['trocarEspacosDuplos'];
    }
    
    /**
     * @return boolean
     */
    public function trimCampo($campo) {
        return in_array($campo, $this->config['camposTrim']);
    }
    
    public function addCampoTrim($campo) {
        if(is_string($campo)) {
            $this->config['camposTrim'][] = $campo;
            return true;
        }
        
        foreach($campo as $c) {
            $this->config['camposTrim'][] = $c;
        }
        
    }
    
    public function getCampos() {
        return array_keys($this->config['campos']);
    }
    
    public function existeCampo($campo) {
        return in_array($campo, $this->getCampos(), true);
    }
}
