<?php

namespace frontend\controllers;

use common\models\City;
use common\models\CityArea;
use common\models\Confirmation;
use common\models\Product;
use common\models\Shipping;
use common\models\Transaction;
use common\models\TransactionSearch;
use common\models\User;
use common\models\UserAttribute;
use common\modules\UploadHelper;
use Yii;
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
        $model = $this->findModel(Yii::$app->user->getId());

        if ($model->load(Yii::$app->request->post())) {
            if ($image = UploadedFile::getInstance($model, 'image')) {
                UploadHelper::saveImage($image, 'user/' . $model->id, [
                    'small' => [
                        'width' => 200,
                        'format' => 'jpeg'
                    ],
                ]);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profile Updated');
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
        if (!($product = Product::findOne($id))) {
            throw new NotFoundHttpException('Product not found');
        }

        if (($model = UserAttribute::findOne(['user_id' => Yii::$app->user->getId(), 'key' => 'favorites'])) === null) {
            $model = new UserAttribute();
            $model->value = '[]';
            $model->user_id = Yii::$app->user->getId();
            $model->key = 'favorites';
        }

        $favorites = Json::decode($model->value);

        $key = array_search($product->id, $favorites);
        if ($key === false) {
            $favorites[] = $product->id;
        } else {
            array_splice($favorites, $key, 1);
        }

        $model->value = Json::encode((array)$favorites);
        $model->save();

        if (Yii::$app->request->isAjax) {
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
            'query' => Product::find()->where(['IN', 'id', $this->favorites]),
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
     * actionToggleComparison
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionToggleComparison($id)
    {
        if (!($product = Product::findOne($id))) {
            throw new NotFoundHttpException('Product not found');
        }

        if (($model = UserAttribute::findOne(['user_id' => Yii::$app->user->getId(), 'key' => 'comparison'])) === null) {
            $model = new UserAttribute();
            $model->value = '[]';
            $model->user_id = Yii::$app->user->getId();
            $model->key = 'comparison';
        }

        $comparison = Json::decode($model->value);

        $key = array_search($product->id, $comparison);
        if ($key === false) {
            $comparison[] = $product->id;
        } else {
            array_splice($comparison, $key, 1);
        }

        $model->value = Json::encode((array)$comparison);
        $model->save();

        if (Yii::$app->request->isAjax) {
            return 'ok';
        } else {
            return $this->redirect(['comparison']);
        }
    }


    /**
     * History Transaction
     * @return mixed
     */
    public function actionTransaction()
    {
        $searchModel = new TransactionSearch();
        $searchModel->user_id = Yii::$app->user->getId();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('transaction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * @return string
     */
    public function actionComparison()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['IN', 'id', $this->comparison]),
            'pagination' => [
                'pageSize' => 0,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        return $this->render('comparison', [
            'dataProvider' => $dataProvider
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
        return $this->render('createShipping', [
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
        $model->province_id = $model->cityArea->city->province_id;
        $model->city_id = $model->cityArea->city_id;
        return $this->render('updateShipping', [
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

    public function actionConfirmation()
    {
        $model = new Confirmation();
        $model->user_id = Yii::$app->user->getId();
        $params = Yii::$app->request->post();
        if ($model->load($params)) {
            $image = UploadedFile::getInstance($model, 'image');
            if (!$image) {
                $model->addError('image', 'Image can not be empty.');
            } else {
                if ($model->save()) {
                    if ($image) {
                        UploadHelper::saveImage($image, 'transactions/' . $model->transaction_id . '/' . $model->id, [
                            'medium' => [
                                'width' => 600,
                                'format' => 'jpeg'
                            ],
                        ], false);
                    }
                    // Set Status
                    $model->transaction->status = Transaction::STATUS_USER_PAY;
                    $model->transaction->disclaimer = 1;
                    $model->transaction->save();
                    Yii::$app->session->setFlash('success', 'Payment Confirmation was successfully added into our system, be patient, we will send you an email after transaction approve');
                    return $this->goHome();
                }
            }
        }

        $paymentMethod = [];

        if ($this->settings['bank_transfer'] != '') {
            $bank_transfers = explode(',', $this->settings['bank_transfer']);
            foreach ($bank_transfers as $bank) {
                $paymentMethod[$bank] = $bank;
            }
        }

        $transactionIds = ArrayHelper::map(
            Transaction::find()
                ->where(['user_id' => Yii::$app->user->getId()])
                ->andWhere(['IN', 'status', [Transaction::STATUS_USER_UN_PAY, Transaction::STATUS_USER_PAY]])
                ->all(),
            'id',
            'id'
        );

        return $this->render('confirmation', [
            'model' => $model,
            'paymentMethod' => $paymentMethod,
            'transactionIds' => $transactionIds,
        ]);

    }

    public function actionDynamicDropdown($model, $parent)
    {
        switch ($model) {
            case 'city':
                return Html::dropDownList('city', null, ArrayHelper::map(City::findAll(['province_id' => $parent]), 'id', 'name'));
                break;
            case 'city_area':
                return Html::dropDownList('city', null, ArrayHelper::map(CityArea::findAll(['city_id' => $parent]), 'id', 'name'));
                break;
        }
        throw new NotSupportedException("Doesn't support for Model $model");
    }

}
