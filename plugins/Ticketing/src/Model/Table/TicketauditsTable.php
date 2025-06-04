<?php
declare(strict_types=1);

namespace Ticketing\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ticketaudits Model
 *
 * @property \Ticketing\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Ticketing\Model\Table\TicketsTable&\Cake\ORM\Association\BelongsTo $Tickets
 *
 * @method \Ticketing\Model\Entity\Ticketaudit newEmptyEntity()
 * @method \Ticketing\Model\Entity\Ticketaudit newEntity(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit[] newEntities(array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit get($primaryKey, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Ticketing\Model\Entity\Ticketaudit[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TicketauditsTable extends Table
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

        $this->setTable('ticketaudits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Ticketing.Users',
        ]);
        $this->belongsTo('Tickets', [
            'foreignKey' => 'ticket_id',
            'joinType' => 'INNER',
            'className' => 'Ticketing.Tickets',
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
            ->scalar('operation')
            ->allowEmptyString('operation');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('ticket_id')
            ->notEmptyString('ticket_id');

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
        $rules->add($rules->existsIn('ticket_id', 'Tickets'), ['errorField' => 'ticket_id']);

        return $rules;
    }
}
