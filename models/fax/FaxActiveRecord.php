<?php
declare(strict_types = 1);

namespace app\models\fax;

use app\models\user\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "fax".
 *
 * @property int $id
 * @property string $ins_ts
 * @property int $user_id
 * @property string $from
 * @property string $to
 * @property int $status
 * @property int $direction
 * @property int $type
 * @property string $typeText
 *
 * @property User $user
 */
class FaxActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'fax';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['type'], 'required'],
            [['ins_ts'], 'safe'],
            [['user_id'], 'integer'],
            [['from', 'to'], 'string'],
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
            'ins_ts' => Yii::t('app', 'Created Time'),
            'user_id' => Yii::t('app', 'User ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
