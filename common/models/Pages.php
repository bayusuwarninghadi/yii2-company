<?php

namespace common\models;

use common\modules\RemoveAssetHelper;
use common\modules\translator\TranslateBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $camel_case
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $order
 * @property integer $type_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PagesLang[] $articleLangs
 */
class Pages extends ActiveRecord
{

    /**
     * TYPE_ARTICLE
     */
    const TYPE_ARTICLE = '1';
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
                case (int)static::TYPE_ARTICLE:
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

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_INACTIVE => 'Inactive',
                static::STATUS_ACTIVE => 'Active',
            ]
            : [
                static::STATUS_INACTIVE,
                static::STATUS_ACTIVE,
            ];
        return $return;
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
                    'title', 'description'
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
        if (isset(Yii::$app->session['lang'])) {
            $this->language = Yii::$app->session['lang'];
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
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
            [['type_id'], 'required'],
            [['status', 'order', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['order'], 'default', 'value' => 0],
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
            ['type_id', 'in', 'range' => [static::TYPE_ARTICLE, static::TYPE_NEWS, static::TYPE_PAGES, static::TYPE_SLIDER, static::TYPE_MAIL]],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],
            [['title', 'description', 'camel_case'], 'string', 'max' => 255]
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
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'order' => Yii::t('app', 'Order'),
            'type_id' => Yii::t('app', 'Type ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
