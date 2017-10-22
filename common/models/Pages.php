<?php

namespace common\models;

use common\modules\UploadHelper;
use Yii;
use common\modules\RemoveAssetHelper;
use common\modules\translator\TranslateBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\UploadedFile;

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
 * @property PageAttribute[] $pageImages
 * @property PageAttribute $pageImage
 * @property PageAttribute $pageDetail
 * @property PageAttribute $pageSize
 * @property PageAttribute $pageColor
 * @property PageAttribute $pageCategory
 * @property PagesLang[] $translations
 * @property User $user
 */
class Pages extends ActiveRecord
{

	const PAGE_ATTRIBUTE_DETAILS = 'detail';
	const PAGE_ATTRIBUTE_COLOR = 'color';
	const PAGE_ATTRIBUTE_SIZE = 'size';
	const PAGE_ATTRIBUTE_TAGS = 'tags';
	const PAGE_ATTRIBUTE_CATEGORY = 'category';

	const TYPE_PRODUCT = '1';
	const TYPE_NEWS = '2';
	const TYPE_PAGES = '3';
	const TYPE_SLIDER = '4';
	const TYPE_MAIL = '5';
	const TYPE_CONTENT = '6';
	const TYPE_PARTNER = '7';
	const TYPE_PILL = '8';
	const TYPE_BRAND = '9';

	const STATUS_INACTIVE = 0;
	const STATUS_ACTIVE = 10;

	public $language = 'en-US';
	public $image;
	public $images;
	public $detail = [];
	public $color = [];
	public $size = [];
	public $tags = [];
	public $category = [];

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getTranslations()
	{
		return $this->hasMany(PagesLang::className(), ['page_id' => 'id']);
	}

