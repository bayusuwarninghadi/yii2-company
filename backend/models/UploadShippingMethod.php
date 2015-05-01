<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/15
 * Time: 20:14
 */

namespace backend\models;


use Yii;
use yii\base\Model;

class UploadShippingMethod extends Model
{

    public $excel;
    public $replace = false;

    public function rules()
    {
        return [
            [
                'replace',
                'file',
                'extensions' => 'xls',
                'mimeTypes' => 'application/vnd.ms-excel',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
        ];
    }

    public function import(){

    }

    public function attributeLabels()
    {
        return [
            'excel' => Yii::t('app', 'Excel file'),
            'replace' => Yii::t('app', 'Replace Old File'),
        ];
    }
}