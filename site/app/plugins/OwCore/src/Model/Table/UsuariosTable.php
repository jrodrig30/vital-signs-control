<?php

namespace OwCore\Model\Table;


use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Usuarios Model
 */
class UsuariosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        $this->table('usuarios');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('UsuarioGrupos', [
            'foreignKey' => 'usuario_grupo_id',
            'joinType' => 'INNER',
            'className' => 'OwCore.UsuarioGrupos'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create')
                ->requirePresence('nome', 'create')
                ->notEmpty('nome')
                ->add('email', 'valid', ['rule' => 'email'])
                ->requirePresence('email', 'create')
                ->notEmpty('email')
                ->requirePresence('senha', 'create')
                ->notEmpty('senha')
                ->requirePresence('senha_confirma', 'create')
                ->notEmpty('senha_confirma')
                ->allowEmpty('obs')
                ->add('ativo', 'valid', ['rule' => 'boolean'])
                ->requirePresence('ativo', 'create')
                ->notEmpty('ativo');

        return $validator;
    }

    public function beforeRules(Event $event, Entity $entity, \ArrayObject $options, $operation) {
        $entity->nome = "Felipe";
        return $event;
    }
    
    public function beforeSave(Event $event, Entity $entity, \ArrayObject $options, $operation) {
        if (isset($entity->senha) && isset($entity->senha_confirma)) {
            $entity->senha = $this->getSenhaCriptografada($entity->senha);
            unset($entity->senha_confirma);
        }
        return true;
    }

    public function getSenhaCriptografada($senha, $salt = null) {
        return crypt($senha, $salt);
    }

    public function getSenhaAleatoria($digitos = 5) {
        $novaSenha = "";
        for ($x = 0; $x < $digitos; $x++) {
            $novaSenha .= rand(0, 9);
        }
        return $novaSenha;
    }

    public function trocarSenha($id, $novaSenha) {
        $senha = $this->getSenhaCriptografada($novaSenha);
        $query = $this->query();
        $query->update()
            ->set(['senha' => $senha])
            ->where(['id' => $id])
            ->execute();
        if (!$query->update()) {
            throw new Exception('Não foi possível salvar a nova senha!');
        }
    }

}
