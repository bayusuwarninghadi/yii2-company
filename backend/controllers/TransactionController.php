<?php

namespace backend\controllers;

use common\models\ShippingMethod;
use common\models\ShippingMethodCost;
use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
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
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'transactionChart' => Transaction::chartOptions(),
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($voucher = $model->getVoucher()){
            $model->grand_total -= $voucher->value;
        }

        if ($model->load(Yii::$app->request->post())) {

            /**
             * Calculate Shipping
             * @var $shippingCostModel ShippingMethodCost
             */
            if ($shippingCostModel = ShippingMethodCost::findOne(['city_area_id' => $model->shipping->city_area_id])){
                $model->shipping_cost = $shippingCostModel->value;
                $model->grand_total += $shippingCostModel->value;
            }

            if ($model->save()){
                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Updated'));
            }
        }
        return $this->render('update', [
            'model' => $model,
            'voucher' => $voucher,
            'shippingMethod' => ArrayHelper::map(ShippingMethod::find()->all(),'id','name')
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $status
     * @return mixed
     */
    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);
        $model->status = $status;
        if ($model->validate() && $model->save()){
            Yii::$app->session->setFlash('success', Yii::t('app', 'Item Created'));
        }
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Deletes an existing Transaction model.
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
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
