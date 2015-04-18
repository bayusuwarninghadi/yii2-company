<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\UserComment;
use common\models\UserCommentSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * UserCommentController implements the CRUD actions for UserComment model.
 */
class UserCommentController extends Controller
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
     * Lists all UserComment models.
     * @param string $key
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndex($key, $id)
    {
        $searchModel = new UserCommentSearch();
        $searchModel->table_key = $key;
        $searchModel->table_id = $id;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new UserComment();

        if ($model->load(Yii::$app->request->post())) {
            switch ($key){
                case UserComment::KEY_PRODUCT:
                    /**
                     * Calculate Rating
                     * @var Product $product
                     */
                    $product = Product::findOne($id);
                    $ratingArr = explode('/', $product->rating);
                    $product->rating = (intval($ratingArr[0]) + $model->rating) .'/'.(intval($ratingArr[1]) + 1);
                    $product->save();

                    $redirect = '/product/view';
                    break;
                case UserComment::KEY_ARTICLE:
                    $redirect = '/article/view';
                    break;
                case UserComment::KEY_NEWS:
                    $redirect = '/news/view';
                    break;
                default;
                    throw new ForbiddenHttpException('Unsupported key');
                    break;
            }
            $model->table_key = $key;
            $model->table_id = $id;
            $model->user_id = Yii::$app->user->getId();
            $model->save();
            return $this->redirect([$redirect, 'id' => $id]);
        }

        $params = [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        return Yii::$app->request->isAjax ? $this->renderPartial('index', $params) : $this->render('index', $params);
    }
}
