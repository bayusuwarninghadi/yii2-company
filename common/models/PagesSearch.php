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
	public $tags;

	public $has_discount;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'status', 'order', 'type_id', 'created_at', 'updated_at', 'cat_id', 'brand_id', 'discount'], 'integer'],
			[['title', 'description', 'subtitle', 'key', 'tags', 'category', 'size', 'color', 'has_discount'], 'safe'],
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
		$query = Pages::find()
			->joinWith(['translations'])
			->leftJoin(PageAttribute::tableName() . ' p_tags', sprintf('`p_tags`.`page_id` = `%s`.`id`', Pages::tableName()))
			->leftJoin(PageAttribute::tableName() . ' p_category', sprintf('`p_category`.`page_id` = `%s`.`id`', Pages::tableName()))
			->leftJoin(PageAttribute::tableName() . ' p_color', sprintf('`p_color`.`page_id` = `%s`.`id`', Pages::tableName()))
			->leftJoin(PageAttribute::tableName() . ' p_size', sprintf('`p_size`.`page_id` = `%s`.`id`', Pages::tableName()))
			->leftJoin(PageAttribute::tableName() . ' p_brand', sprintf('`p_brand`.`page_id` = `%s`.`id`', Pages::tableName()))
			->leftJoin(PageAttribute::tableName() . ' p_discount', sprintf('`p_discount`.`page_id` = `%s`.`id`', Pages::tableName()))
		;

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 20,
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

		$dataProvider->sort->attributes['brand_id'] = [
			'asc' => ['p_brand.int_value' => SORT_ASC],
			'desc' => ['p_brand.int_value' => SORT_DESC],
		];

		$dataProvider->sort->attributes['discount'] = [
			'asc' => ['p_discount.int_value' => SORT_ASC],
			'desc' => ['p_discount.int_value' => SORT_DESC],
		];

		$query->where([
			'p_tags.key' => Pages::PAGE_ATTRIBUTE_TAGS,
			'p_category.key' => Pages::PAGE_ATTRIBUTE_CATEGORY,
			'p_color.key' => Pages::PAGE_ATTRIBUTE_COLOR,
			'p_size.key' => Pages::PAGE_ATTRIBUTE_SIZE,
			'p_brand.key' => Pages::PAGE_ATTRIBUTE_BRAND,
			'p_discount.key' => Pages::PAGE_ATTRIBUTE_DISCOUNT,
		]);


		$query->andFilterWhere([
			'id' => $this->id,
			'status' => $this->status,
			'order' => $this->order,
			'type_id' => $this->type_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
			'p_brand.int_value' => $this->brand_id,
			'p_discount.int_value' => $this->discount,
		])
			->andFilterWhere(['like', 'pages_lang.title', $this->title])
			->andFilterWhere(['like', 'pages_lang.subtitle', $this->subtitle])
			->andFilterWhere(['like', 'p_tags.value', $this->tags])
			->andFilterWhere(['like', 'pages_lang.description', $this->description]);

		if ($this->has_discount){
			$query->andWhere('p_discount.int_value > 0');
		}

		// size
		$this->size = is_array($this->size) ? $this->size : [$this->size];
		$size_query = [];
		foreach ($this->size as $size){
			if ($size != "") $size_query[] = sprintf("(p_size.value like '%%\"%s\"%%')", $size);
		}
		if (!empty($size_query)) $query = $query->andWhere(sprintf('(%s)', implode(' OR ', $size_query)));

		// Color
		$this->color = is_array($this->color) ? $this->color : [$this->color];
		$color_query = [];
		foreach ($this->color as $color){
			if ($color != "") $color_query[] = sprintf("(p_color.value like '%%\"%s\"%%')", $color);
		}
		if (!empty($color_query)) $query = $query->andWhere(sprintf('(%s)', implode(' OR ', $color_query)));

		// Category
		$this->category = is_array($this->category) ? $this->category : [$this->category];
		$category_query = [];
		foreach ($this->category as $category){
			if ($category != "") $category_query[] = sprintf("(p_category.value like '%%\"%s\"%%')", $category);
		}
		if (!empty($category_query)) $query = $query->andWhere(sprintf('(%s)', implode(' OR ', $category_query)));

		if ($this->key) {
			$query->andWhere("pages_lang.title like '%" . $this->key . "%' OR pages_lang.description like '%" . $this->key . "%'");
		}

		/** @var Category $category */
		if ($this->cat_id && $category = Category::findOne($this->cat_id)) {
			$cat_ids = Category::getCategoryChildIds($category);
			$query->andFilterWhere(['in', 'cat_id', $cat_ids]);
		}

		return $dataProvider;
	}
}
