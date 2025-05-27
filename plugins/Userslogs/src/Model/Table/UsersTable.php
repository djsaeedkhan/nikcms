<?php
namespace UsersLogs\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \UsersLogs\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \UsersLogs\Model\Table\ChallengeblueticksTable&\Cake\ORM\Association\HasMany $Challengeblueticks
 * @property \UsersLogs\Model\Table\ChallengefollowersTable&\Cake\ORM\Association\HasMany $Challengefollowers
 * @property \UsersLogs\Model\Table\ChallengeforumsTable&\Cake\ORM\Association\HasMany $Challengeforums
 * @property \UsersLogs\Model\Table\ChallengeqanswersTable&\Cake\ORM\Association\HasMany $Challengeqanswers
 * @property \UsersLogs\Model\Table\ChallengesTable&\Cake\ORM\Association\HasMany $Challenges
 * @property \UsersLogs\Model\Table\ChallengeuserformsTable&\Cake\ORM\Association\HasMany $Challengeuserforms
 * @property \UsersLogs\Model\Table\ChallengeuserprofilesTable&\Cake\ORM\Association\HasMany $Challengeuserprofiles
 * @property \UsersLogs\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \UsersLogs\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \UsersLogs\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \UsersLogs\Model\Table\LmsCoursesTable&\Cake\ORM\Association\HasMany $LmsCourses
 * @property \UsersLogs\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \UsersLogs\Model\Table\LmsCourseusersTable&\Cake\ORM\Association\HasMany $LmsCourseusers
 * @property \UsersLogs\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 * @property \UsersLogs\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \UsersLogs\Model\Table\LmsExamsTable&\Cake\ORM\Association\HasMany $LmsExams
 * @property \UsersLogs\Model\Table\LmsExamusersTable&\Cake\ORM\Association\HasMany $LmsExamusers
 * @property \UsersLogs\Model\Table\LmsFactorsTable&\Cake\ORM\Association\HasMany $LmsFactors
 * @property \UsersLogs\Model\Table\LmsPaymentsTable&\Cake\ORM\Association\HasMany $LmsPayments
 * @property \UsersLogs\Model\Table\LmsUserfactorsTable&\Cake\ORM\Association\HasMany $LmsUserfactors
 * @property \UsersLogs\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 * @property \UsersLogs\Model\Table\LmsUserprofilesTable&\Cake\ORM\Association\HasMany $LmsUserprofiles
 * @property \UsersLogs\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \UsersLogs\Model\Table\PollVotesTable&\Cake\ORM\Association\HasMany $PollVotes
 * @property \UsersLogs\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \UsersLogs\Model\Table\ProfilesTable&\Cake\ORM\Association\HasMany $Profiles
 * @property \UsersLogs\Model\Table\ShopAddressesTable&\Cake\ORM\Association\HasMany $ShopAddresses
 * @property \UsersLogs\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \UsersLogs\Model\Table\ShopOrderlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogs
 * @property \UsersLogs\Model\Table\ShopOrderrefundsTable&\Cake\ORM\Association\HasMany $ShopOrderrefunds
 * @property \UsersLogs\Model\Table\ShopOrdersTable&\Cake\ORM\Association\HasMany $ShopOrders
 * @property \UsersLogs\Model\Table\ShopOrdershippingsTable&\Cake\ORM\Association\HasMany $ShopOrdershippings
 * @property \UsersLogs\Model\Table\ShopOrdertextsTable&\Cake\ORM\Association\HasMany $ShopOrdertexts
 * @property \UsersLogs\Model\Table\ShopOrdertokensTable&\Cake\ORM\Association\HasMany $ShopOrdertokens
 * @property \UsersLogs\Model\Table\ShopPaymentsTable&\Cake\ORM\Association\HasMany $ShopPayments
 * @property \UsersLogs\Model\Table\ShopProfilesTable&\Cake\ORM\Association\HasMany $ShopProfiles
 * @property \UsersLogs\Model\Table\ShopUseraddressesTable&\Cake\ORM\Association\HasMany $ShopUseraddresses
 * @property \UsersLogs\Model\Table\SmsValidationsTable&\Cake\ORM\Association\HasMany $SmsValidations
 * @property \UsersLogs\Model\Table\TicketauditsTable&\Cake\ORM\Association\HasMany $Ticketaudits
 * @property \UsersLogs\Model\Table\TicketcommentsTable&\Cake\ORM\Association\HasMany $Ticketcomments
 * @property \UsersLogs\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \UsersLogs\Model\Table\TmpChallengeformsTable&\Cake\ORM\Association\HasMany $TmpChallengeforms
 * @property \UsersLogs\Model\Table\TmpMembersTable&\Cake\ORM\Association\HasMany $TmpMembers
 * @property \UsersLogs\Model\Table\TmpPersonlikesTable&\Cake\ORM\Association\HasMany $TmpPersonlikes
 * @property \UsersLogs\Model\Table\TmpPersonsTable&\Cake\ORM\Association\HasMany $TmpPersons
 * @property \UsersLogs\Model\Table\TmpProblemformsTable&\Cake\ORM\Association\HasMany $TmpProblemforms
 * @property \UsersLogs\Model\Table\TmpProblemsTable&\Cake\ORM\Association\HasMany $TmpProblems
 * @property \UsersLogs\Model\Table\UserMetasTable&\Cake\ORM\Association\HasMany $UserMetas
 * @property \UsersLogs\Model\Table\ChallengetagsTable&\Cake\ORM\Association\BelongsToMany $Challengetags
 * @property \UsersLogs\Model\Table\LogsTable&\Cake\ORM\Association\BelongsToMany $Logs
 *
 * @method \UsersLogs\Model\Entity\User get($primaryKey, $options = [])
 * @method \UsersLogs\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \UsersLogs\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \UsersLogs\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \UsersLogs\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
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
            'className' => 'UsersLogs.Roles',
        ]);
        $this->hasMany('Challengeblueticks', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challengeblueticks',
        ]);
        $this->hasMany('Challengefollowers', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challengefollowers',
        ]);
        $this->hasMany('Challengeforums', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challengeforums',
        ]);
        $this->hasMany('Challengeqanswers', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challengeqanswers',
        ]);
        $this->hasMany('Challenges', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challenges',
        ]);
        $this->hasMany('Challengeuserforms', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challengeuserforms',
        ]);
        $this->hasMany('Challengeuserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Challengeuserprofiles',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Comments',
        ]);
        $this->hasMany('FormbuilderDatas', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.FormbuilderDatas',
        ]);
        $this->hasMany('LmsCoursefilecans', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsCoursefilecans',
        ]);
        $this->hasMany('LmsCourses', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsCourses',
        ]);
        $this->hasMany('LmsCoursesessions', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsCoursesessions',
        ]);
        $this->hasMany('LmsCourseusers', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsCourseusers',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsExamresultlists',
        ]);
        $this->hasMany('LmsExamresults', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsExamresults',
        ]);
        $this->hasMany('LmsExams', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsExams',
        ]);
        $this->hasMany('LmsExamusers', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsExamusers',
        ]);
        $this->hasMany('LmsFactors', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsFactors',
        ]);
        $this->hasMany('LmsPayments', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsPayments',
        ]);
        $this->hasMany('LmsUserfactors', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsUserfactors',
        ]);
        $this->hasMany('LmsUsernotes', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsUsernotes',
        ]);
        $this->hasMany('LmsUserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.LmsUserprofiles',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Logs',
        ]);
        $this->hasMany('PollVotes', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.PollVotes',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Posts',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Profiles',
        ]);
        $this->hasMany('ShopAddresses', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopAddresses',
        ]);
        $this->hasMany('ShopFavorites', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopFavorites',
        ]);
        $this->hasMany('ShopOrderlogs', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopOrderlogs',
        ]);
        $this->hasMany('ShopOrderrefunds', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopOrderrefunds',
        ]);
        $this->hasMany('ShopOrders', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopOrders',
        ]);
        $this->hasMany('ShopOrdershippings', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopOrdershippings',
        ]);
        $this->hasMany('ShopOrdertexts', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopOrdertexts',
        ]);
        $this->hasMany('ShopOrdertokens', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopOrdertokens',
        ]);
        $this->hasMany('ShopPayments', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopPayments',
        ]);
        $this->hasMany('ShopProfiles', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopProfiles',
        ]);
        $this->hasMany('ShopUseraddresses', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.ShopUseraddresses',
        ]);
        $this->hasMany('SmsValidations', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.SmsValidations',
        ]);
        $this->hasMany('Ticketaudits', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Ticketaudits',
        ]);
        $this->hasMany('Ticketcomments', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Ticketcomments',
        ]);
        $this->hasMany('Tickets', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Tickets',
        ]);
        $this->hasMany('TmpChallengeforms', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.TmpChallengeforms',
        ]);
        $this->hasMany('TmpMembers', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.TmpMembers',
        ]);
        $this->hasMany('TmpPersonlikes', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.TmpPersonlikes',
        ]);
        $this->hasMany('TmpPersons', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.TmpPersons',
        ]);
        $this->hasMany('TmpProblemforms', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.TmpProblemforms',
        ]);
        $this->hasMany('TmpProblems', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.TmpProblems',
        ]);
        $this->hasMany('UsersLogs', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.UserMetas',
        ]);
        $this->belongsToMany('Challengetags', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'challengetag_id',
            'joinTable' => 'challengetags_users',
            'className' => 'UsersLogs.Challengetags',
        ]);
        $this->belongsToMany('UsersLogs', [
            'foreignKey' => 'user_id',
            //'targetForeignKey' => 'log_id',
            'joinTable' => 'users_logs',
            'className' => 'UsersLogs.Logs',
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
