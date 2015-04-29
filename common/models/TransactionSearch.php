<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TransactionSearch represents the model behind the search form about `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{

    public $user_name;
    public $shipping_city;
    public $shipping_city_area;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'shipping_id', 'status', 'sub_total', 'grand_total'], 'integer'],
            [['note', 'user_name', 'shipping_city', 'shipping_city_area'], 'safe'],
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
        $query = Transaction::find()->joinWith(['user', 'shipping', 'shipping.cityArea', 'shipping.cityArea.city']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC,
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);

        // user name
        $dataProvider->sort->attributes['user_name'] = [
            'asc' => ['user.name' => SORT_ASC],
            'desc' => ['user.name' => SORT_DESC],
        ];

        // shipping city
        $dataProvider->sort->attributes['shipping_city'] = [
            'asc' => ['city.name' => SORT_ASC],
            'desc' => ['city.name' => SORT_DESC],
        ];
        // shipping city area
        $dataProvider->sort->attributes['shipping_city_area'] = [
            'asc' => ['city_area.name' => SORT_ASC],
            'desc' => ['city_area.name' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'shipping_id' => $this->shipping_id,
            'transaction.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);
        $query->andFilterWhere(['like', 'user.name', $this->user_name]);
        $query->andFilterWhere(['like', 'grand_total', $this->grand_total]);
        $query->andFilterWhere(['like', 'sub_total', $this->sub_total]);
        $query->andFilterWhere(['like', 'city.name', $this->shipping_city]);
        $query->andFilterWhere(['like', 'city_area.name', $this->shipping_city_area]);

        return $dataProvider;
    }
}
