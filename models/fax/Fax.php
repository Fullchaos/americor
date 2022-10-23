<?php
declare(strict_types = 1);

namespace app\models\fax;

use app\widgets\HistoryList\helpers\templates\FaxTemplateFactory;
use Yii;

/**
 * Бизнес логика модели fax.
 */
class Fax extends FaxActiveRecord
{
    public const EVENT_INCOMING_FAX = 'incoming_fax';
    public const EVENT_OUTGOING_FAX = 'outgoing_fax';

    /**
     * Можно определить разные шаблоны для отрисовки событий, если нужно.
     * @var string[]
     */
    public const EVENTS = [
        self::EVENT_INCOMING_FAX => FaxTemplateFactory::class,
        self::EVENT_OUTGOING_FAX => FaxTemplateFactory::class,
    ];

    public const DIRECTION_INCOMING = 0;
    public const DIRECTION_OUTGOING = 1;

    public const TYPE_POA_ATC = 'poa_atc';
    public const TYPE_REVOCATION_NOTICE = 'revocation_notice';

    /**
     * @return array
     */
    public static function getTypeTexts(): array
    {
        return [
            self::TYPE_POA_ATC => Yii::t('app', 'POA/ATC'),
            self::TYPE_REVOCATION_NOTICE => Yii::t('app', 'Revocation'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getTypeText()
    {
        return self::getTypeTexts()[$this->type] ?? $this->type;
    }
}