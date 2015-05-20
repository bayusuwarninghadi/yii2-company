<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form about `common\models\Product`.
 */
class ProductSearch extends Product
{

    public $category_name;
    public $price_from;
    public $price_to;
    public $discount_from;
    public $discount_to;
    public $stock_from;
    public $stock_to;
    public $sort;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $return = [
            'price_from' => Yii::t('app', 'Price From'),
            'price_to' => Yii::t('app', 'Price To'),
            'discount_from' => Yii::t('app', 'Discount From'),
            'discount_to' => Yii::t('app', 'Discount To'),
            'stock_from' => Yii::t('app', 'Stock From'),
            'stock_to' => Yii::t('app', 'Stock To'),
            'sort' => Yii::t('app', 'Sort'),
            'category_name' => Yii::t('app', 'Category'),
        ];
        return array_merge($return, parent::attributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'discount', 'stock', 'brand_id', 'price_from', 'price_to', 'stock_from', 'stock_to', 'discount_from', 'discount_to', 'status', 'visible', 'order', 'created_at', 'cat_id', 'updated_at'], 'integer'],
            [['name', 'sort', 'description', 'subtitle', 'category_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * getCatId as Array
     * @param Category|NestedSetsBehavior $category
     * @return array
     */
    protected function getCategoryChildIds($category)
    {
        $return = [];
        $return[] = $category->id;
        if ($child = $category->children()->all()) {
            /** @var Category $cat */
            foreach ($child as $cat) {
                $return[] = $cat->id;
            }
        }
        return $return;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Product::find()->joinWith(['category', 'translations']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        // categories name
        $dataProvider->sort->attributes['category_name'] = [
            'asc' => ['category.name' => SORT_ASC],
            'desc' => ['category.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['name'] = [
            'asc' => ['product_lang.name' => SORT_ASC],
            'desc' => ['product_lang.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['subtitle'] = [
            'asc' => ['product_lang.subtitle' => SORT_ASC],
            'desc' => ['product_lang.subtitle' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'brand_id' => $this->brand_id,
            'visible' => $this->visible,
            'order' => $this->order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product_lang.name', $this->name])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'discount', $this->price])
            ->andFilterWhere(['like', 'stock', $this->stock])
            ->andFilterWhere(['>=', 'price', $this->price_from])
            ->andFilterWhere(['<=', 'price', $this->price_to])
            ->andFilterWhere(['>=', 'discount', $this->discount_from])
            ->andFilterWhere(['<=', 'discount', $this->discount_to])
            ->andFilterWhere(['>=', 'stock', $this->stock_from])
            ->andFilterWhere(['<=', 'stock', $this->stock_to])
            ->andFilterWhere(['like', 'product_lang.description', $this->description])
            ->andFilterWhere(['like', 'product_lang.subtitle', $this->subtitle]);

        /** @var Category $category */
        if ($this->cat_id && $category = Category::findOne($this->cat_id)) {
            $cat_ids = static::getCategoryChildIds($category);
            $query->andFilterWhere(['in', 'cat_id', $cat_ids]);
        }

        return $dataProvider;
    }
}
