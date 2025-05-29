<?php
namespace Challenge\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Challengeuserprofiles Model
 *
 * @property \Challenge\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \Challenge\Model\Table\ChallengetopicsTable&\Cake\ORM\Association\BelongsToMany $Challengetopics
 *
 * @method \Challenge\Model\Entity\Challengeuserprofile get($primaryKey, $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile newEmptyEntity(($data = null, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile[] newEntities(array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile[] patchEntities($entities, array $data, array $options = [])
 * @method \Challenge\Model\Entity\Challengeuserprofile findOrCreate($search, callable $callback = null, $options = [])
 */
class ChallengeuserprofilesTable extends Table
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

        $this->setTable('challengeuserprofiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Challenge.Users',
        ]);
        $this->belongsToMany('Challengetopics', [
            'foreignKey' => 'challengeuserprofile_id',
            'targetForeignKey' => 'challengetopic_id',
            'joinTable' => 'challengeuserprofiles_challengetopics',
            'className' => 'Challenge.Challengetopics',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 1)
            //->requirePresence('gender', 'created')
            ->allowEmptyString('gender');

        $validator
            //->requirePresence('provice', 'update')
            ->allowEmptyString('provice');

        $validator
            ->scalar('birth_date')
            ->maxLength('birth_date', 11)
            ->allowEmptyString('birth_date');

        /* $validator->add('birth_date',[
            'number' => array(
                'rule' => array('range', 1310, 1390),
                'message' => 'لطفا سال تولد را بصورت صحیح انتخاب کنید'
            )]); */

        $validator
            ->notEmptyString('single');

        $validator
            ->allowEmptyString('eductions');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 15)
            ->allowEmptyString('mobile');

        $validator->add('mobile',[
            'Mobiles'=>[
                'rule'=>'Mobiles',
                'provider'=>'table',
                'message'=>'فرمت شماره موبایل وارد شده اشتباه است' ]]);

        $validator
            ->allowEmptyString('center');
            
        $validator
            ->scalar('extra')
            ->allowEmptyString('extra');

        $validator
            ->scalar('center_name')
            ->maxLength('center_name', 100)
            ->allowEmptyString('center_name');

        $validator
            ->scalar('semat')
            ->maxLength('semat', 100)
            ->allowEmptyString('semat');

        $validator
            ->scalar('codemeli')
            ->maxLength('codemeli', 15)
            ->allowEmptyString('codemeli');

        $validator->add('codemeli',[
            'CodemeliAsUsername'=>[
                'rule'=>'CodemeliAsUsername',
                'provider'=>'table',
                'message'=>'کدملی وارد شده اشتباه می باشد.'
            ]
        ]);

        $validator
            ->scalar('field')
            ->maxLength('field', 100)
            ->allowEmptyString('field');

        $validator
            ->scalar('univercity')
            ->maxLength('univercity', 100)
            ->allowEmptyString('univercity');

        $validator
            ->scalar('descr')
            ->maxLength('descr', 5000)
            ->allowEmptyString('descr');
        $validator
            ->scalar('image')
            ->maxLength('image', 100)
            ->allowEmptyFile('image');

        return $validator;
    }

    public function CodemeliAsUsername($value,$context){
        if(!preg_match('/^[0-9]{10}$/',$value))
            return false;
        for($i=0;$i<10;$i++)
            if(preg_match('/^'.$i.'{10}$/',$value))
                return false;
        for($i=0,$sum=0;$i<9;$i++)
            $sum+=((10-$i)*intval(substr($value, $i,1)));
        $ret=$sum%11;
        $parity=intval(substr($value, 9,1));
        if(($ret<2 && $ret==$parity) || ($ret>=2 && $ret==11-$parity))
            return true;
        return false;
    }
    public function Mobiles($value,$context){
        if(! preg_match("/^09[0-9]{9}$/", $value)) {
            return false;
        }
        return true;
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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
