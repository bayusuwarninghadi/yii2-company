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
 * @property integer $readonly
 */
class Setting extends ActiveRecord
{

    const READONLY = 1;
    const READONLY_NOT = 0;

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
            [['value'], 'string'],
            [['readonly'], 'integer'],
            ['readonly', 'default', 'value' => static::READONLY_NOT],
            ['readonly', 'in', 'range' => static::getReadonlyAsArray(false)],
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
