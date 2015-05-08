<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PagesSearch represents the model behind the search form about `common\models\Pages`.
 */
class PagesSearch extends Pages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'order', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description'], 'safe'],
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
        $query = Pages::find()->joinWith(['translations']);

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

        $dataProvider->sort->attributes['title'] = [
            'asc' => ['pages_lang.title' => SORT_ASC],
            'desc' => ['pages_lang.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['description'] = [
            'asc' => ['pages_lang.description' => SORT_ASC],
            'desc' => ['pages_lang.description' => SORT_DESC],
        ];

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'order' => $this->order,
            'type_id' => $this->type_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'pages_lang.title', $this->title])
            ->andFilterWhere(['like', 'pages_lang.description', $this->description]);

        return $dataProvider;
    }
}
