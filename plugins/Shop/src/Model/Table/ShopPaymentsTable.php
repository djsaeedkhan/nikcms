<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopPayments Model
 *
 * @property \Shop\Model\Table\ShopOrdersTable&\Cake\ORM\Association\BelongsTo $ShopOrders
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Shop\Model\Entity\ShopPayment get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopPayment newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopPayment[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopPayment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopPayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopPayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopPayment[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopPayment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopPaymentsTable extends Table
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

        $this->setTable('shop_payments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShopOrders', [
            'foreignKey' => 'shop_order_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrders',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Users',
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
            ->scalar('terminalid')
            ->maxLength('terminalid', 20)
            ->requirePresence('terminalid', 'create')
            ->notEmptyString('terminalid');

        $validator
            ->scalar('price')
            ->maxLength('price', 15)
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->scalar('status')
            ->maxLength('status', 5)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('paid')
            ->maxLength('paid', 5)
            ->notEmptyString('paid');

        $validator
            ->scalar('au')
            ->maxLength('au', 50)
            ->allowEmptyString('au');

        $validator
            ->scalar('err_code')
            ->maxLength('err_code', 1000)
            ->allowEmptyString('err_code');

        $validator
            ->scalar('err_text')
            ->maxLength('err_text', 1000)
            ->allowEmptyString('err_text');

        $validator
            ->scalar('return_data')
            ->maxLength('return_data', 5000)
            ->allowEmptyString('return_data');

        $validator
            ->scalar('mobile_number')
            ->maxLength('mobile_number', 20)
            ->allowEmptyString('mobile_number');

        $validator
            ->scalar('myrahid')
            ->maxLength('myrahid', 20)
            ->allowEmptyString('myrahid');

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
        $rules->add($rules->existsIn(['shop_order_id'], 'ShopOrders'));
        //$rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
