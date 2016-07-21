<?php
use backend\widget\NavBar;
use yii\bootstrap\Nav;

/* @var $this \yii\web\View */

NavBar::begin([
    'brandLabel' => '<i class="fa fa-lock fa-fw text-danger"></i> Administrator</span>',
    'brandUrl' => \Yii::$app->homeUrl,
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar-inverse navbar-static-top navbar',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'nav navbar-top-links navbar-right'],
    'items' => [
        [
            'label' => '<i class="fa fa-globe fa-fw"></i>',
            'url' => \Yii::$app->components['frontendSiteUrl'],
            'linkOptions' => [
                'target' => '_blank'
            ],
        ],
        [
            'label' => '<i class="fa fa-gears fa-fw"></i>',
            'url' => ['/setting/index']
        ],
        [
            'label' => '<i class="fa fa-user fa-fw"></i>',
            'items' => [
                ['label' => '<i class="fa fa-user fa-fw"></i> '.\Yii::t('app','Profile'), 'url' => ['/user/view', 'id' => \Yii::$app->user->getId()]],
                '<li class="divider"></li>',
                [
                    'label' => '<i class="fa fa-sign-out fa-fw"></i> '.\Yii::t('app','Logout'),
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