<?php
namespace Admin\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Admin\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \Admin\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Admin\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \Admin\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \Admin\Model\Table\PollVotesTable&\Cake\ORM\Association\HasMany $PollVotes
 * @property \Admin\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \Admin\Model\Table\ProfilesTable&\Cake\ORM\Association\HasMany $Profiles
 * @property \Admin\Model\Table\SmsValidationsTable&\Cake\ORM\Association\HasMany $SmsValidations
 * @property \Admin\Model\Table\UserMetasTable&\Cake\ORM\Association\HasMany $UserMetas
 * @property \Admin\Model\Table\LogsTable&\Cake\ORM\Association\BelongsToMany $Logs
 *
 * @method \Admin\Model\Entity\User get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'Admin.Roles',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Comments',
        ]);
        $this->hasMany('FormbuilderDatas', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.FormbuilderDatas',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Logs',
        ]);
        $this->hasMany('PollVotes', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.PollVotes',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Posts',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.Profiles',
        ]);
        $this->hasMany('SmsValidations', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.SmsValidations',
        ]);
        $this->hasMany('UserMetas', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.UserMetas',
        ]);
        /* $this->belongsToMany('UsersLogs', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'log_id',
            'joinTable' => 'users_logs',
            'className' => 'Admin.UsersLogs',
        ]); */
        $this->hasMany('UsersLogs', [
            'foreignKey' => 'user_id',
            'className' => 'Admin.UsersLogs',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->notEmptyString('username');
            
        $validator
            ->add('username', 'validFormat',[
                'rule' => array('custom', '/^[a-z0-9]*$/i'),
                'message' => 'فقط حروف انگلیسی و عدد ' ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password', null, 'update')
            ->add('password', [
            'minLength' => [
                'rule' => ['minLength', 8],
                'last' => true,
                'message' => 'رمز عبور میبایست بیشتر از 8 کاراکتر باشد'
            ],
            'maxLength' => [
                'rule' => ['maxLength', 255],
                'message' => 'رمز عبور طولانی می باشد'
            ]
        ]);

        /* $validator
            ->add('password', 'validFormat',[
                'rule' =>  ['minLength', 8],
                'message' => 'رمز عبور نمیتواند از 9 کاراکتر کمتر باشد' ]); */
                
        $validator
            ->scalar('family')
            ->maxLength('family', 50)
            ->allowEmptyString('family');

        $validator
            ->email('email')
            ->allowEmptyString('email', null, 'update');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 15)
            ->allowEmptyString('phone');

        $validator
            ->boolean('enable')
            ->notEmptyString('enable');

        $validator
            ->scalar('token')
            ->maxLength('token', 50)
            ->allowEmptyString('token');

        $validator
            ->dateTime('expired')
            ->allowEmptyDateTime('expired');
            
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
        $rules->add($rules->isUnique(['username']));
        //$rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        return $query
            ->where(['Users.enable' => 1 ])
            ->contain(['Roles','UserMetas']);
    }
    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified','expired'])) return true;
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
