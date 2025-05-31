<?php
declare(strict_types=1);

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
 * @property \UsersLogs\Model\Table\LmsCertificatesTable&\Cake\ORM\Association\HasMany $LmsCertificates
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
 * @property \UsersLogs\Model\Table\ShopLogesticusersTable&\Cake\ORM\Association\HasMany $ShopLogesticusers
 * @property \UsersLogs\Model\Table\ShopOrderlogesticlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogesticlogs
 * @property \UsersLogs\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\HasMany $ShopOrderlogestics
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
 * @method \UsersLogs\Model\Entity\User newEmptyEntity()
 * @method \UsersLogs\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User get($primaryKey, $options = [])
 * @method \UsersLogs\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \UsersLogs\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \UsersLogs\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \UsersLogs\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \UsersLogs\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \UsersLogs\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \UsersLogs\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \UsersLogs\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'UsersLogs.Logs',
        ]);
        $this->belongsToMany('Logs', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'log_id',
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
    public function validationDefault(Validator $validator): Validator
    {
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
            ->scalar('role_id')
            ->maxLength('role_id', 20)
            ->allowEmptyString('role_id');

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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->existsIn('role_id', 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }
}
