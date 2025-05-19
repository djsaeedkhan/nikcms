<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', [
            'fields' => ['title','description'],
            'translationTable' => 'CategoriesI18n']);

        $this->belongsToMany('Posts', [
            'foreignKey' => 'category_id',
            'targetForeignKey' => 'post_id',
            'joinTable' => 'posts_categories',
            'through' => 'PostsCategories',
            'className' => 'Admin.Posts'
        ]);
        $this->belongsTo('ParentCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id',
        ]);

        $this->hasMany('ChildrenCategories', [
            'className' => 'Categories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('CategorieMetas', [
            'foreignKey' => 'categorie_id',
            'className' => 'Admin.CategorieMetas'
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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('title')
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('slug')
            //->requirePresence('slug', 'create')
            ->allowEmpty('slug');

        $validator
            ->scalar('description')
            //->requirePresence('description', 'create')
            ->allowEmpty('description');

        $validator
            ->scalar('post_type')
            ->maxLength('post_type', 20)
            ->requirePresence('post_type', 'create')
            ->notEmpty('post_type');

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
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));
        return $rules;
    }
}
