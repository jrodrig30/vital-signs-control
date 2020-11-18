<?php
namespace OwCore\Model\Entity;

use Cake\ORM\Entity;

class TrocarSenha extends Entity {
    
    public function checaSenhaIguais($dados){
            return $dados['senha'] == $dados['senha_confirma'];
        }

}