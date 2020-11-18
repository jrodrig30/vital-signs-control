<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DItems Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Rows
 *
 * @method \App\Model\Entity\DItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\DItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DItem findOrCreate($search, callable $callback = null, $options = [])
 */
class DItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('d_items');
        $this->setDisplayField('row_id');
        $this->setPrimaryKey('row_id');

        $this->belongsTo('Rows', [
            'foreignKey' => 'row_id',
            'joinType' => 'INNER'
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
            ->requirePresence('itemid', 'create')
            ->notEmpty('itemid')
            ->add('itemid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('label');

        $validator
            ->allowEmpty('abbreviation');

        $validator
            ->allowEmpty('dbsource');

        $validator
            ->allowEmpty('linksto');

        $validator
            ->allowEmpty('category');

        $validator
            ->allowEmpty('unitname');

        $validator
            ->allowEmpty('param_type');

        $validator
            ->integer('conceptid')
            ->allowEmpty('conceptid');

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
        $rules->add($rules->isUnique(['itemid']));
        $rules->add($rules->existsIn(['row_id'], 'Rows'));

        return $rules;
    }
}
