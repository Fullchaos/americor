<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\history\History;
use app\models\sms\Sms;
use app\models\user\User;
use Yii;

/**
 * Фабрика для событий типа Sms.
 */
final class SmsTemplateFactory extends TemplateFactory
{
    public $model;

    /**
     * @param History $model
     */
    public function __construct(History $model)
    {
        $this->model = $model;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->model->user;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->model->sms->message ?: '';
    }

    /**
     * @return string
     */
    public function getIconClass(): string
    {
        return 'fa-check-square bg-yellow';
    }

    /**
     * @return string|null
     */
    public function getFooter(): string
    {
        return $this->model->sms->direction === Sms::DIRECTION_INCOMING ?
            Yii::t('app', 'Incoming message from {number}', [
                'number' => $this->model->sms->phone_from ?? ''
            ]) : Yii::t('app', 'Sent message to {number}', [
                'number' => $this->model->sms->phone_to ?? ''
            ]);
    }

    /**
     * @return bool|null
     */
    public function getIconIncome(): ?bool
    {
        return $this->model->sms->direction === Sms::DIRECTION_INCOMING;
    }
}