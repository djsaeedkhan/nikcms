<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comments Model
 *
 * @property \Admin\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \Admin\Model\Table\CommentsTable&\Cake\ORM\Association\BelongsTo $ParentComments
 * @property \Admin\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Admin\Model\Table\CommentMetasTable&\Cake\ORM\Association\HasMany $CommentMetas
 * @property \Admin\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $ChildComments
 *
 * @method \Admin\Model\Entity\Comment get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Comment newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Comment[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Comment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Comment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Comment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Comment[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Comment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class CommentsTable extends Table
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

        $this->setTable('comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER',
            'className' => 'Admin.Posts',
        ]);
        $this->belongsTo('ParentComments', [
            'className' => 'Admin.Comments',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Users',
        ]);
        $this->hasMany('CommentMetas', [
            'foreignKey' => 'comment_id',
            'className' => 'Admin.CommentMetas',
        ]);
        $this->hasMany('ChildComments', [
            'className' => 'Admin.Comments',
            'foreignKey' => 'parent_id',
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
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('author')
            ->maxLength('author', 255)
            ->allowEmptyString('author');

        $validator
            ->scalar('author_email')
            ->maxLength('author_email', 100)
            ->allowEmptyString('author_email');

        $validator
            ->scalar('author_url')
            ->maxLength('author_url', 200)
            ->allowEmptyString('author_url');

        $validator
            ->scalar('author_IP')
            ->maxLength('author_IP', 100)
            ->allowEmptyString('author_IP');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        $validator
            ->scalar('approved')
            ->maxLength('approved', 20)
            ->notEmptyString('approved');

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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        //$rules->add($rules->existsIn(['parent_id'], 'ParentComments'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
