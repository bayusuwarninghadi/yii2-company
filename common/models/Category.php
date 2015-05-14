<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 *
 * @property Product[] $products
 */
class Category extends ActiveRecord
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
        ];
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['cat_id' => 'id']);
    }

    /**
     * getCategoryChild
     *
     * @param Category[] $categories
     * @return array
     */
    public static function getCategoryChild($categories)
    {
        $return = [];
        /** @var Category|NestedSetsBehavior $category */
        foreach ($categories as $category) {
            $return[$category->id] = $category->toArray();
            if ($child = $category->children()->all()) {
                $return[$category->id]['child'] = static::getCategoryChild($child);
            }
        }
        return $return;
    }

    /**
     * renderNavItem
     *
     * @return array
     */
    public static function renderNavItem()
    {
        $items = [];
        /**
         * assuming first row is root
         * @var Category|NestedSetsBehavior $root
         */

        $root = Category::find()->one();
        if (!$root) {
            $root = new Category();
            $root->name = 'root';
            $root->makeRoot();
        }

        foreach ($categories = static::getCategoryChild($root->children(1)->all()) as $category) {
            $_item = [
                'label' => $category['name'],
            ];
            if (isset($category['child'])) {
                foreach ($category['child'] as $subCategory) {
                    $_item['items'][] = [
                        'label' => $subCategory['name'],
                        'url' => ['/product', 'ProductSearch[cat_id]' => $subCategory['id']],
                        'options' => [
                            'class' => 'sub-nav sub-' . (intval($subCategory['depth']) - 1)
                        ]
                    ];
                }
            } else {
                $_item['url'] = ['/product', 'ProductSearch[cat_id]' => $category['id']];
            }
            $items[] = $_item;
        }
        return $items;
    }

}
