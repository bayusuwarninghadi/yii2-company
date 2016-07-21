<?php

namespace common\models;

use common\modules\RemoveAssetHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_attribute".
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $key
 * @property string $value
 * @property int $int_value
 *
 * @property Pages $page
 */
class PageAttribute extends ActiveRecord
{
    /**
     * beforeDelete
     * 1. Remove image asset before deleting
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            RemoveAssetHelper::removeDirectory(\Yii::$app->getBasePath() . '/../frontend/web/images/page/' . $this->page_id . '/' . $this->id . '/');
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'int_value'], 'integer'],
            [['key'], 'required'],
            [['value'], 'string'],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'page_id' => \Yii::t('app', 'Page'),
            'key' => \Yii::t('app', 'Key'),
            'value' => \Yii::t('app', 'Value'),
            'int_value' => \Yii::t('app', 'Integer Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }
    
}
