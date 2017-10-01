<?php

namespace common\models;

use common\modules\translator\TranslateBehavior;
use common\modules\UploadHelper;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $type_id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property string $url
 * @property integer $depth
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Pages[] $pages
 * @property User $user
 */
class Category extends ActiveRecord
{

    const TYPE_PAGE = 1;
    const TYPE_LIST = 2;
    const TYPE_URL = 3;

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getTypeAsArray($with_key = true)
    {
        $return = [
            static::TYPE_PAGE => 'Page',
            static::TYPE_LIST => 'List',
            static::TYPE_URL => 'Url',
        ];

        return $with_key ? $return : array_keys($return);
    }

    public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['type_id', 'default', 'value' => static::TYPE_PAGE],
            ['type_id', 'in', 'range' => static::getTypeAsArray(false)],
            ['created_by', 'default', 'value' => \Yii::$app->user->getId()],
            [
                'image',
                'file',
                'extensions' => 'gif, jpg, png',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * \Yii::$app->params['maxFileUploadSize'],
                'tooBig' => \Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . \Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
            ['url', 'string']
        ];
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'tree' => [
                'class' => NestedSetsBehavior::className(),
            ],
            'trans' => [
                'class' => TranslateBehavior::className(),
                'translationAttributes' => [
                    'title', 'description'
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @var string $language
     */
    public $language = 'en-US';

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(CategoryLang::className(), ['cat_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
	    parent::afterSave($insert, $changedAttributes);

	    if ($image = UploadedFile::getInstance($this, 'image')){
		    UploadHelper::saveImage($image, 'category/' . $this->id);
	    }

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
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'description' => \Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Pages::className(), ['cat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * getCatId as Array
     * @param Category|NestedSetsBehavior $category
     * @return array
     */
    public static function getCategoryChildIds($category)
    {
        $return = [];
        $return[] = $category->id;
        if ($child = $category->children()->all()) {
            /** @var Category $cat */
            foreach ($child as $cat) {
                $return[] = $cat->id;
            }
        }
        return $return;
    }


    /**
     * getCategoryChild
     *
     * @param Category[] $categories
     * @return array
     */
    public static function getCategoryChild($categories)
    {
        $return = [];
        /** @var Category|NestedSetsBehavior $category */
        foreach ($categories as $category) {
            $return[$category->id] = [
                'title' => $category->title,
                'id' => $category->id,
                'type_id' => $category->type_id,
                'url' => $category->url,
            ];
            if ($child = $category->children()->all()) {
                $return[$category->id]['child'] = static::getCategoryChild($child);
            }
        }
        return $return;
    }

    /**
     * renderNavItem
     *
     * @return array
     */
    public static function renderNavItem()
    {
        $items = [];
        /**
         * assuming first row is root
         * @var Category|NestedSetsBehavior $root
         */

        $root = Category::find()->one();

        foreach ($categories = static::getCategoryChild($root->children(1)->all()) as $category) {
            $_item = [
                'label' => $category['title'],
            ];
            if (isset($category['child'])) {
                foreach ($category['child'] as $subCategory) {
                    $_item['items'][] = [
                        'label' => $subCategory['title'],
                        'url' => static::renderUrlCategory($subCategory),
                        'options' => [
                            'class' => 'sub-nav sub-' . (intval($subCategory['depth']) - 1)
                        ]
                    ];
                }
            } else {
                $_item['url'] = static::renderUrlCategory($category);
            }
            $items[] = $_item;
        }
        return $items;
    }

    /**
     * renderUrlCategory
     * @param Category $category
     * @return mixed
     */
    protected static function renderUrlCategory($category){

        \Yii::warning($category);
        switch ($category['type_id']){
            case static::TYPE_LIST:
                $url = ['/content', 'PageSearch[cat_id]' => $category['id']];
                break;
            case static::TYPE_PAGE:
                $url = ['/content/view', 'cat_id' => $category['id']];
                break;
            default:
                $url = $category['url'];
                break;

        }
        return $url;
    }

}