	public static function getAvailableTags($tags = self::PAGE_ATTRIBUTE_TAGS)
	{
		$model = PageAttribute::find()
			->joinWith(['page'])
			->select(PageAttribute::tableName() . '.value')
			->where([
				PageAttribute::tableName() . '.key' => $tags,
			])
			->column();
		$tags = [];
		foreach ($model as $tag) {
			foreach (Json::decode($tag) as $_tag) {
				if (!in_array($_tag, $tags)) $tags[$_tag] = $_tag;
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
				PageAttribute::tableName() . '.key' => self::PAGE_ATTRIBUTE_TAGS,
				Pages::tableName() . '.type_id' => $type
			])
			->column();
		$tags = [];
		foreach ($model as $tag) {
			foreach (Json::decode($tag) as $_tag) {
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
				case (int)static::TYPE_BRAND:
					$folder = 'brand';
					break;
				default:
					$folder = false;
					break;
			}
			if ($folder) {
				RemoveAssetHelper::removeDirectory(Yii::$app->getBasePath() . '/../frontend/web/images/' . $folder . '/' . $this->id . '/');
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

	public function getImagePath()
	{
		if ($this->pageImages) {
			$return = 'page/' . $this->id . '/' . $this->pageImages[0]->id;
		} elseif ($this->pageImage) {
			$return = 'page/' . $this->id . '/' . $this->pageImage->id;
		} else {
			$return = '';
		}
		return $return;
	}

	public function afterSave($insert, $changedAttributes)
	{
		parent::afterSave($insert, $changedAttributes);

		if ($image = UploadedFile::getInstance($this, 'image')) {
			if (($_model = $this->pageImage) == null) {
				$_model = new PageAttribute();
				$_model->key = 'image';
				$_model->page_id = $this->id;
			}
			if ($_model->save() && $upload = UploadHelper::saveImage($image, 'page/' . $this->id . '/' . $_model->id)) {
				$_model->value = Json::encode($upload);
				$_model->save();
			}
		}

		if ($_images = UploadedFile::getInstances($this, 'images')) {
			foreach ($_images as $image) {
				$_model = new PageAttribute();
				$_model->key = 'images';
				$_model->page_id = $this->id;
				if ($_model->save() && $upload = UploadHelper::saveImage($image, 'page/' . $this->id . '/' . $_model->id)) {
					$_model->value = Json::encode($upload);
					$_model->save();
				}
			}
		}

		$_attr = [
			'pageDetail' => self::PAGE_ATTRIBUTE_DETAILS,
			'pageColor' => self::PAGE_ATTRIBUTE_COLOR,
			'pageSize' => self::PAGE_ATTRIBUTE_SIZE,
			'pageTags' => self::PAGE_ATTRIBUTE_TAGS,
			'pageCategory' => self::PAGE_ATTRIBUTE_CATEGORY,
		];
		foreach ($_attr as $key => $attr){
			if (($model = $this->$key) === null) {
				$model = new PageAttribute();
				$model->key = $attr;
				$model->page_id = $this->id;
			}
			$model->value = $this->$attr ? Json::encode($this->$attr) : '[]';
			$model->save();
		}
	}

	public static function getColors()
	{
		return [
			'red' => 'RED',
			'green' => 'GREEN',
			'blue' => 'BLUE',
		];
	}

	public static function getSizes()
	{
		return [
			'33' => '33',
			'34' => '34',
			'35' => '35',
			'36' => '36',
			'37' => '37',
			'38' => '38',
			'39' => '39',
			'40' => '40',
			'41' => '41',
			'42' => '42',
			'43' => '43',
			'44' => '44',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPageDetail()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['page_attribute.key' => self::PAGE_ATTRIBUTE_DETAILS]);
	}

	/**
	 * @inheritdoc
	 */
	public function afterFind()
	{
		parent::afterFind();

		if (isset(Yii::$app->session['lang'])) {
			$this->language = Yii::$app->session['lang'];
		}

		if ($this->pageDetail) {
			$this->detail = Json::decode($this->pageDetail->value);
		}

		if ($this->pageColor) {
			$this->color = Json::decode($this->pageColor->value);
		}

		if ($this->pageSize) {
			$this->size = Json::decode($this->pageSize->value);
		}

		if ($this->pageTags) {
			$this->tags = Json::decode($this->pageTags->value);
		}
		if ($this->pageCategory) {
			$this->category = Json::decode($this->pageCategory->value);
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
				'images',
				'file',
				'maxFiles' => 6,
				'extensions' => 'gif, jpg, png',
				'mimeTypes' => 'image/jpeg, image/png',
				'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
				'tooBig' => Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
			],
			[
				'image',
				'file',
				'extensions' => 'gif, jpg, png',
				'mimeTypes' => 'image/jpeg, image/png',
				'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
				'tooBig' => Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
			],
			['created_by', 'default', 'value' => Yii::$app->user->getId()],
			[['type_id'], 'required'],
			[['status', 'order', 'cat_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
			[['order'], 'default', 'value' => 0],
			['status', 'default', 'value' => static::STATUS_ACTIVE],
			['type_id', 'in', 'range' => static::getTypeAsArray(false)],
			['status', 'in', 'range' => static::getStatusAsArray(false)],
			[['title', 'camel_case', 'subtitle'], 'string', 'max' => 255],
			[['color', 'size', 'detail', 'category', 'tags'], 'each', 'rule' => ['string']]
		];
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'title' => Yii::t('app', 'Title'),
			'subtitle' => Yii::t('app', 'Subtitle'),
			'cat_id' => Yii::t('app', 'Category'),
			'description' => Yii::t('app', 'Description'),
			'status' => Yii::t('app', 'Status'),
			'order' => Yii::t('app', 'Order'),
			'type_id' => Yii::t('app', 'Type ID'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
		];
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageAttributes()
	{
		return $this->hasMany(PageAttribute::className(), ['page_id' => 'id']);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageImages()
	{
		return $this->hasMany(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => 'images']);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageImage()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => 'image']);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageColor()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => self::PAGE_ATTRIBUTE_COLOR]);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageCategory()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => self::PAGE_ATTRIBUTE_CATEGORY]);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageSize()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => self::PAGE_ATTRIBUTE_SIZE]);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getPageTags()
	{
		return $this->hasOne(PageAttribute::className(), ['page_id' => 'id'])->where(['key' => self::PAGE_ATTRIBUTE_TAGS]);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getCategory()
	{
		return $this->hasOne(Category::className(), ['id' => 'cat_id']);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'created_by']);
	}

	/**
	 * @return Yii\db\ActiveQuery
	 */
	public function getUserComments()
	{
		return $this->hasMany(UserComment::className(), ['table_id' => 'id'])->andWhere(['table_key' => static::tableName()]);
	}


}
