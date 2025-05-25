<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class TagsTable extends Table
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
        $this->setTable('tags');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', [
            'fields' => ['title']]);


        $this->belongsToMany('Posts', [
            'foreignKey' => 'tag_id',
            'targetForeignKey' => 'post_id',
            'joinTable' => 'posts_tags',
            'className' => 'Admin.Posts'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            //->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            //->requirePresence('slug', 'create')
            ->allowEmpty('slug');

            //->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('meta_title')
            ->maxLength('meta_title', 255)
            ->allowEmpty('meta_title');

        $validator
            ->scalar('meta_description')
            ->allowEmpty('meta_description');

        $validator
            ->scalar('meta_keywords')
            ->allowEmpty('meta_keywords');

        $validator
            ->scalar('post_type')
            ->maxLength('post_type', 255)
            ->allowEmpty('post_type');

        return $validator;
    }

    public function findOwnedBy(Query $query, array $options)
    {
        $slug = $options['slug'];
        return $query->where(['slug' => $slug]);
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
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->isUnique(['slug']));
        return $rules;
    }
}
