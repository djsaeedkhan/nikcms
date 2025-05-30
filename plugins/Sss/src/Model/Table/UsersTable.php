<?php
declare(strict_types=1);

namespace Sss\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Sss\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \Sss\Model\Table\ChallengeblueticksTable&\Cake\ORM\Association\HasMany $Challengeblueticks
 * @property \Sss\Model\Table\ChallengefollowersTable&\Cake\ORM\Association\HasMany $Challengefollowers
 * @property \Sss\Model\Table\ChallengeforumsTable&\Cake\ORM\Association\HasMany $Challengeforums
 * @property \Sss\Model\Table\ChallengeqanswersTable&\Cake\ORM\Association\HasMany $Challengeqanswers
 * @property \Sss\Model\Table\ChallengesTable&\Cake\ORM\Association\HasMany $Challenges
 * @property \Sss\Model\Table\ChallengeuserformsTable&\Cake\ORM\Association\HasMany $Challengeuserforms
 * @property \Sss\Model\Table\ChallengeuserprofilesTable&\Cake\ORM\Association\HasMany $Challengeuserprofiles
 * @property \Sss\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \Sss\Model\Table\FormbuilderDatasTable&\Cake\ORM\Association\HasMany $FormbuilderDatas
 * @property \Sss\Model\Table\LmsCertificatesTable&\Cake\ORM\Association\HasMany $LmsCertificates
 * @property \Sss\Model\Table\LmsCoursefilecansTable&\Cake\ORM\Association\HasMany $LmsCoursefilecans
 * @property \Sss\Model\Table\LmsCoursesTable&\Cake\ORM\Association\HasMany $LmsCourses
 * @property \Sss\Model\Table\LmsCoursesessionsTable&\Cake\ORM\Association\HasMany $LmsCoursesessions
 * @property \Sss\Model\Table\LmsCourseusersTable&\Cake\ORM\Association\HasMany $LmsCourseusers
 * @property \Sss\Model\Table\LmsExamresultlistsTable&\Cake\ORM\Association\HasMany $LmsExamresultlists
 * @property \Sss\Model\Table\LmsExamresultsTable&\Cake\ORM\Association\HasMany $LmsExamresults
 * @property \Sss\Model\Table\LmsExamsTable&\Cake\ORM\Association\HasMany $LmsExams
 * @property \Sss\Model\Table\LmsExamusersTable&\Cake\ORM\Association\HasMany $LmsExamusers
 * @property \Sss\Model\Table\LmsFactorsTable&\Cake\ORM\Association\HasMany $LmsFactors
 * @property \Sss\Model\Table\LmsPaymentsTable&\Cake\ORM\Association\HasMany $LmsPayments
 * @property \Sss\Model\Table\LmsUserfactorsTable&\Cake\ORM\Association\HasMany $LmsUserfactors
 * @property \Sss\Model\Table\LmsUsernotesTable&\Cake\ORM\Association\HasMany $LmsUsernotes
 * @property \Sss\Model\Table\LmsUserprofilesTable&\Cake\ORM\Association\HasMany $LmsUserprofiles
 * @property \Sss\Model\Table\LogsTable&\Cake\ORM\Association\HasMany $Logs
 * @property \Sss\Model\Table\PollVotesTable&\Cake\ORM\Association\HasMany $PollVotes
 * @property \Sss\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \Sss\Model\Table\ProfilesTable&\Cake\ORM\Association\HasMany $Profiles
 * @property \Sss\Model\Table\ShopAddressesTable&\Cake\ORM\Association\HasMany $ShopAddresses
 * @property \Sss\Model\Table\ShopFavoritesTable&\Cake\ORM\Association\HasMany $ShopFavorites
 * @property \Sss\Model\Table\ShopLogesticusersTable&\Cake\ORM\Association\HasMany $ShopLogesticusers
 * @property \Sss\Model\Table\ShopOrderlogesticlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogesticlogs
 * @property \Sss\Model\Table\ShopOrderlogesticsTable&\Cake\ORM\Association\HasMany $ShopOrderlogestics
 * @property \Sss\Model\Table\ShopOrderlogsTable&\Cake\ORM\Association\HasMany $ShopOrderlogs
 * @property \Sss\Model\Table\ShopOrderrefundsTable&\Cake\ORM\Association\HasMany $ShopOrderrefunds
 * @property \Sss\Model\Table\ShopOrdersTable&\Cake\ORM\Association\HasMany $ShopOrders
 * @property \Sss\Model\Table\ShopOrdershippingsTable&\Cake\ORM\Association\HasMany $ShopOrdershippings
 * @property \Sss\Model\Table\ShopOrdertextsTable&\Cake\ORM\Association\HasMany $ShopOrdertexts
 * @property \Sss\Model\Table\ShopOrdertokensTable&\Cake\ORM\Association\HasMany $ShopOrdertokens
 * @property \Sss\Model\Table\ShopPaymentsTable&\Cake\ORM\Association\HasMany $ShopPayments
 * @property \Sss\Model\Table\ShopProfilesTable&\Cake\ORM\Association\HasMany $ShopProfiles
 * @property \Sss\Model\Table\ShopUseraddressesTable&\Cake\ORM\Association\HasMany $ShopUseraddresses
 * @property \Sss\Model\Table\SmsValidationsTable&\Cake\ORM\Association\HasMany $SmsValidations
 * @property \Sss\Model\Table\TicketauditsTable&\Cake\ORM\Association\HasMany $Ticketaudits
 * @property \Sss\Model\Table\TicketcommentsTable&\Cake\ORM\Association\HasMany $Ticketcomments
 * @property \Sss\Model\Table\TicketsTable&\Cake\ORM\Association\HasMany $Tickets
 * @property \Sss\Model\Table\TmpChallengeformsTable&\Cake\ORM\Association\HasMany $TmpChallengeforms
 * @property \Sss\Model\Table\TmpMembersTable&\Cake\ORM\Association\HasMany $TmpMembers
 * @property \Sss\Model\Table\TmpPersonlikesTable&\Cake\ORM\Association\HasMany $TmpPersonlikes
 * @property \Sss\Model\Table\TmpPersonsTable&\Cake\ORM\Association\HasMany $TmpPersons
 * @property \Sss\Model\Table\TmpProblemformsTable&\Cake\ORM\Association\HasMany $TmpProblemforms
 * @property \Sss\Model\Table\TmpProblemsTable&\Cake\ORM\Association\HasMany $TmpProblems
 * @property \Sss\Model\Table\UserMetasTable&\Cake\ORM\Association\HasMany $UserMetas
 * @property \Sss\Model\Table\ChallengetagsTable&\Cake\ORM\Association\BelongsToMany $Challengetags
 * @property \Sss\Model\Table\LogsTable&\Cake\ORM\Association\BelongsToMany $Logs
 *
 * @method \Sss\Model\Entity\User newEmptyEntity()
 * @method \Sss\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \Sss\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Sss\Model\Entity\User get($primaryKey, $options = [])
 * @method \Sss\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Sss\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Sss\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Sss\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sss\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Sss\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Sss\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Sss\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Sss\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
            'className' => 'Sss.Roles',
        ]);
        $this->hasMany('Challengeblueticks', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challengeblueticks',
        ]);
        $this->hasMany('Challengefollowers', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challengefollowers',
        ]);
        $this->hasMany('Challengeforums', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challengeforums',
        ]);
        $this->hasMany('Challengeqanswers', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challengeqanswers',
        ]);
        $this->hasMany('Challenges', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challenges',
        ]);
        $this->hasMany('Challengeuserforms', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challengeuserforms',
        ]);
        $this->hasMany('Challengeuserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Challengeuserprofiles',
        ]);
        $this->hasMany('Comments', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Comments',
        ]);
        $this->hasMany('FormbuilderDatas', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.FormbuilderDatas',
        ]);
        $this->hasMany('LmsCertificates', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsCertificates',
        ]);
        $this->hasMany('LmsCoursefilecans', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsCoursefilecans',
        ]);
        $this->hasMany('LmsCourses', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsCourses',
        ]);
        $this->hasMany('LmsCoursesessions', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsCoursesessions',
        ]);
        $this->hasMany('LmsCourseusers', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsCourseusers',
        ]);
        $this->hasMany('LmsExamresultlists', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsExamresultlists',
        ]);
        $this->hasMany('LmsExamresults', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsExamresults',
        ]);
        $this->hasMany('LmsExams', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsExams',
        ]);
        $this->hasMany('LmsExamusers', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsExamusers',
        ]);
        $this->hasMany('LmsFactors', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsFactors',
        ]);
        $this->hasMany('LmsPayments', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsPayments',
        ]);
        $this->hasMany('LmsUserfactors', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsUserfactors',
        ]);
        $this->hasMany('LmsUsernotes', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsUsernotes',
        ]);
        $this->hasMany('LmsUserprofiles', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.LmsUserprofiles',
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Logs',
        ]);
        $this->hasMany('PollVotes', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.PollVotes',
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Posts',
        ]);
        $this->hasMany('Profiles', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Profiles',
        ]);
        $this->hasMany('ShopAddresses', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopAddresses',
        ]);
        $this->hasMany('ShopFavorites', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopFavorites',
        ]);
        $this->hasMany('ShopLogesticusers', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopLogesticusers',
        ]);
        $this->hasMany('ShopOrderlogesticlogs', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrderlogesticlogs',
        ]);
        $this->hasMany('ShopOrderlogestics', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrderlogestics',
        ]);
        $this->hasMany('ShopOrderlogs', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrderlogs',
        ]);
        $this->hasMany('ShopOrderrefunds', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrderrefunds',
        ]);
        $this->hasMany('ShopOrders', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrders',
        ]);
        $this->hasMany('ShopOrdershippings', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrdershippings',
        ]);
        $this->hasMany('ShopOrdertexts', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrdertexts',
        ]);
        $this->hasMany('ShopOrdertokens', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopOrdertokens',
        ]);
        $this->hasMany('ShopPayments', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopPayments',
        ]);
        $this->hasMany('ShopProfiles', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopProfiles',
        ]);
        $this->hasMany('ShopUseraddresses', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.ShopUseraddresses',
        ]);
        $this->hasMany('SmsValidations', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.SmsValidations',
        ]);
        $this->hasMany('Ticketaudits', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Ticketaudits',
        ]);
        $this->hasMany('Ticketcomments', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Ticketcomments',
        ]);
        $this->hasMany('Tickets', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.Tickets',
        ]);
        $this->hasMany('TmpChallengeforms', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.TmpChallengeforms',
        ]);
        $this->hasMany('TmpMembers', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.TmpMembers',
        ]);
        $this->hasMany('TmpPersonlikes', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.TmpPersonlikes',
        ]);
        $this->hasMany('TmpPersons', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.TmpPersons',
        ]);
        $this->hasMany('TmpProblemforms', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.TmpProblemforms',
        ]);
        $this->hasMany('TmpProblems', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.TmpProblems',
        ]);
        $this->hasMany('UserMetas', [
            'foreignKey' => 'user_id',
            'className' => 'Sss.UserMetas',
        ]);
        $this->belongsToMany('Challengetags', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'challengetag_id',
            'joinTable' => 'challengetags_users',
            'className' => 'Sss.Challengetags',
        ]);
        $this->belongsToMany('Logs', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'log_id',
            'joinTable' => 'users_logs',
            'className' => 'Sss.Logs',
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
