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
            [['transaction_id', 'user_id', 'name', 'amount', 'image', 'created_at'], 'required'],
            [
                'image',
                'file',
                'extensions' => 'gif, jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed ' . Yii::$app->params['maxFileUploadSize'] . ' Mb')
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
     * @param array $params the additional name-value pairs given in the rule
     * @return bool
     */
    public function checkTransaction($attribute, $params)
    {
        if (!$this->hasErrors()) {
            /**
             * @var $transaction Transaction
             */
            $transaction = Transaction::findOne(['id' => $this->transaction_id, 'user_id' => Yii::$app->user->getId()]);
            if ($transaction === null) {
                $this->addError($attribute, 'Transaction Id Not Found.');
            } else {
                switch ($transaction->status) {
                    case (int)Transaction::STATUS_REJECTED:
                        $this->addError($attribute, 'Transaction Rejected.');
                        break;
                    case (int)Transaction::STATUS_APPROVED:
                        $this->addError($attribute, 'Transaction Was Approved.');
                        break;
                    case (int)Transaction::STATUS_DELIVER:
                    case (int)Transaction::STATUS_DELIVERED:
                        $this->addError($attribute, 'Transaction Was Deliver.');
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
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'user_id' => 'User ID',
            'name' => 'Bank User Name',
            'amount' => 'Amount',
            'image' => 'Payment Struck',
            'note' => 'Leave Me Some Note',
            'created_at' => 'Transfer Date',
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
