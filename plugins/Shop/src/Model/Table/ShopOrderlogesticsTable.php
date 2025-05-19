<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOrderlogestics Model
 *
 * @property \Shop\Model\Table\ShopOrdersTable&\Cake\ORM\Association\BelongsTo $ShopOrders
 * @property \Shop\Model\Table\ShopOrderproductsTable&\Cake\ORM\Association\BelongsTo $ShopOrderproducts
 * @property \Shop\Model\Table\ShopLogesticsTable&\Cake\ORM\Association\BelongsTo $ShopLogestics
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Shop\Model\Table\ShopOrderlogesticlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogesticlogs
 *
 * @method \Shop\Model\Entity\ShopOrderlogestic get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogestic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopOrderlogesticsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('shop_orderlogestics');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShopOrders', [
            'foreignKey' => 'shop_order_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrders',
        ]);
        $this->belongsTo('ShopOrderproducts', [
            'foreignKey' => 'shop_orderproduct_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrderproducts',
        ]);
        $this->belongsTo('ShopLogestics', [
            'foreignKey' => 'shop_logestic_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopLogestics',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Users',
        ]);
        $this->hasMany('ShopOrderlogesticlogs', [
            'foreignKey' => 'shop_orderlogestic_id',
            'className' => 'Shop.ShopOrderlogesticlogs',
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
            ->allowEmptyString('enable');

        $validator
            ->scalar('enable_descr')
            ->maxLength('enable_descr', 1000)
            ->allowEmptyString('enable_descr');

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
        $rules->add($rules->existsIn(['shop_order_id'], 'ShopOrders'));
        $rules->add($rules->existsIn(['shop_orderproduct_id'], 'ShopOrderproducts'));
        $rules->add($rules->existsIn(['shop_logestic_id'], 'ShopLogestics'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
