<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Chartevents Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Rows
 * @property \Cake\ORM\Association\BelongsTo $Subjects
 * @property \Cake\ORM\Association\BelongsTo $Hadms
 * @property \Cake\ORM\Association\BelongsTo $Icustays
 *
 * @method \App\Model\Entity\Chartevent get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chartevent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chartevent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chartevent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chartevent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chartevent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chartevent findOrCreate($search, callable $callback = null, $options = [])
 */
class DiagnosticosSinaisTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);
        $this->setTable('diagnosticos_sinais');
        $this->setPrimaryKey('id');
        $this->belongsTo('Sinais');
        $this->belongsTo('Diagnosticos');
             
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
}
