<?php
use backend\widget\Sidebar;
use common\models\User;
/* @var $this \yii\web\View */
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse collapse">
        <?php
        switch (Yii::$app->user->identity->role) {
            case intval(User::ROLE_SUPER_ADMIN):
                $items = [
                    [
                        'label' => '<i class="fa fa-dashboard fa-fw"></i> Dashboard', 
                        'url' => '/site/index'
                    ],
                    [
                        'label' => '<i class="fa fa-table fa-fw"></i> Article',
                        'items' => [
                            ['label' => 'Manage Article', 'url' => ['/article']],
                            ['label' => 'Create New', 'url' => ['/article/create']]
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-edit fa-fw"></i> News',
                        'items' => [
                            ['label' => 'Manage News', 'url' => ['/news']],
                            ['label' => 'Create New', 'url' => ['/news/create']]
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-group fa-fw"></i> User',
                        'items' => [
                            ['label' => 'Manage User', 'url' => ['/user']],
                            ['label' => 'Create New', 'url' => ['/user/create']]
                        ]
                    ],
                ];
                break;
            case intval(User::ROLE_ADMIN):
                $items = [
                    [
                        'label' => '<i class="fa fa-dashboard fa-fw"></i> Dashboard', 
                        'url' => '/site/index'
                    ],
                    [
                        'label' => '<i class="fa fa-table fa-fw"></i> Article',
                        'items' => [
                            ['label' => 'Manage Article', 'url' => ['/article']],
                            ['label' => 'Create New', 'url' => ['/article/create']]
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-edit fa-fw"></i> News',
                        'items' => [
                            ['label' => 'Manage News', 'url' => ['/news']],
                            ['label' => 'Create New', 'url' => ['/news/create']]
                        ]
                    ],
                    [
                        'label' => '<i class="fa fa-group fa-fw"></i> User',
                        'items' => [
                            ['label' => 'Manage User', 'url' => ['/user']],
                            ['label' => 'Create New', 'url' => ['/user/create']]
                        ]
                    ],
                ];
                break;
            default:
                $items = [];
                break;
        }
        echo Sidebar::widget([
            'options' => [
                'id' => 'side-menu',
                'class' => '',
                'role' => 'navigation',
            ],
            'encodeLabels' => false,
            'items' => $items
        ]);
        ?>  
    </div>
</div>