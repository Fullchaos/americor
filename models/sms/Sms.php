<?php
declare(strict_types = 1);

namespace app\models\sms;

use app\widgets\HistoryList\helpers\templates\SmsTemplateFactory;
use Yii;

/**
 * Бизнес логика Sms.
 */
class Sms extends SmsActiveRecord
{
    public const EVENT_INCOMING_SMS = 'incoming_sms';
    public const EVENT_OUTGOING_SMS = 'outgoing_sms';

    /**
     * Можно определить разные шаблоны для отрисовки событий, если нужно.
     * @var string[]
     */
    public const EVENTS = [
        self::EVENT_INCOMING_SMS => SmsTemplateFactory::class,
        self::EVENT_OUTGOING_SMS => SmsTemplateFactory::class,
    ];

    public const DIRECTION_INCOMING = 0;
    public const DIRECTION_OUTGOING = 1;

    // incoming
    public const STATUS_NEW = 0;
    public const STATUS_READ = 1;
    public const STATUS_ANSWERED = 2;

    // outgoing
    public const STATUS_DRAFT = 10;
    public const STATUS_WAIT = 11;
    public const STATUS_SENT = 12;
    public const STATUS_DELIVERED = 13;
    public const STATUS_FAILED = 14;
    public const STATUS_SUCCESS = 13;

    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'New'),
            self::STATUS_READ => Yii::t('app', 'Read'),
            self::STATUS_ANSWERED => Yii::t('app', 'Answered'),

            self::STATUS_DRAFT => Yii::t('app', 'Draft'),
            self::STATUS_WAIT => Yii::t('app', 'Wait'),
            self::STATUS_SENT => Yii::t('app', 'Sent'),
            self::STATUS_DELIVERED => Yii::t('app', 'Delivered'),
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function getStatusTextByValue($value): string
    {
        return self::getStatusTexts()[$value] ?? $value;
    }

    /**
     * @return mixed|string
     */
    public function getStatusText(): string
    {
        return self::getStatusTextByValue($this->status);
    }

    /**
     * @return array
     */
    public static function getDirectionTexts(): array
    {
        return [
            self::DIRECTION_INCOMING => Yii::t('app', 'Incoming'),
            self::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing'),
        ];
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function getDirectionTextByValue($value): string
    {
        return self::getDirectionTexts()[$value] ?? $value;
    }

    /**
     * @return mixed|string
     */
    public function getDirectionText(): string
    {
        return self::getDirectionTextByValue($this->direction);
    }
}