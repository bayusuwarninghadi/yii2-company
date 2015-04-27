<?php
use backend\widget\Sidebar;

/* @var $this \yii\web\View */

?>
<div class="sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse collapse">
        <?= Sidebar::widget([
            'options' => [
                'id' => 'side-menu',
                'class' => '',
                'role' => 'navigation',
            ],
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => '<i class="fa fa-dashboard fa-fw"></i> Dashboard',
                    'url' => '/site/index'
                ],
                [
                    'label' => '<i class="fa fa-list fa-fw"></i> E-Commerce',
                    'items' => [
                        ['label' => '<i class="fa fa-shopping-cart fa-fw"></i> Transaction', 'url' => '/transaction/index'],
                        ['label' => '<i class="fa fa-list-ol fa-fw"></i> Manage Category', 'url' => ['/category/index']],
                        ['label' => '<i class="fa fa-list-alt fa-fw"></i> Manage Brand', 'url' => ['/brand/index']],
                        ['label' => '<i class="fa fa-th-large fa-fw"></i> Manage Product', 'url' => ['/product/index']],
                    ]
                ],
                [
                    'label' => '<i class="fa fa-table fa-fw"></i> Article',
                    'items' => [
                        ['label' => 'Manage Article', 'url' => ['/article/index']],
                        ['label' => 'Create New', 'url' => ['/article/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-edit fa-fw"></i> News',
                    'items' => [
                        ['label' => 'Manage News', 'url' => ['/news/index']],
                        ['label' => 'Create New', 'url' => ['/news/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-file fa-fw"></i> Manage Pages',
                    'items' => [
                        ['label' => 'Static Pages', 'url' => ['/pages/index']],
                        ['label' => 'Email Template', 'url' => ['/email-template/index']],
                        ['label' => 'Slider', 'url' => ['/slider/index']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-group fa-fw"></i> User',
                    'items' => [
                        ['label' => 'Manage User', 'url' => ['/user/index']],
                        ['label' => 'Create New', 'url' => ['/user/create']]
                    ]
                ],
            ]
        ]);
        ?>  
    </div>
</div>