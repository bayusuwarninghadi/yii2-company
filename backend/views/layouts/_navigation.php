<?php
use yii\bootstrap\Nav;
use backend\widget\NavBar;
use common\models\User;

/* @var $this \yii\web\View */

NavBar::begin([
    'brandLabel' => '<i class="fa fa-lock fa-fw text-info"></i><span class="text-danger"> Administrator</span>',
    'brandUrl' => Yii::$app->homeUrl,
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar-default navbar-static-top navbar',
    ],
]);
switch (Yii::$app->user->identity->role) {
    case intval(User::ROLE_SUPER_ADMIN):
        $items = [
            [
                'label' => '<i class="fa fa-gear fa-fw"></i>',
                'url' => ['/setting/index']
            ],
            [
                'label' => '<i class="fa fa-user fa-fw"></i>',
                'items' => [
                    [
                        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ]
        ];
        break;
    case intval(User::ROLE_ADMIN):
        $items = [
            [
                'label' => '<i class="fa fa-gear fa-fw"></i>',
                'url' => ['/setting/index']
            ],
            [
                'label' => '<i class="fa fa-envelope fa-fw"></i>',
                'items' => [
                    '<li class="divider"></li>',
                    [
                        'label' => 'See All Inbox',
                        'url' => ['/inbox/index']
                    ]
                ]
            ],
            [
                'label' => '<i class="fa fa-user fa-fw"></i>',
                'items' => [
                    [
                        'label' => Yii::$app->user->identity->username,
                        'url' => ['/user/view?id='.Yii::$app->user->getId()],
                    ],
                    '<li class="divider"></li>',    
                    [
                        'label' => 'Logout',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ]
        ];
        break;
    default:
        $items = [];
        break;
}
echo Nav::widget([
    'options' => ['class' => 'nav navbar-top-links navbar-right'],
    'items' => $items,
    'encodeLabels' => false
]);

echo $this->render('_sidebar');
NavBar::end();
?>