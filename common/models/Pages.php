<?php

namespace common\models;

use common\modules\RemoveAssetHelper;
use common\modules\translator\TranslateBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $camel_case
 * @property integer $cat_id
 * @property string $title
 * @property string $subtitle
 * @property string $description
 * @property integer $status
 * @property integer $order
 * @property integer $type_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 *
 * @property PageAttribute $pageTags
 * @property PagesLang[] $translations
 * @property User $user
 */
class Pages extends ActiveRecord
{

	/**
	 * TYPE_ARTICLE
	 */
	const TYPE_PRODUCT = '1';
	/**
	 * TYPE_NEWS
	 */
	const TYPE_NEWS = '2';
	/**
	 * TYPE_PAGES
	 */
	const TYPE_PAGES = '3';
	/**
	 * TYPE_SLIDER
	 */
	const TYPE_SLIDER = '4';
	/**
	 * TYPE_MAIL
	 */
	const TYPE_MAIL = '5';
	/**
	 * TYPE_CONTENT
	 */
	const TYPE_CONTENT = '6';

	/**
	 * TYPE_PARTNER
	 */
	const TYPE_PARTNER = '7';

	/**
	 * TYPE_PARTNER
	 */
	const TYPE_PILL = '8';
	/**
	 * STATUS_INACTIVE
	 */
	const STATUS_INACTIVE = 0;
	/**
	 * STATUS_ACTIVE
	 */
	const STATUS_ACTIVE = 10;

	/**
	 * @var string $language
	 */
	public $language = 'en-US';
	/**
	 * @var
	 */
	public $image;

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTranslations()
	{
		return $this->hasMany(PagesLang::className(), ['page_id' => 'id']);
	}

	public function getModelTags()
	{
		$model = PageAttribute::find()
			->joinWith(['page'])
			->select(PageAttribute::tableName() . '.value')
			->where([
				PageAttribute::tableName() . '.key' => 'tags',
				Pages::tableName() . '.page_id' => $this->id
			])
			->column();
		$tags = [];
		foreach ($model as $tag) {
			foreach (explode(',', $tag) as $_tag) {
				$_tag = trim(strtolower($_tag));
				if (!in_array($_tag, $tags)) $tags[] = $_tag;
			}
		}
		return $tags;
	}

	/**
	 * @param $type
	 * @return array
	 */
	public static function getTags($type)
	{
		$model = PageAttribute::find()
			->joinWith(['page'])
			->select(PageAttribute::tableName() . '.value')
			->where([
				PageAttribute::tableName() . '.key' => 'tags',
				Pages::tableName() . '.type_id' => $type
			])
			->column();
		$tags = [];
		foreach ($model as $tag) {
			foreach (explode(',', $tag) as $_tag) {
				$_tag = trim(strtolower($_tag));
				if (!in_array($_tag, $tags)) $tags[] = $_tag;
			}
		}
		return $tags;
	}

