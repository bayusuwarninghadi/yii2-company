<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $transaction_id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $qty
 *
 * @property Product $product
 * @property User $user
 * @property Transaction $transaction
 */
class Cart extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'qty'], 'required'],
            ['qty', 'integer', 'min' => 1],
            ['qty', 'validateMaxQty'],
            [['user_id', 'product_id', 'transaction_id'], 'integer']
        ];
    }

    /**
     * Get max quantity of product for order.
     * @param string $attribute the attribute currently being validated
     * @return int
     */
    public function validateMaxQty($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->qty > $count = Product::findOne($this->product_id)->stock) {
                $this->addError($attribute, Yii::t('app', 'Quantity must be less than') . ' ' . $count);
            }
        }

        if ($this->product_id) {
            return;
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'product_id' => Yii::t('app', 'Product'),
            'qty' => Yii::t('app', 'Quantity'),
            'product.name' => Yii::t('app', 'Product'),
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaction()
    {
        return $this->hasOne(Transaction::className(), ['id' => 'transaction_id']);
    }

}
