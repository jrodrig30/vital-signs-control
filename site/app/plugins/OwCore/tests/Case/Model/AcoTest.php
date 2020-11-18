<?php
/* Aco Test cases generated on: 2010-12-07 16:12:08 : 1291745888*/
App::import('Model', 'Aco');

class AcoTest extends CakeTestCase {
	var $fixtures = array('plugin.ow_core.aco',
                              'plugin.ow_core.permissao',
                              'plugin.ow_core.usuario',
                              'plugin.ow_core.usuario_grupo'
            );

	function startTest() {
		$this->Aco =& ClassRegistry::init('Aco');
	}

        function testFind(){
            $achou = $this->Aco->findById(1);
            $dados['Aco'] = array(
			'id' => 1,
			'tipo' => 'U',
			'plugin' => 'ow_core',
			'controller' => 'usuarios',
			'action' => 'index',
			'objeto' => ''
		);
            $this->assertEqual($achou, $dados);
        }

	function endTest() {
		unset($this->Aco);
		ClassRegistry::flush();
	}

}
?>