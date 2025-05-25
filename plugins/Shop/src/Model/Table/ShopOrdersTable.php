<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOrders Model
 *
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Shop\Model\Table\ShopAddressesTable&\Cake\ORM\Association\BelongsTo $ShopAddresses
 * @property \Shop\Model\Table\ShopOrderlogesticlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogesticlogs
 * @property \Shop\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\HasMany $ShopOrderlogestics
 * @property \Shop\Model\Table\ShopOrderlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogs
 * @property \Shop\Model\Table\ShopOrderproductsTable&\Cake\ORM\Association\HasMany $ShopOrderproducts
 * @property \Shop\Model\Table\ShopOrderrefundsTable&\Cake\ORM\Association\HasMany $ShopOrderrefunds
 * @property \Shop\Model\Table\ShopOrdershippingsTable&\Cake\ORM\Association\HasMany $ShopOrdershippings
 * @property \Shop\Model\Table\ShopOrdertextsTable&\Cake\ORM\Association\HasMany $ShopOrdertexts
 * @property \Shop\Model\Table\ShopOrdertokensTable&\Cake\ORM\Association\HasMany $ShopOrdertokens
 * @property \Shop\Model\Table\ShopPaymentsTable&\Cake\ORM\Association\HasMany $ShopPayments
 *
 * @method \Shop\Model\Entity\ShopOrder get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopOrder newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopOrder[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrder|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrder saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrder findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopOrdersTable extends Table
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

        $this->setTable('shop_orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Shop.Users',
        ]);
        $this->belongsTo('ShopAddresses', [
            'foreignKey' => 'shop_address_id',
            'className' => 'Shop.ShopAddresses',
        ]);
        $this->hasMany('ShopOrderlogesticlogs', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrderlogesticlogs',
        ]);
        $this->hasMany('ShopOrderlogestics', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrderlogestics',
        ]);
        $this->hasMany('ShopOrderlogs', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrderlogs',
        ]);
        $this->hasMany('ShopOrderproducts', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrderproducts',
        ]);
        $this->hasMany('ShopOrderrefunds', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrderrefunds',
        ]);
        $this->hasMany('ShopOrdershippings', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrdershippings',
        ]);
        $this->hasMany('ShopOrdertexts', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrdertexts',
        ]);
        $this->hasMany('ShopOrdertokens', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopOrdertokens',
        ]);
        $this->hasMany('ShopPayments', [
            'foreignKey' => 'shop_order_id',
            'className' => 'Shop.ShopPayments',
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
            ->scalar('trackcode')
            ->maxLength('trackcode', 20)
            ->allowEmptyString('trackcode');

        $validator
            ->scalar('token')
            ->maxLength('token', 10)
            ->allowEmptyString('token');

        $validator
            ->scalar('shipmentcode')
            ->maxLength('shipmentcode', 50)
            ->allowEmptyString('shipmentcode');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 5)
            ->allowEmptyString('currency');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->notEmptyString('status');

        return $validator;
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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['shop_address_id'], 'ShopAddresses'));

        return $rules;
    }
}
