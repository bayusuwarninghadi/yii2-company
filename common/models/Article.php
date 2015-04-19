<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $order
 * @property integer $type_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class Article extends ActiveRecord
{
    const TYPE_ARTICLE = '1';
    const TYPE_NEWS = '2';
    const TYPE_PAGES = '3';
    const TYPE_SLIDER = '4';
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public $image;
    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_INACTIVE => 'Inactive',
                static::STATUS_ACTIVE => 'Active',
            ]
            : [
                static::STATUS_INACTIVE,
                static::STATUS_ACTIVE,
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
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'image',
                'file',
                'extensions' => 'gif, jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed ' . Yii::$app->params['maxFileUploadSize'] . ' Mb')
            ],

            [['title', 'description', 'type_id'], 'required'],
            [['description'], 'string'],
            [['status', 'order', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['order'], 'default', 'value' => 0],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['type_id', 'in', 'range' => [static::TYPE_ARTICLE, static::TYPE_NEWS, static::TYPE_PAGES, static::TYPE_SLIDER]],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'order' => 'Order',
            'type_id' => 'Type ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
