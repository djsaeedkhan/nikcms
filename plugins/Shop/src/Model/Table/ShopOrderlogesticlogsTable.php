<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOrderlogesticlogs Model
 *
 * @property \Shop\Model\Table\ShopLogesticsTable&\Cake\ORM\Association\BelongsTo $ShopLogestics
 * @property \Shop\Model\Table\ShopOrdersTable&\Cake\ORM\Association\BelongsTo $ShopOrders
 * @property \Shop\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\BelongsTo $ShopOrderlogestics
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Shop\Model\Entity\ShopOrderlogesticlog get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderlogesticlog findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopOrderlogesticlogsTable extends Table
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

        $this->setTable('shop_orderlogesticlogs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShopLogestics', [
            'foreignKey' => 'shop_logestic_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopLogestics',
        ]);
        $this->belongsTo('ShopOrders', [
            'foreignKey' => 'shop_order_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrders',
        ]);
        $this->belongsTo('ShopOrderlogestics', [
            'foreignKey' => 'shop_orderlogestic_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrderlogestics',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Users',
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
            ->scalar('descr')
            ->maxLength('descr', 10000)
            ->requirePresence('descr', 'create')
            ->notEmptyString('descr');

        $validator
            ->scalar('image')
            ->maxLength('image', 100)
            ->allowEmptyFile('image');

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
        $rules->add($rules->existsIn(['shop_logestic_id'], 'ShopLogestics'));
        $rules->add($rules->existsIn(['shop_order_id'], 'ShopOrders'));
        $rules->add($rules->existsIn(['shop_orderlogestic_id'], 'ShopOrderlogestics'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
