<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/29/15
 * Time: 01:32
 */

namespace console\controllers;


use common\modules\jne\JneShipping;
use yii\console\Controller;

/**
 * Class JneController
 * @package console\controllers
 */
class JneController extends Controller
{

    /**
     * Creating Active Query JNE Shipping for Jakarta Only
     *
     * Run By
     * $ ./yii jne
     * with bool parameter
     * $ ./yii jne [$deleteCurrent] [$regenerateLocalization]
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
        $jne = new JneShipping();
        echo "Reading Excel File...\n";
        $jne->read();
        echo "Creating JNE Array...\n";
        $jne->createObject();
        echo "Start Adding Data...\n";
        if ($deleteCurrent) {
            echo "Delete Current Shipping Methods...\n";
            $jne->deleteAllShipping();
        }
        if ($regenerateLocalization) {
            echo "Delete Current Localization...\n";
            $jne->deleteLocalization();
            echo "\nCreate Localization Model (Province, City, CityArea), it will take a white...\n";
            $localization = $jne->generateLocalization();
            echo $localization['count']['province'] . " province created...\n";
            echo $localization['count']['city'] . " city created...\n";
            echo $localization['count']['cityArea'] . " cityArea created...\n";

        }
        echo "\nCreate Shipping Methods, it will take a white...\n";
        if ($count = $jne->generateShippingMethod()) {
            echo "$count Shipping Methods created...\n";
        }
    }
}