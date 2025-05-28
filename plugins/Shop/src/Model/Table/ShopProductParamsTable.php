<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopProductParams Model
 *
 * @property \Shop\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \Shop\Model\Table\ShopParamsTable&\Cake\ORM\Association\BelongsTo $ShopParams
 *
 * @method \Shop\Model\Entity\ShopProductParam get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopProductParam newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopProductParam[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductParam|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductParam saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductParam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductParam[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductParam findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopProductParamsTable extends Table
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

        $this->setTable('shop_product_params');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Posts',
        ]);
        $this->belongsTo('Paramlists', [
            'foreignKey' => 'shop_param_id',
            //'joinType' => 'INNER',
            'className' => 'Shop.ShopParamlists',
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
            ->scalar('value')
            ->maxLength('value', 1500)
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

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
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        ///$rules->add($rules->existsIn(['shop_param_id'], 'ShopParams'));

        return $rules;
    }
}
