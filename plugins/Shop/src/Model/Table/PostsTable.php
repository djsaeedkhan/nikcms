<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Shop\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Shop\Model\Table\PostMetasTable&\Cake\ORM\Association\HasMany $PostMetas
 * @property \Shop\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \Shop\Model\Table\ShopOrderproductsTable&\Cake\ORM\Association\HasMany $ShopOrderproducts
 * @property \Shop\Model\Table\ShopProductMetasTable&\Cake\ORM\Association\HasMany $ShopProductMetas
 * @property \Shop\Model\Table\ShopProductParamsTable&\Cake\ORM\Association\HasMany $ShopProductParams
 * @property \Shop\Model\Table\ShopProductdetailsTable&\Cake\ORM\Association\HasMany $ShopProductdetails
 * @property \Shop\Model\Table\ShopProductmajorsTable&\Cake\ORM\Association\HasMany $ShopProductmajors
 * @property \Shop\Model\Table\ShopProductpricesTable&\Cake\ORM\Association\HasMany $ShopProductprices
 * @property \Shop\Model\Table\ShopProductstocksTable&\Cake\ORM\Association\HasMany $ShopProductstocks
 * @property \Shop\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \Shop\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property \Shop\Model\Table\I18nTable&\Cake\ORM\Association\BelongsToMany $I18n
 * @property \Shop\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \Shop\Model\Entity\Post get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \Shop\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\Post|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\Post saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
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
            'translationTable' => 'PostsI18n']);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Shop.Users',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.Comments',
        ]);
        $this->hasMany('PostMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.PostMetas',
        ]);
        $this->hasMany('ShopFavorites', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopFavorites',
        ]);
        $this->hasMany('ShopOrderproducts', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopOrderproducts',
        ]);
        $this->hasMany('ShopProductMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopProductMetas',
        ]);
        $this->hasMany('ShopProductParams', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopProductParams',
        ]);
        $this->hasMany('ShopProductdetails', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopProductdetails',
        ]);
        $this->hasMany('ShopProductmajors', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopProductmajors',
        ]);
        $this->hasMany('ShopProductprices', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopProductprices',
        ]);
        $this->hasMany('ShopProductstocks', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.ShopProductstocks',
        ]);
        $this->hasMany('Tickets', [
            'foreignKey' => 'post_id',
            'className' => 'Shop.Tickets',
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'posts_categories',
            'className' => 'Shop.Categories',
        ]);
        $this->belongsToMany('I18n', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'i18n_id',
            'joinTable' => 'posts_i18n',
            'className' => 'Shop.I18n',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'posts_tags',
            'className' => 'Shop.Tags',
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
            ->scalar('image')
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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
