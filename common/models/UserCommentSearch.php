<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserCommentSearch represents the model behind the search form about `common\models\UserComment`.
 */
class UserCommentSearch extends UserComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'table_id', 'user_id', 'rating'], 'integer'],
            [['table_key', 'comment'], 'safe'],
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
        $query = UserComment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            'id' => $this->id,
            'table_id' => $this->table_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'table_key', $this->table_key])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
