<?php
declare(strict_types = 1);

namespace app\models\customer;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string $name
 */
class CustomerActiveRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%customer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'name' => Yii::t('app', 'Name'),
        ];
    }
}