<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article_lang".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $article_id
 * @property string $language
 *
 * @property Article $article
 */
class ArticleLang extends ActiveRecord
{

    public $lang;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'article_id'], 'required'],
            [['description'], 'string'],
            [['article_id'], 'integer'],
            [['title', 'language'], 'string', 'max' => 255]
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
            'article_id' => Yii::t('app', 'Article ID'),
            'language' => Yii::t('app', 'Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
