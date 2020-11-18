<?php 

class ParametroFixture extends CakeTestFixture {
	var $name = 'Parametro';
	var $table = 'parametros';
        public $import = array('model' => 'OwCore.Parametro', 'records' => true);
        
	var $records = array(
            array(
		'id' => 1,
		'nome' => 'AMBIENTE_NFE',
		'valor' => 2,
		'obs' => '',
	),
          array(
		'id' => 2,
		'nome' => 'HOST_FTP',
		'valor' => '187.54.166.2',
		'obs' => '',
            ),

            array(
		'id' => 3,
		'nome' => 'USUARIO_FTP',
		'valor' => 'utilar',
		'obs' => '',
            ),
            array(
		'id' => 4,
		'nome' => 'SENHA_FTP',
		'valor' => 'ut1l4r',
		'obs' => '',
            ),
            array(
		'id' => 5,
		'nome' => 'ULTIMO_CODIGO_BARRAS',
		'valor' => '0',
		'obs' => '',
            ),
        );
}
?>