<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_comment".
 *
 * @property integer $id
 * @property string $table_key
 * @property integer $table_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $rating
 *
 * @property User $user
 */
class UserComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'user_id', 'rating'], 'integer'],
            [['user_id'], 'required'],
            [['comment'], 'string'],
            [['table_key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_key' => 'Table Key',
            'table_id' => 'Table ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'rating' => 'Rating',
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
