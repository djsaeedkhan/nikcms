<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopBrands Model
 *
 * @method \Shop\Model\Entity\ShopBrand get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopBrand newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopBrand[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopBrand|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopBrand saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopBrand patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopBrand[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopBrand findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopBrandsTable extends Table
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

        $this->setTable('shop_brands');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
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
            ->scalar('title')
            ->maxLength('title', 50)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 100)
            ->allowEmptyString('slug');

        $validator
            ->scalar('descr')
            ->allowEmptyString('descr');

        $validator
            ->scalar('image')
            ->maxLength('image', 300)
            ->allowEmptyFile('image');

        $validator
            ->scalar('link')
            ->maxLength('link', 300)
            ->allowEmptyString('link');

        return $validator;
    }
}
