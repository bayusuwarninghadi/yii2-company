<?php

namespace common\models;

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
    public function rules()
    {
        return [
            [['id', 'price', 'discount', 'stock', 'price_from', 'price_to', 'stock_from', 'stock_to','discount_from', 'discount_to','status', 'visible', 'order', 'created_at', 'updated_at'], 'integer'],
            [['name', 'sort', 'description', 'category_name'], 'safe'],
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
     * @param Category $category
     * @return array
     */
    protected function getCategoryChildIds($category){
        $return = [];
        $return[] = $category->id;
        if ($child = $category->children()->all()){
            foreach ($child as $cat) {
                array_merge($return, $this->getCategoryChildIds($cat));
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
        $query = Product::find()->joinWith(['category']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        // categories name
        $dataProvider->sort->attributes['category_name'] = [
            'asc' => ['category.name' => SORT_ASC],
            'desc' => ['category.name' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'visible' => $this->visible,
            'order' => $this->order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'discount', $this->price])
            ->andFilterWhere(['like', 'stock', $this->stock])
            ->andFilterWhere(['>=', 'price', $this->price_from])
            ->andFilterWhere(['<=', 'price', $this->price_to])
            ->andFilterWhere(['>=', 'discount', $this->discount_from])
            ->andFilterWhere(['<=', 'discount', $this->discount_to])
            ->andFilterWhere(['>=', 'stock', $this->stock_from])
            ->andFilterWhere(['<=', 'stock', $this->stock_to])
            ->andFilterWhere(['like', 'product.description', $this->description]);

        if ($this->cat_id && $cat_ids = Category::findOne($this->cat_id)){
            $query->andFilterWhere(['in', 'cat_id', $cat_ids]);    
        }

        return $dataProvider;
    }
}
