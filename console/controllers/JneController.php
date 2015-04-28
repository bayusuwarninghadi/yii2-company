<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/29/15
 * Time: 01:32
 */

namespace console\controllers;


use common\models\City;
use common\models\CityArea;
use common\models\Province;
use common\models\ShippingMethod;
use common\models\ShippingMethodCost;
use yii\console\Controller;

/**
 * Class JneController
 * @package console\controllers
 */
class JneController extends Controller
{

    /**
     * Creating Active Query JNE Shipping for Jakarta Only
     * Run By
     * $ ./yii jne
     *
     * 1. Create Province
     * 2. Create City
     * 3. Create City Area
     * 4. Create Shipping Method: [JNE Reguler,JNE OKE,JNE YES]
     * 5. Create Shipping Method Cost Per City Area
     *
     */
    public function actionIndex()
    {
        echo "Reading File...\n";
        $excelReader = \PHPExcel_IOFactory::load(__DIR__ . '/./JNE.xls');
        $objWorksheet = $excelReader->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10

        $jneCost = [];
        echo "Creating Object...\n";
        for ($row = 5; $row <= $highestRow; ++$row) {
            $_row = [
                'province' => $objWorksheet->getCellByColumnAndRow(2, $row)->getValue(),
                'city' => $objWorksheet->getCellByColumnAndRow(3, $row)->getValue(),
                'city_area' => $objWorksheet->getCellByColumnAndRow(4, $row)->getValue(),
                'regular_cost' => $objWorksheet->getCellByColumnAndRow(6, $row)->getValue(),
                'regular_estimate' => $objWorksheet->getCellByColumnAndRow(7, $row)->getValue(),
                'oke_cost' => $objWorksheet->getCellByColumnAndRow(8, $row)->getValue(),
                'oke_estimate' => $objWorksheet->getCellByColumnAndRow(9, $row)->getValue(),
                'yes_cost' => $objWorksheet->getCellByColumnAndRow(10, $row)->getValue(),
            ];

            if (isset($_row['regular_cost'])) {
                $jneCost[$_row['province']][$_row['city']][$_row['city_area']]['JNE Reguler'] = [
                    'cost' => $_row['regular_cost'],
                    'estimate' => $_row['regular_estimate']
                ];
            }
            if (isset($_row['oke_cost'])) {
                $jneCost[$_row['province']][$_row['city']][$_row['city_area']]['JNE OKE'] = [
                    'cost' => $_row['oke_cost'],
                    'estimate' => $_row['oke_estimate']
                ];
            }
            if (isset($_row['yes_cost'])) {
                $jneCost[$_row['province']][$_row['city']][$_row['city_area']]['JNE YES'] = [
                    'cost' => $_row['yes_cost'],
                    'estimate' => '1'
                ];
            }
        }

        echo "Creating Active Query, it will take a few moments...\n";
        $count = 0;
        foreach ($jneCost as $province => $_city) {
            $modelProvince = new Province();
            $modelProvince->name = $province;
            $modelProvince->save();
            foreach ($_city as $city => $_city_area) {
                $modelCity = new City();
                $modelCity->name = $city;
                $modelCity->province_id = $modelProvince->id;
                $modelCity->save();
                foreach ($_city_area as $city_area => $_shippingMethod) {
                    $modelCityArea = new CityArea();
                    $modelCityArea->name = $city_area;
                    $modelCityArea->city_id = $modelCity->id;
                    $modelCityArea->save();
                    foreach ($_shippingMethod as $shippingMethod => $shippingMethodCost) {
                        $modelShippingMethod = ShippingMethod::findOne(['name' => $shippingMethod]);
                        if (!$modelShippingMethod) {
                            $modelShippingMethod = new ShippingMethod();
                            $modelShippingMethod->name = $shippingMethod;
                            $modelShippingMethod->description = $shippingMethod;
                            $modelShippingMethod->save();
                        }

                        $modelShippingMethodCost = new ShippingMethodCost();
                        $modelShippingMethodCost->shipping_method_id = $modelShippingMethod->id;
                        $modelShippingMethodCost->city_area_id = $modelCityArea->id;
                        $modelShippingMethodCost->value = $shippingMethodCost['cost'];
                        $modelShippingMethodCost->estimate_time = $shippingMethodCost['estimate'];
                        $modelShippingMethodCost->save();
                        $count ++;
                    }
                }
            }
        }
        echo "$count row(s) affected\n";
        echo "Success...\n";
    }
}