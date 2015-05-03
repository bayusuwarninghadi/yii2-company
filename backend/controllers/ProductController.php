<?php

namespace backend\controllers;

use common\models\Category;
use common\models\Product;
use common\models\ProductAttribute;
use common\models\ProductLang;
use common\models\ProductSearch;
use common\models\UserComment;
use common\modules\UploadHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $gallery = ProductAttribute::findAll(['product_id' => $model->id, 'key' => 'images']);

        $images = [];
        foreach ($gallery as $image) {
            $_arr = Json::decode($image->value);
            $images[] = Html::img(Yii::$app->components['frontendSiteUrl'] . $_arr['medium']);
        }
        if (!$images) $images[] = Html::img(Yii::$app->components['frontendSiteUrl'].$model->image_url);


        $userCommentDataProvider = new ActiveDataProvider([
            'query' => UserComment::find()->where(['table_key' => 'product', 'table_id' => $model->id]),
        ]);

        return $this->render('view', [
            'model' => $model,
            'images' => $images,
            'attributes' => $model->getProductAttributeDetailValue(),
            'userCommentDataProvider' => $userCommentDataProvider
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        /**
         * Create New Article Language
         */
        $modelEnglish = new ProductLang();
        $modelEnglish->language = 'id-ID';

        $modelIndonesia = new ProductLang();
        $modelIndonesia->language = 'en-US';

        $bodyData = Yii::$app->request->post();
        $attributes = (isset($bodyData['Product']['productAttributeDetailValue'])) ? $bodyData['Product']['productAttributeDetailValue'] : $model->getProductAttributeDetailValue();

        if ($model->load($bodyData)) {

            if ($model->save()) {

                /**
                 * Save Product Lang
                 */
                $modelEnglish->product_id = $model->id;
                $modelEnglish->name = $bodyData['modelEnglish']['name'];
                $modelEnglish->subtitle = $bodyData['modelEnglish']['subtitle'];
                $modelEnglish->description = $bodyData['modelEnglish']['description'];
                if ($modelEnglish->validate()) {
                    $modelEnglish->save();
                }

                $modelEnglish->product_id = $model->id;
                $modelIndonesia->name = $bodyData['modelIndonesia']['name'];
                $modelIndonesia->subtitle = $bodyData['modelIndonesia']['subtitle'];
                $modelIndonesia->description = $bodyData['modelIndonesia']['description'];
                if ($modelIndonesia->validate()) {
                    $modelIndonesia->save();
                }

                $attr = $model->getProductAttributeDetail();
                $attr->value = Json::encode($attributes);
                $attr->save();

                if ($_images = UploadedFile::getInstances($model, 'images')){
                    foreach ($_images as $image) {
                        $_model = new ProductAttribute();
                        $_model->key = 'images';
                        $_model->product_id = $model->id;
                        if ($_model->save() && $upload = UploadHelper::saveImage($image, 'product/' . $model->id . '/' . $_model->id)) {
                            $_model->value = Json::encode($upload);
                            $_model->save();
                            $model->image_url = $upload['medium'];
                        }
                    }
                    $model->save();
                }
                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Created'));
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'gallery' => null,
            'attributes' => $attributes,
            'modelEnglish' => $modelEnglish,
            'modelIndonesia' => $modelIndonesia,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $gallery = ProductAttribute::findAll(['product_id' => $model->id, 'key' => 'images']);

        $bodyData = Yii::$app->request->post();

        $modelEnglish = $this->findLangModel($model->id, 'en-US');
        $modelIndonesia = $this->findLangModel($model->id, 'id-ID');

        $attributes = (isset($bodyData['Product']['productAttributeDetailValue'])) ? $bodyData['Product']['productAttributeDetailValue'] : $model->getProductAttributeDetailValue();

        if ($model->load($bodyData)) {

            $_images = UploadedFile::getInstances($model, 'images');
            foreach ($_images as $image) {
                $_model = new ProductAttribute();
                $_model->key = 'images';
                $_model->product_id = $model->id;
                if ($_model->save() && $upload = UploadHelper::saveImage($image, 'product/' . $model->id . '/' . $_model->id)) {
                    $_model->value = Json::encode($upload);
                    $_model->save();
                    $model->image_url = $upload['medium'];
                }
            }
            if ($model->save()) {
                /**
                 * Save Product Lang
                 */
                $modelEnglish->name = $bodyData['modelEnglish']['name'];
                $modelEnglish->subtitle = $bodyData['modelEnglish']['subtitle'];
                $modelEnglish->description = $bodyData['modelEnglish']['description'];
                if ($modelEnglish->validate()) {
                    $modelEnglish->save();
                }

                $modelIndonesia->name = $bodyData['modelIndonesia']['name'];
                $modelIndonesia->subtitle = $bodyData['modelIndonesia']['subtitle'];
                $modelIndonesia->description = $bodyData['modelIndonesia']['description'];
                if ($modelIndonesia->validate()) {
                    $modelIndonesia->save();
                }


                $attr = $model->getProductAttributeDetail();
                $attr->value = Json::encode($attributes);
                $attr->save();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Item Upated'));
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        return $this->render('update', [
            'model' => $model,
            'gallery' => $gallery,
            'attributes' => $attributes,
            'modelEnglish' => $modelEnglish,
            'modelIndonesia' => $modelIndonesia,
        ]);
    }

    /**
     * Updates Cover Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionSetCover($id)
    {
        if ($image_url = Yii::$app->request->post('imageUrl')){
            Product::updateAll(['image_url' => $image_url], ['id' => $id]);
            echo 'ok';
        }
    }

    /**
     * Delete Product Attribute.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteProductAttribute($id)
    {
        if (($model = ProductAttribute::find()->where($id)->one()) !== null){
            $model->delete();
        }
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categoryModel = $searchModel->cat_id ? Category::findOne($searchModel->cat_id)->children()->all() : Category::find()->roots()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryModel' => $categoryModel
        ]);
    }

    /**
     * Finds the ProductLang model based on its primary key value.
     * @param integer $productId
     * @param string $language
     * @return ProductLang the loaded model
     */
    protected function findLangModel($productId, $language)
    {
        if (($model = ProductLang::findOne(['product_id' => $productId, 'language' => $language])) === null) {
            $model = new ProductLang();
            $model->language = $language;
            $model->product_id = $productId;
        }
        return $model;
    }

}
