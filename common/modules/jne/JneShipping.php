<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/29/15
 * Time: 11:43
 */

namespace common\modules\jne;


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
class JneShipping extends Component
{

    /**
     * @var array
     */
    protected $jneCost = [];


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
        $excelReader = \PHPExcel_IOFactory::load(__DIR__ . '/./JNE.xls');
        $this->worksheet = $excelReader->getActiveSheet();
        return $this->worksheet;
    }

    /**
     * Create array for jne cost
     * @return bool|array
     */
    public function createObject()
    {
        if ($this->worksheet == false) {
            return false;
        }
        for ($row = 3; $row <= $this->worksheet->getHighestRow(); ++$row) {
            $_row = [
                'province' => $this->worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                'city' => $this->worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                'city_area' => $this->worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                'regular_cost' => $this->worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                'regular_estimate' => $this->worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                'oke_cost' => $this->worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                'oke_estimate' => $this->worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                'yes_cost' => $this->worksheet->getCellByColumnAndRow(7, $row)->getValue(),
            ];

            if (isset($_row['regular_cost'])) {
                $this->jneCost[$_row['province']][$_row['city']][$_row['city_area']]['JNE Reguler'] = [
                    'cost' => $_row['regular_cost'],
                    'estimate' => $_row['regular_estimate']
                ];
            }
            if (isset($_row['oke_cost'])) {
                $this->jneCost[$_row['province']][$_row['city']][$_row['city_area']]['JNE OKE'] = [
                    'cost' => $_row['oke_cost'],
                    'estimate' => $_row['oke_estimate']
                ];
            }
            if (isset($_row['yes_cost'])) {
                $this->jneCost[$_row['province']][$_row['city']][$_row['city_area']]['JNE YES'] = [
                    'cost' => $_row['yes_cost'],
                    'estimate' => '1'
                ];
            }
        }

        return $this->jneCost;
    }

    /**
     * deleteAllShipping
     * @return int
     */
    public function deleteAllShipping(){
        return ShippingMethodCost::deleteAll();
    }

    /**
     * deleteLocalization
     * @return bool
     */
    public function deleteLocalization(){
        CityArea::deleteAll();
        City::deleteAll();
        Province::deleteAll();
        return true;
    }

    /**
     * Generate Localization: Province, City, CityArea
     * @return array|mixed
     */
    public function generateLocalization()
    {
        $return = [
            'data' => [],
            'count' => [
                'province' => 0,
                'city' => 0,
                'cityArea' => 0,
            ],
        ];
        foreach ($this->jneCost as $province => $_city) {
            /**
             * Check Province
             * if Model not exist then Create
             */
            $modelProvince = Province::findOne(['name' => $province]);
            if (!$modelProvince) {
                $modelProvince = new Province();
                $modelProvince->name = $province;
                $return['data'][$province]['result'] = $modelProvince->save() ? true : $modelProvince->errors;
                $return['count']['province'] ++;
            }
            foreach ($_city as $city => $_cityArea) {
                /**
                 * Check City
                 * if Model not exist then Create
                 */
                $modelCity = City::findOne(['name' => $province, 'province_id' => $modelProvince->id]);
                if (!$modelCity) {
                    $modelCity = new City();
                    $modelCity->name = $city;
                    $modelCity->province_id = $modelProvince->id;
                    $return['data'][$province]['city'][$city]['result'] = $modelCity->save() ? true : $modelCity->errors;
                    $return['count']['city'] ++;
                }
                foreach ($_cityArea as $cityArea => $_shippingMethod) {
                    /**
                     * Check City Area
                     * if Model not exist then Create
                     */
                    $modelCityArea = CityArea::findOne(['name' => $cityArea, 'city_id' => $modelCity->id]);
                    if (!$modelCityArea) {
                        $modelCityArea = new CityArea();
                        $modelCityArea->name = $cityArea;
                        $modelCityArea->city_id = $modelCity->id;
                        $return['data'][$province]['city'][$city]['cityArea'][$cityArea]['result'] = $modelCityArea->save() ? true : $modelCityArea->errors;
                        $return['count']['cityArea'] ++;
                    }
                }
            }
        }
        return $return;
    }

    /**
     * Generate Shipping Method Row
     * @return integer
     */
    public function generateShippingMethod()
    {
        $count = 0;
        $notFound = [];
        foreach ($this->jneCost as $province => $_city) {
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