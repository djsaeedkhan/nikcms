<?php
declare(strict_types=1);

namespace Ticketing\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \Ticketing\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Ticketing\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Ticketing\Model\Table\PostMetasTable&\Cake\ORM\Association\HasMany $PostMetas
 * @property \Ticketing\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \Ticketing\Model\Table\ShopOrderproductsTable&\Cake\ORM\Association\HasMany $ShopOrderproducts
 * @property \Ticketing\Model\Table\ShopProductMetasTable&\Cake\ORM\Association\HasMany $ShopProductMetas
 * @property \Ticketing\Model\Table\ShopProductParamsTable&\Cake\ORM\Association\HasMany $ShopProductParams
 * @property \Ticketing\Model\Table\ShopProductdetailsTable&\Cake\ORM\Association\HasMany $ShopProductdetails
 * @property \Ticketing\Model\Table\ShopProductmajorsTable&\Cake\ORM\Association\HasMany $ShopProductmajors
 * @property \Ticketing\Model\Table\ShopProductpricesTable&\Cake\ORM\Association\HasMany $ShopProductprices
 * @property \Ticketing\Model\Table\ShopProductstocksTable&\Cake\ORM\Association\HasMany $ShopProductstocks
 * @property \Ticketing\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \Ticketing\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsToMany $Categories
 * @property \Ticketing\Model\Table\I18nTable&\Cake\ORM\Association\BelongsToMany $I18n
 * @property \Ticketing\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \Ticketing\Model\Entity\Post newEmptyEntity()
 * @method \Ticketing\Model\Entity\Post newEntity(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Post get($primaryKey, $options = [])
 * @method \Ticketing\Model\Entity\Post findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Ticketing\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Post[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Post|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Post saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Ticketing\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Ticketing\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Ticketing\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Ticketing.Users',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.Comments',
        ]);
        $this->hasMany('PostMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.PostMetas',
        ]);
        $this->hasMany('ShopFavorites', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopFavorites',
        ]);
        $this->hasMany('ShopOrderproducts', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopOrderproducts',
        ]);
        $this->hasMany('ShopProductMetas', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopProductMetas',
        ]);
        $this->hasMany('ShopProductParams', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopProductParams',
        ]);
        $this->hasMany('ShopProductdetails', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopProductdetails',
        ]);
        $this->hasMany('ShopProductmajors', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopProductmajors',
        ]);
        $this->hasMany('ShopProductprices', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopProductprices',
        ]);
        $this->hasMany('ShopProductstocks', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.ShopProductstocks',
        ]);
        $this->hasMany('Tickets', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.Tickets',
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'posts_categories',
            'className' => 'Ticketing.Categories',
        ]);
        $this->belongsToMany('I18n', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'i18n_id',
            'joinTable' => 'posts_i18n',
            'className' => 'Ticketing.I18n',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'post_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'posts_tags',
            'className' => 'Ticketing.Tags',
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
