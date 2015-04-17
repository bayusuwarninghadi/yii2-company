<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transaction_attribute".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $product_id
 * @property string $product_attribute
 * @property integer $current_price
 * @property integer $current_discount
 *
 * @property Product $product
 * @property Transaction $transaction
 */
class TransactionAttribute extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['transaction_id', 'product_id', 'current_price', 'current_discount'], 'integer'],
            [['product_attribute'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaction_id' => 'Transaction ID',
            'product_id' => 'Product ID',
            'product_attribute' => 'Product Attribute',
            'current_price' => 'Current Price',
            'current_discount' => 'Current Discount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }
}
