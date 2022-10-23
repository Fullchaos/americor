<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\user\User;

/**
 * Абстрактная фабрика.
 * Объявляет создающие методы, для каждого поля в render.
 */
abstract class TemplateFactory
{
    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return '_item_common';
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->model->user ?? null;
    }

    /**
     * @return string
     */
    public function getFooterDateTime(): string
    {
        return $this->model->ins_ts;
    }

    /**
     * @return string
     */
    public function getBodyDateTime(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getIconClass(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return null;
    }

    /**
     * @return bool|null
     */
    public function getIconIncome(): ?bool
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getOldValue(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getNewValue(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    abstract public function getBody(): ?string;

    /**
     * @return string
     */
    abstract public function getFooter(): ?string;
}