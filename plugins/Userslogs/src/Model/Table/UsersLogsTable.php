<?php
declare(strict_types=1);

namespace Userslogs\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersLogs Model
 *
 * @property \Userslogs\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Userslogs\Model\Entity\UsersLog newEmptyEntity()
 * @method \Userslogs\Model\Entity\UsersLog newEntity(array $data, array $options = [])
 * @method \Userslogs\Model\Entity\UsersLog[] newEntities(array $data, array $options = [])
 * @method \Userslogs\Model\Entity\UsersLog get($primaryKey, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Userslogs\Model\Entity\UsersLog[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Userslogs\Model\Entity\UsersLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Userslogs\Model\Entity\UsersLog[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersLogsTable extends Table
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

        $this->setTable('users_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Userslogs.Users',
        ]);
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
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->scalar('username')
            ->maxLength('username', 100)
            ->allowEmptyString('username');

        $validator
            ->allowEmptyString('types');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        //$rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        //$rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
