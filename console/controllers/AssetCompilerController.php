<?php
namespace console\controllers;

use common\models\Product;
use common\models\ProductAttribute;
use common\modules\RemoveAssetHelper;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;


/**
 * Class AssetCompilerController
 * @package console\controllers
 */
class AssetCompilerController extends Controller
{
    /**
     *
     */
    public function actionIndex()
    {
        echo "\n---------------------------------------\n";
        echo "Asset Console Command\n";
        echo "$ ./yii asset-compiler/<action>";
        echo "\n---------------------------------------\n";
        echo "Available Action: \n";
        echo "1. remove-app-asset \n";
    }

    /**
     * Remove @app Asset Folder
     * ex : backend/web/assets/*
     */
    public function actionRemoveAppAsset()
    {
        $folder = array_merge(
            glob('backend/web/assets/*', GLOB_ONLYDIR),
            glob('frontend/web/assets/*', GLOB_ONLYDIR)
        );

        if (RemoveAssetHelper::removeDirectory($folder)) {
            echo "Remove Success \n";
        } else {
            echo "Remove Failed \n";
        }
    }

    public function actionRemoveInvalidProduct()
    {
        /**
         * Collect Directory for Product
         */
        $productExist = Product::find()->column();
        foreach ($productExist as &$id) {
            $id = 'frontend/web/images/product/' . $id;
        }
        $dirExist = glob('frontend/web/images/product/*', GLOB_ONLYDIR);
        $willRemove = array_diff($dirExist, $productExist);

        /**
         * Collect Directory for ProductAttribute
         */
        $productAttrExist = ArrayHelper::map(ProductAttribute::find()->all(), 'id', 'product_id');
        foreach ($productAttrExist as $key => &$attr) {
            $attr = 'frontend/web/images/product/' . $attr . '/' . $key;
        }

        $dirAttributeExist = [];
        foreach ($productExist as $productFolder) {
            $dirAttributeExist = array_merge($dirAttributeExist, glob($productFolder . '/*', GLOB_ONLYDIR));
        }
        $willRemove = array_merge($willRemove, array_diff($dirAttributeExist, $productAttrExist));

        if (RemoveAssetHelper::removeDirectory($willRemove)) {
            echo "Remove Success \n";
        } else {
            echo "Remove Failed \n";
        }
    }


}