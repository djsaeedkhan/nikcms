<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsFactors Model
 *
 * @property \Lms\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Lms\Model\Table\LmsCouponsTable&\Cake\ORM\Association\BelongsTo $LmsCoupons
 * @property \Lms\Model\Table\LmsPaymentsTable&\Cake\ORM\Association\HasMany $LmsPayments
 * @property \Lms\Model\Table\LmsUserfactorsTable&\Cake\ORM\Association\HasMany $LmsUserfactors
 *
 * @method \Lms\Model\Entity\LmsFactor get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsFactor newEntity($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsFactor[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsFactor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsFactor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsFactor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsFactor[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsFactor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsFactorsTable extends Table
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

        $this->setTable('lms_factors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Lms.Users',
        ]);
        $this->belongsTo('LmsCoupons', [
            'foreignKey' => 'lms_coupon_id',
            'className' => 'Lms.LmsCoupons',
        ]);
        $this->hasMany('LmsPayments', [
            'foreignKey' => 'lms_factor_id',
            'className' => 'Lms.LmsPayments',
        ]);
        $this->hasMany('LmsUserfactors', [
            'foreignKey' => 'lms_factor_id',
            'className' => 'Lms.LmsUserfactors',
            'dependent' => true,
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('user_ids')
            ->allowEmptyString('user_ids');

        $validator
            ->notEmptyString('price');

        $validator
            ->allowEmptyString('old_price');

        $validator
            ->notEmptyString('paid');

        $validator
            ->allowEmptyString('status');

        $validator
            ->scalar('descr')
            ->allowEmptyString('descr');

        $validator
            ->scalar('options')
            ->maxLength('options', 10000)
            ->allowEmptyString('options');

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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['lms_coupon_id'], 'LmsCoupons'));

        return $rules;
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
    
}
