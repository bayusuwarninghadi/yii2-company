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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'shipping_id', 'status', 'sub_total', 'grand_total'], 'integer'],
            [['note','user_name', 'shipping_city'], 'safe'],
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
        $query = Transaction::find()->joinWith(['user','shipping']);

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

        // shipping
        $dataProvider->sort->attributes['shipping_city'] = [
            'asc' => ['shipping.city' => SORT_ASC],
            'desc' => ['shipping.city' => SORT_DESC],
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
        $query->andFilterWhere(['like', 'shipping.city', $this->shipping_city]);

        return $dataProvider;
    }
}
