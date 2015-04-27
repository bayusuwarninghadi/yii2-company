<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "confirmation".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $user_id
 * @property string $name
 * @property string $payment_method
 * @property integer $amount
 * @property string $note
 * @property string $created_at
 *
 * @property Transaction $transaction
 * @property User $user
 */
class Confirmation extends ActiveRecord
{

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'confirmation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'user_id', 'name', 'amount', 'created_at'], 'required'],
            [
                'image',
                'file',
                'extensions' => 'gif, jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
            [['transaction_id', 'user_id', 'amount'], 'integer'],
            [['note', 'name', 'payment_method'], 'string'],
            [['created_at'], 'date'],
            ['transaction_id', 'checkTransaction'],
        ];
    }

    /**
     * Check Transaction exist or not
     *
     * @param string $attribute the attribute currently being validated
     * @return bool
     */
    public function checkTransaction($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->transaction === null) {
                $this->addError($attribute, Yii::t('yii', 'Transaction Id Not Found'));
            } else {
                switch ($this->transaction->status) {
                    case (int)Transaction::STATUS_REJECTED:
                        $this->addError($attribute, Yii::t('yii', 'Transaction Rejected'));
                        break;
                    case (int)Transaction::STATUS_CONFIRM:
                        $this->addError($attribute, Yii::t('yii', 'Transaction Was Approved'));
                        break;
                    case (int)Transaction::STATUS_DELIVER:
                    case (int)Transaction::STATUS_DELIVERED:
                        $this->addError($attribute, Yii::t('yii', 'Transaction Was Deliver'));
                        break;
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'transaction_id' => Yii::t('yii', 'Transaction ID'),
            'user_id' => Yii::t('yii', 'User ID'),
            'name' => Yii::t('yii', 'Bank User Name'),
            'amount' => Yii::t('yii', 'Amount'),
            'image' => Yii::t('yii', 'Payment Struck'),
            'note' => Yii::t('yii', 'Leave Me Some Note'),
            'created_at' => Yii::t('yii', 'Transfer Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
