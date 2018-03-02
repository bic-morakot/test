<?php

namespace app\modules\resource\models;

use Yii;
use app\modules\resource\models\ResDocSequence;
use app\modules\resource\models\ResUsers;

/**
 * This is the model class for table "res_group".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $create_uid
 * @property string $create_date
 * @property integer $write_uid
 * @property string $write_date
 *
 * @property ResGroupDocseqRel[] $resGroupDocseqRels
 * @property ResUsers[] $resUsers
 */
class ResGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'res_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pr_sequence_id','create_uid', 'write_uid'], 'integer'],
            [['create_date', 'write_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 5],
            [['pr_approver_user'],'string','max'=>255],
            [['pr_approver_user'],function($attribute,$params,$validator){
                if($this[$attribute]){
                    $users = explode(',', $this[$attribute]);
                    $temp = ResUsers::find()->where(['in','username', $users])->all();
                    $sys_usernames = \yii\helpers\ArrayHelper::getColumn($temp, 'username');
                    $diff = array_diff($users, $sys_usernames);
                    if(!empty($diff)){
                        $this->addError($attribute,'User ไม่มีในระบบ -> '. implode(',', $diff));
                    }
                }
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Group name'),
            'code' => Yii::t('app', 'Group code'),
            'create_uid' => Yii::t('app', 'Create Uid'),
            'create_date' => Yii::t('app', 'Create Date'),
            'write_uid' => Yii::t('app', 'Write Uid'),
            'write_date' => Yii::t('app', 'Write Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResUsers()
    {
        return $this->hasMany(ResUsers::className(), ['id' => 'user_id'])
                ->viaTable('res_users_group_rel', ['group_id'=>'id']);
    }
        
    
   
    
    /**
     * @inheritdoc
     * @return ResGroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResGroupQuery(get_called_class());
    }
}
