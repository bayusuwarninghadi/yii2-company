<?php

namespace frontend\controllers;

use common\models\Pages;
use common\models\PagesSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Pages model.
 */
class PartnerController extends BaseController
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Pages models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PagesSearch();
		$searchModel->type_id = Pages::TYPE_PARTNER;
		$dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
		$dataProvider->setSort(['defaultOrder' => ['order'=>SORT_DESC]]);

		$header = Pages::findOne(['type_id' => Pages::TYPE_PAGES, 'camel_case' => 'PartnerHeader']);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'header' => $header,
		]);
	}

	/**
	 * Displays a single Pages model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	public function actionRelated($id)
	{
		$model = $this->findModel($id);
		return $this->renderPartial('_related', [
			'models' => $model->getRelated()
		]);
	}

	/**
	 * Finds the Pages model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Pages the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Pages::findOne(['id' => $id, 'type_id' => Pages::TYPE_PARTNER])) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
