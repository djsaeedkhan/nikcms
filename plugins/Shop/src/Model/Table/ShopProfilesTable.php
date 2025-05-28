<?php
namespace Shop\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShopProfiles Model
 *
 * @property \Shop\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Shop\Model\Entity\ShopProfile get($primaryKey, $options = [])
 * @method \Shop\Model\Entity\ShopProfile newEmptyEntity(($data = null, array $options = [])
 * @method \Shop\Model\Entity\ShopProfile[] newEntities(array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProfile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProfile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Shop\Model\Entity\ShopProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProfile[] patchEntities($entities, array $data, array $options = [])
 * @method \Shop\Model\Entity\ShopProfile findOrCreate($search, callable $callback = null, $options = [])
 */
class ShopProfilesTable extends Table
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

        $this->setTable('shop_profiles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            'className' => 'Shop.Users',
        ]);
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
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('family')
            ->maxLength('family', 200)
            ->requirePresence('family', 'create')
            ->notEmptyString('family');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 11)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');
        $validator->add('phone',[
            'Mobiles'=>[
                'rule'=>'Mobiles',
                'provider'=>'table',
                'message'=>'فرمت شماره موبایل وارد شده اشتباه است' ]]);

        $validator
            ->scalar('nationalid')
            ->maxLength('nationalid', 10)
            ->requirePresence('nationalid', 'create')
            ->notEmptyString('nationalid');
        $validator->add('nationalid',[
            'CodemeliAsUsername'=>[
                'rule'=>'CodemeliAsUsername',
                'provider'=>'table',
                'message'=>'کدملی وارد شده اشتباه می باشد.'
            ]
        ]);

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['user_id']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
