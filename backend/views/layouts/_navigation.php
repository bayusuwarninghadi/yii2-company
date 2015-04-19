<?php
use yii\bootstrap\Nav;
use backend\widget\NavBar;

/* @var $this \yii\web\View */

NavBar::begin([
    'brandLabel' => '<i class="fa fa-lock fa-fw text-danger"></i> Administrator</span>',
    'brandUrl' => Yii::$app->homeUrl,
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar-inverse navbar-static-top navbar',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'nav navbar-top-links navbar-right'],
    'items' => [
        [
            'label' => '<i class="fa fa-gear fa-fw"></i>',
            'url' => ['/setting/index']
        ],
        [
            'label' => '<i class="fa fa-envelope fa-fw"></i>',
            'url' => ['/inbox/index']
        ],
        [
            'label' => '<i class="fa fa-user fa-fw"></i>',
            'items' => [
                [
                    'label' => '<i class="fa fa-user fa-fw"></i> Profile',
                    'url' => ['/user/view', 'id' => Yii::$app->user->getId()],
                ],
                '<li class="divider"></li>',
                [
                    'label' => '<i class="fa fa-sign-out fa-fw"></i>  Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ]
            ]
        ]
    ],
    'encodeLabels' => false
]);

echo $this->render('_sidebar');
NavBar::end();