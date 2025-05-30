<?php
declare(strict_types=1);

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Options Model
 *
 * @method \Admin\Model\Entity\Option newEmptyEntity()
 * @method \Admin\Model\Entity\Option newEntity(array $data, array $options = [])
 * @method \Admin\Model\Entity\Option[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Option get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Option findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Admin\Model\Entity\Option patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Option[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Option|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Option saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Option[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class OptionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('options');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('value')
            ->maxLength('value', 4294967295)
            ->allowEmptyString('value');

        $validator
            ->scalar('types')
            ->maxLength('types', 255)
            ->allowEmptyString('types');

        $validator
            ->integer('autoload')
            ->notEmptyString('autoload');

        return $validator;
    }
}
