<?php
declare(strict_types = 1);

namespace app\models\task;

use app\widgets\HistoryList\helpers\templates\TaskTemplateFactory;
use Yii;

/**
 * Бизнес логика задач.
 */
class Task extends TaskActiveRecord
{
    public const EVENT_CREATED_TASK = 'created_task';
    public const EVENT_UPDATED_TASK = 'updated_task';
    public const EVENT_COMPLETED_TASK = 'completed_task';

    /**
     * Можно определить разные шаблоны для отрисовки событий, если нужно.
     * @var string[]
     */
    public const EVENTS = [
        self::EVENT_CREATED_TASK => TaskTemplateFactory::class,
        self::EVENT_UPDATED_TASK => TaskTemplateFactory::class,
        self::EVENT_COMPLETED_TASK => TaskTemplateFactory::class,
    ];

    public const STATUS_NEW = 0;
    public const STATUS_DONE = 1;
    public const STATUS_CANCEL = 3;

    public const STATE_INBOX = 'inbox';
    public const STATE_DONE = 'done';
    public const STATE_FUTURE = 'future';

    /**
     * @return array
     */
    public static function getStatusTexts(): array
    {
        return [
            self::STATUS_NEW => Yii::t('app', 'New'),
            self::STATUS_DONE => Yii::t('app', 'Complete'),
            self::STATUS_CANCEL => Yii::t('app', 'Cancel'),
        ];
    }

    /**
     * @param $value
     * @return int|mixed
     */
    public function getStatusTextByValue($value): int
    {
        return self::getStatusTexts()[$value] ?? $value;
    }

    /**
     * @return mixed|string
     */
    public function getStatusText(): string
    {
        return $this->getStatusTextByValue($this->status);
    }

    /**
     * @return array
     */
    public static function getStateTexts(): array
    {
        return [
            self::STATE_INBOX => Yii::t('app', 'Inbox'),
            self::STATE_DONE => Yii::t('app', 'Done'),
            self::STATE_FUTURE => Yii::t('app', 'Future')
        ];
    }

    /**
     * @return mixed
     */
    public function getStateText()
    {
        return self::getStateTexts()[$this->state] ?? $this->state;
    }

    /**
     * @return bool
     */
    public function getIsOverdue(): bool
    {
        return $this->status !== self::STATUS_DONE && strtotime($this->due_date) < time();
    }

    /**
     * @return bool
     */
    public function getIsDone(): bool
    {
        return $this->status === self::STATUS_DONE;
    }
}