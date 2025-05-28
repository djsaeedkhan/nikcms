<?php
namespace Lms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Lms\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \Lms\Model\Table\ChallengeblueticksTable&\Cake\ORM\Association\HasMany $Challengeblueticks
 * @property \Lms\Model\Table\ChallengefollowersTable&\Cake\ORM\Association\HasMany $Challengefollowers
 * @property \Lms\Model\Table\ChallengeforumsTable&\Cake\ORM\Association\HasMany $Challengeforums
 * @property \Lms\Model\Table\ChallengeqanswersTable&\Cake\ORM\Association\HasMany $Challengeqanswers
 * @property \Lms\Model\Table\ChallengesTable&\Cake\ORM\Association\HasMany $Challenges
 * @property \Lms\Model\Table\ChallengeuserformsTable&\Cake\ORM\Association\HasMany $Challengeuserforms
 * @property \Lms\Model\Table\ChallengeuserprofilesTable&\Cake\ORM\Association\HasMany $Challengeuserprofiles
 * @property \Lms\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Lms\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \Lms\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \Lms\Model\Table\LmsCoursesTable&\Cake\ORM\Association\HasMany $LmsCourses
 * @property \Lms\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \Lms\Model\Table\LmsCourseusersTable&\Cake\ORM\Association\HasMany $LmsCourseusers
 * @property \Lms\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 * @property \Lms\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \Lms\Model\Table\LmsExamsTable&\Cake\ORM\Association\HasMany $LmsExams
 * @property \Lms\Model\Table\LmsExamusersTable&\Cake\ORM\Association\HasMany $LmsExamusers
 * @property \Lms\Model\Table\LmsFactorsTable&\Cake\ORM\Association\HasMany $LmsFactors
 * @property \Lms\Model\Table\LmsPaymentsTable&\Cake\ORM\Association\HasMany $LmsPayments
 * @property \Lms\Model\Table\LmsUserfactorsTable&\Cake\ORM\Association\HasMany $LmsUserfactors
 * @property \Lms\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 * @property \Lms\Model\Table\LmsUserprofilesTable&\Cake\ORM\Association\HasMany $LmsUserprofiles
 * @property \Lms\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \Lms\Model\Table\PollVotesTable&\Cake\ORM\Association\HasMany $PollVotes
 * @property \Lms\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \Lms\Model\Table\ProfilesTable&\Cake\ORM\Association\HasMany $Profiles
 * @property \Lms\Model\Table\ShopAddressesTable&\Cake\ORM\Association\HasMany $ShopAddresses
 * @property \Lms\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \Lms\Model\Table\ShopOrderlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogs
 * @property \Lms\Model\Table\ShopOrderrefundsTable&\Cake\ORM\Association\HasMany $ShopOrderrefunds
 * @property \Lms\Model\Table\ShopOrdersTable&\Cake\ORM\Association\HasMany $ShopOrders
 * @property \Lms\Model\Table\ShopOrdershippingsTable&\Cake\ORM\Association\HasMany $ShopOrdershippings
 * @property \Lms\Model\Table\ShopOrdertextsTable&\Cake\ORM\Association\HasMany $ShopOrdertexts
 * @property \Lms\Model\Table\ShopOrdertokensTable&\Cake\ORM\Association\HasMany $ShopOrdertokens
 * @property \Lms\Model\Table\ShopPaymentsTable&\Cake\ORM\Association\HasMany $ShopPayments
 * @property \Lms\Model\Table\ShopProfilesTable&\Cake\ORM\Association\HasMany $ShopProfiles
 * @property \Lms\Model\Table\ShopUseraddressesTable&\Cake\ORM\Association\HasMany $ShopUseraddresses
 * @property \Lms\Model\Table\SmsValidationsTable&\Cake\ORM\Association\HasMany $SmsValidations
 * @property \Lms\Model\Table\TicketauditsTable&\Cake\ORM\Association\HasMany $Ticketaudits
 * @property \Lms\Model\Table\TicketcommentsTable&\Cake\ORM\Association\HasMany $Ticketcomments
 * @property \Lms\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \Lms\Model\Table\TmpChallengeformsTable&\Cake\ORM\Association\HasMany $TmpChallengeforms
 * @property \Lms\Model\Table\TmpMembersTable&\Cake\ORM\Association\HasMany $TmpMembers
 * @property \Lms\Model\Table\TmpPersonlikesTable&\Cake\ORM\Association\HasMany $TmpPersonlikes
 * @property \Lms\Model\Table\TmpPersonsTable&\Cake\ORM\Association\HasMany $TmpPersons
 * @property \Lms\Model\Table\TmpProblemformsTable&\Cake\ORM\Association\HasMany $TmpProblemforms
 * @property \Lms\Model\Table\TmpProblemsTable&\Cake\ORM\Association\HasMany $TmpProblems
 * @property \Lms\Model\Table\UserMetasTable&\Cake\ORM\Association\HasMany $UserMetas
 * @property \Lms\Model\Table\ChallengetagsTable&\Cake\ORM\Association\BelongsToMany $Challengetags
 * @property \Lms\Model\Table\LogsTable&\Cake\ORM\Association\BelongsToMany $Logs
 *
 * @method \Lms\Model\Entity\User get($primaryKey, $options = [])
 * @method \Lms\Model\Entity\User newEmptyEntity(($data = null, array $options = [])
 * @method \Lms\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Lms\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Lms\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Lms\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \Lms\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'Lms.Roles',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Comments',
        ]);
        $this->hasMany('FormbuilderDatas', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.FormbuilderDatas',
        ]);
        $this->hasMany('LmsCoursefilecans', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsCoursefilecans',
        ]);
        $this->hasMany('LmsCourses', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsCourses',
        ]);
        $this->hasMany('LmsCoursesessions', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsCoursesessions',
        ]);
        $this->hasMany('LmsCourseusers', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsCourseusers',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsExamresultlists',
        ]);
        $this->hasMany('LmsExamresults', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsExamresults',
        ]);
        $this->hasMany('LmsExams', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsExams',
        ]);
        $this->hasMany('LmsExamusers', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsExamusers',
        ]);
        $this->hasMany('LmsFactors', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsFactors',
        ]);
        $this->hasMany('LmsPayments', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsPayments',
        ]);
        $this->hasMany('LmsUserfactors', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsUserfactors',
        ]);
        $this->hasMany('LmsUsernotes', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsUsernotes',
        ]);
        $this->hasMany('LmsUserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.LmsUserprofiles',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Logs',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Posts',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Profiles',
        ]);
        $this->hasMany('SmsValidations', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.SmsValidations',
        ]);
        $this->hasMany('Ticketaudits', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Ticketaudits',
        ]);
        $this->hasMany('Ticketcomments', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Ticketcomments',
        ]);
        $this->hasMany('Tickets', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.Tickets',
        ]);
        $this->hasMany('UserMetas', [
            'foreignKey' => 'user_id',
            'className' => 'Lms.UserMetas',
        ]);
        
        $this->belongsToMany('Logs', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'log_id',
            'joinTable' => 'users_logs',
            'className' => 'Lms.Logs',
        ]);
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
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }
}
