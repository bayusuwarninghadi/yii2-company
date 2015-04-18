<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 9/9/14
 * Time: 14:42
 */

namespace common\modules;

use Imagine\Imagick\Imagine;
use Yii;
use yii\helpers\BaseArrayHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * Class UploadHelper
 * @package common\helper
 */
class UploadHelper extends BaseArrayHelper
{

    /**
     * Save File
     *
     * @param UploadedFile $file
     * @param string $path
     * @return bool|string
     */
    public static function saveFIle($file, $path = '')
    {

        if (!$file) {
            return false;
        }
        
        // define path
        $path = 'upload/' . $path;

        // check if path doesn't exist then create directory
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file->saveAs($path . $file->baseName . '.' . $file->extension);

        return $path . $file->baseName . '.' . $file->extension;
    }

    /**
     * Save Image Helper
     *
     * @param $image
     * @param string $path
     * @return bool
     */
    public static function saveImage($image, $path = '')
    {

        if (!$image) {
            return false;
        }

        // define path
        $path = 'images/upload/' . $path . '/';

        // check if path doesn't exist then create directory else remove all asset images
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        } else {
            array_map('unlink', glob(Yii::$app->getBasePath() . '/../backend/web/' . $path . '*{jpg,png,gif,jpeg}', GLOB_BRACE));
        }


        $imagine = new Imagine();
        $imagine = $imagine->open($image->tempName);

        // keep original
        $imagine->save($path . '/original.' . $image->extension);

        // create thumbnails
        $imagine->resize($imagine->getSize()->widen(600))->save($path . '/large.' . $image->extension);
        $imagine->resize($imagine->getSize()->widen(400))->save($path . '/medium.' . $image->extension);
        $imagine->resize($imagine->getSize()->widen(128))->save($path . '/small.' . $image->extension);
        $imagine->resize($imagine->getSize()->widen(64))->save($path . '/icon.' . $image->extension);

        return true;
    }

    /**
     * Get Html Image
     *
     * @param $path
     * @param string $size
     * @param array $option
     * @param bool $not_found
     * @return bool|string Image url
     */
    public static function getHtml($path, $size = 'medium', $option = [], $not_found = false)
    {
        $image_url = self::getImageUrl($path, $size, $not_found);
        return ($image_url) ? Html::img($image_url, $option) : false;
    }

    /**
     * Get Image Url
     *
     * @param $path
     * @param string $size
     * @param bool $not_found
     * @return bool
     */
    public static function getImageUrl($path, $size = 'medium', $not_found = false)
    {

        $real_path = Yii::$app->getBasePath() . '/../backend/web/images/upload/' . $path . '/';

        if (!file_exists($real_path)) {
            return $not_found ? Yii::$app->components['backendSiteUrl'] . '/images/404.png' : false;
        }

        $_images = glob($real_path . '*{jpg,png,gif,jpeg}', GLOB_BRACE);

        $images = [];

        foreach ($_images as $image) {
            $path_info = pathinfo($image);
            $image_url = Yii::$app->components['backendSiteUrl'] . '/images/upload/' . $path . '/' . $path_info['basename'];
            $images[$path_info['filename']] = $image_url;
        }

        $size = array_key_exists($size,$images) ? $size : 'medium';

        return isset($images[$size]) ? $images[$size] : ($not_found ? Yii::$app->components['backendSiteUrl'] . '/images/404.png' : false);
    }

    /**
     * @param $path
     * @param string $size
     * @return bool
     */
    public static function getUrl($path, $size = 'medium')
    {
        return self::getImageUrl($path, $size);
    }
}