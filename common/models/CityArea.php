<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "city_area".
 *
 * @property integer $id
 * @property integer $city_id
 * @property string $name
 *
 * @property City $city
 */
class CityArea extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'city_id' => \Yii::t('app', 'City ID'),
            'name' => \Yii::t('app', 'City Area Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }


}
