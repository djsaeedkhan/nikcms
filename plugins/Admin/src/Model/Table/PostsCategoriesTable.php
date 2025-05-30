<?php
declare(strict_types=1);

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PostsCategories Model
 *
 * @property \Admin\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \Admin\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 *
 * @method \Admin\Model\Entity\PostsCategory newEmptyEntity()
 * @method \Admin\Model\Entity\PostsCategory newEntity(array $data, array $options = [])
 * @method \Admin\Model\Entity\PostsCategory[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\PostsCategory get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\PostsCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Admin\Model\Entity\PostsCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\PostsCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\PostsCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\PostsCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\PostsCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\PostsCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\PostsCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\PostsCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PostsCategoriesTable extends Table
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

        $this->setTable('posts_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Posts',
        ]);
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Categories',
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
            ->integer('post_id')
            ->notEmptyString('post_id');

        $validator
            ->integer('category_id')
            ->notEmptyString('category_id');

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
        $rules->add($rules->existsIn('post_id', 'Posts'), ['errorField' => 'post_id']);
        $rules->add($rules->existsIn('category_id', 'Categories'), ['errorField' => 'category_id']);

        return $rules;
    }
}
