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
                ['label' => '<i class="fa fa-dashboard fa-fw"></i> Dashboard', 'url' => '/site/index'],
                ['label' => '<i class="fa fa-shopping-cart fa-fw"></i> Transaction', 'url' => '/transaction/index'],
                [
                    'label' => '<i class="fa fa-list fa-fw"></i> Product',
                    'items' => [
                        ['label' => '<i class="fa fa-list-ol fa-fw"></i> Manage Category', 'url' => ['/category/index']],
                        ['label' => '<i class="fa fa-list-alt fa-fw"></i> Manage Brand', 'url' => ['/brand/index']],
                        ['label' => '<i class="fa fa-th-large fa-fw"></i> Manage Product', 'url' => ['/product/index']],
                    ]
                ],
                [
                    'label' => '<i class="fa fa-table fa-fw"></i> Article',
                    'items' => [
                        ['label' => '<i class="fa fa-table fa-fw"></i>  Manage Article', 'url' => ['/article/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> Create New', 'url' => ['/article/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-edit fa-fw"></i> News',
                    'items' => [
                        ['label' => '<i class="fa fa-edit fa-fw"></i> Manage News', 'url' => ['/news/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> Create New', 'url' => ['/news/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-file fa-fw"></i> Manage Pages',
                    'items' => [
                        ['label' => '<i class="fa fa-file-archive-o fa-fw"></i> Static Pages', 'url' => ['/pages/index']],
                        ['label' => '<i class="fa fa-envelope-o fa-fw"></i> Email Template', 'url' => ['/email-template/index']],
                        ['label' => '<i class="fa fa-picture-o fa-fw"></i> Slider', 'url' => ['/slider/index']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-group fa-fw"></i> User',
                    'items' => [
                        ['label' => '<i class="fa fa-user-md fa-fw"></i> Manage User', 'url' => ['/user/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> Create New', 'url' => ['/user/create']]
                    ]
                ],
            ]
        ]);
        ?>  
    </div>
</div>