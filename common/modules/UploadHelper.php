<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 9/9/14
 * Time: 14:42
 */

namespace common\modules;

use Imagine\Imagick\Imagine;
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
     * @param bool $saveToFrontEnd
     * @return bool|string
     */
    public static function saveFile($file, $path = '', $saveToFrontEnd = true)
    {

        if (!$file) {
            return false;
        }

        // define path
        $app = $saveToFrontEnd ? 'frontend' : 'backend';
        $destination = \Yii::$app->getBasePath() . '/../' . $app . '/web/images/' . $path . '/';

        // check if path doesn't exist then create directory
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->saveAs($destination . $file->baseName . '.' . $file->extension);

        return $destination . $file->baseName . '.' . $file->extension;
    }

    /**
     * Save Image Helper
     *
     * @param $image
     * @param string $path
     * @param array $sizes
     * @param bool $saveToFrontEnd
     * @return bool|array
     */
    public static function saveImage($image, $path = '', $sizes = [], $saveToFrontEnd = true)
    {

        if (!$image) {
            return false;
        }

        // define path
        $app = $saveToFrontEnd ? 'frontend' : 'backend';
        $destination = \Yii::$app->getBasePath() . '/../' . $app . '/web/images/' . $path . '/';

        // check if path doesn't exist then create directory else remove all asset images
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        } else {
            array_map('unlink', glob($destination . '*', GLOB_BRACE));
        }

        $imagine = new Imagine();
        $imagine = $imagine->open($image->tempName);

        // create thumbnails
        if ($sizes) {
            $availableSizes = $sizes;
        } else {
            $availableSizes = [
                'large' => [
                    'width' => 1000,
                    'format' => 'jpeg'
                ],
                'medium' => [
                    'width' => 400,
                    'format' => 'jpeg'
                ],
                'small' => [
                    'width' => 50,
                    'format' => 'jpeg'
                ],
            ];
        }

        $return = [];

        foreach ($availableSizes as $size => $value) {
            $imagine->resize($imagine->getSize()->widen($value['width']))->save($destination . $size . '.' . $value['format'], ['format' => $value['format']]);
            $return[$size] = '/images/' . $path . '/' . $size . '.' . $value['format'];
        }
        return $return;
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
        $image_url = static::getImageUrl($path, $size, $not_found);
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

        $real_path = \Yii::$app->getBasePath() . '/../frontend/web/images/' . $path . '/';

        if (!file_exists($real_path)) {
            return $not_found ? \Yii::$app->components['frontendSiteUrl'] . '/images/320x150.gif' : false;
        }

        $_images = glob($real_path . '*{jpg,png,gif,jpeg}', GLOB_BRACE);

        $images = [];

        foreach ($_images as $image) {
            $path_info = pathinfo($image);
            $image_url = \Yii::$app->components['frontendSiteUrl'] . '/images/' . $path . '/' . $path_info['basename'];
            $images[$path_info['filename']] = $image_url;
        }

        $size = array_key_exists($size, $images) ? $size : 'medium';

        return isset($images[$size]) ? $images[$size] : ($not_found ? \Yii::$app->components['frontendSiteUrl'] . '/images/320x150.gif' : false);
    }
}