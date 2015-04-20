<?php

namespace frontend\controllers;

use common\models\Shipping;
use common\modules\UploadHelper;
use Yii;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel(Yii::$app->user->getId());

        if ($model->load(Yii::$app->request->post())) {
            if ($image = UploadedFile::getInstance($model, 'image')){
                UploadHelper::saveImage($image, 'user/' . $model->id,[
                    'small' => [
                        'width' => 200,
                        'format' => 'jpeg'
                    ],
                ]);
            }
            $model->save();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Create Shipping.
     * @return mixed
     */
    public function actionCreateShipping()
    {
        $model = new Shipping();
        $model->user_id = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }
        return $this->render('create-shipping', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteShipping($id)
    {
        $this->findShippingModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Update Shipping.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateShipping($id)
    {
        $model = $this->findShippingModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }
        return $this->render('create-shipping', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Shipping model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shipping the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findShippingModel($id)
    {
        if (($model = Shipping::findOne(['id' => $id, 'user_id' => Yii::$app->user->getId()])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
