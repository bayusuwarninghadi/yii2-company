<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'backendSiteUrl' => 'http://justforyou.bayoz.xyz',
        'frontendSiteUrl' => 'http://company.bayoz.xyz',
        'formatter' => [
            'locale' => 'id-ID',
            'timeZone' => 'Asia/Jakarta',
            'dateFormat' => 'yyyy-MM-d',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'Rp ',
        ],
        'urlManager' => [
            // here is your normal backend url manager config
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'bundles' => [
                // refer to min asset
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapThemeAsset' => [
                    'css' => [
                        'css/bootstrap-theme.min.css'
                    ]
                ],
            ],
        ],
    ],
];
