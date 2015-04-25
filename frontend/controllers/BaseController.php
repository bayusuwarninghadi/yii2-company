<?php
/**
 * Created by PhpStorm.
 * User: bay_oz
 * Date: 4/18/15
 * Time: 12:26
 */

namespace frontend\controllers;


use common\models\Request;
use common\models\Setting;
use common\models\UserAttribute;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Class BaseController
 * @package frontend\controllers
 */
class BaseController extends Controller
{

    /**
     * @var array
     */
    public $settings = [];

    /**
     * @var array
     */
    public $favorites = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->loadSettings();
        $this->loadFavorites();
        $this->loadThemes();
    }

    /**
     * Load Setting
     */
    protected function loadSettings()
    {
        $settings = Setting::find()->all();

        /** @var Setting $s */
        foreach ($settings as $s) {
            $this->settings[$s->key] = $s->value;
        }
    }

    /**
     * Load Themes
     */
    protected function loadThemes()
    {
        if (isset($this->settings['themes'])) {
            $this->getView()->theme = Yii::createObject([
                'class' => '\yii\base\Theme',
                'pathMap' => [
                    '@app/views' => '@app/themes/' . $this->settings['themes']
                ],
                'baseUrl' => '@app/themes/' . $this->settings['themes']
            ]);
        }
    }

    /**
     * Load Favorites
     */
    protected function loadFavorites()
    {
        if (Yii::$app->user->isGuest) return false;

        /**
         * @var $model UserAttribute
         */
        if (($model = UserAttribute::findOne(['user_id' => Yii::$app->user->getId(), 'key' => 'favorites'])) === null) {
            return false;
        }
        $this->favorites = Json::decode($model->value);

    }

    /**
     * @param \yii\base\Action $action
     * @param mixed $result
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        // do increase api after action
        self::increaseApi();

        // return parent action
        return $result;
    }


    /**
     * increase api each request
     * @return mixed
     */
    private function increaseApi()
    {
        $model = new Request();
        $model->user_id = Yii::$app->user->getId();
        $model->controller = Yii::$app->controller->id;
        $model->action = Yii::$app->controller->action->id;

        $url = Yii::$app->urlManager->parseRequest(Yii::$app->request);
        $related = $_REQUEST;
        foreach ($url as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $_k => $_v) {
                    $related[$_k] = $_v;
                }
            } else {
                $related[$k] = $v;
            }
        }

        $model->related_parameters = Json::encode($related);

        $model->from_device = 'other';
        $model->from_ip = Yii::$app->getRequest()->getUserIP();
        $model->from_latitude = (Yii::$app->request->post('from_latitude') != '') ? Yii::$app->request->post('from_latitude') : Yii::$app->request->get('from_latitude');
        $model->merchant_id = (Yii::$app->request->post('merchant_id') != '') ? Yii::$app->request->post('merchant_id') : Yii::$app->request->get('merchant_id');
        $model->from_longitude = (Yii::$app->request->post('from_longitude') != '') ? Yii::$app->request->post('from_longitude') : Yii::$app->request->get('from_longitude');
        return $model->save();
    }
}