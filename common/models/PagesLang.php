<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "pages_lang".
 *
 * @property integer $id
 * @property string $title
 * @property string $subtitle
 * @property string $description
 * @property integer $page_id
 * @property string $language
 *
 * @property Pages $article
 */
class PagesLang extends ActiveRecord
{

    public $lang;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'page_id'], 'required'],
            [['description'], 'string'],
            [['page_id'], 'integer'],
            [['title', 'language', 'subtitle'], 'string', 'max' => 255]
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
            'description' => \Yii::t('app', 'Description'),
            'page_id' => \Yii::t('app', 'Pages ID'),
            'language' => \Yii::t('app', 'Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }
}
