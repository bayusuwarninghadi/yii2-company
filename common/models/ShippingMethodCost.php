<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shipping_method_cost".
 *
 * @property integer $id
 * @property integer $shipping_method_id
 * @property integer $value
 * @property string $estimate_time
 * @property integer $city_area_id
 *
 * @property CityArea $cityArea
 * @property ShippingMethod $shippingMethod
 */
class ShippingMethodCost extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping_method_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shipping_method_id', 'value', 'city_area_id'], 'integer'],
            [['estimate_time'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shipping_method_id' => Yii::t('app', 'Shipping Method ID'),
            'value' => Yii::t('app', 'Value'),
            'estimate_time' => Yii::t('app', 'Estimate Time'),
            'city_area_id' => Yii::t('app', 'City Area ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityArea()
    {
        return $this->hasOne(CityArea::className(), ['id' => 'city_area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingMethod()
    {
        return $this->hasOne(ShippingMethod::className(), ['id' => 'shipping_method_id']);
    }
}
