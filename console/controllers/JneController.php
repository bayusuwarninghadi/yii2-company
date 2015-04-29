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
        $jne = new JneShipping();
        $jne->generate();
    }
}