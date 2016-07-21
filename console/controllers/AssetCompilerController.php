<?php
namespace console\controllers;

use common\models\PageAttribute;
use common\models\Pages;
use common\modules\RemoveAssetHelper;
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

    public function actionRemoveInvalidPages()
    {
        /**
         * Collect Directory for Product
         */
        $page_exist = Pages::find()->column();
        foreach ($page_exist as &$id) {
            $id = 'frontend/web/images/page/' . $id;
        }
        $dirExist = glob('frontend/web/images/product/*', GLOB_ONLYDIR);
        $willRemove = array_diff($dirExist, $page_exist);

        /**
         * Collect Directory for ProductAttribute
         */
        $page_attr_exist = ArrayHelper::map(PageAttribute::find()->all(), 'id', 'page_id');
        foreach ($page_attr_exist as $key => &$attr) {
            $attr = 'frontend/web/images/page/' . $attr . '/' . $key;
        }

        $dirAttributeExist = [];
        foreach ($page_exist as $page_folder) {
            $dirAttributeExist = array_merge($dirAttributeExist, glob($page_folder . '/*', GLOB_ONLYDIR));
        }
        $willRemove = array_merge($willRemove, array_diff($dirAttributeExist, $page_attr_exist));

        if (RemoveAssetHelper::removeDirectory($willRemove)) {
            echo "Remove Success \n";
        } else {
            echo "Remove Failed \n";
        }
    }


}