<?php
/* Aco Test cases generated on: 2010-12-07 16:12:08 : 1291745888*/
App::import('Model', array('OwCore.Aco','OwCore.Usuario'));
App::import('Lib', 'OwCore.PermissaoLib');

class PermissaoLibTest extends CakeTestCase {
	var $fixtures = array(
            'plugin.ow_core.permissao',
            'plugin.ow_core.aco',
            'plugin.ow_core.usuario',
            'plugin.ow_core.usuario_grupo'
            );

	function startTest() {

            $usuario_id = 1;

            $this->_cacheDisable = Configure::read('Cache.disable');
            Configure::write('Cache.disable', false);

            $this->_defaultCacheConfig = Cache::config('default');
            Cache::config('default', array('engine' => 'File', 'path' => TMP . 'tests'));
            
            $this->Aco =& ClassRegistry::init('Aco');
            $this->Usuario =& ClassRegistry::init('Usuario');
            PermissaoLib::makeLogout();
            PermissaoLib::makeLogin($this->Usuario->findById($usuario_id));
		
	}

        function endTest() {
                Configure::write('Cache.disable', $this->_cacheDisable);
		Cache::config('default', $this->_defaultCacheConfig['settings']);
		unset($this->Aco);
                unset($this->Usuario);
		ClassRegistry::flush();
                PermissaoLib::makeLogout( );

	}

        function testCarregaPermissoesBanco(){
            $permissoes = PermissaoLib::carregaPermissoesBanco(1);
            $esperado[] = array(
                        'tipo' => 'U',
                        'plugin' => 'ow_core',
                        'controller' => 'usuarios',
                        'action' => 'index',
                        'objeto' => ''
                    );
            $this->assertEqual($permissoes,$esperado);
        }

        function testCache(){
            $usuario_grupo_id = 1;
            PermissaoLib::removeCache($usuario_grupo_id);
            $permissoes = PermissaoLib::carregaPermissoesBanco($usuario_grupo_id);
            $this->assertTrue(PermissaoLib::gravaPermissoesCache( $usuario_grupo_id, $permissoes ));
            
            $permissoes2 = PermissaoLib::getPermissoesCache($usuario_grupo_id);
            $this->assertEqual($permissoes, $permissoes2);
            PermissaoLib::removeCache($usuario_grupo_id);
        }

        function testGetListaPermissoes(){
            $usuario_grupo_id = 1;
            $permissoes = PermissaoLib::getListaPermissoes($usuario_grupo_id);
            $esperado[] = array(
                        'tipo' => 'U',
                        'plugin' => 'ow_core',
                        'controller' => 'usuarios',
                        'action' => 'index',
                        'objeto' => ''
                    );
            $this->assertEqual($permissoes,$esperado);

            $permissoes = PermissaoLib::getListaPermissoes($usuario_grupo_id);
            $this->assertEqual($permissoes,$esperado);
            
        }
        
        function testTemPermissaoObjeto(){
            $usuario_grupo_id = 1;
            $this->assertFalse(PermissaoLib::temPermissaoObjeto($usuario_grupo_id, 'CancelarFatura'));
        }

        function testTemPermissaoUrl(){
            $usuario_grupo_id = 1;
            $this->assertFalse(PermissaoLib::temPermissaoUrl($usuario_grupo_id, '/ow_core/usuarios/delete'));
            $this->assertTrue(PermissaoLib::temPermissaoUrl($usuario_grupo_id, '/ow_core/usuarios/index'));
        }

        function testMontarAcoComUrl(){
            $url = '/ow_core/parametros/index';
            $esperado = array(
                'tipo' => Aco::getTipoUrl(),
                'plugin' => 'ow_core',
                'controller' => 'parametros',
                'action' => 'index'
            );

            $this->assertEqual($esperado, PermissaoLib::montarAcoComUrl($url));
        }

        function testTemPermissao(){
            $usuario_grupo_id = 1;
            $aco1 = PermissaoLib::montarAcoComUrl('/ow_core/parametros/index');
            $aco2 = PermissaoLib::montarAcoComObjeto('AlgumaCoisa');
            $aco3 = PermissaoLib::montarAcoComUrl('/ow_core/usuarios/index');
            $this->assertFalse(PermissaoLib::temPermissao($usuario_grupo_id, $aco1));
            $this->assertFalse(PermissaoLib::temPermissao($usuario_grupo_id, $aco2));
            $this->assertTrue(PermissaoLib::temPermissao($usuario_grupo_id, $aco3));
        }

        function testGetIdGrupoUsuarioSessao(){
            
        }

        function testAcosSaoIguais(){
            
        }

        function testIsUrlAcoAutorizada(){
            
        }

        function testAutorizarUrl(){
            $url = '/home/index';
            $this->assertFalse( PermissaoLib::temPermissaoUrl(null, $url) );
            PermissaoLib::autorizarUrl($url);
            $this->assertTrue( PermissaoLib::temPermissaoUrl(null, $url) );
        }


        function testIsRoot(){
            $usuario_grupo_id = 1;
            $this->assertFalse(PermissaoLib::isRoot($usuario_grupo_id));
        }

}
?>