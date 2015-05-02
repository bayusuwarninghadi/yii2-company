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
use yii\base\Component;

/**
 * Class JneShipping
 * @package common\modules\jne
 */
class LocalizationGenerator extends Component
{

    /**
     * @var array
     */
    protected $localization = [];


    /**
     * @var \PHPExcel_Worksheet|bool
     */
    public $worksheet = false;

    /**
     * read JNE.xls
     * @return bool|\PHPExcel_Worksheet
     */
    public function read()
    {
        $excelReader = \PHPExcel_IOFactory::load(__DIR__ . '/assets/city.xls');
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
            $province = $this->worksheet->getCellByColumnAndRow(0, $row)->getValue();
            $city = $this->worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $cityArea = $this->worksheet->getCellByColumnAndRow(2, $row)->getValue();
            $this->localization[$province][$city] = $cityArea;
        }

        return $this->localization;
    }

    /**
     * deleteLocalization
     * @return bool
     */
    public function deleteLocalization()
    {
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
        foreach ($this->localization as $province => $_city) {
            /**
             * Check Province
             * if Model not exist then Create
             */
            $modelProvince = Province::findOne(['name' => $province]);
            if (!$modelProvince) {
                $modelProvince = new Province();
                $modelProvince->name = $province;
                $return['data'][$province]['result'] = $modelProvince->save() ? true : $modelProvince->errors;
                $return['count']['province']++;
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
                    $return['count']['city']++;
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
                        $return['count']['cityArea']++;
                    }
                }
            }
        }
        return $return;
    }
}