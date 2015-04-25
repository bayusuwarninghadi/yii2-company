<?php

namespace backend\controllers;

use common\modules\UploadHelper;
use Yii;
use common\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
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
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $param = Yii::$app->request->post();

        if ($param) {
            foreach ($param['Setting'] as $_key => $_param) {
                /** @var Setting $_model */
                $_model = Setting::findOne($_key);

                if (isset($_FILES['Setting']['name'][$_key])){
                    if (!empty($_FILES['Setting']['name'][$_key]['value'])) {
                        // get file
                        $_file = UploadedFile::getInstance($_model, '[' . $_key . ']value');

                        $_path = 'setting/' . $_key;
                        if (getimagesize($_file->tempName)) {
                            $sizes = [
                                'large' => [
                                    'width' => 600,
                                    'format' => 'png'
                                ],
                                'small' => [
                                    'width' => 50,
                                    'format' => 'png'
                                ],
                            ];
                            UploadHelper::saveImage($_file, $_path, $sizes);
                            $_param['value'] = $_FILES['Setting']['name'][$_key]['value'];
                        } else {
                            $_param['value'] = UploadHelper::saveFile($_file, $_path);
                        }
                    } else {
                        // set value = current, if upload file is empty
                        $_param['value'] = $_model->value;
                    }
                }

                $_model->value = $_param['value'];
                $_model->save();
            }
            Yii::$app->getSession()->setFlash('success', 'Your setting has been saved.');
        }


        $model = Setting::find()->all();
        return $this->render('index', [
            'model' => $model,
        ]);

    }

    /**
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Setting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
