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
class JneShipping extends Component{

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
    public function read(){
        echo "Reading File...\n";
        $excelReader = \PHPExcel_IOFactory::load(__DIR__ . '/./JNE.xls');
        $this->worksheet = $excelReader->getActiveSheet();
        return $this->worksheet;
    }

    /**
     * Create array for jne cost
     * @return bool|array
     */
    public function createObject(){
        if ($this->worksheet == false){
            return false;
        }
        $highestRow = $this->worksheet->getHighestRow();
        for ($row = 3; $row <= $highestRow; ++$row) {
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
     * Generate Row
     * @return integer
     */
    public function generate(){
        $count = 0;
        foreach ($this->jneCost as $province => $_city) {
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
        return $count;
    }
}