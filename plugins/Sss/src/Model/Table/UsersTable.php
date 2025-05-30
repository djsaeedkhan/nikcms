<?php
declare(strict_types=1);

namespace SSS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \SSS\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \SSS\Model\Table\ChallengeblueticksTable&\Cake\ORM\Association\HasMany $Challengeblueticks
 * @property \SSS\Model\Table\ChallengefollowersTable&\Cake\ORM\Association\HasMany $Challengefollowers
 * @property \SSS\Model\Table\ChallengeforumsTable&\Cake\ORM\Association\HasMany $Challengeforums
 * @property \SSS\Model\Table\ChallengeqanswersTable&\Cake\ORM\Association\HasMany $Challengeqanswers
 * @property \SSS\Model\Table\ChallengesTable&\Cake\ORM\Association\HasMany $Challenges
 * @property \SSS\Model\Table\ChallengeuserformsTable&\Cake\ORM\Association\HasMany $Challengeuserforms
 * @property \SSS\Model\Table\ChallengeuserprofilesTable&\Cake\ORM\Association\HasMany $Challengeuserprofiles
 * @property \SSS\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \SSS\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \SSS\Model\Table\LmsCertificatesTable&\Cake\ORM\Association\HasMany $LmsCertificates
 * @property \SSS\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \SSS\Model\Table\LmsCoursesTable&\Cake\ORM\Association\HasMany $LmsCourses
 * @property \SSS\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \SSS\Model\Table\LmsCourseusersTable&\Cake\ORM\Association\HasMany $LmsCourseusers
 * @property \SSS\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 * @property \SSS\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \SSS\Model\Table\LmsExamsTable&\Cake\ORM\Association\HasMany $LmsExams
 * @property \SSS\Model\Table\LmsExamusersTable&\Cake\ORM\Association\HasMany $LmsExamusers
 * @property \SSS\Model\Table\LmsFactorsTable&\Cake\ORM\Association\HasMany $LmsFactors
 * @property \SSS\Model\Table\LmsPaymentsTable&\Cake\ORM\Association\HasMany $LmsPayments
 * @property \SSS\Model\Table\LmsUserfactorsTable&\Cake\ORM\Association\HasMany $LmsUserfactors
 * @property \SSS\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 * @property \SSS\Model\Table\LmsUserprofilesTable&\Cake\ORM\Association\HasMany $LmsUserprofiles
 * @property \SSS\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \SSS\Model\Table\PollVotesTable&\Cake\ORM\Association\HasMany $PollVotes
 * @property \SSS\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \SSS\Model\Table\ProfilesTable&\Cake\ORM\Association\HasMany $Profiles
 * @property \SSS\Model\Table\ShopAddressesTable&\Cake\ORM\Association\HasMany $ShopAddresses
 * @property \SSS\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \SSS\Model\Table\ShopLogesticusersTable&\Cake\ORM\Association\HasMany $ShopLogesticusers
 * @property \SSS\Model\Table\ShopOrderlogesticlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogesticlogs
 * @property \SSS\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\HasMany $ShopOrderlogestics
 * @property \SSS\Model\Table\ShopOrderlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogs
 * @property \SSS\Model\Table\ShopOrderrefundsTable&\Cake\ORM\Association\HasMany $ShopOrderrefunds
 * @property \SSS\Model\Table\ShopOrdersTable&\Cake\ORM\Association\HasMany $ShopOrders
 * @property \SSS\Model\Table\ShopOrdershippingsTable&\Cake\ORM\Association\HasMany $ShopOrdershippings
 * @property \SSS\Model\Table\ShopOrdertextsTable&\Cake\ORM\Association\HasMany $ShopOrdertexts
 * @property \SSS\Model\Table\ShopOrdertokensTable&\Cake\ORM\Association\HasMany $ShopOrdertokens
 * @property \SSS\Model\Table\ShopPaymentsTable&\Cake\ORM\Association\HasMany $ShopPayments
 * @property \SSS\Model\Table\ShopProfilesTable&\Cake\ORM\Association\HasMany $ShopProfiles
 * @property \SSS\Model\Table\ShopUseraddressesTable&\Cake\ORM\Association\HasMany $ShopUseraddresses
 * @property \SSS\Model\Table\SmsValidationsTable&\Cake\ORM\Association\HasMany $SmsValidations
 * @property \SSS\Model\Table\TicketauditsTable&\Cake\ORM\Association\HasMany $Ticketaudits
 * @property \SSS\Model\Table\TicketcommentsTable&\Cake\ORM\Association\HasMany $Ticketcomments
 * @property \SSS\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \SSS\Model\Table\TmpChallengeformsTable&\Cake\ORM\Association\HasMany $TmpChallengeforms
 * @property \SSS\Model\Table\TmpMembersTable&\Cake\ORM\Association\HasMany $TmpMembers
 * @property \SSS\Model\Table\TmpPersonlikesTable&\Cake\ORM\Association\HasMany $TmpPersonlikes
 * @property \SSS\Model\Table\TmpPersonsTable&\Cake\ORM\Association\HasMany $TmpPersons
 * @property \SSS\Model\Table\TmpProblemformsTable&\Cake\ORM\Association\HasMany $TmpProblemforms
 * @property \SSS\Model\Table\TmpProblemsTable&\Cake\ORM\Association\HasMany $TmpProblems
 * @property \SSS\Model\Table\UserMetasTable&\Cake\ORM\Association\HasMany $UserMetas
 * @property \SSS\Model\Table\ChallengetagsTable&\Cake\ORM\Association\BelongsToMany $Challengetags
 * @property \SSS\Model\Table\LogsTable&\Cake\ORM\Association\BelongsToMany $Logs
 *
 * @method \SSS\Model\Entity\User newEmptyEntity()
 * @method \SSS\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \SSS\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \SSS\Model\Entity\User get($primaryKey, $options = [])
 * @method \SSS\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \SSS\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SSS\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \SSS\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SSS\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SSS\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \SSS\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \SSS\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \SSS\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
            'className' => 'SSS.Roles',
        ]);
        $this->hasMany('Challengeblueticks', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challengeblueticks',
        ]);
        $this->hasMany('Challengefollowers', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challengefollowers',
        ]);
        $this->hasMany('Challengeforums', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challengeforums',
        ]);
        $this->hasMany('Challengeqanswers', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challengeqanswers',
        ]);
        $this->hasMany('Challenges', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challenges',
        ]);
        $this->hasMany('Challengeuserforms', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challengeuserforms',
        ]);
        $this->hasMany('Challengeuserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Challengeuserprofiles',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Comments',
        ]);
        $this->hasMany('FormbuilderDatas', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.FormbuilderDatas',
        ]);
        $this->hasMany('LmsCertificates', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsCertificates',
        ]);
        $this->hasMany('LmsCoursefilecans', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsCoursefilecans',
        ]);
        $this->hasMany('LmsCourses', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsCourses',
        ]);
        $this->hasMany('LmsCoursesessions', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsCoursesessions',
        ]);
        $this->hasMany('LmsCourseusers', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsCourseusers',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsExamresultlists',
        ]);
        $this->hasMany('LmsExamresults', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsExamresults',
        ]);
        $this->hasMany('LmsExams', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsExams',
        ]);
        $this->hasMany('LmsExamusers', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsExamusers',
        ]);
        $this->hasMany('LmsFactors', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsFactors',
        ]);
        $this->hasMany('LmsPayments', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsPayments',
        ]);
        $this->hasMany('LmsUserfactors', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsUserfactors',
        ]);
        $this->hasMany('LmsUsernotes', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsUsernotes',
        ]);
        $this->hasMany('LmsUserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.LmsUserprofiles',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Logs',
        ]);
        $this->hasMany('PollVotes', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.PollVotes',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Posts',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Profiles',
        ]);
        $this->hasMany('ShopAddresses', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopAddresses',
        ]);
        $this->hasMany('ShopFavorites', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopFavorites',
        ]);
        $this->hasMany('ShopLogesticusers', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopLogesticusers',
        ]);
        $this->hasMany('ShopOrderlogesticlogs', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrderlogesticlogs',
        ]);
        $this->hasMany('ShopOrderlogestics', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrderlogestics',
        ]);
        $this->hasMany('ShopOrderlogs', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrderlogs',
        ]);
        $this->hasMany('ShopOrderrefunds', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrderrefunds',
        ]);
        $this->hasMany('ShopOrders', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrders',
        ]);
        $this->hasMany('ShopOrdershippings', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrdershippings',
        ]);
        $this->hasMany('ShopOrdertexts', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrdertexts',
        ]);
        $this->hasMany('ShopOrdertokens', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopOrdertokens',
        ]);
        $this->hasMany('ShopPayments', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopPayments',
        ]);
        $this->hasMany('ShopProfiles', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopProfiles',
        ]);
        $this->hasMany('ShopUseraddresses', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.ShopUseraddresses',
        ]);
        $this->hasMany('SmsValidations', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.SmsValidations',
        ]);
        $this->hasMany('Ticketaudits', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Ticketaudits',
        ]);
        $this->hasMany('Ticketcomments', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Ticketcomments',
        ]);
        $this->hasMany('Tickets', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.Tickets',
        ]);
        $this->hasMany('TmpChallengeforms', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.TmpChallengeforms',
        ]);
        $this->hasMany('TmpMembers', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.TmpMembers',
        ]);
        $this->hasMany('TmpPersonlikes', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.TmpPersonlikes',
        ]);
        $this->hasMany('TmpPersons', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.TmpPersons',
        ]);
        $this->hasMany('TmpProblemforms', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.TmpProblemforms',
        ]);
        $this->hasMany('TmpProblems', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.TmpProblems',
        ]);
        $this->hasMany('UserMetas', [
            'foreignKey' => 'user_id',
            'className' => 'SSS.UserMetas',
        ]);
        $this->belongsToMany('Challengetags', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'challengetag_id',
            'joinTable' => 'challengetags_users',
            'className' => 'SSS.Challengetags',
        ]);
        $this->belongsToMany('Logs', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'log_id',
            'joinTable' => 'users_logs',
            'className' => 'SSS.Logs',
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
