<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopProductstocks Model
 *
 * @property \Shop\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \Shop\Model\Entity\ShopProductstock get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopProductstock newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopProductstock[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductstock|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductstock saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProductstock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductstock[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProductstock findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopProductstocksTable extends Table
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

        $this->setTable('shop_productstocks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Posts',
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
            ->scalar('pattern')
            ->maxLength('pattern', 100)
            ->allowEmptyString('pattern');

        $validator
            ->integer('stock')
            ->notEmptyString('stock');

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

        return $rules;
    }
}
