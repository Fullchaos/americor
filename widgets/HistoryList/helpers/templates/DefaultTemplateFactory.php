<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\history\History;

/**
 * Фабрика для событий по умолчанию.
 */
final class DefaultTemplateFactory extends TemplateFactory
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
        return $this->model->eventText;
    }

    /**
     * @return string
     */
    public function getFooter(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getIconClass(): ?string
    {
        return 'fa-gear bg-purple-light';
    }

    /**
     * @return string
     */
    public function getBodyDateTime(): ?string
    {
        return $this->model->ins_ts;
    }
}