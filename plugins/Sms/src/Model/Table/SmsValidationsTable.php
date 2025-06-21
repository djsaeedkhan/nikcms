<?php
declare(strict_types=1);

namespace Sms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SmsValidations Model
 *
 * @property \Sms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Sms\Model\Entity\SmsValidation newEmptyEntity()
 * @method \Sms\Model\Entity\SmsValidation newEntity(array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation[] newEntities(array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation get($primaryKey, $options = [])
 * @method \Sms\Model\Entity\SmsValidation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Sms\Model\Entity\SmsValidation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sms\Model\Entity\SmsValidation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sms\Model\Entity\SmsValidation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Sms\Model\Entity\SmsValidation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Sms\Model\Entity\SmsValidation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Sms\Model\Entity\SmsValidation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SmsValidationsTable extends Table
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

        $this->setTable('sms_validations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Sms.Users',
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
            ->notEmptyString('user_id');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 11)
            ->allowEmptyString('mobile');

        $validator
            ->scalar('code')
            ->maxLength('code', 10)
            ->allowEmptyString('code');

        $validator
            ->boolean('status')
            ->notEmptyString('status');

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
        //$rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
