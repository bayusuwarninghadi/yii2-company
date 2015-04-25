<?php

namespace common\models;

use common\modules\RemoveAssetHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;


/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $subtitle
 * @property string $description
 * @property integer $price
 * @property integer $brand_id
 * @property integer $cat_id
 * @property integer $discount
 * @property integer $stock
 * @property integer $status
 * @property integer $visible
 * @property integer $order
 * @property string $rating
 * @property string $image_url
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Brand $brand
 * @property ProductAttribute[] $productAttributes
 * @property Category $category
 * @property Cart[] $carts
 * @property UserComment[] $userComments
 */
class Product extends ActiveRecord
{
    /**
     *
     */
    const STATUS_INACTIVE = 0;
    /**
     *
     */
    const STATUS_ACTIVE = 1;
    /**
     *
     */
    const VISIBLE_INVISIBLE = 0;
    /**
     *
     */
    const VISIBLE_VISIBLE = 1;

    /**
     * @var
     */
    public $images;

    /**
     * @var $productAttributeDetail ProductAttribute
     */
    public $productAttributeDetail = false;

    /**
     * @var array
     */
    public $productAttributeDetailValue = [];

    /**
     * beforeDelete
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            /*
             * remove image asset before deleting
             */
            RemoveAssetHelper::removeDirectory(Yii::$app->getBasePath() . '/../frontend/web/images/product/' . $this->id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * afterSave
     * @param boolean $insert whether this method called while inserting a record.
     * @param array $changedAttributes The old values of attributes that had changed and were saved.
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (parent::afterSave($insert, $changedAttributes)) {
            if ($this->isNewRecord){
                $attr = new ProductAttribute();
                $attr->product_id = $this->id;
                $attr->key = 'detail';
            } else {
                $attr = $this->getProductAttributeDetail();
            }
            $attr->value = Json::encode($this->productAttributeDetailValue);
            $attr->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_ACTIVE => 'Active',
                static::STATUS_INACTIVE => 'Inactive',
            ]
            : [
                static::STATUS_ACTIVE,
                static::STATUS_INACTIVE,
            ];
        return $return;
    }

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getVisibleAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::VISIBLE_VISIBLE => 'Visible',
                static::VISIBLE_INVISIBLE => 'Invisible',
            ]
            : [
                static::VISIBLE_VISIBLE,
                static::VISIBLE_INVISIBLE,
            ];
        return $return;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                'images',
                'file',
                'maxFiles' => 6,
                'extensions' => 'gif, jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed ' . Yii::$app->params['maxFileUploadSize'] . ' Mb')
            ],
            [['name', 'description', 'cat_id'], 'required'],
            [['description'], 'string'],
            [['stock', 'status', 'visible', 'cat_id', 'brand_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'subtitle', 'rating', 'image_url'], 'string', 'max' => 255],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],
            ['visible', 'default', 'value' => static::VISIBLE_VISIBLE],
            ['visible', 'in', 'range' => static::getVisibleAsArray(false)],
            [['order', 'discount', 'price', 'stock'], 'default', 'value' => 0],
            [['order', 'discount', 'price', 'stock'], 'integer', 'min' => 0],
            ['discount', 'integer', 'max' => 100],
            ['image_url', 'default', 'value' => '/images/320x150.gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'subtitle' => 'Subtitle',
            'description' => 'Description',
            'price' => 'Price',
            'cat_id' => 'Category Id',
            'discount' => 'Discount',
            'stock' => 'Stock',
            'status' => 'Status',
            'visible' => 'Visible',
            'order' => 'Order',
            'rating' => 'Rating',
            'image_url' => 'Image URL',
            'category.name' => 'Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'brand_id' => 'Brand',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttributes()
    {
        return $this->hasMany(ProductAttribute::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserComments()
    {
        return $this->hasMany(UserComment::className(), ['table_id' => 'id'])->andWhere(['table_key' => static::tableName()]);
    }

    /**
     * @return bool|float
     */
    public function countRating()
    {
        if ($this->rating) {
            $rating = explode(',', $this->rating);
            $totalRating = intval($rating[0]);
            $totalUser = intval($rating[1]);
            return $totalUser > 0 ? round($totalRating / $totalUser, 0) : false;
        } else {
            return false;
        }
    }

    /**
     * Get Product Attribute
     * @return null|ProductAttribute|ActiveRecord
     */
    public function getProductAttributeDetail()
    {
        if (!$this->productAttributeDetail){
            $this->productAttributeDetail = ProductAttribute::findOne(['product_id' => $this->id, 'key' => 'details']);
            if ($this->productAttributeDetail == null){
                $attr = new ProductAttribute();
                $attr->product_id = $this->id;
                $attr->key = 'details';
                // add default value
                $attr->value = Json::encode([]);
                $this->productAttributeDetail = $attr;
            }
        }
        return $this->productAttributeDetail;
    }

    /**
     * Get Product Attribute Value
     * @return string|Json
     */
    public function getProductAttributeDetailValue()
    {
        if (!$this->productAttributeDetailValue && $detail = $this->getProductAttributeDetail()){
            $this->productAttributeDetailValue = Json::decode($detail->value);
        }
        return $this->productAttributeDetailValue;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}
