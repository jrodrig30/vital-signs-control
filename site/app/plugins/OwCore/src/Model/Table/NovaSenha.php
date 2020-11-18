<?php
namespace OwCore\Model\Table;

class NovaSenha extends AppTable {
	var $name = 'NovaSenha';
	var $validate = array(
		'email' => array(
			'rule' => 'email', 
			'message' => 'Preencha corretamente o campo email!',
			'required' => true
		)
	);
	var $useTable = false;
}