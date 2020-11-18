<?php

namespace OwCore\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use OwCore\Model\Table\AppTable;

class UsuarioGruposTable extends Table {

    const ID_ROOT = 1;
    const ID_VISITANTE = 2;    
    
    public function initialize(array $config) {
        $this->table('usuario_grupos');
        $this->displayField('nome');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        
        $this->hasMany('Usuarios', [
           'className' => 'OwCore.Usuarios',
            'foreignKey' => 'usuario_grupo_id',
            'dependent' => false,
            'joinType' => 'INNER'
        ]);
    }
    
    public function validationDefault(Validator $validator) {
        return $validator
                        ->notEmpty('nome', 'Por favor preencha o nome!')
                        ->notEmpty('identificacao', 'Por favor preencha o nome!')
                        ->boolean('root');
    }

    public function isRoot($usuarioGrupoId) {        
        $usuarioGrupo = $this->get($usuarioGrupoId);
        return $usuarioGrupo->root;
    }

    public static function isRootRegistro($usuario_grupo) {
        return $usuario_grupo['UsuarioGrupo']['root'] == 1;
    }

    public function tornarRoot($usuario_grupo_id) {
        $this->id = $usuario_grupo_id;
        return $this->saveField('root', 1);
    }

    public function removerRoot($usuario_grupo_id) {
        $this->id = $usuario_grupo_id;
        return $this->saveField('root', 0);
    }

    public function beforeDelete($cascade = true) {
        if ($this->id == self::ID_ROOT) {
            return false;
        }

        if ($this->id == self::ID_VISITANTE) {
            return false;
        }

        parent::beforeDelete($cascade);
    }

}
