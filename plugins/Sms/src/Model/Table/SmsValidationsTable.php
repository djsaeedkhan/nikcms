<?php
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
 * @method \Sms\Model\Entity\SmsValidation get($primaryKey, $options = [])
 * @method \Sms\Model\Entity\SmsValidation newEmptyEntity($data = null, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation[] newEntities(array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sms\Model\Entity\SmsValidation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sms\Model\Entity\SmsValidation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation[] patchEntities($entities, array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsValidation findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'Sms.Users',
        ]);
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified'])) return true;
                if(is_array($entity->{$v})){
                    //$entity->{$v} = ($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
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
            ->allowEmptyString('id', null, 'create');

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
        //$rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
