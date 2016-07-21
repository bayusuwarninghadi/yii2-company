<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "category_lang".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $cat_id
 * @property string $language
 *
 * @property Category $category
 */
class CategoryLang extends ActiveRecord
{

    public $lang;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id'], 'required'],
            [['description'], 'string'],
            [['cat_id'], 'integer'],
            [['title', 'language'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'title' => \Yii::t('app', 'Name'),
            'description' => \Yii::t('app', 'Description'),
            'cat_id' => \Yii::t('app', 'Category'),
            'language' => \Yii::t('app', 'Language'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }
}
