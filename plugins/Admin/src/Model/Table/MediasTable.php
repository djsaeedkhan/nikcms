<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Medias Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Users
 * @property &\Cake\ORM\Association\HasMany $Comments
 * @property \Admin\Model\Table\PostMetasTable&\Cake\ORM\Association\HasMany $PostMetas
 * @property &\Cake\ORM\Association\HasMany $ShopFavorites
 * @property &\Cake\ORM\Association\HasMany $ShopOrderproducts
 * @property &\Cake\ORM\Association\HasMany $ShopProductMetas
 * @property &\Cake\ORM\Association\HasMany $ShopProductParams
 * @property &\Cake\ORM\Association\HasMany $ShopProductdetails
 * @property &\Cake\ORM\Association\HasMany $ShopProductmajors
 * @property &\Cake\ORM\Association\HasMany $ShopProductprices
 * @property &\Cake\ORM\Association\HasMany $ShopProductstocks
 * @property &\Cake\ORM\Association\HasMany $Tickets
 * @property \Admin\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property &\Cake\ORM\Association\BelongsToMany $I18n
 * @property &\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \Admin\Model\Entity\Media get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Media newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Media[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Media|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Media saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Media patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Media[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Media findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MediasTable extends Table
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

        $this->setTable('posts');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasMany('PostMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Admin.PostMetas',
            'dependent' => true,
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Users',
        ]);
        /* $this->hasMany('Comments', [
            'foreignKey' => 'post_id',
            'className' => 'Admin.Comments',
        ]); */
        $this->hasMany('PostMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Admin.PostMetas',
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'posts_categories',
            'className' => 'Admin.Categories'
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
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

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
            //->scalar('image')
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
            ->scalar('post_type')
            ->requirePresence('post_type', 'create')
            ->notEmptyString('post_type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
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
        //$rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
