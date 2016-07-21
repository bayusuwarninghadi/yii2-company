<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_attribute".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $key
 * @property string $value
 *
 * @property User $user
 */
class UserAttribute extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            ['key', 'string', 'max' => 255],
            ['value', 'string'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
