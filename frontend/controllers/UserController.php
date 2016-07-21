<?php

namespace frontend\controllers;

use common\models\City;
use common\models\CityArea;
use common\models\Pages;
use common\models\User;
use common\models\UserAttribute;
use common\modules\UploadHelper;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * @return array
     */
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
        $model = $this->findModel(\Yii::$app->user->getId());

        if ($model->load(\Yii::$app->request->post())) {
            if ($image = UploadedFile::getInstance($model, 'image')) {
                UploadHelper::saveImage($image, 'user/' . $model->id, [
                    'small' => [
                        'width' => 200,
                        'format' => 'jpeg'
                    ],
                ]);
            }
            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Profile Updated');
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * actionToggleFavorite
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionToggleFavorite($id)
    {
        if (!($page = Pages::findOne($id))) {
            throw new NotFoundHttpException('Product not found');
        }

        if (($model = UserAttribute::findOne(['user_id' => \Yii::$app->user->getId(), 'key' => 'favorites'])) === null) {
            $model = new UserAttribute();
            $model->value = '[]';
            $model->user_id = \Yii::$app->user->getId();
            $model->key = 'favorites';
        }

        $favorites = Json::decode($model->value);

        $key = array_search($page->id, $favorites);
        if ($key === false) {
            $favorites[] = $page->id;
        } else {
            array_splice($favorites, $key, 1);
        }

        $model->value = Json::encode((array)$favorites);
        $model->save();

        if (\Yii::$app->request->isAjax) {
            return 'ok';
        } else {
            return $this->redirect(['favorite']);
        }
    }

    /**
     * @return string
     */
    public function actionFavorite()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Pages::find()->where(['IN', 'id', $this->favorites]),
            'pagination' => [
                'pageSize' => 0,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        return $this->render('favorite', [
            'dataProvider' => $dataProvider
        ]);
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

    /**
     * actionDynamicDropdown
     *
     * @param $model
     * @param $id
     * @return string
     * @throws NotSupportedException
     */
    public function actionDynamicDropdown($model, $id)
    {
        switch ($model) {
            case 'city':
                return Html::dropDownList('city', null, ArrayHelper::map(City::findAll(['province_id' => $id]), 'id', 'name'));
                break;
            case 'city_area':
                return Html::dropDownList('city', null, ArrayHelper::map(CityArea::findAll(['city_id' => $id]), 'id', 'name'));
                break;
        }
        throw new NotSupportedException("Doesn't support for Model $model");
    }

}
