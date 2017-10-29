<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 9/9/14
 * Time: 14:42
 */

namespace common\modules;

use yii\db\Exception;
use yii\helpers\BaseArrayHelper;

/**
 * Class UploadHelper
 * @package common\helper
 */
class RemoveAssetHelper extends BaseArrayHelper
{
    /**
     * Remove Recursively
     * @param string|array $folder
     * @return bool
     */
    public static function removeDirectory($folder)
    {
        return static::removeDirectoryRecursive($folder);
    }

    protected static function removeDirectoryRecursive($folder)
    {
        $folder = is_array($folder) ? $folder : [$folder];

        foreach ($folder as $f) {
            if (is_dir($f)) {
                $_folder = glob($f . '/*', GLOB_BRACE);
                static::removeDirectoryRecursive($_folder);
                rmdir($f);
            } else {
            	try{
            		if (file_exists($f)){
		                unlink($f);
		            }
	            } catch (Exception $e){

	            }
            }
        }
        return true;
    }


}