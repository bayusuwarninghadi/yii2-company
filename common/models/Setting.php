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

    const READONLY = 1;
    const READONLY_NOT = 0;
    const TYPE_TEXT = 1;
    const TYPE_TEXT_AREA = 2;
    const TYPE_TINIMCE = 3;
    const TYPE_FILE_INPUT = 4;

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
            ['key', 'unique', 'message' => 'This key already exist.'],
            [['value'], 'string'],
            [['readonly'], 'integer'],
            ['readonly', 'default', 'value' => static::READONLY_NOT],
            ['readonly', 'in', 'range' => static::getReadonlyAsArray(false)],
            ['type', 'default', 'value' => static::TYPE_TEXT],
            ['type', 'in', 'range' => [static::TYPE_TEXT, static::TYPE_TEXT_AREA, static::TYPE_FILE_INPUT]],
            [['key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'readonly' => 'Readonly',
        ];
    }
}
