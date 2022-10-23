<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\history\History;

/**
 * Фабрика для событий типа Task.
 */
final class TaskTemplateFactory extends TemplateFactory
{
    /**
     * @var History $model
     */
    public $model;

    /**
     * @param History $model
     */
    public function __construct(History $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->model->eventText . ": " . ($this->model->task->title ?? '');
    }

    /**
     * @return string
     */
    public function getIconClass(): string
    {
        return 'fa-check-square bg-yellow';
    }

    /**
     * В Примере было customerCreditor но такого свойства у Task нет,
     * заменил на customer, не знаю что там должно быть по логике.
     * @return string|null
     */
    public function getFooter(): string
    {
        return isset($this->model->task->customer->name) ? "Creditor: " . $this->model->task->customer->name : '';
    }
}