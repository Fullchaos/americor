<?php
declare(strict_types = 1);

namespace app\models\sms;

use app\models\customer\Customer;
use app\models\user\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sms}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $customer_id
 * @property int $status
 * @property string $phone_from
 * @property string $message
 * @property string $ins_ts
 * @property int $direction
 * @property string $phone_to
 * @property int $type
 * @property string $formatted_message
 *
 * @property string $statusText
 * @property string $directionText
 *
 * @property Customer $customer
 * @property User $user
 */
class SmsActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%sms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['phone_to', 'direction'], 'required'],
            [['user_id', 'customer_id', 'status', 'direction', 'applicant_id', 'type'], 'integer'],
            [['message'], 'string'],
            [['ins_ts'], 'safe'],
            [['phone_from', 'phone_to'], 'string', 'max' => 255],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Customer::class,
                'targetAttribute' => ['customer_id' => 'id']
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'status' => Yii::t('app', 'Status'),
            'statusText' => Yii::t('app', 'Status'),
            'phone_from' => Yii::t('app', 'Phone From'),
            'phone_to' => Yii::t('app', 'Phone To'),
            'message' => Yii::t('app', 'Message'),
            'ins_ts' => Yii::t('app', 'Date'),
            'direction' => Yii::t('app', 'Direction'),
            'directionText' => Yii::t('app', 'Direction'),
            'user.fullname' => Yii::t('app', 'User'),
            'customer.name' => Yii::t('app', 'Client'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
