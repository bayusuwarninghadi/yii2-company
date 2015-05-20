<?php

namespace common\models;

use common\modules\RemoveAssetHelper;
use common\modules\translator\TranslateBehavior;
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
 * @property ProductAttribute[] $productImages
 * @property ProductAttribute $productDetail
 * @property ProductAttribute $productTotalView
 * @property Category $category
 * @property Cart[] $carts
 * @property UserComment[] $userComments
 * @property ProductLang[] $productLangs
 */
class Product extends ActiveRecord
{

    /**
     * PRODUCT_ATTRIBUTE_DETAILS
     */
    const PRODUCT_ATTRIBUTE_DETAILS = 'productDetail';
    /**
     * PRODUCT_ATTRIBUTE_TOTAL_VIEW
     */
    const PRODUCT_ATTRIBUTE_TOTAL_VIEW = 'totalView';
    /**
     * PRODUCT_ATTRIBUTE_IMAGES
     */
    const PRODUCT_ATTRIBUTE_IMAGES = 'images';
    /**
     * STATUS_INACTIVE
     */
    const STATUS_INACTIVE = 0;

    /**
     * STATUS_ACTIVE
     */
    const STATUS_ACTIVE = 1;

    /**
     * VISIBLE_INVISIBLE
     */
    const VISIBLE_INVISIBLE = 0;

    /**
     * VISIBLE_VISIBLE
     */
    const VISIBLE_VISIBLE = 1;

    /**
     * @var
     */
    public $images;

    public $productTotalView = false;
    /**
     * @var array
     */
    public $detailValue = [];

    /**
     * @var string
     */
    public $language = 'en-US';

    /**
     * beforeDelete
     * 1. Remove image asset before deleting
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            RemoveAssetHelper::removeDirectory(Yii::$app->getBasePath() . '/../frontend/web/images/product/' . $this->id);
            return true;
        }
        return false;
    }

    /**
     * afterSave
     *
     * @param boolean $insert whether this method called while inserting a record.
     * @param array $changedAttributes The old values of attributes that had changed and were saved.
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($this->detailValue) {
            if (($productDetail = $this->productDetail) === null){
                $productDetail = new ProductAttribute();
                $productDetail->key = self::PRODUCT_ATTRIBUTE_DETAILS;
            }
            $productDetail->value = Json::encode($this->detailValue);
            $productDetail->save();
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
            'trans' => [
                'class' => TranslateBehavior::className(),
                'translationAttributes' => [
                    'name', 'subtitle', 'description'
                ]
            ],

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
                'tooBig' => Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
            [['cat_id'], 'required'],
            [['description'], 'string'],
            [['stock', 'status', 'visible', 'cat_id', 'brand_id', 'created_at', 'updated_at'], 'integer'],
            [['rating', 'image_url'], 'string', 'max' => 255],
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
    public function afterFind()
    {
        parent::afterFind();
        if (isset(Yii::$app->session['lang'])) {
            $this->language = Yii::$app->session['lang'];
        }
        if ($this->productDetail){
            $this->detailValue = Json::decode($this->productDetail->value);
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'subtitle' => Yii::t('app', 'Subtitle'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'cat_id' => Yii::t('app', 'Category'),
            'discount' => Yii::t('app', 'Discount'),
            'stock' => Yii::t('app', 'Stock'),
            'status' => Yii::t('app', 'Status'),
            'visible' => Yii::t('app', 'Visible'),
            'order' => Yii::t('app', 'Order'),
            'rating' => Yii::t('app', 'Rating'),
            'image_url' => Yii::t('app', 'Image URL'),
            'category.name' => Yii::t('app', 'Category'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'brand_id' => Yii::t('app', 'Brand'),
            'productTotalView.int_value' => Yii::t('app', 'Total View'),
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
    public function getProductTotalView()
    {
        return $this->hasOne(ProductAttribute::className(), ['product_id' => 'id'])->where(['product_attribute.key' => self::PRODUCT_ATTRIBUTE_TOTAL_VIEW]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductDetail()
    {
        return $this->hasOne(ProductAttribute::className(), ['product_id' => 'id'])->where(['product_attribute.key' => self::PRODUCT_ATTRIBUTE_DETAILS]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->hasMany(ProductAttribute::className(), ['product_id' => 'id'])->where(['product_attribute.key' => self::PRODUCT_ATTRIBUTE_IMAGES]);
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
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(ProductLang::className(), ['product_id' => 'id']);
    }

}
