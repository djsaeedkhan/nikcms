<?php
namespace Sms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SmsLogs Model
 *
 * @method \Sms\Model\Entity\SmsLog get($primaryKey, $options = [])
 * @method \Sms\Model\Entity\SmsLog newEmptyEntity($data = null, array $options = [])
 * @method \Sms\Model\Entity\SmsLog[] newEntities(array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsLog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sms\Model\Entity\SmsLog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sms\Model\Entity\SmsLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsLog[] patchEntities($entities, array $data, array $options = [])
 * @method \Sms\Model\Entity\SmsLog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SmsLogsTable extends Table
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

        $this->setTable('sms_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->maxLength('mobile', 20)
            ->requirePresence('mobile', 'create')
            ->notEmptyString('mobile');

        $validator
            ->scalar('message')
            ->maxLength('message', 500)
            ->allowEmptyString('message');

        $validator
            ->scalar('sender')
            ->maxLength('sender', 15)
            ->requirePresence('sender', 'create')
            ->notEmptyString('sender');

        $validator
            ->scalar('terminal')
            ->maxLength('terminal', 10)
            ->allowEmptyString('terminal');

        $validator
            ->scalar('status')
            ->maxLength('status', 25)
            ->allowEmptyString('status');

        $validator
            ->scalar('error')
            ->maxLength('error', 20)
            ->allowEmptyString('error');

        $validator
            ->scalar('error_text')
            ->maxLength('error_text', 200)
            ->allowEmptyString('error_text');

        return $validator;
    }
}
