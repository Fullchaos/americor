<?php
declare(strict_types = 1);

namespace app\widgets\DateTime;

use Exception;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Виджет календаря.
 */
class DateTime extends Widget
{
    public $dateTime;

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return
            Html::tag('i', '', ['class' => "icon glyphicon glyphicon-time"]) . " " .
            Yii::$app->formatter->format($this->dateTime, 'relativeTime') . ' - ' .
            Yii::$app->formatter->asDatetime($this->dateTime, 'MM/dd/y (hh:mm a)');
    }
}
