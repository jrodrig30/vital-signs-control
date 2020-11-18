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
class CharteventsTable extends Table
{
    const SINAL_HEART_RATE =  211;
    const SINAL_RESPIRATORY_RATE =  618;
    const SINAL_TEMPERATURE =  676;
    const SINAL_SPO2 = 646;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('chartevents');
        $this->setDisplayField('row_id');
        $this->setPrimaryKey('row_id');

        $this->belongsTo('Rows', [
            'foreignKey' => 'row_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Subjects', [
            'foreignKey' => 'subject_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Hadms', [
            'foreignKey' => 'hadm_id'
        ]);
        $this->belongsTo('Icustays', [
            'foreignKey' => 'icustay_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('itemid')
            ->allowEmpty('itemid');

        $validator
            ->dateTime('charttime')
            ->allowEmpty('charttime');

        $validator
            ->dateTime('storetime')
            ->allowEmpty('storetime');

        $validator
            ->integer('cgid')
            ->allowEmpty('cgid');

        $validator
            ->allowEmpty('value');

        $validator
            ->numeric('valuenum')
            ->allowEmpty('valuenum');

        $validator
            ->allowEmpty('valueuom');

        $validator
            ->integer('warning')
            ->allowEmpty('warning');

        $validator
            ->integer('error')
            ->allowEmpty('error');

        $validator
            ->allowEmpty('resultstatus');

        $validator
            ->allowEmpty('stopped');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['row_id'], 'Rows'));
        $rules->add($rules->existsIn(['subject_id'], 'Subjects'));
        $rules->add($rules->existsIn(['hadm_id'], 'Hadms'));
        $rules->add($rules->existsIn(['icustay_id'], 'Icustays'));

        return $rules;
    }

    public function getHistorico(){
        $conn = ConnectionManager::get('default');

        $sql = "SELECT  DISTINCT       ON(C1.row_id) C1.row_id, 
               C1.subject_id as paciente,
               C1.value as frequencia_cardiaca,
                       C2.value as frequencia_respiratoria, 
                       C3.value as temperature,
                       C4.value as pressao_sys,
                       C5.value as pressao_dias,
                       C1.charttime as horario_hr
                FROM chartevents C1,chartevents C2, chartevents C3, chartevents C4, chartevents C5
                WHERE C1.subject_id = 3 
                AND C1.value is not null
                AND C2.value is not null
                AND C3.value is not null 
                AND C3.value != '0'
                AND C2.value != '0'
                AND C1.value != '0'
                AND C1.itemid = 211
                AND C2.itemid = 618 
                AND C3.itemid = 676
                AND C4.itemid = 51
                AND C5.itemid = 8368 
                AND (C1.charttime = C2.charttime and C3.charttime = C1.charttime and C1.charttime = C4.charttime and C5.charttime = C1.charttime) 
                LIMIT 20;";
        return $conn->execute($sql)->fetchAll('assoc');
    }
}
