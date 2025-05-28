<?php
namespace Ticketing\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tickets Model
 *
 * @property \Ticketing\Model\Table\TicketstatusesTable&\Cake\ORM\Association\BelongsTo $Ticketstatuses
 * @property \Ticketing\Model\Table\TicketprioritiesTable&\Cake\ORM\Association\BelongsTo $Ticketpriorities
 * @property \Ticketing\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Ticketing\Model\Table\AgentsTable&\Cake\ORM\Association\BelongsTo $Agents
 * @property \Ticketing\Model\Table\PostsTable&\Cake\ORM\Association\BelongsTo $Posts
 * @property \Ticketing\Model\Table\TicketcategoriesTable&\Cake\ORM\Association\BelongsTo $Ticketcategories
 * @property \Ticketing\Model\Table\TicketauditsTable&\Cake\ORM\Association\HasMany $Ticketaudits
 * @property \Ticketing\Model\Table\TicketcommentsTable&\Cake\ORM\Association\HasMany $Ticketcomments
 *
 * @method \Ticketing\Model\Entity\Ticket get($primaryKey, $options = [])
 * @method \Ticketing\Model\Entity\Ticket newEmptyEntity(($data = null, array $options = [])
 * @method \Ticketing\Model\Entity\Ticket[] newEntities(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticket|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticket saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticket patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticket[] patchEntities($entities, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticket findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TicketsTable extends Table
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

        $this->setTable('tickets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ticketstatuses', [
            'foreignKey' => 'ticketstatus_id',
            'className' => 'Ticketing.Ticketstatuses',
        ]);
        $this->belongsTo('Ticketpriorities', [
            'foreignKey' => 'ticketpriority_id',
            'className' => 'Ticketing.Ticketpriorities',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            //'joinType' => 'INNER',
            'className' => 'Ticketing.Users',
        ]);
        $this->belongsTo('Agents', [
            'foreignKey' => 'agent_id',
            'className' => 'Ticketing.Users',
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'className' => 'Ticketing.Posts',
        ]);
        $this->belongsTo('Ticketcategories', [
            'foreignKey' => 'ticketcategory_id',
            'className' => 'Ticketing.Ticketcategories',
        ]);
        $this->hasMany('Ticketaudits', [
            'foreignKey' => 'ticket_id',
            'className' => 'Ticketing.Ticketaudits',
        ]);
        $this->hasMany('Ticketcomments', [
            'foreignKey' => 'ticket_id',
            'dependent' => true,
            'className' => 'Ticketing.Ticketcomments',
        ]);
    }

    public function beforeSave($event){
        $entity = $event->getData('entity');
        $modified = $entity->getDirty();
        foreach((array) $modified as $v) {
            if(isset($entity->{$v}) and $entity->{$v} != null) {
                if(in_array($v,['created','modified','completed'])) return true;
                if(is_array($entity->{$v})){
                    //$entity->{$v} = ($entity->{$v});
                }else{
                    $entity->{$v} = strip_tags($entity->{$v},'<button><fieldset><h1><h2><h3><h4><h5><h6><small><label><img><img><p><a><b><br><strong><br /><hr><i><span><div><ul><li><table><tr><td><thead><tbody>');
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
            ->scalar('subject')
            ->maxLength('subject', 300)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        $validator
            ->scalar('html')
            ->allowEmptyString('html');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 13)
            ->allowEmptyString('phone_number');

        $validator
            ->allowEmptyString('alert_type');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->dateTime('completed')
            ->allowEmptyDateTime('completed');

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
        //$rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['ticketstatus_id'], 'Ticketstatuses'));
        $rules->add($rules->existsIn(['ticketpriority_id'], 'Ticketpriorities'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['agent_id'], 'Agents'));
        //$rules->add($rules->existsIn(['post_id'], 'Posts'));
        $rules->add($rules->existsIn(['ticketcategory_id'], 'Ticketcategories'));

        return $rules;
    }
}
