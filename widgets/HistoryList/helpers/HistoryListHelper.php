<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers;

use app\models\call\Call;
use app\models\customer\Customer;
use app\models\history\History;

/**
 * Помощник для истории.
 */
class HistoryListHelper
{
    /**
     * @param History $model
     * @return string
     */
    public static function getBodyByModel(History $model): ?string
    {
        switch ($model->event) {
            case History::EVENT_CREATED_TASK:
            case History::EVENT_COMPLETED_TASK:
            case History::EVENT_UPDATED_TASK:
                $task = $model->task;
                return "$model->eventText: " . ($task->title ?? '');
            case History::EVENT_INCOMING_SMS:
            case History::EVENT_OUTGOING_SMS:
                return $model->sms->message ?: '';
            case History::EVENT_CUSTOMER_CHANGE_TYPE:
                return "$model->eventText " .
                    (Customer::getTypeTextByType($model->getDetailValue('type', 'old')) ?? "not set") . ' to ' .
                    (Customer::getTypeTextByType($model->getDetailValue('type', 'old')) ?? "not set");
            case History::EVENT_CUSTOMER_CHANGE_QUALITY:
                return "$model->eventText " .
                    (Customer::getQualityTextByQuality($model->getDetailValue('quality', 'old')) ?? "not set") . ' to ' .
                    (Customer::getQualityTextByQuality($model->getDetailValue('quality', 'new')) ?? "not set");
            case History::EVENT_INCOMING_CALL:
            case History::EVENT_OUTGOING_CALL:
                /** @var Call $call */
                $call = $model->call;
                return ($call ? $call->totalStatusText . ($call->getTotalDisposition(false) ? " <span class='text-grey'>" . $call->getTotalDisposition(false) . "</span>" : "") : '<i>Deleted</i> ');
            default:
                return $model->eventText;
        }
    }
}