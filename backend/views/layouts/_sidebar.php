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
                ['label' => '<i class="fa fa-dashboard fa-fw"></i> ' . \Yii::t('app', 'Dashboard'), 'url' => '/site/index'],
	            [
		            'label' => '<i class="fa fa-pagelines fa-fw"></i> ' . \Yii::t('app', 'Index Pages'),
		            'items' => [
			            ['label' => '<i class="fa fa-picture-o fa-fw"></i> ' . \Yii::t('app', 'Slider'), 'url' => ['/slider/index']],
			            ['label' => '<i class="fa fa-hacker-news fa-fw"></i> ' . \Yii::t('app', 'Pills'), 'url' => ['/pill/index']],
		            ]
	            ],
//	            [
//                    'label' => '<i class="fa fa-list fa-fw"></i> ' . \Yii::t('app', 'Content'),
//                    'items' => [
//                        ['label' => '<i class="fa fa-list-ol fa-fw"></i> ' . \Yii::t('app', 'Manage Category'), 'url' => ['/category/index']],
//                        ['label' => '<i class="fa fa-th-large fa-fw"></i> ' . \Yii::t('app', 'Manage Content'), 'url' => ['/content/index']],
//                    ]
//                ],
                [
                    'label' => '<i class="fa fa-handshake-o fa-fw"></i> ' . \Yii::t('app', 'Partner'),
                    'items' => [
                        ['label' => '<i class="fa fa-table fa-fw"></i> ' . \Yii::t('app', 'Manage Partner'), 'url' => ['/partner/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> ' . \Yii::t('app', 'Create Partner'), 'url' => ['/partner/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-table fa-fw"></i> ' . \Yii::t('app', 'Article'),
                    'items' => [
                        ['label' => '<i class="fa fa-table fa-fw"></i> ' . \Yii::t('app', 'Manage Article'), 'url' => ['/article/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> ' . \Yii::t('app', 'Create New'), 'url' => ['/article/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-newspaper-o fa-fw"></i> ' . \Yii::t('app', 'News'),
                    'items' => [
                        ['label' => '<i class="fa fa-edit fa-fw"></i> ' . \Yii::t('app', 'Manage News'), 'url' => ['/news/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> ' . \Yii::t('app', 'Create New'), 'url' => ['/news/create']]
                    ]
                ],
                [
                    'label' => '<i class="fa fa-file fa-fw"></i> ' . \Yii::t('app', 'Manage Pages'),
                    'items' => [
                        ['label' => '<i class="fa fa-file-archive-o fa-fw"></i> ' . \Yii::t('app', 'Static Pages'), 'url' => ['/pages/index']],
                        ['label' => '<i class="fa fa-envelope-o fa-fw"></i> ' . \Yii::t('app', 'Email Template'), 'url' => ['/email-template/index']],
                    ]
                ],
                [
                    'label' => '<i class="fa fa-group fa-fw"></i> ' . \Yii::t('app', 'User'),
                    'items' => [
                        ['label' => '<i class="fa fa-user-md fa-fw"></i> ' . \Yii::t('app', 'Manage User'), 'url' => ['/user/index']],
                        ['label' => '<i class="fa fa-comments fa-fw"></i> ' . \Yii::t('app', 'User Comment'), 'url' => ['/user-comment/index']],
                        ['label' => '<i class="fa fa-plus fa-fw"></i> ' . \Yii::t('app', 'Create New'), 'url' => ['/user/create']]
                    ]
                ],
            ]
        ]);
        ?>
    </div>
</div>