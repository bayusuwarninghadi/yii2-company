<?php

namespace common\models;

use DateInterval;
use DatePeriod;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "request".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $controller
 * @property string $action
 * @property string $related_parameters
 * @property string $from_device
 * @property string $from_ip
 * @property string $from_latitude
 * @property string $from_longitude
 * @property integer $created_at
 * @property integer $updated_at
 */
class Request extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['controller', 'action', 'related_parameters', 'from_device', 'from_ip', 'from_latitude', 'from_longitude'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'user_id' => 'User',
            'controller' => 'Controller',
            'action' => 'Action',
            'related_parameters' => 'Related Parameters',
            'from_device' => 'From Device',
            'from_ip' => 'From Ip',
            'from_latitude' => 'From Latitude',
            'from_longitude' => 'From Longitude',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * get Chart Options
     * @param int $startTime
     * @return array
     */
    public static function chartOptions($startTime = 0)
    {

        $day = 24 * 60 * 60;
        // default $startTime 30 days before
        $startTime = ($startTime <= 0) ? (time() - (28 * $day)) : (time() - (($startTime + 2) * $day));

        // default $endTime NOW()
        $endTime = time() + $day;

        $begin = new DateTime(date('Y-m-d', $startTime - $day));
        $end = new DateTime(date('Y-m-d', $endTime));

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        /**
         * @var \DateTimeInterface $d
         */
        $total = (new Query())
            ->select('count(*) as total_request, DATE(FROM_UNIXTIME(`created_at`)) AS created_at')
            ->from(static::tableName())
            ->where('created_at >= :start_time', [':start_time' => (int)$startTime])
            ->andWhere('created_at <= :end_time', [':end_time' => (int)$endTime])
            ->groupBy('DATE(FROM_UNIXTIME(`created_at`))')
            ->all();
        $total = ArrayHelper::map($total, 'created_at', 'total_request');

        $data = [];
        foreach ($period as $d) {
            $data[] = [
                'period' => $d->format("Y-m-d"),
                'total' => isset($total[$d->format("Y-m-d")]) ? intval($total[$d->format("Y-m-d")]) : 0,
            ];
        }

        $return = [
            'options' => [
                'data' => $data,
                'xkey' => 'period',
                'ykeys' => ['total'],
                'labels' => ['total'],
                'pointSize' => 2,
                'hideHover' => 'auto',
                'resize' => true
            ],
        ];
        return $return;
    }

}
