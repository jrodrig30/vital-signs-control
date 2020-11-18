<?php
/* Menu Test cases generated on: 2010-12-20 14:12:41 : 1292861561*/
App::import('Model', 'Menu');

class MenuTest extends CakeTestCase {
	var $fixtures = array('app.ow_menu');

	function startTest() {
		$this->Menu =& ClassRegistry::init('Menu');
	}

	function endTest() {
		unset($this->Menu);
		ClassRegistry::flush();
	}

}
?>