<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 9/13/14
 * Time: 23:52
 */

namespace common\assets;

use yii\web\AssetBundle;
class FontAwesomeAsset extends AssetBundle{
    public $sourcePath = '@vendor/fortawesome/font-awesome';
    public $css = [
        'css/font-awesome.min.css',
    ];

    public static function listFont(){
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        $subject = file_get_contents(dirname(dirname(__DIR__)).'/vendor/fortawesome/font-awesome/css/font-awesome.css');

        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

        $icons = [];

        foreach($matches as $match){
            $icons[] = $match[1];
        }

        return $icons;
    }
} 