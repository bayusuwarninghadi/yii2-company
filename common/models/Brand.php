<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $brand
 * @property string $description
 *
 * @property Product[] $products
 */
class Brand extends ActiveRecord
{

    /**
     * @var
     */
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
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
                'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
            [['brand'], 'required'],
            [['description'], 'string'],
            [['brand'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'brand' => Yii::t('yii', 'Brand'),
            'description' => Yii::t('yii', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['brand_id' => 'id']);
    }
}
