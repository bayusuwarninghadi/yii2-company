<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "voucher".
 *
 * @property integer $id
 * @property string $voucher_code
 * @property integer $value
 * @property integer $status
 * @property integer $expired_at
 *
 * @property Transaction $transaction
 */
class Voucher extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'voucher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value', 'status', 'expired_at'], 'integer'],
            [['voucher_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'voucher_code' => Yii::t('app', 'Voucher Code'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'expired_at' => Yii::t('app', 'Expired At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasOne(Transaction::className(), ['voucher_id' => 'id']);
    }
}
