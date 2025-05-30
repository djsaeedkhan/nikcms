<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Challenge\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \Challenge\Model\Table\ChallengeblueticksTable&\Cake\ORM\Association\HasMany $Challengeblueticks
 * @property \Challenge\Model\Table\ChallengefollowersTable&\Cake\ORM\Association\HasMany $Challengefollowers
 * @property \Challenge\Model\Table\ChallengeforumsTable&\Cake\ORM\Association\HasMany $Challengeforums
 * @property \Challenge\Model\Table\ChallengeqanswersTable&\Cake\ORM\Association\HasMany $Challengeqanswers
 * @property \Challenge\Model\Table\ChallengesTable&\Cake\ORM\Association\HasMany $Challenges
 * @property \Challenge\Model\Table\ChallengeuserformsTable&\Cake\ORM\Association\HasMany $Challengeuserforms
 * @property \Challenge\Model\Table\ChallengeuserprofilesTable&\Cake\ORM\Association\HasMany $Challengeuserprofiles
 * @property \Challenge\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Challenge\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \Challenge\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \Challenge\Model\Table\LmsCoursesTable&\Cake\ORM\Association\HasMany $LmsCourses
 * @property \Challenge\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \Challenge\Model\Table\LmsCourseusersTable&\Cake\ORM\Association\HasMany $LmsCourseusers
 * @property \Challenge\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 * @property \Challenge\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \Challenge\Model\Table\LmsExamsTable&\Cake\ORM\Association\HasMany $LmsExams
 * @property \Challenge\Model\Table\LmsExamusersTable&\Cake\ORM\Association\HasMany $LmsExamusers
 * @property \Challenge\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 * @property \Challenge\Model\Table\LmsUserprofilesTable&\Cake\ORM\Association\HasMany $LmsUserprofiles
 * @property \Challenge\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \Challenge\Model\Table\PollVotesTable&\Cake\ORM\Association\HasMany $PollVotes
 * @property \Challenge\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \Challenge\Model\Table\ProfilesTable&\Cake\ORM\Association\HasMany $Profiles
 * @property \Challenge\Model\Table\ShopAddressesTable&\Cake\ORM\Association\HasMany $ShopAddresses
 * @property \Challenge\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \Challenge\Model\Table\ShopOrderlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogs
 * @property \Challenge\Model\Table\ShopOrderrefundsTable&\Cake\ORM\Association\HasMany $ShopOrderrefunds
 * @property \Challenge\Model\Table\ShopOrdersTable&\Cake\ORM\Association\HasMany $ShopOrders
 * @property \Challenge\Model\Table\ShopOrdershippingsTable&\Cake\ORM\Association\HasMany $ShopOrdershippings
 * @property \Challenge\Model\Table\ShopOrdertextsTable&\Cake\ORM\Association\HasMany $ShopOrdertexts
 * @property \Challenge\Model\Table\ShopOrdertokensTable&\Cake\ORM\Association\HasMany $ShopOrdertokens
 * @property \Challenge\Model\Table\ShopPaymentsTable&\Cake\ORM\Association\HasMany $ShopPayments
 * @property \Challenge\Model\Table\ShopProfilesTable&\Cake\ORM\Association\HasMany $ShopProfiles
 * @property \Challenge\Model\Table\ShopUseraddressesTable&\Cake\ORM\Association\HasMany $ShopUseraddresses
 * @property \Challenge\Model\Table\SmsValidationsTable&\Cake\ORM\Association\HasMany $SmsValidations
 * @property \Challenge\Model\Table\TicketauditsTable&\Cake\ORM\Association\HasMany $Ticketaudits
 * @property \Challenge\Model\Table\TicketcommentsTable&\Cake\ORM\Association\HasMany $Ticketcomments
 * @property \Challenge\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \Challenge\Model\Table\TmpChallengeformsTable&\Cake\ORM\Association\HasMany $TmpChallengeforms
 * @property \Challenge\Model\Table\TmpMembersTable&\Cake\ORM\Association\HasMany $TmpMembers
 * @property \Challenge\Model\Table\TmpPersonlikesTable&\Cake\ORM\Association\HasMany $TmpPersonlikes
 * @property \Challenge\Model\Table\TmpPersonsTable&\Cake\ORM\Association\HasMany $TmpPersons
 * @property \Challenge\Model\Table\TmpProblemformsTable&\Cake\ORM\Association\HasMany $TmpProblemforms
 * @property \Challenge\Model\Table\TmpProblemsTable&\Cake\ORM\Association\HasMany $TmpProblems
 * @property \Challenge\Model\Table\UserMetasTable&\Cake\ORM\Association\HasMany $UserMetas
 * @property \Challenge\Model\Table\ChallengetagsTable&\Cake\ORM\Association\BelongsToMany $Challengetags
 * @property \Challenge\Model\Table\LogsTable&\Cake\ORM\Association\BelongsToMany $Logs
 *
 * @method \Challenge\Model\Entity\User get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\User newEmptyEntity($data = null, array $options = [])
 * @method \Challenge\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'className' => 'Challenge.Roles',
        ]);
        $this->hasMany('Challengeblueticks', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challengeblueticks',
        ]);
        $this->hasMany('Challengefollowers', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challengefollowers',
        ]);
        $this->hasMany('Challengeforums', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challengeforums',
        ]);
        $this->hasMany('Challengeqanswers', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challengeqanswers',
        ]);
        $this->hasMany('Challenges', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challenges',
        ]);
        $this->hasMany('Challengeuserforms', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challengeuserforms',
        ]);
        $this->hasOne('Challengeuserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Challengeuserprofiles',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Comments',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Logs',
        ]);
        $this->hasMany('PollVotes', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.PollVotes',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Posts',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.Profiles',
        ]);
        $this->hasMany('UserMetas', [
            'foreignKey' => 'user_id',
            'className' => 'Challenge.UserMetas',
        ]);
        $this->belongsToMany('Challengetags', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'challengetag_id',
            'joinTable' => 'challengetags_users',
            'className' => 'Challenge.Challengetags',
        ]);
        $this->belongsToMany('Logs', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'log_id',
            'joinTable' => 'users_logs',
            'className' => 'Challenge.Logs',
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('username')
            ->maxLength('username', 50)
            ->allowEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password');

        $validator
            ->scalar('family')
            ->maxLength('family', 50)
            ->allowEmptyString('family');

        $validator
            ->email('email')
            ->allowEmptyString('email');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
