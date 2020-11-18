<?php
namespace OwEventos\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Event\Event;

class EventoCategoriasTable extends Table {
    
    public function initialize(array $config) {
        $this->table('evento_categorias');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create')
                ->add('evento_categoria_id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('evento_categoria_id', 'create')
                ->requirePresence('nome', 'create')
                ->notEmpty('nome');

        return $validator;
    }

    public function listarNosFolha($separador = ' » ') {
        $retorno = array();
        
        $folhas = $this->find('all')
        ->select('id')
        //->distinct('evento_categoria_id')
        ->where('evento_categoria_id');

        foreach ($folhas as $folha) {
            $id = $folha['id'];
            $str = $this->getNomeFull($id, $separador);
            $retorno[$id] = $str;
        }

        return $retorno;
    }

    public function listarTodas($separador = ' » ') {
        $retorno = array();
        $options = array(
            'recursive' => -1,
        );

        $folhas = $this->find('all', $options);
        foreach ($folhas as $folha) {
            $id = $folha['id'];
            $str = $this->getNomeFull($id, $separador);
            $retorno[$id] = $str;
        }

        return $retorno;
    }

    public function getNomeFull($eventoCategoria, $separador = ' » ') {
        if (!is_array($eventoCategoria)) {
            $this->recursive = -1;
            $eventoCategoria = $this->get($eventoCategoria);
        }
        $evento_categoria_id = $eventoCategoria['evento_categoria_id'];
        $str = $eventoCategoria['nome'];
        while (strlen($evento_categoria_id)) {
            $this->recursive = -1;
            $cat = $this->get($evento_categoria_id);
            $str = $cat['nome'] . $separador . $str;
            $evento_categoria_id = $cat[$this->alias()]['evento_categoria_id'];
        }
        return $str;
    }

}
