<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
                static::KEY_PRODUCT => Yii::t('yii', 'Product'),
                static::KEY_ARTICLE => Yii::t('yii', 'Article'),
                static::KEY_NEWS => Yii::t('yii', 'News'),
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
            [['title', 'user_id'], 'required'],
            [['comment'], 'string'],
            [['title', 'table_key'], 'string', 'max' => 255],
            ['table_key', 'in', 'range' => static::getKeyAsArray(false)],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'table_key' => Yii::t('yii', 'Table Key'),
            'table_id' => Yii::t('yii', 'Table ID'),
            'user_id' => Yii::t('yii', 'User'),
            'title' => Yii::t('yii', 'Title'),
            'comment' => Yii::t('yii', 'Comment'),
            'rating' => Yii::t('yii', 'Rating'),
            'created_at' => Yii::t('yii', 'Created At'),
            'updated_at' => Yii::t('yii', 'Updated At'),
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
