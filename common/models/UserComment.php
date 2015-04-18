<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_comment".
 *
 * @property integer $id
 * @property string $table_key
 * @property integer $table_id
 * @property integer $user_id
 * @property string $title
 * @property string $comment
 * @property integer $rating
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserComment extends ActiveRecord
{
    const KEY_PRODUCT = 'product';
    const KEY_ARTICLE = 'article';
    const KEY_NEWS = 'news';

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getKeyAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::KEY_PRODUCT => 'Product',
                static::KEY_ARTICLE => 'Article',
                static::KEY_NEWS => 'News',
            ]
            : [
                static::KEY_PRODUCT,
                static::KEY_ARTICLE,
                static::KEY_NEWS,
            ];
        return $return;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

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
            [['title','user_id'], 'required'],
            [['comment'], 'string'],
            [['title','table_key'], 'string', 'max' => 255],
            ['table_key', 'in', 'range' => static::getKeyAsArray(false)],
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
            'title' => 'Title',
            'comment' => 'Comment',
            'rating' => 'Rating',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
