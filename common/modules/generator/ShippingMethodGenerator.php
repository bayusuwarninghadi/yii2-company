<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/29/15
 * Time: 11:43
 */

namespace common\modules\generator;


use common\models\City;
use common\models\CityArea;
use common\models\Province;
use common\models\ShippingMethod;
use common\models\ShippingMethodCost;
use yii\base\Component;

/**
 * Class JneShipping
 * @package common\modules\jne
 */
class ShippingMethodGenerator extends Component
{

    /**
     * @var array
     */
    protected $shippingCost = [];


    /**
     * @var \PHPExcel_Worksheet|bool
     */
    protected $worksheet = false;

    /**
     * read JNE.xls
     * @return bool|\PHPExcel_Worksheet
     */
    public function read()
    {
        $excelReader = \PHPExcel_IOFactory::load(__DIR__ . '/assets/shipping.xls');
        $this->worksheet = $excelReader->getActiveSheet();
        return $this->worksheet;
    }

    /**
     * Create array for shipping cost
     * @return bool|array
     */
    public function createObject()
    {
        if ($this->worksheet == false) {
            return false;
        }

        $availableMethod = [];
        for ($col = 3; $col <= 100; ++$col) {
            if ($value = $this->worksheet->getCellByColumnAndRow($col, 1)->getValue()) {
                $availableMethod[] = $value;
            }
        }

        for ($row = 3; $row <= $this->worksheet->getHighestRow(); ++$row) {
            $province = $this->worksheet->getCellByColumnAndRow(0, $row)->getValue();
            $city = $this->worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $cityArea = $this->worksheet->getCellByColumnAndRow(2, $row)->getValue();
            foreach ($availableMethod as $_row => $method) {
                $cost = $this->worksheet->getCellByColumnAndRow((($_row + 1) * 2) + 1, $row)->getValue();
                $estimate = $this->worksheet->getCellByColumnAndRow((($_row + 1) * 2) + 2, $row)->getValue();
                if (!empty($cost) && !empty($estimate)) {
                    $this->shippingCost[$province][$city][$cityArea][$method] = [
                        'cost' => $cost,
                        'estimate' => $estimate
                    ];
                }
            }
        }

        return $this->shippingCost;
    }

    /**
     * deleteAllShipping
     * @return int
     */
    public function deleteAllShipping()
    {
        ShippingMethodCost::deleteAll();
        ShippingMethod::deleteAll();
        return true;
    }

    /**
     * Generate Shipping Method Row
     * @return integer
     */
    public function generateShippingMethod()
    {
        $count = 0;
        $notFound = [];

        if (!$this->shippingCost) {
            $this->read();
            $this->createObject();
        }

        foreach ($this->shippingCost as $province => $_city) {
            /** @var $modelProvince Province */
            $modelProvince = Province::findOne(['name' => $province]);
            /* Continue if not exist */
            if (!$modelProvince) {
                $notFound[] = $province;
                continue;
            }
            foreach ($_city as $city => $_cityArea) {
                /** @var $modelCity City */
                $modelCity = City::findOne(['name' => $city, 'province_id' => $modelProvince->id]);
                /* Continue if not exist */
                if (!$modelCity) {
                    $notFound[] = $city;
                    continue;
                }
                foreach ($_cityArea as $cityArea => $_shippingMethod) {
                    /** @var $modelCityArea CityArea */
                    $modelCityArea = CityArea::findOne(['name' => $cityArea, 'city_id' => $modelCity->id]);
                    /* Continue if not exist */
                    if (!$modelCityArea) {
                        $notFound[] = $cityArea;
                        continue;
                    }

                    foreach ($_shippingMethod as $shippingMethod => $shippingMethodCost) {
                        $modelShippingMethod = ShippingMethod::findOne(['name' => $shippingMethod]);
                        if (!$modelShippingMethod) {
                            /**
                             * Create Shipping Method
                             */
                            $modelShippingMethod = new ShippingMethod();
                            $modelShippingMethod->name = $shippingMethod;
                            $modelShippingMethod->description = $shippingMethod;
                            $modelShippingMethod->save();
                        }

                        /**
                         * Create Shipping Method Cost
                         */
                        $modelShippingMethodCost = new ShippingMethodCost();
                        $modelShippingMethodCost->shipping_method_id = $modelShippingMethod->id;
                        $modelShippingMethodCost->city_area_id = $modelCityArea->id;
                        $modelShippingMethodCost->value = $shippingMethodCost['cost'];
                        $modelShippingMethodCost->estimate_time = $shippingMethodCost['estimate'];
                        if ($modelShippingMethodCost->save()) {
                            $count++;
                        } else {
                            print_r($modelShippingMethodCost->errors);
                            return false;
                        }
                    }
                }
            }
        }
        return $count;
    }
}