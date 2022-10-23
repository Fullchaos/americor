<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers;

use app\models\history\History;
use app\widgets\HistoryList\helpers\templates\TemplateFactory;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\web\View;

/**
 * Наше событие, принимает объект абстрактной фабрики в качестве параметра,
 * что позволяет ему работать с любым типом событий.
 */
class Event
{
    /** @var History $model */
    public $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Отрисовка нашего события.
     * @param View $view
     * @return string
     * @throws InvalidConfigException
     */
    public function render(View $view): string
    {
        /** @var TemplateFactory $factory */
        $factory = $this->model->getTemplateFactory();

        return $view->render($factory->getTemplate(), [
            'model' => $this->model,
            'user' => $factory->getUser(),
            'body' => $factory->getBody(),
            'iconClass' => $factory->getIconClass(),
            'footerDatetime' => $factory->getFooterDateTime(),
            'footer' => $factory->getFooter(),
            'iconIncome' => $factory->getIconIncome(),
            'content' => $factory->getContent(),
            'bodyDatetime' => $factory->getBodyDateTime(),
            'oldValue' => $factory->getOldValue(),
            'newValue' => $factory->getNewValue(),
        ]);
    }
}