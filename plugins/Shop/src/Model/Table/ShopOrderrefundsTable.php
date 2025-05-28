<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOrderrefunds Model
 *
 * @property \Shop\Model\Table\ShopOrdersTable&\Cake\ORM\Association\BelongsTo $ShopOrders
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Shop\Model\Entity\ShopOrderrefund get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderrefund findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopOrderrefundsTable extends Table
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

        $this->setTable('shop_orderrefunds');
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
            ->requirePresence('types', 'create')
            ->notEmptyString('types');

        $validator
            ->allowEmptyString('status');

        $validator
            ->allowEmptyString('enable');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 2000)
            ->allowEmptyString('descr');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
