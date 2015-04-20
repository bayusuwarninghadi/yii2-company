<?php
namespace console\controllers;

use common\modules\RemoveAssetHelper;
use yii\console\Controller;
use Yii;


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

}