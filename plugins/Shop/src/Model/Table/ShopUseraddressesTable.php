<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopUseraddresses Model
 *
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Shop\Model\Entity\ShopUseraddress get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopUseraddress findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopUseraddressesTable extends Table
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

        $this->setTable('shop_useraddresses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('billing_state')
            ->requirePresence('billing_state', 'create')
            ->notEmptyString('billing_state');

        $validator
            ->scalar('billing_city')
            ->maxLength('billing_city', 100)
            ->requirePresence('billing_city', 'create')
            ->notEmptyString('billing_city');

        $validator
            ->scalar('billing_address')
            ->maxLength('billing_address', 500)
            ->requirePresence('billing_address', 'create')
            ->notEmptyString('billing_address');

        $validator
            ->scalar('billing_zip')
            ->maxLength('billing_zip', 12)
            ->allowEmptyString('billing_zip');

        $validator
            ->scalar('m1')
            ->maxLength('m1', 20)
            ->allowEmptyString('m1');

        $validator
            ->scalar('m2')
            ->maxLength('m2', 20)
            ->allowEmptyString('m2');

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

        return $rules;
    }
}
