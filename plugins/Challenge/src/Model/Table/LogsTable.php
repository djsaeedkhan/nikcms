<?php
declare(strict_types=1);

namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
 *
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Challenge\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \Challenge\Model\Entity\Log newEmptyEntity()
 * @method \Challenge\Model\Entity\Log newEntity(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Log[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Log get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Log findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Challenge\Model\Entity\Log patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Log[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Log|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Log saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Challenge\Model\Entity\Log[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LogsTable extends Table
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

        $this->setTable('logs');
        $this->setDisplayField('group_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Users',
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Groups',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'log_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'users_logs',
            'className' => 'Challenge.Users',
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
            ->integer('id')
            ->requirePresence('id', 'create')
            ->notEmptyString('id');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('action_id')
            ->requirePresence('action_id', 'create')
            ->notEmptyString('action_id');

        $validator
            ->scalar('group_id')
            ->maxLength('group_id', 20)
            ->notEmptyString('group_id');

        $validator
            ->scalar('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('group_id', 'Groups'), ['errorField' => 'group_id']);

        return $rules;
    }
}
