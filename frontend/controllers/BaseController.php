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
     * @var array
     */
    public $comparison = [];

    /**
     * @var array
     */
    public $supportedLanguage = ['id-ID', 'en-US'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->loadSettings();
        $this->loadLanguage();
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
     * Load Language
     */
    protected function loadLanguage()
    {
        if ($lang = \Yii::$app->request->get('lang')) {
            if (in_array($lang, $this->supportedLanguage)){
                \Yii::$app->session['lang'] = $lang;
            }
        }
        if (!\Yii::$app->session['lang']){
            \Yii::$app->session['lang'] = $this->settings['default_language'];
        }
        \Yii::$app->language = \Yii::$app->session['lang'];
    }

    /**
     * Run afterAction, after user request each page
     * 1 Increase api request
     *
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
        $model->user_id = \Yii::$app->user->getId();
        $model->controller = \Yii::$app->controller->id;
        $model->action = \Yii::$app->controller->action->id;

        $url = \Yii::$app->urlManager->parseRequest(\Yii::$app->request);
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
        $model->from_ip = \Yii::$app->getRequest()->getUserIP();
        $model->from_latitude = (\Yii::$app->request->post('from_latitude') != '') ? \Yii::$app->request->post('from_latitude') : \Yii::$app->request->get('from_latitude');
        $model->from_longitude = (\Yii::$app->request->post('from_longitude') != '') ? \Yii::$app->request->post('from_longitude') : \Yii::$app->request->get('from_longitude');
        return $model->save();
    }
}