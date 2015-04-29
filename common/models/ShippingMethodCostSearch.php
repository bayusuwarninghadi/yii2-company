<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShippingMethodCostSearch represents the model behind the search form about `common\models\ShippingMethodCost`.
 */
class ShippingMethodCostSearch extends ShippingMethodCost
{
    public $province_name;
    public $city_name;
    public $city_area_name;
    public $shipping_method_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shipping_method_id', 'value', 'city_area_id'], 'integer'],
            [['province_name', 'city_area_name', 'city_name', 'shipping_method_name', 'estimate_time'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ShippingMethodCost::find()->joinWith(['cityArea', 'cityArea.city', 'cityArea.city.province', 'shippingMethod']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // cityArea name
        $dataProvider->sort->attributes['city_area_name'] = [
            'asc' => ['city_area.name' => SORT_ASC],
            'desc' => ['city_area.name' => SORT_DESC],
        ];
        // city name
        $dataProvider->sort->attributes['city_name'] = [
            'asc' => ['city.name' => SORT_ASC],
            'desc' => ['city.name' => SORT_DESC],
        ];
        // province name
        $dataProvider->sort->attributes['province_name'] = [
            'asc' => ['province.name' => SORT_ASC],
            'desc' => ['province.name' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'shipping_method_id' => $this->shipping_method_id,
            'value' => $this->value,
            'city_area_id' => $this->city_area_id,
        ]);

        $query
            ->andFilterWhere(['like', 'estimate_time', $this->estimate_time])
            ->andFilterWhere(['like', 'city_area.name', $this->city_area_name])
            ->andFilterWhere(['like', 'city.name', $this->city_name])
            ->andFilterWhere(['like', 'province.name', $this->province_name]);

        return $dataProvider;
    }
}
