<?php 
/* SVN FILE: $Id$ */
/* Analitico Fixture generated on: 2010-02-18 10:32:29 : 1266496349*/

class UsuarioFixture extends CakeTestFixture {
	var $name = 'Usuario';
	var $table = 'usuarios';
	var $import = 'OwCore.Usuario';
        
	var $records = array(
            array(
		'id' => 1,
                'usuario_grupo_id' => 1,
		'nome' => 'Gerson Felipe Schwinn',
		'email' => 'gerson@onehost.com.br',
		'senha' => '$1$8e0.vX3.$6pBO7TY8MuscKHNYetBMF.',
		'ativo' => '1',
		'created' => '2010-05-06 00:00:00',
                'updated' => '2010-05-06 00:00:00'
	)
          );
}
?>