<?php
declare(strict_types = 1);

namespace app\models\customer;

use app\widgets\HistoryList\helpers\templates\CustomerQualityTemplateFactory;
use app\widgets\HistoryList\helpers\templates\CustomerTypeTemplateFactory;
use Yii;

/**
 * Бизнес логика клиентов.
 */
class Customer extends CustomerActiveRecord
{
    public const EVENT_CUSTOMER_CHANGE_TYPE = 'customer_change_type';
    public const EVENT_CUSTOMER_CHANGE_QUALITY = 'customer_change_quality';

    /**
     * @var string[]
     */
    public const EVENTS = [
        self::EVENT_CUSTOMER_CHANGE_TYPE => CustomerTypeTemplateFactory::class,
        self::EVENT_CUSTOMER_CHANGE_QUALITY => CustomerQualityTemplateFactory::class,
    ];

    public const QUALITY_ACTIVE = 'active';
    public const QUALITY_REJECTED = 'rejected';
    public const QUALITY_COMMUNITY = 'community';
    public const QUALITY_UNASSIGNED = 'unassigned';
    public const QUALITY_TRICKLE = 'trickle';

    public const TYPE_LEAD = 'lead';
    public const TYPE_DEAL = 'deal';
    public const TYPE_LOAN = 'loan';

    /**
     * @return array
     */
    public static function getQualityTexts(): array
    {
        return [
            self::QUALITY_ACTIVE => Yii::t('app', 'Active'),
            self::QUALITY_REJECTED => Yii::t('app', 'Rejected'),
            self::QUALITY_COMMUNITY => Yii::t('app', 'Community'),
            self::QUALITY_UNASSIGNED => Yii::t('app', 'Unassigned'),
            self::QUALITY_TRICKLE => Yii::t('app', 'Trickle'),
        ];
    }

    /**
     * @param $quality
     * @return mixed|null
     */
    public static function getQualityTextByQuality($quality)
    {
        return self::getQualityTexts()[$quality] ?? $quality;
    }

    /**
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return [
            self::TYPE_LEAD => Yii::t('app', 'Lead'),
            self::TYPE_DEAL => Yii::t('app', 'Deal'),
            self::TYPE_LOAN => Yii::t('app', 'Loan'),
        ];
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getTypeTextByType($type)
    {
        return self::getTypeTexts()[$type] ?? $type;
    }
}