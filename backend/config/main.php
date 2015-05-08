<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'tiny-mce' => [
            'options' => [
                'class' => 'form-control tinymce',
                'readonly' => 'readonly',
            ],
            'configs' => [
                'height' => 300,
                'plugins' => 'link fullscreen image pagebreak paste',
                'extended_valid_elements' => 'iframe[src|frameborder|style|scrolling|class|width|height|name|align]',
                'paste_as_text' => true,
                'toolbar' => "fullscreen | undo redo | styleselect | bold italic |  alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | image | pagebreak",
                'menu' => []
            ]
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
