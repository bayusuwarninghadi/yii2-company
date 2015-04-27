<?php

namespace common\models;

use common\modules\RemoveAssetHelper;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_attribute".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $key
 * @property string $value
 *
 * @property Product $product
 */
class ProductAttribute extends ActiveRecord
{
    /**
     * beforeDelete
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            /*
             * remove image asset before deleting
             */
            RemoveAssetHelper::removeDirectory(Yii::$app->getBasePath() . '/../frontend/web/images/product/' . $this->product_id . '/' . $this->id . '/');
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['key'], 'required'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii','ID'),
            'product_id' => Yii::t('yii','Product'),
            'key' => Yii::t('yii','Key'),
            'value' => Yii::t('yii','Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
