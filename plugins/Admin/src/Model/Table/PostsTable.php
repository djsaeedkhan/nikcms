<?php
declare(strict_types=1);

namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Admin\View\Helper\FuncHelper;

/**
 * Posts Model
 *
 * @property \Admin\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Admin\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Admin\Model\Table\PostMetasTable&\Cake\ORM\Association\HasMany $PostMetas
 * @property \Admin\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property \Admin\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \Admin\Model\Entity\Post newEmptyEntity()
 * @method \Admin\Model\Entity\Post newEntity(array $data, array $options = [])
 * @method \Admin\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Post get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Post findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Admin\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Post[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Post|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Post saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Admin\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTable extends Table
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

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Translate', [
            'fields' => ['title','summary','content'],
            'translationTable' => 'PostsI18n',
            //'onlyTranslated' => true,
            //'defaultLocale' => 'fa',
            //'strategy' => 'subquery',
            //'allowEmptyTranslations' => false,
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Users',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'post_id',
            'className' => 'Admin.Comments',
        ]);
        $this->hasMany('PostMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Admin.PostMetas',
        ]);
        $this->hasMany('ShopFavorites', [
            'foreignKey' => 'post_id',
            'className' => 'Admin.ShopFavorites',
        ]);
        
        $this->belongsToMany('Categories', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'posts_categories',
            'className' => 'Admin.Categories',
        ]);
        $this->belongsToMany('I18n', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'i18n_id',
            'joinTable' => 'posts_i18n',
            'className' => 'Admin.I18n',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'posts_tags',
            'className' => 'Admin.Tags',
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
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

        $validator
            ->scalar('summary')
            ->allowEmptyString('summary');

        $validator
            ->scalar('content')
            ->maxLength('content', 4294967295)
            ->allowEmptyString('content');

        $validator
            ->allowEmptyFile('image');

        $validator
            ->boolean('published')
            ->notEmptyString('published');

        $validator
            ->allowEmptyString('post_status');

        $validator
            ->boolean('in_rss')
            ->notEmptyString('in_rss');

        $validator
            ->scalar('meta_title')
            ->maxLength('meta_title', 255)
            ->allowEmptyString('meta_title');

        $validator
            ->scalar('meta_description')
            ->maxLength('meta_description', 255)
            ->allowEmptyString('meta_description');

        $validator
            ->scalar('meta_keywords')
            ->maxLength('meta_keywords', 255)
            ->allowEmptyString('meta_keywords');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->scalar('post_type')
            ->requirePresence('post_type', 'create')
            ->notEmptyString('post_type');

        $validator
            ->integer('priority')
            ->allowEmptyString('priority');

        return $validator;
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();

        /* Log::write('debug', $modified);
        Log::write('debug',$entity);

        foreach((array) $entity as $v) {
            //var_dump($entity);

            $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
        } */

        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
               
                if(in_array($v,['created','modified'])) return true;
                if(is_array($entity->{$v})){
                    //$entity->{$v} = ($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags( (string) $entity->{$v},'<img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
