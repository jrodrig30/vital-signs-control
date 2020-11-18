<?php
namespace OwCore\Lib;
use Cake\Routing\Router;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use OwCore\Model\Table\AcosTable;

class PermissaoLib {
    static $urlsAutorizadas = array();

    public static function autorizarUrl($url){
        self::$urlsAutorizadas[] = $url;
        return true;
    }

    public static function isUrlAcoAutorizada($aco){
        foreach(self::$urlsAutorizadas as $url){
            if( self::acosSaoIguais( self::montarAcoComUrl($url) , $aco) ){                
                return true;
            }
        }
        return false;
    }

    public static function isUrlAutorizada($url){
        return self::isUrlAcoAutorizada( self::montarAcoComUrl($url) );
    }
    
    public static function acosSaoIguais($acoOrigem,$acoDestino){
        if( AcosTable::isTipoUrl( $acoOrigem ) ){
            return $acoOrigem['tipo']        == $acoDestino['tipo'] &&
                   $acoOrigem['plugin']      == $acoDestino['plugin'] &&
                   $acoOrigem['controller']  == $acoDestino['controller'] &&
                   $acoOrigem['action']      == $acoDestino['action'];
        }
        
        if( AcosTable::isTipoObjeto( $acoOrigem ) ){
            return $acoOrigem['tipo']    == $acoDestino['tipo'] &&
                   $acoOrigem['objeto']  == $acoDestino['objeto'];
        }

        return false;
    }

    public static function isRoot($usuario_grupo_id){
        
        if(empty($usuario_grupo_id)) {
            return false;
        }
        
        static $roots = array();

        if( isset( $roots[$usuario_grupo_id] ) ){
            return $roots[$usuario_grupo_id];
        }

        $sessao = self::getObjetoSessao();
        if($sessao->check( 'OwCore.UsuarioGrupo.root' )){
            $isRoot = (bool) $sessao->read('OwCore.UsuarioGrupo.root');
            $roots[$usuario_grupo_id] = $isRoot;
            return $isRoot;
        }

        $grupo = TableRegistry::get('OwCore.UsuarioGrupos');
        $roots[$usuario_grupo_id] = $grupo->isRoot( $usuario_grupo_id );
        
        return $roots[$usuario_grupo_id];
        
    }

    public static function getObjetoSessao(){
        static $sessao = null;
        if($sessao == null){
            $sessao = Request::createFromGlobals()->session();
        }
        return $sessao;
    }

    public static function sistemaAtivo(){
        $sessao = self::getObjetoSessao();
        return $sessao->check( 'OwCore.UsuarioGrupo.id' );
    }

    public static function getIdGrupoUsuarioSessao(){
        $sessao = self::getObjetoSessao();
        return $sessao->read( 'OwCore.UsuarioGrupo.id');
    }

    public static function temPermissao($usuario_grupo_id,$aco){
        
        if(self::isRoot($usuario_grupo_id)){
            return true;
        }
        
        if(AcosTable::isTipoUrl($aco)){            
            if( self::isUrlAcoAutorizada($aco) ){
                return true;
            }
        }

        $listaPermissoes = self::getListaPermissoes($usuario_grupo_id);
        foreach($listaPermissoes as $permissao){
            if(self::acosSaoIguais($permissao, $aco)){
                return true;
            }
        }
        
        return false;
    }

    public static function montarAcoComUrl($url){
        if(is_string($url)){
            $dados = Router::parse( Router::normalize( $url ) );
        }else{
            $dados = $url;
        }
        
        return array(
            'tipo'          => AcosTable::getTipoUrl(),
            'plugin'        => $dados['plugin'],
            'controller'    => $dados['controller'],
            'action'        => $dados['action']
        );
    }

    public static function montarAcoComObjeto($objeto){
        return array(
            'tipo'          => AcosTable::getTipoObjeto(),
            'objeto'        => $objeto
        );
    }

    public static function temPermissaoUrl($usuario_grupo_id,$url){
        $aco = self::montarAcoComUrl($url);
        return self::temPermissao($usuario_grupo_id,  $aco );
    }

    public static function temPermissaoObjeto($usuario_grupo_id,$objeto){
        $aco = self::montarAcoComObjeto($objeto);
        return self::temPermissao($usuario_grupo_id, $aco);
    }
    
    public static function usuarioTemPermissaoObjeto($objeto){
        return self::temPermissaoObjeto(self::getIdGrupoUsuarioSessao(), $objeto);
    }
    
    public static function usuarioTemPermissaoUrl($objeto){
        return self::temPermissaoUrl(self::getIdGrupoUsuarioSessao(), $objeto);
    }

    public static function getListaPermissoes($usuario_grupo_id){

        static $permissoes = array();

        if(!strlen($usuario_grupo_id)){
            return array();
        }

        if(isset($permissoes[$usuario_grupo_id])){
            return $permissoes[$usuario_grupo_id];
        }

        $cache = self::getPermissoesCache($usuario_grupo_id);
        if($cache !== false){
            $permissoes[$usuario_grupo_id] = $cache;
            return $cache;
        }

        $permissoesBanco = self::carregaPermissoesBanco($usuario_grupo_id);
        $permissoes[$usuario_grupo_id] = $permissoesBanco;
        self::gravaPermissoesCache($usuario_grupo_id, $permissoesBanco);

        return $permissoesBanco;
    }
    
    private static function configCache(){
        Cache::config('core_config', array(
            'engine' => 'File',
            'duration' => '+30 days',
            'probability' => 100,
            'path' => CACHE,
        ));
    }

    public static function getPermissoesCache($usuario_grupo_id){
        self::configCache();
        return Cache::read('ow_core_permissao_' . $usuario_grupo_id, 'core_config');
    }

    public static function gravaPermissoesCache($usuario_grupo_id, $permissoes){
        self::configCache();
        return Cache::write('ow_core_permissao_' . $usuario_grupo_id,$permissoes, 'core_config');
    }

    public static function removeCache($usuario_grupo_id){
        self::configCache();
        return Cache::delete('ow_core_permissao_' . $usuario_grupo_id, 'core_config');
    }

    public static function carregaPermissoesBanco($usuario_grupo_id){
        $p = ClassRegistry::init('Permissao');
        $permissoes = $p->getPermissoesDoGrupo( $usuario_grupo_id );
        $retorno = array();
        foreach($permissoes as $permissao){
            $retorno[] = array(
                'tipo'          => $permissao['Aco']['tipo'],
                'plugin'        => $permissao['Aco']['plugin'],
                'controller'    => $permissao['Aco']['controller'],
                'action'        => $permissao['Aco']['action'],
                'objeto'        => $permissao['Aco']['objeto'],
            );
        }

        return $retorno;
    }

    public static function makeLogin($usuario){
        $sessao = self::getObjetoSessao();
        $UGrupo = TableRegistry::get('OwCore.UsuarioGrupos');
        $sessao->write('OwCore.UsuarioGrupo.root', $UGrupo->isRoot( $usuario['usuario_grupo_id'] ) );
        $sessao->write('OwCore.UsuarioGrupo.id', $usuario['usuario_grupo_id']  );
        return true;
    }

    public static function makeLogout(){
        $sessao = self::getObjetoSessao();
        $sessao->delete('OwCore');
        return true;
    }
}