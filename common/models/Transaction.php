<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use DatePeriod;
use DateInterval;
use DateTime;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $shipping_id
 * @property string $note
 * @property string $payment_method
 * @property integer $status
 * @property integer $sub_total
 * @property integer $grand_total
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Shipping $shipping
 * @property Confirmation[] $confirmations
 * @property User $user
 * @property Cart[] $transactionAttributes
 */
class Transaction extends ActiveRecord
{
    const STATUS_WAITING_APPROVAL = 0;
    const STATUS_APPROVED = 1;
    const STATUS_CONFIRM = 2;
    const STATUS_DELIVER = 3;
    const STATUS_DELIVERED = 4;
    const STATUS_REJECTED = 5;


    public $disclaimer = 0;
    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_WAITING_APPROVAL => 'Waiting Approval',
                static::STATUS_APPROVED => 'Approved',
                static::STATUS_CONFIRM => 'Confirm',
                static::STATUS_DELIVER => 'Deliver',
                static::STATUS_DELIVERED => 'Delivered',
                static::STATUS_REJECTED => 'Rejected',
            ]
            : [
                static::STATUS_WAITING_APPROVAL,
                static::STATUS_APPROVED,
                static::STATUS_CONFIRM,
                static::STATUS_DELIVER,
                static::STATUS_DELIVERED,
                static::STATUS_REJECTED,
            ];
        return $return;
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
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shipping_id', 'sub_total', 'grand_total', 'payment_method'], 'required'],
            [
                'disclaimer',
                'required',
                'requiredValue' => Yii::$app->id == "app-backend" ? 0 : 1,
                'message' => 'You must agree to our disclaimer'
            ],
            ['status', 'default', 'value' => static::STATUS_WAITING_APPROVAL],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],
            [['user_id', 'shipping_id', 'status', 'sub_total', 'grand_total'], 'integer'],
            [['note'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'shipping_id' => 'Shipping Address',
            'note' => 'Note',
            'status' => 'Status',
            'sub_total' => 'Sub Total',
            'grand_total' => 'Grand Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Shipping::className(), ['id' => 'shipping_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['transaction_id' => 'id']);
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
            'type' => 'Bar',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfirmations()
    {
        return $this->hasMany(Confirmation::className(), ['transaction_id' => 'id']);
    }
}
