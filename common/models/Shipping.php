<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shipping".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $address
 * @property string $city_area_id
 * @property integer $postal_code
 *
 * @property User $user
 * @property Transaction[] $transactions
 * @property CityArea $cityArea
 */
class Shipping extends ActiveRecord
{

    /**
     * Temp city_id
     * @var integer
     */
    public $city_id = 1;

    /**
     * Temp province_id
     * @var integer
     */
    public $province_id = 1;

    /**
     * Temp province_id
     * @var integer
     */

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shipping';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'postal_code'], 'integer'],
            [['address', 'city_area_id'], 'required'],
            [['address', 'city_area_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'address' => Yii::t('app', 'Address'),
            'city_area_id' => Yii::t('app', 'City Area'),
            'postal_code' => Yii::t('app', 'Postal Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['shipping_id' => 'id']);
    }
}
