<?php

use backend\widget\Sidebar;

/* @var $this Yii\web\View */

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
				['label' => '<i class="fa fa-dashboard fa-fw"></i> ' . Yii::t('app', 'Dashboard'), 'url' => '/site/index'],
				[
					'label' => '<i class="fa fa-pagelines fa-fw"></i> ' . Yii::t('app', 'Index Pages'),
					'items' => [
						['label' => '<i class="fa fa-picture-o fa-fw"></i> ' . Yii::t('app', 'Slider'), 'url' => ['/slider/index']],
						['label' => '<i class="fa fa-hacker-news fa-fw"></i> ' . Yii::t('app', 'Pills'), 'url' => ['/pill/index']],
					]
				],
				[
					'label' => '<i class="fa fa-table fa-fw"></i> ' . Yii::t('app', 'Product'),
					'items' => [
						['label' => '<i class="fa fa-list fa-fw"></i> ' . Yii::t('app', 'Manage Brand'), 'url' => ['/brand/index']],
						['label' => '<i class="fa fa-table fa-fw"></i> ' . Yii::t('app', 'Manage Product'), 'url' => ['/product/index']],
					]
				],
				[
					'label' => '<i class="fa fa-handshake-o fa-fw"></i> ' . Yii::t('app', 'Partner'),
					'url' => ['/partner/index']
				],
				[
					'label' => '<i class="fa fa-newspaper-o fa-fw"></i> ' . Yii::t('app', 'News'),
					'url' => ['/news/index']

				],
				[
					'label' => '<i class="fa fa-file fa-fw"></i> ' . Yii::t('app', 'Manage Pages'),
					'items' => [
						['label' => '<i class="fa fa-file-archive-o fa-fw"></i> ' . Yii::t('app', 'Static Pages'), 'url' => ['/pages/index']],
						['label' => '<i class="fa fa-envelope-o fa-fw"></i> ' . Yii::t('app', 'Email Template'), 'url' => ['/email-template/index']],
					]
				],
				[
					'label' => '<i class="fa fa-group fa-fw"></i> ' . Yii::t('app', 'User'),
					'items' => [
						['label' => '<i class="fa fa-user-md fa-fw"></i> ' . Yii::t('app', 'Manage User'), 'url' => ['/user/index']],
						['label' => '<i class="fa fa-comments fa-fw"></i> ' . Yii::t('app', 'User Comment'), 'url' => ['/user-comment/index']],
						['label' => '<i class="fa fa-inbox fa-fw"></i> ' . Yii::t('app', 'Inbox'), 'url' => ['/inbox/index']],
						['label' => '<i class="fa fa-plus fa-fw"></i> ' . Yii::t('app', 'Create New'), 'url' => ['/user/create']]
					]
				],
			]
		]);
		?>
    </div>
</div>