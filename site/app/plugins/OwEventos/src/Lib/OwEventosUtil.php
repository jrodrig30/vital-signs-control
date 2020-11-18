<?php
namespace OwEventos\Lib;

use Cake\Core\Configure;

class OwEventosUtil {
    
    public static function isCampoAtivo($campo){
        $desativados = Configure::read('OwEventos.CamposDesativados');
        if($desativados == NULL){
            return TRUE;
        }
        return !in_array($campo, $desativados, true);
    }
    
    public static function getTiposEventoConfig(){
        $tipos = Configure::read('OwEventos.TiposDeEvento');
        if($tipos == NULL){
            return array();
        }
        return $tipos;
    }
    
    public static function isMaisFotosAtiva(){
        return Configure::read('OwEventos.HabilitarMaisFotos') === TRUE;
    }
    
    public static function isCategoriasAtiva(){
        return Configure::read('OwEventos.HabilitarCategorias') === TRUE;
    }
    
    public static function getNumeroPastasEventoFoto(){
        $numero = Configure::read('OwEventos.NumeroPastasFotos');
        if($numero == NULL){
            return 2;
        }
        return $numero;
    }
    
    public static function getPastaEventoFoto($evento_id){
        $numeroPastas = self::getNumeroPastasEventoFoto();
        $pasta = '';
        for($x = 1; $x <= $numeroPastas; $x++){
            $pasta .= chr(rand(97, 122)) . rand(0,9);
            if($x < $numeroPastas){
                $pasta .= DS;
            }
        }
        return $pasta;
    }
    
    public static function getPastaEventoFotoWeb($pasta){
        return str_replace('\\', '/', $pasta);
    }
}
