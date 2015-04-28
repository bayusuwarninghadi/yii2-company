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
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $note
 * @property integer $shipping_id
 * @property string $shipping_method
 * @property string $shipping_cost
 * @property string $voucher_code
 * @property string $payment_method
 * @property integer $status
 * @property integer $sub_total
 * @property integer $grand_total
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Shipping $shipping
 * @property Cart $carts
 * @property Confirmation[] $confirmations
 * @property User $user
 * @property Cart[] $transactionAttributes
 * @property Voucher $voucher
 */
class Transaction extends ActiveRecord
{
    /**
     *
     */
    const STATUS_USER_UN_PAY = 0;
    /**
     *
     */
    const STATUS_USER_PAY = 1;
    /**
     *
     */
    const STATUS_CONFIRM = 2;
    /**
     *
     */
    const STATUS_DELIVER = 3;
    /**
     *
     */
    const STATUS_DELIVERED = 4;
    /**
     *
     */
    const STATUS_REJECTED = 5;


    /**
     * @var int
     */
    public $disclaimer = 0;

    /**
     * @var bool|Voucher
     */
    public $voucher = false;

    /**
     * @param bool $with_key
     * @return array
     */
    public static function getStatusAsArray($with_key = true)
    {
        $return = ($with_key == true)
            ? [
                static::STATUS_USER_UN_PAY => Yii::t('app', 'User Un Pay'),
                static::STATUS_USER_PAY => Yii::t('app', 'User Has Pay'),
                static::STATUS_CONFIRM => Yii::t('app', 'Confirm'),
                static::STATUS_DELIVER => Yii::t('app', 'Deliver'),
                static::STATUS_DELIVERED => Yii::t('app', 'Delivered'),
                static::STATUS_REJECTED => Yii::t('app', 'Rejected'),
            ]
            : [
                static::STATUS_USER_UN_PAY,
                static::STATUS_USER_PAY,
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
            [['user_id', 'shipping_id', 'sub_total', 'grand_total', 'shipping_method','payment_method'], 'required'],
            [
                'disclaimer',
                'required',
                'requiredValue' => Yii::$app->id == "app-backend" ? 0 : 1,
                'message' => Yii::t('app', 'You must agree to our disclaimer')
            ],
            ['voucher_code', 'unique', 'message' => Yii::t('app', 'Voucher Has Been Used')],
            ['voucher_code' ,'validateVoucher'],
            ['status', 'default', 'value' => static::STATUS_USER_UN_PAY],
            ['status', 'in', 'range' => static::getStatusAsArray(false)],
            [['user_id', 'shipping_id', 'status', 'sub_total', 'shipping_cost', 'grand_total'], 'integer'],
            [['note', 'voucher_code', 'payment_method', 'shipping_method'], 'string', 'max' => 255]
        ];
    }

    /**
     * Validate Voucher.
     * @param string $attribute the attribute currently being validated
     */
    public function validateVoucher($attribute){
        if ($this->isNewRecord){
            $voucher = $this->getVoucher();
            if (!$voucher || ($voucher->status != Voucher::STATUS_AVAILABLE)) {
                $this->addError($attribute, Yii::t('app', 'Voucher Is Not Available'));
            }
        }
    }

    /**
     * Finds voucher by [[voucher_code]]
     *
     * @return Voucher|null
     */
    public function getVoucher(){
        if (!$this->voucher && $this->voucher_code) {
            $this->voucher = Voucher::find()->where(['id' => $this->voucher_code, 'status' => Voucher::STATUS_AVAILABLE])->one();
        }

        return $this->voucher;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'shipping_id' => Yii::t('app', 'Shipping Address'),
            'shipping_method' => Yii::t('app', 'Shipping Method'),
            'shipping_cost' => Yii::t('app', 'Shipping Cost'),
            'payment_method' => Yii::t('app', 'Payment Method'),
            'voucher_code' => Yii::t('app', 'Voucher Code'),
            'note' => Yii::t('app', 'Note'),
            'status' => Yii::t('app', 'Status'),
            'sub_total' => Yii::t('app', 'Sub Total'),
            'grand_total' => Yii::t('app', 'Grand Total'),
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
