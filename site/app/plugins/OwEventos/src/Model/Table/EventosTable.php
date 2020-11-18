<?php
namespace OwEventos\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Core\Exception\Exception;

class EventosTable extends Table {
    
    public function initialize(array $config) {
        $this->table('eventos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'img_destaque' => [
                'path' => '/uploads/eventos/img_destaque',
                'fields' => [
                    'dir' => 'photo_dir',
                    'size' => 'photo_size',
                    'type' => 'photo_type',
                ],
                'filesystem' => ['root' => PUBLIC_HTML],
            ],
        ]);
        $this->belongsTo('EventoCategorias', [
            'foreignKey' => 'evento_categoria_id',
            'joinType' => 'INNER',
            'className' => 'OwEventos.EventoCategorias'
        ]);
        $this->hasMany('EventoFotos', [
            'foreignKey' => 'evento_id',
            'joinType' => 'INNER',
            'className' => 'OwEventos.EventoFotos'
        ]);
    }
    
    public function validationDefault(Validator $validator) {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->add('descricao', 'valid', ['rule' => 'notBlank'])
            ->allowEmpty('descricao', 'create')
            ->add('destaque', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('destaque', 'create')
            ->requirePresence('img_destaque', 'create')
            ->notEmpty('img_destaque');
        return $validator;
    }
    
    public function getUltimasEventos($quantidade = 10, $options = array()) {
        $options_default = array(
            'conditions' => array(
                'Evento.data<= NOW()'
            ),
            'order' => 'Evento.data DESC',
            'fields' => 'Evento.id, Evento.titulo',
            'limit' => $quantidade
        );

        $options = array_merge_recursive($options_default, $options);
        return $this->find('all', $options);
    }

    public function getUltimaEvento($options = array()) {
        $options_default = array(
            'conditions' => array(
                'Evento.data <= NOW()'
            ),
            'order' => 'Evento.data DESC'
        );
        $options = array_merge_recursive($options_default, $options);
        return $this->find('first', $options);
    }

    public function getUltimaEventoDestaque($options = array()) {
        $options_default = array(
            'conditions' => array(
                'Evento.data <= NOW()',
                'Evento.destaque' => 1
            ),
            'order' => 'Evento.data DESC'
        );
        $options = array_merge_recursive($options_default, $options);
        return $this->find('first', $options);
    }

    public function getEvento($id, $options = array()) {
        $options_default = array(
            'conditions' => array(
                'Evento.id' => $id
            )
        );

        $options = array_merge_recursive($options_default, $options);

        $evento = $this->find('first', $options);
        if (empty($evento)) {
            throw new Exception('Notícia de código ' . $id . ' não encontrada!');
        }
        return $evento;
    }

    public function cancelarDestaques() {
        if (!$this->updateAll(array('destaque' => 0), array('Eventos.destaque' => 1))) {
            throw new Exception('Não foi possível cancelar os destaques!');
        }
    }

}
