<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopOrderproducts Model
 *
 * @property \Shop\Model\Table\ShopOrdersTable&\Cake\ORM\Association\BelongsTo $ShopOrders
 * @property \Shop\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \Shop\Model\Table\ShopOrderattributesTable&\Cake\ORM\Association\HasMany $ShopOrderattributes
 * @property \Shop\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\HasMany $ShopOrderlogestics
 *
 * @method \Shop\Model\Entity\ShopOrderproduct get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopOrderproduct findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopOrderproductsTable extends Table
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

        $this->setTable('shop_orderproducts');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ShopOrders', [
            'foreignKey' => 'shop_order_id',
            'joinType' => 'INNER',
            'className' => 'Shop.ShopOrders',
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.Posts',
        ]);
        $this->hasMany('ShopOrderattributes', [
            'foreignKey' => 'shop_orderproduct_id',
            'className' => 'Shop.ShopOrderattributes',
        ]);
        $this->hasMany('ShopOrderlogestics', [
            'foreignKey' => 'shop_orderproduct_id',
            'className' => 'Shop.ShopOrderlogestics',
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
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->notEmptyString('quantity');

        $validator
            ->scalar('price')
            ->maxLength('price', 15)
            ->notEmptyString('price');

        $validator
            ->scalar('subtotal')
            ->maxLength('subtotal', 15)
            ->allowEmptyString('subtotal');

        $validator
            ->scalar('attrs')
            ->maxLength('attrs', 50)
            ->allowEmptyString('attrs');

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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['shop_order_id'], 'ShopOrders'));
        $rules->add($rules->existsIn(['post_id'], 'Posts'));

        return $rules;
    }
}
