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
        $path = Yii::$app->getBasePath() . '/../frontend/web/files/' . $path . '/';

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
     * @return bool|array
     */
    public static function saveImage($image, $path = '')
    {

        if (!$image) {
            return false;
        }

        // define path
        $destination = Yii::$app->getBasePath() . '/../frontend/web/images/' . $path . '/';

        // check if path doesn't exist then create directory else remove all asset images
        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        } else {
            array_map('unlink', glob($destination . '*', GLOB_BRACE));
        }

        $imagine = new Imagine();
        $imagine = $imagine->open($image->tempName);

        // create thumbnails
        $sizes = [
            'large' => 600,
            'medium' => 400,
            'small' => 200,
        ];
        $return = [];
        foreach ($sizes as $size => $width) {
            $imagine->resize($imagine->getSize()->widen($width))->save($destination . $size . '.jpeg', ['format' => 'jpeg']);
            $return[$size] = '/images/' . $path . '/' . $size . '.jpeg';
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

        $real_path = Yii::$app->getBasePath() . '/../frontend/web/images/' . $path . '/';

        if (!file_exists($real_path)) {
            return $not_found ? Yii::$app->components['frontendSiteUrl'] . '/images/320x150.gif' : false;
        }

        $_images = glob($real_path . '*{jpg,png,gif,jpeg}', GLOB_BRACE);

        $images = [];

        foreach ($_images as $image) {
            $path_info = pathinfo($image);
            $image_url = Yii::$app->components['frontendSiteUrl'] . '/images/' . $path . '/' . $path_info['basename'];
            $images[$path_info['filename']] = $image_url;
        }

        $size = array_key_exists($size, $images) ? $size : 'medium';

        return isset($images[$size]) ? $images[$size] : ($not_found ? Yii::$app->components['frontendSiteUrl'] . '/images/320x150.gif' : false);
    }
}