<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\call\Call;
use app\models\history\History;

/**
 * Фабрика для событий для звонков.
 */
final class CallTemplateFactory extends TemplateFactory
{
    /**
     * @var History $model
     */
    public $model;

    /**
     * @var bool $answered Факт ответа.
     */
    public $answered;

    /**
     * @param History $model
     */
    public function __construct(History $model)
    {
        $this->model = $model;
        $this->answered = $this->model->call && $this->model->call->status === Call::STATUS_ANSWERED;
    }

    /**
     * Надо вывод ниже.
     * @return string
     */
    public function getBody(): string
    {
        $call = $this->model->call;
        return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ? " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->model->call->comment ?? '';
    }

    /**
     * В Примере было applicant но такого свойства у Call нет,
     * заменил на customer, не знаю что там должно быть по логике.
     * @return string
     */
    public function getFooter(): ?string
    {
        return isset($this->model->call->customer) ? "Called <span>{$this->model->call->customer->name}</span>" : null;
    }

    /**
     * @return string
     */
    public function getIconClass(): string
    {
        return true === $this->answered ? 'md-phone bg-green' : 'md-phone-missed bg-red';
    }

    /**
     * @return bool|null
     */
    public function getIconIncome(): ?bool
    {
        return $this->answered && $this->model->call->direction === Call::DIRECTION_INCOMING;
    }
}