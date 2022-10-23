<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\customer\Customer;
use app\models\history\History;

/**
 * Фабрика для событий по Customer Type.
 */
final class CustomerTypeTemplateFactory extends TemplateFactory
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
    public function getTemplate(): string
    {
        return '_item_statuses_change';
    }

    /**
     * @return string|null
     */
    public function getNewValue(): ?string
    {
        return Customer::getTypeTextByType($this->model->getDetailValue('type', 'new'));
    }

    /**
     * @return string|null
     */
    public function getOldValue(): ?string
    {
        return Customer::getTypeTextByType($this->model->getDetailValue('type', 'old'));
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
    public function getBody(): ?string
    {
        return null;
    }
}