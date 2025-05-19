<?php
namespace Admin\Model\Table;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategorieMetasTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->setTable('post_metas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Translate', ['fields' => ['meta_value']]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');
        $validator
            ->scalar('meta_key')
            ->maxLength('meta_key', 255)
            ->allowEmpty('meta_key');
        $validator
            ->scalar('meta_value')
            ->maxLength('meta_value', 4294967295)
            ->allowEmpty('meta_value');
        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->existsIn(['post_id'], 'Posts'));
        return $rules;
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
}