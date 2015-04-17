<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $shipping_id
 * @property string $note
 * @property integer $status
 * @property integer $sub_total
 * @property integer $grand_total
 *
 * @property Shipping $shipping
 * @property User $user
 * @property TransactionAttribute[] $transactionAttributes
 */
class Transaction extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shipping_id', 'status', 'sub_total', 'grand_total'], 'integer'],
            [['note'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'shipping_id' => 'Shipping ID',
            'note' => 'Note',
            'status' => 'Status',
            'sub_total' => 'Sub Total',
            'grand_total' => 'Grand Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Shipping::className(), ['id' => 'shipping_id']);
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
    public function getTransactionAttributes()
    {
        return $this->hasMany(TransactionAttribute::className(), ['transaction_id' => 'id']);
    }
}
