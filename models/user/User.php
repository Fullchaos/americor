<?php
declare(strict_types = 1);

namespace app\models\user;

use Yii;

/**
 * Бизнес логика пользователей.
 */
class User extends UserActiveRecord
{
    public const STATUS_DELETED = 0;
    public const STATUS_HIDDEN = 1;
    public const STATUS_ACTIVE = 10;

    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
            self::STATUS_HIDDEN => Yii::t('app', 'Hidden'),
        ];
    }

    /**
     * @return string|int
     */
    public function getStatusText()
    {
        return self::getStatusTexts()[$this->status] ?? $this->status;
    }
}