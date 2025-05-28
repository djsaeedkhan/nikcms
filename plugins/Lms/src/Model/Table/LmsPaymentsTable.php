<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsPayments Model
 *
 * @property \Lms\Model\Table\LmsFactorsTable&\Cake\ORM\Association\BelongsTo $LmsFactors
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Lms\Model\Entity\LmsPayment get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsPayment newEmptyEntity(($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsPayment[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsPayment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsPayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsPayment[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsPayment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsPaymentsTable extends Table
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

        $this->setTable('lms_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LmsFactors', [
            'foreignKey' => 'lms_factor_id',
            'className' => 'Lms.LmsFactors',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Lms.Users',
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
                    $entity->{$v} = strip_tags($entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('token')
            ->maxLength('token', 100)
            ->allowEmptyString('token');

        $validator
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->allowEmptyString('terminal_ids');

        $validator
            ->scalar('auth')
            ->maxLength('auth', 100)
            ->allowEmptyString('auth');

        $validator
            ->scalar('RefID')
            ->maxLength('RefID', 100)
            ->allowEmptyString('RefID');

        $validator
            ->scalar('TraceID')
            ->maxLength('TraceID', 100)
            ->allowEmptyString('TraceID');

        $validator
            ->scalar('Errcode')
            ->maxLength('Errcode', 100)
            ->allowEmptyString('Errcode');

        $validator
            ->scalar('Errtext')
            ->maxLength('Errtext', 100)
            ->allowEmptyString('Errtext');

        $validator
            ->notEmptyString('status');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

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
        $rules->add($rules->existsIn(['lms_factor_id'], 'LmsFactors'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
