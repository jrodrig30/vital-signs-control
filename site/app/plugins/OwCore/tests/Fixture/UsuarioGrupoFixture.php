<?php
/* OwGrupo Fixture generated on: 2010-12-07 16:12:15 : 1291745235 */
class UsuarioGrupoFixture extends CakeTestFixture {
	var $name = 'OwGrupo';

	var $import = 'OwCore.UsuarioGrupo';

	var $records = array(
		array(
			'id' => 1,
			'nome' => 'Admin',
			'identificacao' => 'admin',
			'root' => 0,
                        'created' => '2011-01-01 00:00:00',
                        'updated' => '2011-01-01 00:00:00',
		),
                array(
			'id' => 2,
			'nome' => 'Root',
			'identificacao' => 'root',
			'root' => 1,
                        'created' => '2011-01-01 00:00:00',
                        'updated' => '2011-01-01 00:00:00',
		),
	);
}
?>