<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "voucher".
 *
 * @property integer $id
 * @property integer $value
 * @property integer $status
 * @property integer $expired_at
 */
class Voucher extends ActiveRecord
{

    const STATUS_AVAILABLE = 0;
    const STATUS_REDEEM = 1;
    const STATUS_EXPIRED = 2;
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
            [['value','id'], 'required'],
            [['id'], 'string', 'max' => 255],
            [['value', 'status', 'expired_at'], 'integer'],
        ];
    }

    public function generateVoucher(){
        if ($this->isNewRecord){
            $this->id =  Yii::$app->security->generateRandomString(10);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Voucher Code'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'expired_at' => Yii::t('app', 'Expired At'),
        ];
    }

}
