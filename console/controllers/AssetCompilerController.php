<?php
namespace console\controllers;

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

        if ($this->removeDirectoryRecursive($folder)) {
            echo "Remove Success \n";
        } else {
            echo "Remove Failed \n";
        }
    }

    /**
     * Remove Recursively Directory
     * @param string|array $folder
     * @return bool
     */
    protected function removeDirectoryRecursive($folder)
    {
        $folder = is_array($folder) ? $folder : [$folder];

        foreach ($folder as $f) {
            if (is_dir($f)) {
                $_folder = glob($f . '/*', GLOB_BRACE);
                $this->removeDirectoryRecursive($_folder);
                rmdir($f);
            } else {
                unlink($f);
            }
        }
        return true;
    }

}