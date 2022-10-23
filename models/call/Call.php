<?php
declare(strict_types = 1);

namespace app\models\call;

use app\widgets\HistoryList\helpers\templates\CallTemplateFactory;
use Yii;

/**
 * Бизнес логика звонков.
 */
class Call extends CallActiveRecord
{
    public const EVENT_INCOMING_CALL = 'incoming_call';
    public const EVENT_OUTGOING_CALL = 'outgoing_call';

    /**
     * Можно определить разные шаблоны для отрисовки событий, если нужно.
     * @var string[]
     */
    public const EVENTS = [
        self::EVENT_INCOMING_CALL => CallTemplateFactory::class,
        self::EVENT_OUTGOING_CALL => CallTemplateFactory::class,
    ];

    /**
     * @return string
     */
    public function getClient_phone(): string
    {
        return $this->direction === self::DIRECTION_INCOMING ? $this->phone_from : $this->phone_to;
    }

    /**
     * @return mixed|string
     */
    public function getTotalStatusText(): string
    {
        if (
            $this->status === self::STATUS_NO_ANSWERED
            && $this->direction === self::DIRECTION_INCOMING
        ) {
            return Yii::t('app', 'Missed Call');
        }

        if (
            $this->status === self::STATUS_NO_ANSWERED
            && $this->direction === self::DIRECTION_OUTGOING
        ) {
            return Yii::t('app', 'Client No Answer');
        }

        $msg = $this->getFullDirectionText();

        if ($this->duration) {
            $msg .= ' (' . $this->getDurationText() . ')';
        }

        return $msg;
    }

    /**
     * @param bool $hasComment
     * @return string
     */
    public function getTotalDisposition(bool $hasComment = true): string
    {
        $t = [];
        if ($hasComment && $this->comment) {
            $t[] = $this->comment;
        }
        return implode(': ', $t);
    }

    /**
     * @return array
     */
    public static function getFullDirectionTexts(): array
    {
        return [
            self::DIRECTION_INCOMING => Yii::t('app', 'Incoming Call'),
            self::DIRECTION_OUTGOING => Yii::t('app', 'Outgoing Call'),
        ];
    }

    /**
     * @return mixed|string
     */
    public function getFullDirectionText()
    {
        return self::getFullDirectionTexts()[$this->direction] ?? $this->direction;
    }

    /**
     * @return string
     */
    public function getDurationText(): string
    {
        if (null !== $this->duration) {
            return $this->duration >= 3600 ? gmdate("H:i:s", $this->duration) : gmdate("i:s", $this->duration);
        }
        return '00:00';
    }
}