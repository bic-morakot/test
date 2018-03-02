<?php

namespace app\modules\resource\models;

use Yii;
use app\modules\resource\models\ResGroup;
use yii\db\Expression;

/**
 * This is the model class for table "res_users".
 *
 * @property integer $id
 * @property string $code รหัสพนักงาน
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property string $id_card
 * @property string $email
 * @property integer $active
 * @property integer $create_uid
 * @property string $create_date
 * @property integer $write_uid
 * @property string $write_date
 */
class ResUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'res_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','id_card'], 'required'],
            [['username','email','id_card'],'unique'],
            [['active', 'create_uid', 'write_uid'], 'integer'],
            [['create_date', 'write_date'], 'safe'],
            [['username','firstname','lastname','email'], 'string', 'max' => 255],
            [['code'],'string'],
            [['id_card'], 'string', 'max' => 13]
        ];
    }
    
    public function fields() {
        $fields = [
            'id','firstname','lastname','email'
        ];
        
        return $fields;
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code'=>Yii::t('app','รหัสพนักงาน'),
            'name' => Yii::t('app', 'Name'),
            'id_card' => Yii::t('app', 'บัตรประชาชน'),
            'active' => Yii::t('app', 'Active'),            
            'create_uid' => Yii::t('app', 'Create Uid'),
            'create_date' => Yii::t('app', 'Create Date'),
            'write_uid' => Yii::t('app', 'Write Uid'),
            'write_date' => Yii::t('app', 'Write Date'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($isInsert) {
        if($isInsert){
            $this->create_uid = Yii::$app->user->id;
            $this->create_date = new Expression("NOW()");
            $this->write_uid = Yii::$app->user->id;
            $this->write_date = new Expression("NOW()");
        } else {
            $this->write_uid = Yii::$app->user->id;
            $this->write_date = new Expression("NOW()");
        }
        return true;
    }
    
    public function getGroups()
    {
        return $this->hasMany(ResGroup::className(), ['id' => 'group_id'])
                ->viaTable('res_users_group_rel', ['user_id'=>'id']);
    }
    
    public function getGroupDisplay(){
        $groups = $this->getGroups()->asArray()->all();
        $group_names = array_column($groups, 'name');
        $str = implode(", ", $group_names);
        return $str;
    }
    
    public static function currentUser(){
        return ResUsers::findOne(['id'=>Yii::$app->user->id]);
    }
    
    public static function currentUserGroups(){
        $user = ResUsers::find()
                ->where(['id'=>Yii::$app->user->id])
                ->one();
        return $user->groups;
    }
    
    public function getDisplayName(){
        return $this->firstname.' '.$this->lastname.' ('.$this->email.')';
    }

    
    public function getFullName(){
        return $this->firstname.' '.$this->lastname;
    }
    
}
