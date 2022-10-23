<?php
declare(strict_types = 1);

namespace app\widgets\HistoryList\helpers\templates;

use app\models\history\History;
use Yii;
use yii\helpers\Html;

/**
 * Фабрика для событий Fax.
 */
final class FaxTemplateFactory extends TemplateFactory
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
     * Нет document а Fax.
     * @return string
     */
    public function getBody(): string
    {
        return $this->model->eventText . ' - ' .
            (isset($this->model->fax->document) ? Html::a(
                Yii::t('app', 'view document'),
                $this->model->fax->document->getViewUrl(),
                [
                    'target' => '_blank',
                    'data-pjax' => 0
                ]
            ) : '');
    }

    /**
     * @return string
     */
    public function getFooter(): ?string
    {
        return Yii::t('app', '{type} was sent to {group}', [
            'type' => $this->model->fax ? $this->model->fax->getTypeText() : 'Fax',
            'group' => isset($this->model->fax->creditorGroup) ?
                Html::a($this->model->fax->creditorGroup->name, ['creditors/groups'], ['data-pjax' => 0]) : ''
        ]);
    }

    /**
     * @return string|null
     */
    public function getIconClass(): ?string
    {
        return 'fa-fax bg-green';
    }

    /**
     * @return string
     */
    public function getBodyDateTime(): ?string
    {
        return $this->model->ins_ts;
    }
}