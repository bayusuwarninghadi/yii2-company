<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/29/15
 * Time: 01:32
 */

namespace console\controllers;


use common\modules\generator\LocalizationGenerator;
use common\modules\generator\ShippingMethodGenerator;
use yii\console\Controller;

/**
 * Class JneController
 * @package console\controllers
 */
class ShippingController extends Controller
{

    /**
     * Creating Active Query JNE Shipping for Jakarta Only
     *
     * Run By
     * $ ./yii shipping
     * with bool parameter
     * $ ./yii shipping [$deleteCurrent] [$regenerateLocalization]
     *
     * $ ./yii jne
     * 1. Create Province
     * 2. Create City
     * 3. Create City Area
     * 4. Create Shipping Method: [JNE Reguler,JNE OKE,JNE YES]
     * 5. Create Shipping Method Cost Per City Area
     *
     * @param bool $deleteCurrent
     * @param bool $regenerateLocalization
     * @return string|array|mixed
     */
    public function actionIndex($deleteCurrent = true, $regenerateLocalization = false)
    {
        $shipping = new ShippingMethodGenerator();
        echo "Reading excel file...";
        $worksheet = $shipping->read();
        echo " done\n";
        echo "Creating JNE Array...";
        $shipping->createObject();
        echo " done\n";

        echo "Start Adding Data...\n";
        if ($deleteCurrent) {
            echo "Delete current shipping methods... ";
            $shipping->deleteAllShipping();
            echo " done\n";
        }
        if ($regenerateLocalization) {
            $localization = New LocalizationGenerator();
            $localization->worksheet = $worksheet;
            echo "Delete current localization... ";
            $localization->deleteLocalization();
            echo " done\n";
            echo "\nCreate localization model (Province, City, CityArea), it will take a white...\n";
            $count = $localization->generateLocalization();
            echo $count['count']['province'] . " province created...\n";
            echo $count['count']['city'] . " city created...\n";
            echo $count['count']['cityArea'] . " cityArea created...\n";

        }
        echo "\nCreate shipping methods, it will take a white...\n";
        if ($count = $shipping->generateShippingMethod()) {
            echo "$count shipping methods created...\n";
        }
    }
}