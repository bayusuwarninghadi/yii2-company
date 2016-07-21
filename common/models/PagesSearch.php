<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PagesSearch represents the model behind the search form about `common\models\Pages`.
 * @property string $key
 */
class PagesSearch extends Pages
{
    public $key;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'order', 'type_id', 'created_at', 'updated_at', 'cat_id'], 'integer'],
            [['title', 'description', 'key'], 'safe'],
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
        ])
            ->andFilterWhere(['like', 'pages_lang.title', $this->title])
            ->andFilterWhere(['like', 'pages_lang.description', $this->description]);
        /** @var Category $category */

        if ($this->key){
            $query->andWhere("pages_lang.title like '%".$this->key."%' OR pages_lang.description like '%".$this->key."%'");
        }
        if ($this->cat_id && $category = Category::findOne($this->cat_id)) {
            $cat_ids = Category::getCategoryChildIds($category);
            $query->andFilterWhere(['in', 'cat_id', $cat_ids]);
        }

        return $dataProvider;
    }
}
