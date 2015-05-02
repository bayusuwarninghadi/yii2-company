<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 5/1/15
 * Time: 20:14
 */

namespace backend\models;


use common\modules\generator\ShippingMethodGenerator;
use Yii;
use yii\base\Model;

/**
 * Class UploadShippingMethod
 * @package backend\models
 */
class UploadShippingMethod extends Model
{

    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $excel;
    /**
     * @var bool
     */
    public $replace = false;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique', 'class' => 'common/models/ShippingMethod'],
            [
                'excel',
                'file',
                'extensions' => 'xls',
                'mimeTypes' => 'application/vnd.ms-excel',
                'maxSize' => 1024 * 1024 * Yii::$app->params['maxFileUploadSize'],
                'tooBig' => Yii::t('app', 'The file "{file}" is too big. Its size cannot exceed') . ' ' . Yii::$app->params['maxFileUploadSize'] . ' Mb'
            ],
        ];
    }

    /**
     * @return int
     */
    public function import()
    {
        $shipping = new ShippingMethodGenerator();
        if ($this->replace) {
            $shipping->deleteAllShipping();
        }
        return $shipping->generateShippingMethod();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'excel' => Yii::t('app', 'Excel file'),
            'replace' => Yii::t('app', 'Replace Old Shipping Method'),
        ];
    }
}