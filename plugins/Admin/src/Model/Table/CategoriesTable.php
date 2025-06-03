<?php
declare(strict_types=1);

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Admin\Model\Table\PostsTable&\Cake\ORM\Association\BelongsToMany $Posts
 *
 * @method \Admin\Model\Entity\Category newEmptyEntity()
 * @method \Admin\Model\Entity\Category newEntity(array $data, array $options = [])
 * @method \Admin\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Category get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Category findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Admin\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Category[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Category|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Category saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class CategoriesTable extends Table
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

        $this->setTable('categories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('ParentCategories', [
            'className' => 'Admin.Categories',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildCategories', [
            'className' => 'Admin.Categories',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsToMany('I18n', [
            'foreignKey' => 'category_id',
            'targetForeignKey' => 'i18n_id',
            'joinTable' => 'categories_i18n',
            'className' => 'Admin.I18n',
        ]);
        $this->belongsToMany('Posts', [
            'foreignKey' => 'category_id',
            'targetForeignKey' => 'post_id',
            'joinTable' => 'posts_categories',
            'className' => 'Admin.Posts',
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
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->allowEmptyString('slug');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->integer('parent_id')
            ->allowEmptyString('parent_id');

        $validator
            ->scalar('post_type')
            ->maxLength('post_type', 20)
            ->allowEmptyString('post_type');

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
        //$rules->add($rules->existsIn('parent_id', 'ParentCategories'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
