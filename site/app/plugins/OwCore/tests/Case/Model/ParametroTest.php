<?php 
App::import('Model', 'OwCore.Parametro');
class ParametroTest extends CakeTestCase {
    var $Parametro = null;
    var $fixtures = array();

    function startTest() {
        $this->Parametro =& ClassRegistry::init('Parametro');
    }

    function testParametroInstance() {
        $this->assertTrue(is_a($this->Parametro, 'Parametro'));
    }
}
?>