<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property integer $type
 * @property integer $readonly
 */
class Setting extends ActiveRecord
{

    /**
     * READONLY
     */
    const READONLY = 1;
    /**
     * READONLY_NOT
     */
    const READONLY_NOT = 0;
    /**
     * TYPE_TEXT
     */
    const TYPE_TEXT = 1;
    /**
     * TYPE_TEXT_AREA
     */
    const TYPE_TEXT_AREA = 2;
    /**
     * TYPE_TINY_MCE
     */
    const TYPE_TINY_MCE = 3;
    /**
     * TYPE_IMAGE_INPUT
     */
    const TYPE_IMAGE_INPUT = 4;
    /**
     * TYPE_FILE_INPUT
     */
    const TYPE_FILE_INPUT = 5;
    /**
     * TYPE_FILE_INPUT
     */
    const TYPE_CHECK = 6;

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getReadonlyAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::READONLY_NOT => 'Not Readonly',
                static::READONLY => 'Readonly',
            ]
            : [
                static::READONLY_NOT,
                static::READONLY,
            ];
        return $return;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            ['key', 'filter', 'filter' => 'trim'],
            ['key', 'unique', 'message' => Yii::t('app', 'This key already exist')],
            [['value'], 'string'],
            [['readonly'], 'integer'],
            ['readonly', 'default', 'value' => static::READONLY_NOT],
            ['readonly', 'in', 'range' => static::getReadonlyAsArray(false)],
            ['type', 'default', 'value' => static::TYPE_TEXT],
            ['type', 'in', 'range' => [static::TYPE_TEXT, static::TYPE_TEXT_AREA, static::TYPE_TINY_MCE, static::TYPE_IMAGE_INPUT, static::TYPE_FILE_INPUT, static::TYPE_CHECK]],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'readonly' => Yii::t('app', 'Readonly'),
        ];
    }
}