	/**
	 * beforeDelete
	 * @return bool
	 */
	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			/*
			 * remove image asset before deleting
			 */
			switch ($this->type_id) {
				case (int)static::TYPE_PRODUCT:
					$folder = 'article';
					break;
				case (int)static::TYPE_NEWS:
					$folder = 'news';
					break;
				case (int)static::TYPE_PAGES:
					$folder = 'slider';
					break;
				case (int)static::TYPE_SLIDER:
					$folder = 'slider';
					break;
				case (int)static::TYPE_MAIL:
					$folder = 'mail';
					break;
				case (int)static::TYPE_PARTNER:
					$folder = 'partner';
					break;
				case (int)static::TYPE_PILL:
					$folder = 'pill';
					break;
				default:
					$folder = false;
					break;
			}
			if ($folder) {
				RemoveAssetHelper::removeDirectory(\Yii::$app->getBasePath() . '/../frontend/web/images/' . $folder . '/' . $this->id . '/');
			}
			return true;
		} else {
			return false;
		}
	}

	public function getRelated($limit = 4)
	{
		$key = Html::encode($this->title . ' ' . $this->subtitle . ' ' . $this->description);
		$related = Pages::find()
			->joinWith(['translations'])
			->where(
				"(
					MATCH (pages_lang.title) AGAINST (:string_1 IN BOOLEAN MODE) OR
					MATCH (pages_lang.subtitle) AGAINST (:string_2 IN BOOLEAN MODE) OR
					MATCH (pages_lang.description) AGAINST (:string_3 IN BOOLEAN MODE)
				)",
				[
					':string_1' => $key,
					':string_2' => $key,
					':string_3' => $key,
				]
			)
			->andWhere([
				'pages.type_id' => $this->type_id
			])
			->andWhere(['<>', 'pages.id', $this->id])
			->orderBy('pages.order asc, pages.updated_at desc')
			->groupBy('pages.id')
			->limit($limit)
			->all();
		return $related;
	}

	/**
	 * @param bool $with_key
	 * @return array
	 */
	public static function getStatusAsArray($with_key = true)
	{
		$return = [
			static::STATUS_INACTIVE => 'Inactive',
			static::STATUS_ACTIVE => 'Active',
		];

		return $with_key ? $return : array_keys($return);
	}


	/**
	 * @param bool $with_key
	 * @return array
	 */
	public static function getTypeAsArray($with_key = true)
	{
		$return = [
			static::TYPE_CONTENT => 'Content',
			static::TYPE_NEWS => 'News',
			static::TYPE_PRODUCT => 'Article',
			static::TYPE_MAIL => 'Mail',
			static::TYPE_PAGES => 'Pages',
			static::TYPE_SLIDER => 'Slider',
			static::TYPE_PARTNER => 'Partner',
			static::TYPE_PILL => 'Pill',
		];

		return $with_key ? $return : array_keys($return);
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			'trans' => [
				'class' => TranslateBehavior::className(),
				'translationAttributes' => [
					'title', 'subtitle', 'description',
				]
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function afterFind()
	{
		parent::afterFind();
		if (isset(\Yii::$app->session['lang'])) {
			$this->language = \Yii::$app->session['lang'];
		}
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'pages';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[
				'image',
				'file',
				'extensions' => 'gif, jpg, png',
				'mimeTypes' => 'image/jpeg, image/png',
				'maxSize' => 1024 * 1024 * \Yii::$app->params['maxFileUploadSize'],
				'tooBig' => \Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . \Yii::$app->params['maxFileUploadSize'] . ' Mb'
			],
			['created_by', 'default', 'value' => \Yii::$app->user->getId()],
			[['type_id'], 'required'],
			[['status', 'order', 'cat_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
			[['order'], 'default', 'value' => 0],
			['status', 'default', 'value' => static::STATUS_ACTIVE],
			['type_id', 'in', 'range' => static::getTypeAsArray(false)],
			['status', 'in', 'range' => static::getStatusAsArray(false)],
			[['title', 'camel_case', 'subtitle'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => \Yii::t('app', 'ID'),
			'title' => \Yii::t('app', 'Title'),
			'subtitle' => \Yii::t('app', 'Subtitle'),
			'cat_id' => \Yii::t('app', 'Category'),
			'description' => \Yii::t('app', 'Description'),
			'status' => \Yii::t('app', 'Status'),
			'order' => \Yii::t('app', 'Order'),
			'type_id' => \Yii::t('app', 'Type ID'),
			'created_at' => \Yii::t('app', 'Created At'),
			'updated_at' => \Yii::t('app', 'Updated At'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPageAttributes()
	{
		return $this->hasMany(PageAttribute::className(), ['page_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPageTags()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => 'tags']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory()
	{
		return $this->hasOne(Category::className(), ['id' => 'cat_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'created_by']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserComments()
	{
		return $this->hasMany(UserComment::className(), ['table_id' => 'id'])->andWhere(['table_key' => static::tableName()]);
	}


}
