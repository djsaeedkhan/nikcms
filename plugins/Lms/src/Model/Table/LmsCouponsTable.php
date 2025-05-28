<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LmsCoupons Model
 *
 * @property \Lms\Model\Table\LmsFactorsTable&\Cake\ORM\Association\HasMany $LmsFactors
 *
 * @method \Lms\Model\Entity\LmsCoupon get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\LmsCoupon newEmptyEntity(($data = null, array $options = [])
 * @method \Lms\Model\Entity\LmsCoupon[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoupon|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoupon saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\LmsCoupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoupon[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\LmsCoupon findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LmsCouponsTable extends Table
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

        $this->setTable('lms_coupons');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('LmsFactors', [
            'foreignKey' => 'lms_coupon_id',
            'className' => 'Lms.LmsFactors',
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
            ->scalar('title')
            ->maxLength('title', 20)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('product_ids')
            ->allowEmptyString('product_ids');

        $validator
            ->integer('usage_limit_per_user')
            ->allowEmptyString('usage_limit_per_user');

        $validator
            ->integer('usage_limit_price')
            ->allowEmptyString('usage_limit_price');

        $validator
            ->integer('usage_count')
            ->allowEmptyString('usage_count');

        $validator
            ->integer('maximum_amount')
            ->allowEmptyString('maximum_amount');

        $validator
            ->scalar('product_categories')
            ->allowEmptyString('product_categories');

        $validator
            ->scalar('discount_type')
            ->maxLength('discount_type', 100)
            ->allowEmptyString('discount_type');

        $validator
            ->date('expiry_date')
            ->allowEmptyDate('expiry_date');


        $validator
            ->scalar('descr')
            ->allowEmptyString('descr');
        return $validator;
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified','expiry_date'])) return true;
                if(is_array($entity->{$v})){
                    $entity->{$v} = serialize($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags($entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
                }
            }
        }
        return true;
    }
}
